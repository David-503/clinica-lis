<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_information_data
 * @property boolean $highrisk_pregnancy
 * @property string $location
 * @property string $ethnic
 * @property boolean $literate
 * @property string $studies
 * @property boolean $lonely
 * @property boolean $tbc
 * @property boolean $diabetes
 * @property boolean $hipertension
 * @property boolean $preeclamsia
 * @property boolean $eclampsia
 * @property string $other_illness
 * @property boolean $surgery
 * @property boolean $infertility
 * @property boolean $heart_disease
 * @property boolean $nephropathy
 * @property boolean $violence
 * @property boolean $VIH
 * @property boolean $end_of_last_pregnancy
 * @property boolean $planned_pregnancy
 * @property string $contraceptives
 * @property float $last_weight
 * @property float $size
 * @property boolean $antirubeola
 * @property boolean $antitetanica
 * @property boolean $actively_smoke
 * @property boolean $passively_smoke
 * @property boolean $use_drugs
 * @property boolean $alcoholic
 * @property File[] $files
 */
class InformationDataFile extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'information_data';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_information_data';

    /**
     * @var array
     */
    protected $fillable = ['highrisk_pregnancy', 'location', 'ethnic', 'literate', 'studies', 'lonely', 'tbc', 'diabetes', 'hipertension', 'preeclamsia', 'eclampsia', 'other_illness', 'surgery', 'infertility', 'heart_disease', 'nephropathy', 'violence', 'VIH', 'end_of_last_pregnancy', 'planned_pregnancy', 'contraceptives', 'last_weight', 'size', 'antirubeola', 'antitetanica', 'actively_smoke', 'passively_smoke', 'use_drugs', 'alcoholic'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany('App\File', 'id_information_file', 'id_information_data');
    }
}
