<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'appointments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['time', 'patient_id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'time'
    ];

    /**
     * An appointment belongs to a patient.
     *
     * @return BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }

    /**
     * An appointment has many sms.
     *
     * @return HasMany
     */
    public function sms()
    {
        return $this->hasMany('App\Sms');
    }

}
