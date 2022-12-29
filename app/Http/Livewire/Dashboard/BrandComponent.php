<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Brand;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class BrandComponent extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $brand;
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

    public function loadData(Brand $brand)
    {
        $this->reset('name', 'status');
        $this->emit('openEditModal');
        $this->name = $brand->name;
        $this->status = $brand->status;
        $this->brand = $brand;
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
            'name' => ['required', 'min:2', 'max:44', Rule::unique('brands', 'name')->ignore($this->brand['id'])]
        ]);
        $this->brand->update($data);
        $this->emit('dataAdded', ['dataId' => 'item-id-'.$this->brand->id]);
        $this->alert('success', __('Data updated successfully'));
        $this->reset('name', 'status');
    }
    public function saveData()
    {
        $data = $this->validate([
            'status' => ['required'],
            'name' => ['required', 'min:2', 'max:44', Rule::unique('brands', 'name')]
        ]);
        $data = Brand::create($data);
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
    public function changeStatus(Brand $brand)
    {
        $brand->status=='active'?$brand->update(['status'=>'inactive']):$brand->update(['status'=>'active']);
        $this->alert('success', __('Data updated successfully'));
    }
    public function deleteMultiple()
    {
        Brand::whereIn('id', $this->selectedRows)->delete();
        $this->selectPageRows = false;
        $this->selectedRows = [];
        $this->alert('success', __('Data deleted successfully'));
    }
    public function deleteSingle(Brand $brand)
    {
        $brand->delete();
        $this->alert('success', __('Data deleted successfully'));
    }
    public function getDataProperty()
    {
        return Brand::where($this->searchBy, 'like', '%'.$this->search.'%')->orderBy($this->orderBy, $this->orderDirection)->paginate($this->itemPerPage, ['id', 'name', 'status', 'created_at'])->withQueryString();
    }

    public function resetData()
    {
        $this->reset('name', 'status');
    }
    public function render()
    {
        $items = $this->data;
        return view('livewire.dashboard.brand-component', compact('items'));
    }
}
