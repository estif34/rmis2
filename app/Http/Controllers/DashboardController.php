<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use App\Models\RiskCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_risks' => $this->getTotalRisks(),
            'total_categories' => RiskCategory::count(),
            'high_risks' => $this->getRisksByLevel('high'),
            'open_risks' => $this->getRisksByStatus('open'),
            'user_risks' => $this->getUserRisks(),
        ];
        
        if (Auth::user()->role === 'admin') {
            $stats['pending_users'] = User::where('is_approved', false)->count();
            $stats['total_users'] = User::count();
        }
        
        return view('dashboard', compact('stats'));
    }
    
    public function filterByLevel($level)
    {
        $risks = Risk::with(['user', 'category'])
            ->where('level', $level)
            ->latest()
            ->paginate(10);
            
        $filterTitle = ucfirst($level) . ' Level Risks';
        
        return view('risks.filtered', compact('risks', 'filterTitle'));
    }
    
    public function filterByStatus($status)
    {
        $risks = Risk::with(['user', 'category'])
            ->where('status', $status)
            ->latest()
            ->paginate(10);
            
        $filterTitle = ucfirst(str_replace('_', ' ', $status)) . ' Risks';
        
        return view('risks.filtered', compact('risks', 'filterTitle'));
    }
    
    public function filterUserRisks()
    {
        $risks = Risk::with(['user', 'category'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        $filterTitle = 'My Risks';
        
        return view('risks.filtered', compact('risks', 'filterTitle'));
    }
    
    public function filterAllRisks()
    {
        $risks = Risk::with(['user', 'category'])
            ->latest()
            ->paginate(10);
            
        $filterTitle = 'All Risks';
        
        return view('risks.filtered', compact('risks', 'filterTitle'));
    }
    
    private function getTotalRisks()
    {
        // All users can see all risks now
        return Risk::count();
    }
    
    private function getRisksByLevel($level)
    {
        // All users can see all risks with the specified level
        return Risk::where('level', $level)->count();
    }
    
    private function getRisksByStatus($status)
    {
        // All users can see all risks with the specified status
        return Risk::where('status', $status)->count();
    }
    
    private function getUserRisks()
    {
        // This still shows only risks created by the current user
        return Risk::where('user_id', Auth::id())->count();
    }
}