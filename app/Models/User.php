<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;



class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
         'clinica_id'
    ];

    public function pacientes(){
        return $this->hasMany(Paciente::class);
    }

    public function citas()
{
    return $this->hasManyThrough(\App\Models\Cita::class, \App\Models\Paciente::class);
}





public function notas()
{
    return $this->hasManyThrough(
        Nota::class,   // Modelo final
        Paciente::class, // Modelo intermedio
        'user_id',     // FK en tabla pacientes que apunta a user
        'paciente_id', // FK en tabla notas que apunta a paciente
        'id',          // PK en tabla usuarios
        'id'           // PK en tabla pacientes
    );
}


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    
}
