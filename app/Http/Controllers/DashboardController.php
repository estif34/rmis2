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
    
    private function getTotalRisks()
    {
        
            return Risk::count();
        
    }
    
    private function getRisksByLevel($level)
    {
        
        return Risk::where('level', $level)->count();
    }
    
    private function getRisksByStatus($status)
    {

        return Risk::where('status', $status)->count();
    }
    
    private function getUserRisks()
    {
        return Risk::where('user_id', Auth::id())->count();
    }
}