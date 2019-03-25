<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BlogReply;

class BlogReplyPolicy extends Policy
{
    public function update(User $user, BlogReply $reply)
    {
        return $user->isAuthorOf($reply);
    }

    public function destroy(User $user, BlogReply $reply)
    {
        return $user->isAuthorOf($reply);
    }
}
