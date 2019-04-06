<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;
use App\Models\BlogReply;

class ReplyPolicy extends Policy
{
    public function update(User $user, Reply $reply)
    {
        return $user->isAuthorOf($reply);
    }

    public function destroy(User $user, Reply $reply)
    {
        return $user->isAuthorOf($reply);
    }
}
