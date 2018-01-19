<?php

use Illuminate\Database\Seeder;
use App\PricePlan;

class PricePlansTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1 SMS per appointment
        Priceplan::create(['name' => 'basic', 'number_of_appointments_per_day' => '3', 'number_of_reminders_per_appointment' => 1, 'support' => 'basic', 'price' => 16.99, 'sms_total' => 66, 'paypal_plan_id' => 'P-1UH42622WN331381CAPEQYAY']);
        Priceplan::create(['name' => 'standard', 'number_of_appointments_per_day' => '5', 'number_of_reminders_per_appointment' => 1, 'support' => 'priority', 'price' => 24.99, 'sms_total' => 110]);
        Priceplan::create(['name' => 'advanced', 'number_of_appointments_per_day' => '10', 'number_of_reminders_per_appointment' => 1, 'support' => 'premium', 'price' => 37.99, 'sms_total' => 220]);
        // 2 SMS per appointment
        Priceplan::create(['name' => 'basic', 'number_of_appointments_per_day' => '3', 'number_of_reminders_per_appointment' => 2, 'support' => 'basic', 'price' => 21.99, 'sms_total' => 132]);
        Priceplan::create(['name' => 'standard', 'number_of_appointments_per_day' => '5', 'number_of_reminders_per_appointment' => 2, 'support' => 'priority', 'price' => 32.99, 'sms_total' => 220]);
        Priceplan::create(['name' => 'advanced', 'number_of_appointments_per_day' => '10', 'number_of_reminders_per_appointment' => 2, 'support' => 'premium', 'price' => 53.99, 'sms_total' => 440]);
        // 3 SMS per appointment
        Priceplan::create(['name' => 'basic', 'number_of_appointments_per_day' => '3', 'number_of_reminders_per_appointment' => 3, 'support' => 'basic', 'price' => 25.99, 'sms_total' => 198]);
        Priceplan::create(['name' => 'standard', 'number_of_appointments_per_day' => '5', 'number_of_reminders_per_appointment' => 3, 'support' => 'priority', 'price' => 40.99, 'sms_total' => 330]);
        Priceplan::create(['name' => 'advanced', 'number_of_appointments_per_day' => '10', 'number_of_reminders_per_appointment' => 3, 'support' => 'premium', 'price' => 68.99, 'sms_total' => 660]);
    }

}
