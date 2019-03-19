<?php
/**
 * 七牛云存储 适配器类
 */

namespace App\Services\FileSystem;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use League\Flysystem\Adapter\AbstractAdapter;
use League\Flysystem\Config;
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

class QiniuAdapter extends AbstractAdapter
{
    private $accessKey;
    private $accessSecret;

    // images.learnku.net
    protected $uploadManager;
    protected $bucketManager;
    private $bucketName;
    private $domainName;
    private $token;

    public function __construct($qiniu='qiniu', $prefix = '')
    {
        $this->accessKey = \config('filesystems.disks.'. $qiniu .'.access_key');
        $this->accessSecret = \config('filesystems.disks.'. $qiniu .'.secret_key');

        // 上传文件句柄
        $this->uploadManager = new UploadManager();
        $this->bucketName = \config('filesystems.disks.'. $qiniu .'.bucket');
        $this->domainName = \config('filesystems.disks.'. $qiniu .'.domain');
        $auth = new \Qiniu\Auth($this->accessKey, $this->accessSecret);
        // 管理文件句柄
        $this->bucketManager = new BucketManager($auth);
        $this->token = $auth->uploadToken($this->bucketName);

        $this->setPathPrefix($prefix);
    }

    /**
     * 写一个新文件。
     * Write a new file.
     *
     * @param string $path
     * @param string $contents
     * @param Config $config Config object
     *
     * @return array|false false on failure file meta data on success
     * @throws \Exception
     */
    public function write($path, $contents, Config $config)
    {
        return $this->upload($path, $contents);
    }

    /**
     * 使用流写一个新文件。
     * Write a new file using a stream.
     *
     * @param string $path
     * @param resource $resource
     * @param Config $config Config object
     *
     * @return array|false false on failure file meta data on success
     * @throws \Exception
     */
    public function writeStream($path, $resource, Config $config)
    {
        return $this->upload($path, $resource, true);
    }

    /**
     * 更新文件。
     * Update a file.
     *
     * @param string $path
     * @param string $contents
     * @param Config $config Config object
     *
     * @return array|false false on failure file meta data on success
     * @throws \Exception
     */
    public function update($path, $contents, Config $config)
    {
        return $this->upload($path, $contents);
    }

    /**
     * 使用流更新文件。
     * Update a file using a stream.
     *
     * @param string $path
     * @param resource $resource
     * @param Config $config Config object
     *
     * @return array|false false on failure file meta data on success
     * @throws \Exception
     */
    public function updateStream($path, $resource, Config $config)
    {
        return $this->upload($path, $resource, true);
    }

    /**
     * 重命名文件。
     * Rename a file.
     *
     * @param string $path
     * @param string $newpath
     *
     * @return bool
     */
    public function rename($path, $newpath)
    {
        $path = $this->addPrefix($path);
        $newpath = $this->addPrefix($newpath);
        $error = $this->bucketManager->rename($this->bucketName, $path, $newpath);
        return $error == null ? true : false;
    }

    /**
     * 复制文件。
     * Copy a file.
     *
     * @param string $path
     * @param string $newpath
     *
     * @return bool
     */
    public function copy($path, $newpath)
    {
        $path = $this->addPrefix($path);
        $newpath = $this->addPrefix($newpath);
        $error = $this->bucketManager->copy($this->bucketName, $path, $this->bucketName, $newpath);
        return $error == null ? true : false;
    }

    /**
     * 删除文件。
     * Delete a file.
     *
     * @param string $path
     *
     * @return bool
     */
    public function delete($path)
    {
        $this->addPrefix($path);
        $error = $this->bucketManager->delete($this->bucketName, $path);
        return $error == null ? true : false;
    }

    /**
     * 删除目录。
     * Delete a directory.
     *
     * @param string $dirname
     *
     * @return void
     */
    public function deleteDir($dirname)
    {
        throw new \BadFunctionCallException('暂不支持该操作');
    }

