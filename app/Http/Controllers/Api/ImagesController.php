<?php

namespace App\Http\Controllers\Api;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\Api\ImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

# use App\Http\Controllers\Controller;

class ImagesController extends Controller
{
    /**
     * 图片上传功能
     * @param ImageRequest $request
     * @param ImageUploadHandler $uploader
     * @param Image $image
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request, ImageUploadHandler $uploader, Image $image)
    {
        $user = $this->user();

        // 更新图片
        if ($request->action && $request->action == 'update') {
            if ($user->id == '1') {
                $uploader->update($request->path, $request->image);
                return $this->json([
                    'status' => 1,
                    'msg' => '替换成功 ~',
                ]);
            } else {
                return $this->json([]);
            }
        } else if ($request->action && $request->action == 'delete') {
            if ($user->id == '1') {
                $uploader->delete($request->path);
                return $this->json([
                    'status' => 1,
                    'msg' => '删除成功 ~',
                ]);
            } else {
                return $this->json([]);
            }
        }

        $size = $request->type == 'avatar' ? 362 : 1024;
        $result = $uploader->save($request->image, str_plural($request->image_type), $user->id, $size);

        $image->path = $result['path'];
        $image->image_type = $request->image_type;
        $image->user_id = $user->id;
        $image->save();

        return $this->created(new ImageResource($image));
    }
}
