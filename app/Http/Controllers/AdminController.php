<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // public function __construct()
    // {
    //     // Ensure only admins can access these routes
    //     $this->middleware('admin');
    // }
    
    public function userManagement()
    {
        // Pending users: not approved AND not rejected
        $pendingUsers = User::where('is_approved', false)
        ->where('is_rejected', false)
        ->get();

        // Approved users: approved AND not rejected
        $approvedUsers = User::where('is_approved', true)
            ->where('is_rejected', false)
            ->get();

        // Get all users for reference (useful for rejected users)
        $users = User::all();

        return view('admin.users', compact('pendingUsers', 'approvedUsers', 'users'));
    }
    
    public function approveUser(User $user)
    {
        $user->update(['is_approved' => true]);
        
        return redirect()->back()->with('success', 'User approved successfully');
    }
    
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'string', 'in:user,manager,admin'],
        ]);
        
        $user->update(['role' => $request->role]);
        
        return redirect()->back()->with('success', 'User role updated successfully');
    }
    /**
     * Reject a user account
     */
    public function rejectUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:255'],
        ]);
        
        $user->update([
            'is_approved' => false,
            'is_rejected' => true,
            'rejection_reason' => $validated['rejection_reason'],
        ]);
        
        return redirect()->back()->with('success', 'User account rejected successfully');
    }
    /**
     * Deactivate an approved user account
     */
    public function deactivateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:255'],
        ]);
        
        $user->update([
            'is_approved' => false,
            'is_rejected' => true,
            'rejection_reason' => $validated['rejection_reason'],
        ]);
        
        return redirect()->back()->with('success', 'User account deactivated successfully');
    }
    /**
     * Reactivate a rejected user account
     */
    public function reactivateUser(User $user)
    {
        $user->update([
            'is_approved' => true,
            'is_rejected' => false,
            'rejection_reason' => null,
        ]);
        
        return redirect()->back()->with('success', 'User account reactivated successfully');
    }
}