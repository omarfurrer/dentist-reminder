<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Clinic;

class AdminUsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Clinic::create([
            'name' => 'Admin Clinic',
            'sms_template' => "Dear {patient_first_name}, this is a reminder for your dental's appointment {day_relation} {date} at {time}.",
            'price_plan_id' => 7,
            'number_of_reminders_per_appointment' => 3
        ]);
        User::create([
            'first_name' => 'Omar',
            'last_name' => 'Furrer',
            'email' => 'omar.furrer@gmail.com',
            'password' => bcrypt('123456'),
            'country_code' => '20',
            'mobile_number' => '1005214486',
            'is_admin' => true,
            'clinic_id' => 1
        ]);
        User::create([
            'first_name' => 'Ahmed',
            'last_name' => 'Al Gallad',
            'email' => 'Ahmed.algalladd@gmail.com',
            'password' => bcrypt('123456'),
            'country_code' => '20',
            'mobile_number' => '1157486130',
            'is_admin' => true,
            'clinic_id' => 1
        ]);
    }

}
