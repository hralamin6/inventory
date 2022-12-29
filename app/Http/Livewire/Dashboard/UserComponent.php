<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class UserComponent extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $user;
    public $name, $phone, $address, $note, $status='active', $type='customer', $email;
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

    public function loadData(User $user)
    {
        $this->reset('name', 'email', 'phone', 'note', 'address', 'status', 'type');
        $this->emit('openEditModal');
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->note = $user->note;
        $this->address = $user->address;
        $this->status = $user->status;
        $this->type = $user->type;
        $this->user = $user;
    }

    public function openModal()
    {
        $this->reset('name', 'email', 'phone', 'note', 'address', 'status', 'type');
        $this->emit('openModal');

    }
    public function editData()
    {
       $data = $this->validate([
            'name' => ['required', 'min:2', 'max:33'],
            'phone' => ['required', 'numeric'],
            'status' => ['required'],
            'type' => ['required'],
            'note' => ['nullable', 'min:10'],
            'address' => ['nullable', 'min:10'],
            'email' => ['required', 'min:2', 'max:44', Rule::unique('users', 'email')->ignore($this->user['id'])]
        ]);
        $this->user->update($data);
        $this->emit('dataAdded', ['dataId' => 'item-id-'.$this->user->id]);
        $this->alert('success', __('Data updated successfully'));
        $this->reset('name', 'email', 'phone', 'note', 'address', 'status', 'type');
    }
    public function saveData()
    {
        $data = $this->validate([
            'name' => ['required', 'min:2', 'max:33'],
            'phone' => ['required', 'numeric'],
            'status' => ['required'],
            'type' => ['required'],
            'note' => ['nullable', 'min:10'],
            'address' => ['nullable', 'min:10'],
            'email' => ['required', 'min:2', 'max:44', Rule::unique('users', 'email')]
        ]);
        $data = User::create($data);
        $this->reset('name', 'email', 'phone', 'note', 'address', 'status', 'type');
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
    public function changeStatus(User $user)
    {
        $user->status=='active'?$user->update(['status'=>'inactive']):$user->update(['status'=>'active']);
        $this->alert('success', __('Data updated successfully'));
    }
    public function deleteMultiple()
    {
        User::whereIn('id', $this->selectedRows)->delete();
        $this->selectPageRows = false;
        $this->selectedRows = [];
        $this->alert('success', __('Data deleted successfully'));
    }
    public function deleteSingle(User $user)
    {
        $user->delete();
        $this->alert('success', __('Data deleted successfully'));
    }
    public function getDataProperty()
    {
        return User::where($this->searchBy, 'like', '%'.$this->search.'%')->orderBy($this->orderBy, $this->orderDirection)->paginate($this->itemPerPage, ['id', 'name', 'email', 'phone', 'address', 'note', 'type', 'status', 'created_at'])->withQueryString();
    }

    public function resetData()
    {
        $this->reset('name', 'email', 'phone', 'note', 'address', 'status', 'type');
    }
    public function render()
    {
        $items = $this->data;
        return view('livewire.dashboard.user-component', compact('items'));
    }
}
