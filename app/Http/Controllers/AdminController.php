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
        $pendingUsers = User::where('is_approved', false)->get();
        $approvedUsers = User::where('is_approved', true)->get();
        
        return view('admin.users', compact('pendingUsers', 'approvedUsers'));
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
}