<?php

namespace App\Livewire;

use App\Models\Risk;
use App\Models\RiskCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class RiskSearch extends Component
{
    use WithPagination;
    
    public $search = '';
    public $category = '';
    public $level = '';
    public $status = '';
    
    // Listen for these properties to change and re-render when they do
    protected $queryString = ['search', 'category', 'level', 'status'];
    
    // Reset pagination when filters change
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingCategory()
    {
        $this->resetPage();
    }
    
    public function updatingLevel()
    {
        $this->resetPage();
    }
    
    public function updatingStatus()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        // Get all categories for the dropdown
        $categories = RiskCategory::all();
        
        // Define options for dropdowns
        $levels = ['high', 'medium', 'low'];
        $statuses = ['open', 'in_progress', 'mitigated', 'closed'];
        
        // Base query
        $risksQuery = Risk::query()
            ->with(['user', 'category'])
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('risk_area', 'like', '%' . $this->search . '%')
                      ->orWhere('department', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->category, function ($query) {
                return $query->where('risk_category_id', $this->category);
            })
            ->when($this->level, function ($query) {
                return $query->where('level', $this->level);
            })
            ->when($this->status, function ($query) {
                return $query->where('status', $this->status);
            });
            
        // If not admin, filter to show only accessible risks
        // if (Auth::user()->role !== 'admin') {
        //     $risksQuery->where(function ($query) {
        //         $query->where('user_id', Auth::id())
        //               ->orWhereHas('collaborators', function ($q) {
        //                   $q->where('user_id', Auth::id());
        //               });
        //     });
        // }
        
        // Get paginated results
        $risks = $risksQuery->latest()->paginate(10);
        
        return view('livewire.risk-search', [
            'risks' => $risks,
            'categories' => $categories,
            'levels' => $levels,
            'statuses' => $statuses,
        ]);
    }
    
    public function resetFilters()
    {
        $this->search = '';
        $this->category = '';
        $this->level = '';
        $this->status = '';
        $this->resetPage();
    }
}