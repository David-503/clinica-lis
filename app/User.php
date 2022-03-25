<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticable;
/**
 * @property string $dui
 * @property int $id_type_user
 * @property string $name
 * @property string $lastname
 * @property string $email
 * @property string $address
 * @property string $password
 * @property string $birthdate
 * @property TypeUser $typeUser
 * @property MedicalMonitoring[] $medicalMonitorings
 * @property File[] $files
 * @property Phone[] $phones
 */
class User extends Authenticable
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'dui';

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
    protected $fillable = ['id_type_user', 'name', 'lastname', 'email', 'address', 'password', 'birthdate', 'remember_token'];


    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeUser()
    {
        return $this->belongsTo('App\TypeUser', 'id_type_user', 'id_type_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medicalMonitorings()
    {
        return $this->hasMany('App\MedicalMonitoring', 'id_promoter', 'dui');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function files()
    {
        return $this->belongsToMany('App\File', 'patients', 'id_patient', 'id_file');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function phones()
    {
        return $this->hasMany('App\Phone', 'id_usuario', 'dui');
    }

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    // public function getAuthIdentifierName(){
    //     $identifierName = $this->namem
    //     return $this->
    // }
    // public function getAuthIdentifier();
    // public function getAuthPassword();
    // public function getRememberToken();
    // public function setRememberToken($value);
    // public function getRememberTokenName();
}
