<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Unit;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class UnitComponent extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use LivewireAlert;
    public $unit;
    public $name, $status='active';
    public $selectedRows = [];
    public $selectPageRows = false;
    public $itemPerPage;
    public $orderBy = 'id';
    public $searchBy = 'id';
    public $orderDirection = 'asc';
    public $search = '';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $listeners = ['deleteMultiple', 'deleteSingle'];

    public function loadData(Unit $unit)
    {
        $this->reset('name', 'status');
        $this->emit('openEditModal');
        $this->name = $unit->name;
        $this->status = $unit->status;
        $this->unit = $unit;
    }

    public function openModal()
    {
        $this->reset('name', 'status');
        $this->emit('openModal');

    }
    public function editData()
    {
       $data = $this->validate([
            'status' => ['required'],
            'name' => ['required', 'min:2', 'max:44', Rule::unique('units', 'name')->ignore($this->unit['id'])]
        ]);
        $this->unit->update($data);
        $this->emit('dataAdded', ['dataId' => 'item-id-'.$this->unit->id]);
        $this->alert('success', __('Data updated successfully'));
        $this->reset('name', 'status');
    }
    public function saveData()
    {
        $data = $this->validate([
            'status' => ['required'],
            'name' => ['required', 'min:2', 'max:44', Rule::unique('units', 'name')]
        ]);
        $data = Unit::create($data);
        $this->reset('name', 'status');
        $this->goToPage($this->getDataProperty()->lastPage());
        $this->emit('dataAdded', ['dataId' => 'item-id-'.$data->id]);
        $this->alert('success', __('Data updated successfully'));

    }
    public function orderByDirection($field)
    {
        $this->orderBy = $field;
        $this->orderDirection==='asc'? $this->orderDirection='desc': $this->orderDirection='asc';
    }

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->data->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        } else {
            $this->reset('selectedRows', 'selectPageRows');
        }
    }
    public function changeStatus(Unit $unit)
    {
        $unit->status=='active'?$unit->update(['status'=>'inactive']):$unit->update(['status'=>'active']);
        $this->alert('success', __('Data updated successfully'));
    }
    public function deleteMultiple()
    {
        Unit::whereIn('id', $this->selectedRows)->delete();
        $this->selectPageRows = false;
        $this->selectedRows = [];
        $this->alert('success', __('Data deleted successfully'));
    }
    public function deleteSingle(Unit $unit)
    {
        $unit->delete();
        $this->alert('success', __('Data deleted successfully'));
    }
    public function getDataProperty()
    {
        return Unit::where($this->searchBy, 'like', '%'.$this->search.'%')->orderBy($this->orderBy, $this->orderDirection)->paginate($this->itemPerPage, ['id', 'name', 'status', 'created_at'])->withQueryString();
    }

    public function resetData()
    {
        $this->reset('name', 'status');
    }
    public function render()
    {
        $this->authorize('isAdmin');
        $items = $this->data;
        return view('livewire.dashboard.unit-component', compact('items'));
    }
}
