<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryComponent extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $category;
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

    public function loadData(Category $category)
    {
        $this->reset('name', 'status');
        $this->emit('openEditModal');
        $this->name = $category->name;
        $this->status = $category->status;
        $this->category = $category;
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
            'name' => ['required', 'min:2', 'max:44', Rule::unique('categories', 'name')->ignore($this->category['id'])]
        ]);
        $this->category->update($data);
        $this->emit('dataAdded', ['dataId' => 'item-id-'.$this->category->id]);
        $this->alert('success', __('Data updated successfully'));
        $this->reset('name', 'status');
    }
    public function saveData()
    {
        $data = $this->validate([
            'status' => ['required'],
            'name' => ['required', 'min:2', 'max:44', Rule::unique('categories', 'name')]
        ]);
        $data = Category::create($data);
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
    public function changeStatus(Category $category)
    {
        $category->status=='active'?$category->update(['status'=>'inactive']):$category->update(['status'=>'active']);
        $this->alert('success', __('Data updated successfully'));
    }
    public function deleteMultiple()
    {
        Category::whereIn('id', $this->selectedRows)->delete();
        $this->selectPageRows = false;
        $this->selectedRows = [];
        $this->alert('success', __('Data deleted successfully'));
    }
    public function deleteSingle(Category $category)
    {
        $category->delete();
        $this->alert('success', __('Data deleted successfully'));
    }
    public function getDataProperty()
    {
        return Category::with('products')->where($this->searchBy, 'like', '%'.$this->search.'%')->orderBy($this->orderBy, $this->orderDirection)->paginate($this->itemPerPage, ['id', 'name', 'status', 'created_at'])->withQueryString();
    }

    public function resetData()
    {
        $this->reset('name', 'status');
    }
    public function render()
    {
        $items = $this->data;
        return view('livewire.dashboard.category-component', compact('items'));
    }
}
