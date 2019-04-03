<?php

namespace App\Http\Controllers;

use App\Services\FileSystem\QiniuAdapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;

class QiniusController extends Controller
{
    // 缓存文件列表
    protected $cdnFiles = [];

    // 缓存 public 文件夹下的目录
    protected $cdnPublicDir = [
        'ext',
        'css',
        'js',
        'fonts',
        'images',
        'svg'
    ];

    public function __construct()
    {
        $this->path = public_path();

        $this->middleware('auth');
    }

    public function index()
    {
        $this->isFounder();

        return view('pages.qinius.index');
    }

    public function cdns(Request $request)
    {
        $this->isFounder();

        // 允许的动作
        $actions = ['delete', 'create', 'refresh'];
        // 动作
        $action = $request->action;
        // 所有的 key
        $keys = [];

        $str = '';
        switch ($action) {
            case 'delete':
                $str = '清空静态资源';
                break;
            case 'create':
                $str = '上传静态资源';
                break;
            case 'refresh':
                $str = '刷新预取';
                break;
        }

        dump($str . ' 开始，请不要刷新页面 ...');

        if (in_array($action, $actions)) {
            // 获取实例
            $flysystem = new QiniuAdapter('qiniu_cdns', '');
            // 列出所有文件
            $images = $flysystem->listContents('css');
            if (!empty($images)) {
                $images = $images['items'];
            }
            $keys = array_column($images, 'key');
        }

        if ($action == 'delete') {
            foreach ($keys as $key) {
                $flysystem->delete($key);
            }
        }

        if ($action == 'create') {
            $files = $this->getPublicPath();
            foreach ($files as $file){
                // 要上传文件的本地路径
                $filePath = $file[0];

                // 上传到七牛后保存的文件名
                $key = $file[1];

                Storage::disk('qiniu_cdns')->write($key, $filePath);
            }
        }

        if ($action == 'refresh') {
            foreach ($keys as $index=> $key) {
                $keys[$index] = assert_cdns($key);
            }
            $flysystem->refresh($keys);
        }

        dump($str . ' 完成，即将跳转 ...');

        return redirect('qinius')->with('success', $str . '成功 ~');
    }

    public function images()
    {
        $this->isFounder();

        // 获取实例
        $flysystem = new QiniuAdapter('qiniu', '');

        // 列出所有文件
        $images = $flysystem->listContents('css');
        if (!empty($images)) {
            $images = $images['items'];
        }

        return view('pages.qinius.images', compact('images'));
    }


    /**
     * 获取 public 文件夹需要做 cdn 缓存的文件列表
     * @return array
     */
    protected function getPublicPath()
    {
        $arr = $this->cdnPublicDir;
        foreach ($arr as $item) {
            $path = $this->path . '/' . $item;
            $this->getPublicFile($path, $item);
        }

        return $this->cdnFiles;
    }

    /**
     * 递归获取文件名
     * [
     *      0=> [
     *          0 => "/home/vagrant/Code/blog/public/css/app.css"
     *          1 => "css/app.css"
     *      ],
     * ]
     * @param $path
     * @param string $key
     */
    protected function getPublicFile($path, $key='')
    {
        $dir = opendir($path);
        while($filename = readdir($dir)){
            if ($filename != '.' && $filename != '..') {
                $tmpPath = $path .'/'. $filename;
                $tmpKey = $key.'/'.$filename;
                if (is_dir($tmpPath)) {
                    $this->getPublicFile($tmpPath, $tmpKey);
                } else {
                    $this->cdnFiles[] = [
                        $tmpPath,
                        $tmpKey
                    ];
                }
            }
        };
        closedir($dir);
    }

    /**
     * 鉴权处理
     */
    protected function isFounder(){
        if (Auth::user() && Auth::user()->hasRole('Founder')) {
            // ...
        } else {
            abort(403);
        }
    }
}
