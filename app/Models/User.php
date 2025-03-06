<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department',
        'is_approved',
    ];  

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
            'is_approved' => 'boolean'
        ];
    }
    /**
     * Get the risks created by the user.
     */
    public function risks()
    {
        return $this->hasMany(Risk::class, 'user_id');
    }

    /**
     * Get the risk collaborations for the user.
     */
    public function riskCollaborations()
    {
        return $this->hasMany(RiskCollaborator::class, 'user_id');
    }

    /**
     * Get all risks that the user can collaborate on.
     */
    public function collaborativeRisks()
    {
        return $this->belongsToMany(Risk::class, 'risk_collaborators', 'user_id', 'risk_id')
                    ->withPivot('permission') // If you store permission level in the pivot table
                    ->withTimestamps();
    }

}
