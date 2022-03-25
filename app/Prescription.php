<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_drug
 * @property string $id_patient
 * @property string $drug
 * @property string $dose
 * @property Patient $patient
 */
class Prescription extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_drug';

    /**
     * @var array
     */
    protected $fillable = ['id_patient', 'drug', 'dose'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient', 'id_patient', 'id_patient');
    }
}
