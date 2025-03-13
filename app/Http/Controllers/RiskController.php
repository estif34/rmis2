<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use App\Models\RiskCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiskController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Display a listing of the risks.
     */
    public function index()
    {
        $risks = Risk::with(['user', 'category'])
            ->where(function($query) {
                // Show risks created by the user
                $query->where('user_id', Auth::id());
                
                // Or risks where the user is a collaborator
                if (!Auth::user()->isAdmin()) {
                    $query->orWhereHas('collaborators', function($q) {
                        $q->where('user_id', Auth::id());
                    });
                }
            })
            ->latest()
            ->paginate(10);
        // all users can view all risks    
        // If admin, show all risks with no filters    
        if (Auth::user()->role === 'admin') {
            $risks = Risk::with(['user', 'category'])->latest()->paginate(10);    
        } else {
        // For regular users, show all risks but indicate which ones they can edit        
        $risks = Risk::with(['user', 'category', 'collaborators'])->latest()->paginate(10);    
        }    
        
        return view('risks.index', compact('risks'));
    }

    /**
     * Show the form for creating a new risk.
     */
    public function create()
    {
        $categories = RiskCategory::all();
        $departments = $this->getDepartmentsList();
        
        return view('risks.create', compact('categories', 'departments'));
    }

    /**
     * Store a newly created risk in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'level' => 'nullable',
            'proximity' => 'nullable',
            'likelihood' => 'nullable',
            'risk_area' => 'nullable',
            'department' => 'nullable',
            'impact_level' => 'nullable',
            'impact_likelihood' => 'nullable',
            'impact_proximity' => 'nullable',
            'impact_description' => 'nullable',
            'impact_type' => 'nullable',
            'cause_of_impact' => 'nullable',
            'financial_impact' => 'nullable|numeric',
            'response_type' => 'nullable',
            'mitigation_strategy' => 'nullable',
            'residual_risk' => 'nullable',
            'mitigation_department' => 'nullable',
            'risk_category_id' => 'required|exists:risk_categories,id',
        ]);
        
        // Add user_id and initial status to the validated data
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'open';
        $validated['impact_status'] = 'pending';
        $validated['mitigation_status'] = 'pending';
        
        $risk = Risk::create($validated);
        
        return redirect()->route('risks.show', $risk)
            ->with('success', 'Risk created successfully.');
    }

    /**
     * Display the specified risk.
     */
    public function show(Risk $risk)
    {
        // Check if user has access to this risk
        $this->authorizeAccess($risk);
        
        $risk->load(['user', 'category', 'collaborators.user', 'comments.user', 'updatedByUser']);
        
        return view('risks.show', compact('risk'));
    }

    /**
     * Show the form for editing the specified risk.
     */
    public function edit(Risk $risk)
    {
        // Check if user has access to edit this risk
        $this->authorizeAccess($risk, 'edit');
        
        $categories = RiskCategory::all();
        $departments = $this->getDepartmentsList();
        
        return view('risks.edit', compact('risk', 'categories', 'departments'));
    }

/**
 * Update the specified risk in storage.
 */
public function update(Request $request, Risk $risk)
{
    // Check if user has access to edit this risk
    $this->authorizeAccess($risk, 'edit');
    
    $validated = $request->validate([
        'title' => 'required|max:255',
        'description' => 'nullable',
        'level' => 'nullable',
        'proximity' => 'nullable',
        'likelihood' => 'nullable',
        'risk_area' => 'nullable',
        'department' => 'nullable',
        'status' => 'nullable|in:open,in_progress,mitigated,closed',
        'impact_level' => 'nullable',
        'impact_likelihood' => 'nullable',
        'impact_proximity' => 'nullable',
        'impact_description' => 'nullable',
        'impact_type' => 'nullable',
        'cause_of_impact' => 'nullable',
        'financial_impact' => 'nullable|numeric',
        'impact_status' => 'nullable',
        'response_type' => 'nullable',
        'mitigation_strategy' => 'nullable',
        'residual_risk' => 'nullable',
        'mitigation_department' => 'nullable',
        'mitigation_status' => 'nullable',
        'risk_category_id' => 'required|exists:risk_categories,id',
    ]);
    
    $validated['updated_by'] = Auth::id();

    $risk->update($validated);
    
    return redirect()->route('risks.show', $risk)
        ->with('success', 'Risk updated successfully.');
}
    /**
     * Remove the specified risk from storage.
     */
    public function destroy(Risk $risk)
    {
        // Check if user has permission to delete this risk
        $this->authorizeAccess($risk, 'delete');
        
        $risk->delete();
        
        return redirect()->route('risks.index')
            ->with('success', 'Risk deleted successfully.');
    }
    
    /**
     * Manage collaborators for a risk.
     */
    public function manageCollaborators(Risk $risk)
    {
    // Only the risk owner or admin can manage collaborators
    if (Auth::id() !== $risk->user_id && Auth::user()->role !== 'admin') {
        return redirect()->route('risks.show', $risk)
            ->with('error', 'You do not have permission to manage collaborators.');
    }
    
    $users = User::where('id', '!=', Auth::id())->get();
    $currentCollaborators = $risk->collaborators->pluck('user_id')->toArray();
    
    return view('risks.collaborators', compact('risk', 'users', 'currentCollaborators'));
    }
    
    /**
     * Update collaborators for a risk.
     */
    public function updateCollaborators(Request $request, Risk $risk)
    {
        // Check if user is the owner or admin
        if (Auth::id() !== $risk->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('risks.show', $risk)
                ->with('error', 'You do not have permission to manage collaborators.');
        }
        
        // Validate the request
        $validated = $request->validate([
            'collaborators' => 'nullable|array',
            'collaborators.*' => 'exists:users,id',
            'permissions' => 'required|array',
            'permissions.*' => 'in:view,edit',
        ]);
        
        // Remove existing collaborators
        $risk->collaborators()->delete();
        
        // Add new collaborators
        if (!empty($validated['collaborators'])) {
            foreach ($validated['collaborators'] as $userId) {
                $permission = $validated['permissions'][$userId] ?? 'view';
                $risk->collaborators()->create([
                    'user_id' => $userId,
                    'permission' => $permission,
                ]);
            }
        }
        
        return redirect()->route('risks.show', $risk)
            ->with('success', 'Collaborators updated successfully.');
    }
    
    /**
     * Helper method to get a list of departments for dropdown
     */
    private function getDepartmentsList()
    {
        return [
            'Finance',
            'Operations',
            'IT',
            'HR',
            'Legal',
            'Marketing',
            'Sales',
            'Executive',
            'Other'
        ];
    }
    
    /**
     * Check if user has access to a risk
     */
    private function authorizeAccess(Risk $risk, $permission = 'view')
    {
        $user = Auth::user();
        
        // Admin has access to all risks
        if ($user->role === 'admin') {
            return true;
        }
        
        // Owner has all access
        if ($risk->user_id === $user->id) {
            return true;
        }
        
        if($permission === 'view'){
            return true;
        }
        // For collaborators, check their permission level
        $collaborator = $risk->collaborators()
            ->where('user_id', $user->id)
            ->where('permission', 'edit')
            ->first();
            
            if (!$collaborator && ($permission === 'edit' || $permission === 'delete')) {
                abort(403, 'You do not have permission to ' . $permission . ' this risk.');
            }
        
        // For edit or delete permission, the collaborator must have 'edit' permission
        if (($permission === 'edit' || $permission === 'delete') && $collaborator->permission !== 'edit') {
            abort(403, 'You do not have permission to ' . $permission . ' this risk.');
        }
        
        return true;
    }
}