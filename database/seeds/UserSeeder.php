<?php

use App\Http\Constants\UserTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create User types rows
        DB::table('user_types')->insert([
            [
                'id' => UserTypeEnum::blogger,
                'name' => 'Blogger',
                'description' => 'Blogger user type',
            ],
            [
                'id' => UserTypeEnum::supervisor,
                'name' => 'Supervisor',
                'description' => 'Supervisor user type',
            ],
            [
                'id' => UserTypeEnum::admin,
                'name' => 'Admin',
                'description' => 'Admin user type',
            ],
        ]);

        // Create admin

        DB::table('users')->insert([
            [
                'name' => 'Allan',
                'last_name' => 'Ramirez',
                'user_type' => 3, // Admin User Type
                'email' => 'allanhavidramirez@gmail.com',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => bcrypt('81!kp6HGvZfQ'),
            ]
        ]);


    }
}
