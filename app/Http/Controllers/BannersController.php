<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BannersController extends Controller
{
    public function index()
    {
        $this->_policy();
        $banners = Banner::all();
        return view('pages.banners.index', compact('banners'));
    }

    public function create(Banner $banner)
    {
        $this->_policy();
        return view('pages.banners.create_and_edit', compact('banner'));
    }

    public function store(Request $request, Banner $banner)
    {
        $this->_policy();
        $banner->fill($request->all());
        $banner->save();
        return redirect()->route('banners.index')->with('success', 'Banner 创建成功');
    }

    public function edit(Banner $banner)
    {
        $this->_policy();
        return view('pages.banners.create_and_edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $this->_policy();
        $banner->update($request->all());
        return redirect()->route('banners.index')->with('success', '更新成功');
    }

    public function destroy(Banner $banner)
    {
        $this->_policy();
        $banner->delete();
        return redirect()->route('banners.index')->with('success', '删除成功.');
    }

    /**
     * 判断当前用户是否是站长
     */
    protected function _policy()
    {
        if (!Auth::user() || !Auth::user()->isAdminOf()) {
            abort(404);
        }
    }
}
