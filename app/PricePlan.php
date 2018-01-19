<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PricePlan extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'price_plans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'number_of_appointments_per_day', 'number_of_reminders_per_appointment', 'sms_total', 'support', 'price', 'paypal_plan_id'];

}
