<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsHistory extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sms_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['status', 'error_code'];

    /**
     * A history belongs to an sms.
     *
     * @return BelongsTo
     */
    public function sms()
    {
        return $this->belongsTo('App\Sms');
    }

}