    /**
     * 创建一个目录。
     * Create a directory.
     *
     * @param string $dirname directory name
     * @param Config $config
     *
     * @return void
     */
    public function createDir($dirname, Config $config)
    {
        throw new \BadFunctionCallException('暂不支持该操作');
    }

    /**
     * 设置文件的可见性。
     * Set the visibility for a file.
     *
     * @param string $path
     * @param string $visibility
     *
     * @return void file meta data
     */
    public function setVisibility($path, $visibility)
    {
        throw new \BadFunctionCallException('暂不支持该操作');
    }

    /**
     * 检查文件是否存在。
     * Check whether a file exists.
     *
     * @param string $path
     *
     * @return array|bool|null
     */
    public function has($path)
    {
        $path = $this->addPrefix($path);
        $stat = $this->bucketManager->stat($this->bucketName, $path);
        if ($stat[0] == null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 读一个文件。
     * Read a file.
     *
     * @param string $path
     *
     * @return array|false
     * @throws FileNotFoundException
     */
    public function read($path)
    {
        $path = $this->addPrefix($path);
        list($fileInfo, $error) = $this->bucketManager->stat($this->bucketName, $path);
        if ($fileInfo) {
            return $fileInfo;
        } else {
            throw new FileNotFoundException('对应文件不存在');
        }
    }

    /**
     * 将文件作为流读取。
     * Read a file as a stream.
     *
     * @param string $path
     *
     * @return void
     */
    public function readStream($path)
    {
        throw new \BadFunctionCallException('暂不支持该操作');
    }

    /**
     * 列出目录的内容。
     * List contents of a directory.
     *
     * @param string $directory
     * @param bool $recursive
     *
     * @return array
     */
    public function listContents($directory = '', $recursive = false)
    {
        return $this->bucketManager->listFiles($this->bucketName);
    }

    /**
     * 获取文件或目录的所有元数据。
     * Get all the meta data of a file or directory.
     *
     * @param string $path
     *
     * @return array|false
     * @throws FileNotFoundException
     */
    public function getMetadata($path)
    {
        return $this->read($path);
    }

    /**
     * 获取文件的大小。
     * Get the size of a file.
     *
     * @param string $path
     *
     * @return array|false
     * @throws FileNotFoundException
     */
    public function getSize($path)
    {
        $fileInfo = $this->read($path);
        return $fileInfo['fsize'];
    }

    /**
     * 获取文件的mimetype。
     * Get the mimetype of a file.
     *
     * @param string $path
     *
     * @return array|false
     * @throws FileNotFoundException
     */
    public function getMimetype($path)
    {
        $fileInfo = $this->read($path);
        return $fileInfo['fileType'];// TODO: Implement getMimetype() method.
    }

    /**
     * 获取文件的上次修改时间作为时间戳。
     * Get the last modified time of a file as a timestamp.
     *
     * @param string $path
     *
     * @return array|false
     * @throws FileNotFoundException
     */
    public function getTimestamp($path)
    {
        $fileInfo = $this->read($path);
        return $fileInfo['putTime'];
    }

    /**
     * 获取文件的可见性。
     * Get the visibility of a file.
     *
     * @param string $path
     *
     * @return void
     */
    public function getVisibility($path)
    {
        throw new \BadFunctionCallException('暂不支持该操作');
    }

    /**
     * @param string $path
     * @param $contents
     * @param bool $stream
     * @return mixed
     * @throws \Exception
     */
    protected function upload(string $path, $contents, $stream = false)
    {
        $path = $this->addPrefix($path);
        try {
            if ($stream) {
                $response = $this->uploadManager->put($this->token, $path, $contents);
            } else {
                $response = $this->uploadManager->putFile($this->token, $path, $contents);
            }
        } catch (\Exception $ex) {
            throw $ex;
        }
        list($uploadResult, $error) = $response;
        if ($uploadResult) {
            return $uploadResult;
        } else {
            throw new UploadException('上传文件到七牛失败：' . $error->message());
        }
    }

    protected function addPrefix($path)
    {
        return $this->applyPathPrefix($path);
        // return ltrim($path, '\\/');
    }
}
