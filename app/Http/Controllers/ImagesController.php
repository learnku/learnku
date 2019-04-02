<?php

namespace App\Http\Controllers;

use App\Services\FileSystem\QiniuAdapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;

class ImagesController extends Controller
{
    public function index()
    {
        // 获取实例
        $flysystem = new QiniuAdapter('qiniu_cdns', '');

        // 列出所有文件
        $images = $flysystem->listContents('css');
        if (!empty($images)) {
            $images = $images['items'];
        }

        return view('pages.images.index', compact('images'));
    }
}
