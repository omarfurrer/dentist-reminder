<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'patients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'mobile_number', 'clinic_id'];

    /**
     * A patient belongs to a clinic.
     *
     * @return BelongsTo
     */
    public function clinic()
    {
        return $this->belongsTo('App\Clinic');
    }

}
