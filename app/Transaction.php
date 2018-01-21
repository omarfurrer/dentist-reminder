<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['transaction_id', 'order_number', 'response_msg', 'response_code', 'total', 'data', 'clinic_id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array'
    ];

    /**
     * A transaction belongs to a clinic.
     *
     * @return BelongsTo
     */
    public function clinic()
    {
        return $this->belongsTo('App\Clinic');
    }

}
