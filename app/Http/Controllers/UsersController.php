<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show(User $user)
    {
        return view('pages.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        dd($user->info()->toSql());
        return view('pages.users.edit', compact('user'));
    }

    public function update(UserRequest $reques, User $user)
    {
        dd($reques->toArray());
    }
}
