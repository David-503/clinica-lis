<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_medical_appointment
 * @property string $id_patient
 * @property string $id_doctor
 * @property string $code_medical_appointment
 * @property boolean $status
 * @property string $appointment_date
 * @property string $initial_date
 * @property string $finalization_date
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property User $user
 */
class MedicalAppoint extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'medical_appointment';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_medical_appointment';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['id_patient', 'id_doctor', 'code_medical_appointment', 'status', 'appointment_date', 'initial_date', 'finalization_date', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('App\User', 'id_patient', 'dui');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo('App\User', 'id_doctor', 'dui');
    }
}
