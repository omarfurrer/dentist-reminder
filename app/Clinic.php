<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clinics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'number_of_reminders_per_appointment', 'sms_template', 'price_plan_id', 'billing_agreement_active'];

  

    /**
     * A clinic has many patients.
     *
     * @return HasMany
     */
    public function patients()
    {
        return $this->hasMany('App\Patient');
    }

    /**
     * A clinic has many users.
     *
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * A clinic has many patient appointments.
     * 
     * @return hasManyThrough
     */
    public function appointments()
    {
        return $this->hasManyThrough('App\Appointment', 'App\Patient');
    }

    /**
     * A clinic has a price plan.
     * 
     * @return HasOne
     */
    public function price_plan()
    {
        return $this->belongsTo('App\PricePlan');
    }

    /**
     * A product has many questions
     *
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

}
