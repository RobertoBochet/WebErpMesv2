<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Workflow\OrderLines;

class OrdersLinesIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $sortField = 'LABEL'; // default sorting field
    public $sortAsc = true; // default sort direction
    
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc; 
        } else {
            $this->sortAsc = true; 
        }
        $this->sortField = $field;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $OrderLines = OrderLines::where('LABEL','like', '%'.$this->search.'%')->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->paginate(15);
        return view('livewire.orders-lines-index', [
            'OrderLineslist' => $OrderLines,
        ]);
    }
}
