<?php

use Illuminate\Database\Seeder;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new \App\User;
        $administrator->username = "prayogolintang21";
        $administrator->name = "Lintang Prayogo";
        $administrator->email = "lintangprayogo12@gmail.com";
        $administrator->roles = json_encode(["ADMIN"]);
        $administrator->password = \Hash::make("12345678");
        $administrator->phone="081212367674"; 
        $administrator->avatar = "saat-ini-tidak-ada-file.png";
        $administrator->address = "Sarmili, Bintaro, Tangerang Selatan";

        $administrator->save();

        $this->command->info("User Admin berhasil diinsert");
    }
}
