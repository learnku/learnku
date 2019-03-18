@extends('layouts.app')
@section('title', '个人信息')

@section('content')
    <div class="ui centered grid container stackable">
        @include('pages.users._left', ['_left'=> ['active'=> 'edit']])

        <div class="twelve wide column">
            <div class="ui stacked segment">
                <div class="content px-3 py-3">
                    <h1>
                        <i class="icon edit" aria-hidden="true"></i> 修改资料
                    </h1>
                    <div class="ui divider"></div>
                    <form class="ui form" method="POST" action="{{ route('users.update', $user->id) }}"
                          accept-charset="UTF-8" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        {{-- 错误消息 --}}
                        @include('shared._error')

                        <div class="two fields">
                            <div class="ten wide field ">
                                <label for="">用户名</label>
                                <input name="name" type="text" value="{{ old('name', $user->name) }}">
                            </div>
                            <div class="six wide field pt-3 mt-4">
                                如：张三
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="ten wide field ">
                                <label for="">性别</label>
                                <select name="gender" class="ui dropdown">
                                    <option value="male">男</option>
                                    <option value="female">女</option>
                                </select>
                            </div>
                            <div class="six wide field pt-3 mt-4">

                            </div>
                        </div>

                        <div class="two fields">
                            <div class="ten wide field ">
                                <label for="">GitHub Name</label>
                                {{--<input name="github_name" type="text" value="{{ old('github_name', $user->info->github_name) }}">--}}
                                <input name="github_name" type="text" value="{{ $user->info->github_name }}">
                            </div>
                            <div class="six wide field pt-3 mt-4">
                                请跟 GitHub 上保持一致
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="ten wide field ">
                                <label for="">邮 箱</label>
                                <input name="email" type="text" value="{{ old('email', $user->email) }}">
                            </div>
                            <div class="six wide field pt-3 mt-4">
                                如：name@website.com
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="ten wide field ">
                                <label for="">真实姓名</label>
                                <input name="real_name" type="text" value="{{ old('real_name', $user->info->real_name) }}">
                            </div>
                            <div class="six wide field pt-3 mt-4">
                                如：李小明
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="ten wide field ">
                                <label for="">城市</label>
                                <input name="city" type="text" value="{{ old('city', $user->info->city) }}">
                            </div>
                            <div class="six wide field pt-3 mt-4">
                                如：北京、广州
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="ten wide field ">
                                <label for="">公司或组织名称</label>
                                <input name="company" type="text" value="{{ old('company', $user->info->company) }}">
                            </div>
                            <div class="six wide field pt-3 mt-4">
                                如：阿里巴巴
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="ten wide field ">
                                <label for="">职位头衔</label>
                                <input name="jobtitle" type="text" value="{{ old('jobtitle', $user->info->jobtitle) }}">
                            </div>
                            <div class="six wide field pt-3 mt-4">
                                如：技术小组长
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="ten wide field ">
                                <label for="">个人网站</label>
                                <input name="personal_website" type="text" value="{{ old('personal_website', $user->info->personal_website) }}">
                            </div>
                            <div class="six wide field pt-3 mt-4">
                                如：example.com，不需要加前缀 https://
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="ten wide field ">
                                <label for="wechat_qrcode">微信账号二维码</label>
                                <input type="file" name="wechat_qrcode" class="image-upload-input" value="{{ old('wechat_qrcode', $user->info->wechat_qrcode) }}">
                                <img class="payment-qrcode" src="" alt="">
                                <span class="close clear-image">x</span>
                            </div>
                            <div class="six wide field pt-3 mt-4">
                                你的微信个人账号，或者订阅号
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="ten wide field ">
                                <label for="">支付二维码</label>
                                <input type="file" name="payment_qrcode" class="image-upload-input" value="{{ old('payment_qrcode', $user->info->payment_qrcode) }}">

                                <img class="payment-qrcode" src="" alt="">
                                <span class="close clear-image">x</span>
                            </div>
                            <div class="six wide field pt-3 mt-4">
                                文章打赏时使用，微信支付二维码
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="ten wide field ">
                                <label for="">用户头像</label>
                                <input type="file" name="avatar" class="image-upload-input"
                                       value="{{ old('avatar', $user->avatar) }}">
                                @if(!empty($user->avatar))
                                <img class="payment-qrcode" src="{{ $user->avatar }}" alt="">
                                <span class="close clear-image">x</span>
                                @endif
                            </div>
                            <div class="six wide field pt-3 mt-4">
                                个人头像
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="ten wide field ">
                                <label for="">个人简介</label>
                                <textarea rows="3" name="introduction" cols="50" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 94.9886px;">{{ old('introduction', $user->introduction) }}</textarea>
                            </div>
                            <div class="six wide field pt-3 mt-4">
                                请一句话介绍你自己，大部分情况下会在你的头像和名字旁边显示
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="ten wide field ">
                                <label for="">署名</label>
                                <textarea rows="3" name="signature" cols="50" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 94.9886px;">{{ old('signature', $user->info->signature) }}</textarea>
                            </div>
                            <div class="six wide field pt-3 mt-4">
                                文章署名，会拼接在每一个你发表过的帖子内容后面。支持 Markdown。
                            </div>
                        </div>

                        <div class="field">
                            <div class="col-sm-offset-2 col-sm-6">
                                <input class="ui button primary" id="user-edit-submit" type="submit" value="应用修改">
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@stop
