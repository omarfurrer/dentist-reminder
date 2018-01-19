<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['content', 'from_number', 'from_name', 'to', 'send_at', 'queued', 'failed', 'sent', 'delivered', 'undelivered', 'status', 'sid', 'appointment_id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'send_at'
    ];

    /**
     * An sms belongs to an appointment
     *
     * @return BelongsTo
     */
    public function appointment()
    {
        return $this->belongsTo('App\Appointment');
    }

    /**
     * An sms has a history.
     *
     * @return HasMany
     */
    public function history()
    {
        return $this->hasMany('App\SmsHistory');
    }

}
