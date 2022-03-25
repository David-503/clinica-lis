<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_identification_file
 * @property boolean $gender
 * @property int $age
 * @property string $marital_status
 * @property string $occupation
 * @property string $father_name
 * @property string $mother_name
 * @property string $couple_name
 * @property string $attendant_name
 * @property string $attendant_address
 * @property string $attendant_phone
 * @property string $provided_information_name
 * @property string $provided_information_relationship
 * @property string $provided_information_dui
 * @property string $couple_provided_information_name
 * @property string $take_information_name
 * @property string $inscription_date
 * @property File[] $files
 */
class IdentificationFile extends Model
{

    protected $table = 'identification_files';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_identification_file';

    /**
     * @var array
     */
    protected $fillable = ['gender', 'age', 'marital_status', 'occupation', 'father_name', 'mother_name', 'couple_name', 'attendant_name', 'attendant_address', 'attendant_phone', 'provided_information_name', 'provided_information_relationship', 'provided_information_dui', 'couple_provided_information_name', 'take_information_name', 'inscription_date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany('App\File', 'id_identification_file', 'id_identification_file');
    }
}
