<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_monitoring
 * @property string $id_promoter
 * @property string $id_patient
 * @property string $date
 * @property User $user
 * @property Patient $patient
 */
class MedicalMonitoring extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'medical_monitoring';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_monitoring';

    /**
     * @var array
     */
    protected $fillable = ['id_promoter', 'id_patient', 'date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id_promoter', 'dui');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient', 'id_patient', 'id_patient');
    }
}
