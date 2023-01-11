<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductComponent extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use LivewireAlert;
    use WithFileUploads;

    public $product;
    public $name, $image_link, $image,$asdf, $status='active', $quantity=0, $unit_relation=1, $category_id, $brand_id, $buying_unit_id, $selling_unit_id, $regular_price, $actual_price, $overview, $description;
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

    public function loadData(Product $product)
    {
        $this->reset('name', 'status', 'category_id', 'brand_id', 'quantity', 'unit_relation', 'buying_unit_id', 'selling_unit_id');
        $this->emit('openEditModal');
        $this->regular_price = $product->regular_price;
        $this->actual_price = $product->actual_price;
        $this->quantity = $product->quantity;
        $this->unit_relation = $product->unit_relation;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->buying_unit_id = $product->buying_unit_id;
        $this->selling_unit_id = $product->selling_unit_id;
        $this->name = $product->name;
        $this->overview = $product->overview;
        $this->description = $product->description;
        $this->status = $product->status;
        $this->product = $product;
    }

    public function openModal()
    {
        $this->reset('name', 'status', 'category_id', 'brand_id', 'quantity', 'unit_relation', 'buying_unit_id', 'selling_unit_id');
        $this->emit('openModal');

    }

    public function deleteMedia(Product $product, $k)
    {
        $m = $product->getMedia();
       $m[$k]->delete();
    }
    public function editData()
    {
        $this->validate([
            'image'=>'nullable|image',
        ]);

        $data = $this->validate([
           'name' => ['required', 'min:2', 'max:33'],
           'overview' => ['nullable', 'min:2', 'max:333'],
           'description' => ['nullable', 'min:2', 'max:3333'],
           'unit_relation' => ['required', 'numeric'],
           'regular_price' => ['required', 'numeric'],
           'actual_price' => ['required', 'numeric'],
           'quantity' => ['required', 'numeric'],
           'status' => ['required'],
           'category_id' => ['required'],
           'brand_id' => ['required'],
           'buying_unit_id' => ['required'],
        ]);
        $this->product->update($data);
        if ($this->image){
//            $this->product->clearMediaCollection();
            $a = $this->product->addMedia($this->image->getRealPath())->toMediaCollection();
            unlink("media/".$a->id.'/'. $a->file_name);
        }elseif ($this->image_link){
            $this->product->clearMediaCollection();
            $this->product->addMediaFromUrl($this->image_link)->toMediaCollection();
            unlink("media/".$this->product->getFirstMedia()->id.'/'. $this->product->getFirstMedia()->file_name);
        }
        $this->emit('dataAdded', ['dataId' => 'item-id-'.$this->product->id]);
        $this->alert('success', __('Data updated successfully'));
        $this->reset('name', 'status', 'category_id', 'brand_id', 'quantity', 'unit_relation', 'buying_unit_id', 'selling_unit_id');
    }
    public function saveData()
    {
        $data = $this->validate([
            'name' => ['required', 'min:2', 'max:33'],
            'overview' => ['nullable', 'min:2', 'max:333'],
            'description' => ['nullable', 'min:2', 'max:3333'],
            'unit_relation' => ['required', 'numeric'],
            'regular_price' => ['required', 'numeric'],
            'actual_price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'status' => ['required'],
            'category_id' => ['required'],
            'brand_id' => ['required'],
            'buying_unit_id' => ['required'],
            'selling_unit_id' => ['required'],
        ]);
//        Setup::first()->clearMediaCollection('register');
//        Setup::first()->addMedia($this->register->getRealPath())->toMediaCollection('register');
        $data = Product::create($data);
//        $data->addMedia($this->image->getRealPath())->toMediaCollection('logo');
        $this->reset('name', 'status', 'category_id', 'brand_id', 'quantity', 'unit_relation', 'buying_unit_id', 'selling_unit_id');
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
    public function changeStatus(Product $product)
    {
        $product->status=='active'?$product->update(['status'=>'inactive']):$product->update(['status'=>'active']);
        $this->alert('success', __('Data updated successfully'));
    }
    public function deleteMultiple()
    {
        Product::whereIn('id', $this->selectedRows)->delete();
        $this->selectPageRows = false;
        $this->selectedRows = [];
        $this->alert('success', __('Data deleted successfully'));
    }
    public function deleteSingle(Product $product)
    {
        $product->delete();
        $this->alert('success', __('Data deleted successfully'));
    }
    public function getDataProperty()
    {
        return Product::with('category', 'brand', 'buyingUnit', 'sellingUnit', 'invoiceDetails', 'purchaseDetails')
            ->where($this->searchBy, 'like', '%'.$this->search.'%')->orderBy($this->orderBy, $this->orderDirection)
            ->paginate($this->itemPerPage, ['id', 'name', 'status', 'category_id', 'brand_id', 'quantity', 'unit_relation', 'buying_unit_id', 'selling_unit_id', 'created_at'])
            ->withQueryString();
    }

    public function resetData()
    {
        $this->reset('name', 'status', 'category_id', 'brand_id', 'quantity', 'unit_relation', 'buying_unit_id', 'selling_unit_id');
    }
    public function render()
    {
//        dd($this->product);
        $this->authorize('isAdmin');
        $items = $this->data;
        $categories = Category::where('status', 'active')->get();
        $brands = Brand::where('status', 'active')->get();
        $units = Unit::where('status', 'active')->get();
        return view('livewire.dashboard.product-component', compact('items', 'categories', 'brands', 'units'));
    }
}
