<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id_patient
 * @property string $id_file
 * @property User $user
 * @property File $file
 * @property MedicalMonitoring[] $medicalMonitorings
 * @property Prescription[] $prescriptions
 */
class Patient extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_patient';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['id_file'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id_patient', 'dui');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo('App\File', 'id_file', 'id_file');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medicalMonitorings()
    {
        return $this->hasMany('App\MedicalMonitoring', 'id_patient', 'id_patient');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prescriptions()
    {
        return $this->hasMany('App\Prescription', 'id_patient', 'id_patient');
    }
}
