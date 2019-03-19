<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class GenerateToken extends Command
{
    /**
     * 指令
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'learnku:generate-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '快速为用户生成 token';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userIde = $this->ask('输入用户 id');

        $user = User::find($userIde);

        if (!$user) {
            return $this->error('用户不存在');
        }

        // 一年后过期
        $ttl = 365 * 24 * 60;
        $this->info(Auth::guard('api')->setTTl($ttl)->fromUser($user));
    }
}
