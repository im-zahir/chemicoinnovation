<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ListAdminUsers extends Command
{
    protected $signature = 'user:list-admins';
    protected $description = 'List all admin users';

    public function handle()
    {
        $admins = User::where('is_admin', true)->get();

        if ($admins->isEmpty()) {
            $this->warn('No admin users found!');
            if ($this->confirm('Would you like to create an admin user?')) {
                $email = $this->ask('Enter email for the admin user:');
                $user = User::where('email', $email)->first();
                
                if ($user) {
                    $user->update(['is_admin' => true]);
                    $this->info("User {$email} is now an admin!");
                } else {
                    $this->error("User with email {$email} not found!");
                }
            }
            return;
        }

        $this->info('Admin Users:');
        $headers = ['ID', 'Name', 'Email'];
        $rows = $admins->map(function ($admin) {
            return [$admin->id, $admin->name, $admin->email];
        });

        $this->table($headers, $rows);
    }
}
