<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_type_user
 * @property string $type
 * @property User[] $users
 */
class TypeUser extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_type_user';

    /**
     * @var array
     */
    protected $fillable = ['type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User', 'id_type_user', 'id_type_user');
    }
}
