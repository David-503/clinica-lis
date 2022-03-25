<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id_file
 * @property int $id_identification_file
 * @property int $id_information_file
 * @property string $created_at
 * @property string $updated_at
 * @property IdentificationFile $identificationFile
 * @property InformationDatum $informationDatum
 * @property Patient[] $patients
 */
class File extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_file';

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
    protected $fillable = ['id_identification_file', 'id_information_file', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function identificationFile()
    {
        return $this->belongsTo('App\IdentificationFile', 'id_identification_file', 'id_identification_file');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function informationDatum()
    {
        return $this->belongsTo('App\InformationDatum', 'id_information_file', 'id_information_data');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function patients()
    {
        return $this->hasMany('App\Patient', 'id_file', 'id_file');
    }
}
