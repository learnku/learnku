<?php
namespace App\Handlers;

use Image;
use Illuminate\Support\Facades\Storage;

class ImageUploadHandler
{
    protected $allowed_ext = ["png", "jpg", "gif", 'jpeg'];

    /**
     * 保存图片到本地
     * @param $file
     * @param $folder
     * @param $file_prefix
     * @param bool $max_width
     * @return array|bool
     */
    public function save($file, $folder, $file_prefix, $max_width = false)
    {
        // 构建存储的文件夹规则，值如：uploads/images/avatars/201709/21/
        // 文件夹切割能让查找效率更高。
        $folder_name = $folder_qiniu = "uploads/images/$folder/" . date("Ym", time()) . '/'.date("d", time()).'/';
        // 文件具体存储的物理路径，`public_path()` 获取的是 `public` 文件夹的物理路径。
        // 值如：/home/vagrant/Code/larabbs/public/uploads/images/avatars/201709/21/
        $upload_path = public_path() . '/' . $folder_name;
        // 获取文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        // 拼接文件名，加前缀是为了增加辨析度，前缀可以是相关数据模型的 ID
        // 值如：1_1493521050_7BVc9v9ujP.png
        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;
        // 如果上传的不是图片将终止操作
        if ( ! in_array($extension, $this->allowed_ext)) {
            return false;
        }

        // 将图片移动到我们的目标存储路径中
        $file->move($upload_path, $filename);

        // 如果是本地就存储到磁盘, 否则存储到 七牛云
        if (app()->isLocal()){
            // 如果限制了图片宽度，就进行裁剪
            if ($max_width && $extension != 'gif') {
                // 此类中封装的函数，用于裁剪图片
                $this->reduseSize($upload_path . $filename, $max_width);
            }
        } else {
            // 将图片上传至七牛云空间
            $qiniu = Storage::disk('qiniu');
            $qiniu->write($folder_qiniu . $filename, $upload_path . $filename);

            // 删除本地文件
            unlink($folder_qiniu . $filename);
        }

        return [
            'path' => "/$folder_name$filename"
        ];
    }

    public function update($path, $file)
    {
        $path_path = substr($path, 0, strrpos($path, '.'));
        $path_filename = substr($path_path, strrpos($path_path, '/') + 1);
        $path_path = substr($path_path, 0, strrpos($path_path, '/'));

        // 获取文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        // 拼接文件名，加前缀是为了增加辨析度，前缀可以是相关数据模型的 ID
        // 值如：1_1493521050_7BVc9v9ujP.png
        $filename = $path_filename . '.' . $extension;

        $upload_path = public_path() . '/' . $path_path .'/';

        // 如果上传的不是图片将终止操作
        if ( ! in_array($extension, $this->allowed_ext)) {
            return false;
        }

        // 将图片移动到我们的目标存储路径中
        $file->move($upload_path, $filename);

        $qiniu = Storage::disk('qiniu');
        $qiniu->update($path, $upload_path . $filename);
    }

    public function delete($path)
    {
        $qiniu = Storage::disk('qiniu');
        $qiniu->delete($path);
    }

    /**
     * 图片裁剪
     * @param $file_path
     * @param $max_width
     */
    public function reduseSize($file_path, $max_width)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);
        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {
            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();
            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });
        // 对图片修改后进行保存
        $image->save();
    }
}
