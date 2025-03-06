<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskCollaborator extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'risk_id',
        'user_id',
        'permission',
    ];
    
    /**
     * Get the risk that the collaboration is for.
     */
    public function risk()
    {
        return $this->belongsTo(Risk::class, 'risk_id');
    }

    /**
     * Get the user who is collaborating.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}