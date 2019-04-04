<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use App\Models\CourseArticle;
use App\Services\FileSystem\QiniuAdapter;
use http\Url;
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

    /**
     * 资源管理入口
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->isFounder();

        return view('pages.qinius.index');
    }

    /**
     * cdns 静态资源
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * images 镜像图片库
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
     * 主动提交链接给搜索引擎抓取
     */
    public function urls(Request $request)
    {
        // 待推送的 url 数组
        $urls = [];
        $msg = '推送成功 ~';

        // 博客文章
        $ids = BlogArticle::orderBy('id', 'asc')->pluck('id');
        foreach ($ids as $id) {
            array_push($urls, route('blog.articles.show', $id));
        }

        // 教程文章
        $ids = CourseArticle::with('section')->select('id','course_section_id')->orderBy('id', 'asc')->get();
        foreach ($ids as $item) {
            $book_id = $item->section->book->id;
            $id = $item->id;
            array_push($urls, route('course.articles.show', [$book_id, $id]));
        }


        if ($request->action == 'local') {
            // 写入文件
            $msg = $this->_writeFile($urls);
        }elseif ($request->action == 'baidu') {
            // 推送百度
            $msg = $this->_baidu($urls);
        }

        return redirect('qinius')->with('success', $msg);
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
     * 写入文件 uploads/urls.html
     * @param array $urls
     * @return string
     */
    protected function _writeFile($urls = [])
    {
        $file = public_path() . '/uploads/urls.html';
        $fp = fopen($file, 'w');
        fwrite($fp, '<textarea style="width: 100%;height: 90vh;">' . PHP_EOL);
        foreach ($urls as $url) {
            fwrite($fp, $url . PHP_EOL);
        }
        fwrite($fp, '</textarea>' . PHP_EOL);
        fclose($fp);
        return config('app.url') . '/uploads/urls.html';
    }

    /**
     * 推送到百度
     * @param array $urls
     * @return \Illuminate\Http\RedirectResponse
     */
    private function _baidu($urls = [])
    {
        $msg = '推送成功 ~';
        $api = 'http://data.zz.baidu.com/urls?site=https://www.learnku.net&token=pJNUfWjlnSnO1Ss7';
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $result = json_decode($result);

        if (isset($result->error)){
            $msg = $result->message;
        } elseif ($result->success == '0') {
            if (!empty($result->not_same_site)) {
                $msg = '由于不是本站url而未处理的url列表' . json_encode($result->not_same_site);
            } elseif (!empty($result->not_valid)) {
                $msg = '不合法的url列表' . json_encode($result->not_valid);
            }
        } else {
            $msg = $msg . $result->success . '条';
        }

        return $msg;
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
