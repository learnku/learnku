<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserInfo;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    public function created(User $user)
    {
        $userInfo = new UserInfo();
        $userInfo->user_id = $user->id;

        $userInfo->save();
    }
}
