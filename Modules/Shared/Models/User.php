<?php

namespace Modules\Shared\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Client\Models\Client;
use Modules\CompleteInfo\Models\Residence;
use Modules\CompleteInfo\Models\Speciality;
use Modules\CompleteInfo\Models\Talent;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'number',
        'email',
        'password',
        'remember_token',
        'email_verification_token',
        'full_name',
        'username',
        'age',
        'residence_id',
        'study_id',
        'study_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'password',
        'remember_token',
        'email_verification_token',
        'residence_id',
        'study_id',
        'study_type',
        'email_verified_at'

    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function residence ()
    {
        return $this->belongsTo(Residence::class);
    }
    public function talents ()
    {
        return $this->belongsToMany(Talent::class);
    }
    public function study()
    {
        return $this->morphTo();
    }
    public function clients()
    {
        return $this->morphMany(Client::class, 'clientable');
    }
}