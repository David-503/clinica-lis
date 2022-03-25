<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_phone
 * @property string $id_usuario
 * @property string $phone
 * @property string $type
 * @property User $user
 */
class Phone extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_phone';

    /**
     * @var array
     */
    protected $fillable = ['id_usuario', 'phone', 'type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id_usuario', 'dui');
    }
}
