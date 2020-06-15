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

        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\en_US\PhoneNumber($faker));
        for ($i = 0; $i < 10; $i++) {
            echo $faker->name, "\n";
        }
        try {
            $administrator = new \App\User;
            $administrator->username = "prayogolintang21";
            $administrator->name = "Lintang Prayogo";
            $administrator->email = "lintangprayogo12@gmail.com";
            $administrator->roles = json_encode(["ADMIN"]);
            $administrator->password = \Hash::make("12345678");
            $administrator->phone = "081212367674";
            $administrator->avatar = "avatars/blank.png";
            $administrator->address = "Sarmili, Bintaro, Tangerang Selatan";

            $administrator->save();

            $this->command->info("User Admin berhasil diinsert");
        } catch (Exception $e) {
        }


        for ($i = 0; $i < 5; $i++) {
            $administrator = new \App\User;
            $administrator->username = $faker->userName;
            $administrator->name = $faker->name;
            $administrator->email = $faker->email;
            $administrator->roles = json_encode(["ADMIN"]);
            $administrator->password = \Hash::make("12345678");
            $administrator->phone = $faker->phoneNumber;
            $administrator->avatar = "avatars/blank.png";
            $administrator->address = $faker->address;
            $administrator->save();
            $this->command->info("User Admin berhasil diinsert");
        }

        for ($i = 0; $i < 5; $i++) {
            $staff = new \App\User;
            $staff->username = $faker->userName;
            $staff->name = $faker->name;
            $staff->email = $faker->email;
            $staff->roles = json_encode(["STAFF"]);
            $staff->password = \Hash::make("12345678");
            $staff->phone = $faker->phoneNumber;
            $staff->avatar = "avatars/blank.png";
            $staff->address = $faker->address;
            $staff->save();
            $this->command->info("User Staff berhasil diinsert");
        }
        for ($i = 0; $i < 5; $i++) {
            $customer = new \App\User;
            $customer->username = $faker->userName;
            $customer->name = $faker->name;
            $customer->email = $faker->email;
            $customer->roles = json_encode(["CUSTOMER"]);
            $customer->password = \Hash::make("12345678");
            $customer->phone = $faker->phoneNumber;
            $customer->avatar = "avatars/blank.png";
            $customer->address = $faker->address;
            $customer->save();
            $this->command->info("User Customer berhasil diinsert");
        }
    }
}
