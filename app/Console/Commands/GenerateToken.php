<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;

class GenerateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'letu:generate-admin-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '快速为管理员生成 token';

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
        $adminId = $this->ask('输入管理员 id');

        $admin = Admin::find($adminId);

        if (!$admin) {
            return $this->error('管理员不存在');
        }

        // 一年以后过期
        $ttl = 365*24*60;
        $this->info(auth('admin')->setTTL($ttl)->fromUser($admin));
    }
}
