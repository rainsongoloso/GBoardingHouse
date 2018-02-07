<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\User;
use App\Room;
use Faker\Factory as Faker;
class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $user = new User();
        DB::table('users')->insert([
        'firstname' => 'Rainson',
        'lastname' => 'Goloso',
        'street_ad' => 'Janssen Heights Dampas District',
        'city' => 'Tagbilaran',
        'province' => 'Bohol',
        'email' => 'rainson@gmail.com',
        'contact_no' => '09123861788',
        'username' => 'rson',
        'password' => bcrypt('admin'),
        'status' => 'Active',
        'role' => 'Admin',
        'dob' => Carbon::create('2000', '01', '01')
        ]);
        // $user->save();

        $faker = Faker::create('App\Room');

        for($i=1; $i<=20; $i++)
        {
            DB::table('rooms')->insert([
            'room_no'       =>  $faker->randomDigitNotNull,
            'description'   =>  $faker->text(20),
            'type'          =>  $faker->randomLetter,
            'max_capacity'  =>  $faker->randomDigitNotNull,
            'rate'          =>  $faker->randomFloat,
            'created_at' =>\Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            ]);
        }

        // $faker2 = Faker::create('App\User');

        // for($i = 1; $i<=10; $i++)
        // {
        //     DB::table('users')->insert([
        //     'firstname' => $faker2->word,
        //     'lastname' => $faker2->word,
        //     'street_ad' => $faker2->text(25),
        //     'city' => $faker2->text(10),
        //     'province' => $faker2->text(10),
        //     'email' => $faker2->email,
        //     'contact_no' => $faker2->randomNumber,
        //     'username' => $faker2->name,
        //     'password' => bcrypt($faker2->password),
        //     'dob' => \Carbon\Carbon::now(),
        //     ]);
        // } 
    }
}
