<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\User;

class adminRestore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'restores the admin demo user credentials';

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
        $user = User::where('email', 'admin@admin.com')->first();

        if ($user != null) {

            $user->password = '$2y$10$UnL7P/Euwi5f0XtT5aekyOtzP10VfA2uMu/Svm7ctVxKUIJnFjAtK';
            $user->role_id  =   1;
            $user->verified    = 1;
            $user->name = 'admin';
            $user->avatar = 'http://dev.scriptdemo.website/storage/users/default.png';
            $user->is_ticket_admin  =   1;
            $user->save();

            echo "restored the password";

            return ;
        
        }else{

            echo "User not fount :::::::: ";
        }

        $user = User::create([
            'name'  =>  'admin',
            'role_id'   =>  1,
            'email' =>  'admin@admin.com',
            'verified'  =>  1,
            'is_ticket_admin'  =>   1,
            'avatar'    => 'http://dev.scriptdemo.website/storage/users/default.png',
        ]);

        echo "created a new admin user";

        return ;
    }
}
