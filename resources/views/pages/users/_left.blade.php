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
        <a href="{{ route('users.edit_avatar', $user->id) }}" class="item {{ $_left['active']=='edit_avatar' ? 'active' : '' }}">
            <i class="nofloat icon picture outline"></i>
            &nbsp;修改头像
        </a>
        <a href="{{ route('users.edit_password', $user->id) }}" class="item {{ $_left['active']=='edit_password' ? 'active' : '' }}">
            <i class="nofloat icon lock " style="
    color: inherit;"></i>
            &nbsp;修改密码
        </a>
    </div>
</div>
