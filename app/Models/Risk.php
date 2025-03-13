<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        // Risk assessment attributes
        'level',
        'proximity',
        'likelihood',
        'risk_area',
        'department',
        'status',
        
        // Impact details
        'impact_level',
        'impact_likelihood',
        'impact_proximity',
        'impact_description',
        'impact_type',
        'cause_of_impact',
        'financial_impact',
        'impact_status',
        
        // Mitigation details
        'response_type',
        'mitigation_strategy',
        'residual_risk',
        'mitigation_department',
        'mitigation_status',
        
        // Foreign keys
        'user_id',
        'risk_category_id',
        'updated_by',
    ];
    
    /**
     * Get the user that created the risk.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the category of the risk.
     */
    public function category()
    {
        return $this->belongsTo(RiskCategory::class, 'risk_category_id');
    }

    /**
     * Get the collaborators for the risk.
     */
    public function collaborators()
    {
        return $this->hasMany(RiskCollaborator::class, 'risk_id');
    }

    /**
     * Get all users who can collaborate on this risk.
     */
    public function collaboratingUsers()
    {
        return $this->belongsToMany(User::class, 'risk_collaborators', 'risk_id', 'user_id')
                    ->withPivot('permission')
                    ->withTimestamps();
    }
    /**
     * Get the user who last updated this risk.
     */
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function comments()
    {
        return $this->hasMany(RiskComment::class)->orderBy('created_at', 'asc');
    }
}