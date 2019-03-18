<div class="four wide column ">
    <div class="ui fluid large text-center vertical pointing menu" style="border: 1px solid #d3e0e9;">
        <a href="{{ route('users.show', $user->id) }}" class="item {{ $_left['active']=='show' ? 'active' : '' }}">
            <i class="nofloat icon list user"></i>
            &nbsp;个人信息
        </a>
        <a href="{{ route('users.edit', $user->id) }}" class="item {{ $_left['active']=='edit' ? 'active' : '' }}">
            <i class="nofloat icon list alt"></i>
            &nbsp;修改资料
        </a>
        <a href="https://learnku.com/users/24725/edit_avatar" class="item ">
            <i class="nofloat icon picture outline"></i>
            &nbsp;修改头像
        </a>
        <a href="https://learnku.com/users/24725/edit_email_notify" class="item ">
            <i class="nofloat icon bell"></i>
            &nbsp;消息通知
        </a>
        <a href="https://learnku.com/users/24725/edit_social_binding" class="item ">
            <i class="nofloat icon flask"></i>
            &nbsp;账号绑定
        </a>
        <a href="https://learnku.com/users/24725/edit_password" class="item ">
            <i class="nofloat icon lock " style="
    color: inherit;"></i>
            &nbsp;修改密码
        </a>
    </div>
</div>
