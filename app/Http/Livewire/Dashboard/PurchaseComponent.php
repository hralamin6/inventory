<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use PDF;
class PurchaseComponent extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use LivewireAlert;
    public $purchase;
    public $purchaseDetails;
    public $bill;
    public $billDetail;
    public $products;
    public $date, $paid_amount, $supplier_id, $note, $grand_total, $discount, $total, $purchase_no, $product_id;
    public $name, $status='active', $quantity=0, $unit_relation=1, $category_id, $brand_id, $buying_unit_id, $selling_unit_id;
    public $selectedRows = [];
    public $selectPageRows = false;
    public $itemPerPage;
    public $orderBy = 'id';
    public $searchBy = 'id';
    public $orderDirection = 'asc';
    public $search = '';
//    public $inputs = array();
    public Collection $inputs;
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $listeners = ['deleteMultiple', 'deleteSingle'];
    protected $rules = [
        'inputs.*.unit_price' => 'required|numeric|min:1',
        'inputs.*.quantity' => 'required|numeric|min:1',
    ];

    protected $validationAttributes  = [
        'inputs.*.quantity' => 'Quantity',
        'inputs.*.unit_price' => 'Unit price',
        'supplier_id' => 'Supplier',
    ];
    public function createPDF() {
        return $this->redirectRoute('pdf');
    }
     public function mount()
    {
        $this->fill([
            'inputs' => collect([]),
        ]);
        $this->products = $this->product;
        $this->setValue();
    }

    public function setValue()
    {
        $this->date = date('Y-m-d');
        $last_id = Purchase::orderBy('id', 'desc')->first();
        if ($last_id!=null){
            $this->purchase_no = $last_id->id+1;
        }else{
            $this->purchase_no = 1;
        }
    }
    public function add()
    {
        $data = $this->validate([
            'purchase_no' => ['required'],
            'date' => ['required'],
            'product_id' => ['required'],
        ]);
        foreach ($this->inputs as $key => $input) {
            if ($this->inputs[$key]['product_id'] == $this->product_id){
                $this->alert('error', __('You can not select same product'));

                return false;
            }
        }

            $this->inputs->push(['product_id'=>$this->product_id, 'quantity'=>null, 'unit_price'=>null]);
    }
    public function remove($key)
    {
        $this->inputs->pull($key);
        $this->calculation();
//        unset($this->inputs[$key]);
        $this->inputs = array_values($this->inputs);
    }

    public function calculation()
    {
        $this->total=0;
        foreach ($this->inputs as $key => $input) {
            if($this->inputs[$key]['unit_price']>=1 && $this->inputs[$key]['quantity']>=1){
                $this->total += $this->inputs[$key]['quantity']*$this->inputs[$key]['unit_price'];
            }else{
                $this->total += 0;
            }
        }
        if ($this->discount>=1){
            $this->grand_total = $this->total-$this->discount;
        }else{
            $this->grand_total = $this->total;
        }
    }
    public function updated($k, $i)
    {
        $this->calculation();
        $this->validate();
    }
    public function updatedCategoryId($id)
    {
        if ($this->category_id!=null){
           $this->products = $this->product->where('category_id', $id);
        }else{
            $this->products = $this->product;
        }
    }
    public function updatedBrandId($id)
    {
        if ($this->brand_id!=null){
           $this->products = $this->product->where('brand_id', $id);
        }else{
            $this->products = $this->product;
        }
    }

    public function loadData(Purchase $purchase)
    {
        $this->reset('purchase_no', 'date', 'supplier_id', 'total', 'grand_total', 'discount', 'note', 'paid_amount');
        $this->emit('openEditModal');
        $this->purchase_no = $purchase->purchase_no;
        $this->date = $purchase->date;
        $this->grand_total = $purchase->total;
        $this->note = $purchase->note;
        $this->supplier_id = $purchase->user_id;
        $discount_amount = Bill::where('purchase_id', $purchase->id)->first()->discount_amount;
        $this->paid_amount = Bill::where('purchase_id', $purchase->id)->first()->paid_amount;
        $this->discount = $discount_amount;
        $this->total = $this->grand_total+$discount_amount;
        $this->purchase = $purchase;
        $this->purchaseDetails = PurchaseDetail::where('purchase_id', $purchase->id)->get();
        $this->bill = Bill::where('purchase_id', $purchase->id)->first();
        $this->billDetail = BillDetail::where('purchase_id', $purchase->id)->first();
        foreach ($this->purchaseDetails as $key => $purchaseDetail){
            $this->inputs->push(['product_id'=>$purchaseDetail->product_id, 'quantity'=>$purchaseDetail->quantity, 'unit_price'=>$purchaseDetail->unit_price]);
        }
    }

    public function openModal()
    {
        $this->reset('purchase_no', 'date', 'supplier_id', 'total', 'grand_total', 'discount', 'note', 'paid_amount');
        $this->emit('openModal');

    }
    public function editData()
    {
        $data = $this->validate([
            'date' => ['required','date'],
            'supplier_id' => ['required', 'numeric'],
            'paid_amount' => ['required', 'numeric'],
            'note' => ['nullable'],
        ]);
        $this->validate();
        if (count($this->inputs)>=1){
            if ($this->paid_amount>$this->grand_total) {
                $this->alert('error', __('You can not paid more than grand total'));
            }else{
                $this->purchase->purchase_no = $this->purchase_no;
                $this->purchase->total = $this->grand_total;
                $this->purchase->note = $this->note;
                $this->purchase->date = $this->date;
                $this->purchase->user_id = $this->supplier_id;
                $this->purchase->status = 'inactive';
                $this->purchase->save();

                foreach ($this->purchaseDetails as $key => $purchaseDetail) {
                    $purchaseDetail->purchase_no = $this->purchase_no;
                    $purchaseDetail->quantity = $this->inputs[$key]['quantity'];
                    $purchaseDetail->unit_price = $this->inputs[$key]['unit_price'];
                    $purchaseDetail->total_price = $this->inputs[$key]['unit_price'] * $this->inputs[$key]['quantity'];
                    $purchaseDetail->product_id = $this->inputs[$key]['product_id'];
                    $purchaseDetail->purchase_id = $this->purchase->id;
                    $purchaseDetail->user_id = $this->supplier_id;
                    $purchaseDetail->status = 'inactive';
                    $purchaseDetail->save();
                    $this->inputs->pull($key);


                }
                $this->bill->purchase_no = $this->purchase_no;
                $this->bill->total_amount = $this->grand_total;
                $this->bill->discount_amount = $this->discount;
                $this->bill->paid_amount = $this->paid_amount;
                $this->bill->due_amount = $this->grand_total - $this->paid_amount;
                $this->bill->purchase_id = $this->purchase->id;
                $this->bill->user_id = $this->supplier_id;
                if ($this->paid_amount == $this->grand_total) {
                    $this->bill->paid_status = 'paid';
                } elseif ($this->paid_amount > 0) {
                    $this->bill->paid_status = 'partial';
                } else {
                    $this->bill->paid_status = 'due';
                }
                $this->bill->save();

                $this->billDetail->purchase_id = $this->purchase->id;
                $this->billDetail->date = $this->date;
                $this->billDetail->current_paid_amount = $this->paid_amount;
                $this->billDetail->save();
                $this->emit('dataAdded', ['dataId' => 'item-id-'.$this->purchase->id]);
                $this->alert('success', __('Data updated successfully'));
                $this->reset('purchase_no', 'date', 'supplier_id', 'total', 'grand_total', 'discount', 'note', 'paid_amount');
                $this->setValue();
            }

        }else{
            $this->alert('error', __('You did not select any product'));

        }
    }
    public function saveData()
    {
        $data = $this->validate([
            'date' => ['required','date'],
            'supplier_id' => ['required', 'numeric'],
            'paid_amount' => ['required', 'numeric'],
            'note' => ['nullable'],
        ]);
        $this->validate();
        if (count($this->inputs)>=1){
            if ($this->paid_amount>$this->grand_total) {
                $this->alert('error', __('You can not paid more than grand total'));
            }else{
                $purchase = new Purchase();
                $purchase->purchase_no = $this->purchase_no;
                $purchase->total = $this->grand_total;
                $purchase->note = $this->note;
                $purchase->date = $this->date;
                $purchase->user_id = $this->supplier_id;
                $purchase->status = 'inactive';
                $purchase->save();

                foreach ($this->inputs as $key => $input) {
                    $purchaseDetail = new PurchaseDetail();
                    $purchaseDetail->purchase_no = $this->purchase_no;
                    $purchaseDetail->quantity = $this->inputs[$key]['quantity'];
                    $purchaseDetail->unit_price = $this->inputs[$key]['unit_price'];
                    $purchaseDetail->total_price = $this->inputs[$key]['unit_price'] * $this->inputs[$key]['quantity'];
                    $purchaseDetail->product_id = $this->inputs[$key]['product_id'];
                    $purchaseDetail->purchase_id = $purchase->id;
                    $purchaseDetail->user_id = $this->supplier_id;
                    $purchaseDetail->status = 'inactive';
                    $purchaseDetail->save();
                    $this->inputs->pull($key);

                }
                $bill = new Bill();
                $bill->purchase_no = $this->purchase_no;
                $bill->total_amount = $this->grand_total;
                $bill->discount_amount = $this->discount;
                $bill->paid_amount = $this->paid_amount;
                $bill->due_amount = $this->grand_total - $this->paid_amount;
                $bill->purchase_id = $purchase->id;
                $bill->user_id = $this->supplier_id;
                if ($this->paid_amount == $this->grand_total) {
                    $bill->paid_status = 'paid';
                } elseif ($this->paid_amount > 0) {
                    $bill->paid_status = 'partial';
                } else {
                    $bill->paid_status = 'due';
                }
                $bill->save();

                $billDetail = new BillDetail();
                $billDetail->purchase_id = $purchase->id;
                $billDetail->date = $this->date;
                $billDetail->current_paid_amount = $this->paid_amount;
                $billDetail->save();
                $this->reset('purchase_no', 'date', 'supplier_id', 'total', 'grand_total', 'discount', 'note', 'paid_amount');
                $this->goToPage($this->getDataProperty()->lastPage());
                $this->emit('dataAdded', ['dataId' => 'item-id-'.$purchase->id]);
                $this->alert('success', __('Data saved successfully'));
            }

        }else{
            $this->alert('error', __('You did not select any product'));

        }

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
    public function changeStatus(Purchase $purchase)
    {
        $this->alert('success', __('Data updated successfully'));
            foreach ($purchase->purchaseDetails as $key => $purchaseDetail) {
                $product = Product::where('id', $purchaseDetail->product_id)->first();
                $pd = PurchaseDetail::where('id', $purchaseDetail->id)->first();
                if ($purchase->status=='inactive'){
                    $product->quantity += ((float)$purchaseDetail->quantity);
                    $pd->status='active';
                }else{
                    $product->quantity -= ((float)$purchaseDetail->quantity);
                    $pd->status='inactive';
                }
                $product->save();
                $pd->save();
            }
        $purchase->status=='active'?$purchase->update(['status'=>'inactive']):$purchase->update(['status'=>'active']);
    }
    public function deleteMultiple()
    {
        Purchase::whereIn('id', $this->selectedRows)->delete();
        $this->selectPageRows = false;
        $this->selectedRows = [];
        $this->alert('success', __('Data deleted successfully'));
    }
    public function deleteSingle(Purchase $purchase)
    {
        $purchase->delete();
        $this->alert('success', __('Data deleted successfully'));
    }
    public function getDataProperty()
    {
        return Purchase::with( 'supplier')
            ->where($this->searchBy, 'like', '%'.$this->search.'%')->orderBy($this->orderBy, $this->orderDirection)
            ->paginate($this->itemPerPage, ['id', 'status', 'purchase_no', 'total', 'note', 'date', 'user_id', 'created_at'])
            ->withQueryString();
    }
    public function getProductProperty()
    {
        return Product::where('status', 'active')->get();
    }

    public function resetData()
    {
        $this->reset('purchase_no', 'date', 'supplier_id', 'total', 'grand_total', 'discount', 'note', 'paid_amount');
        foreach ($this->inputs as $key => $input) {
            $this->inputs->pull($key);
        }

        $this->setValue();
    }
    public function render()
    {
        $this->authorize('isAdmin');
        $items = $this->data;
        $categories = Category::where('status', 'active')->get();
        $suppliers = User::where('type', 'supplier')->get();
        $brands = Brand::where('status', 'active')->get();
        $units = Unit::where('status', 'active')->get();
        return view('livewire.dashboard.purchase-component', compact('items', 'categories', 'brands', 'units', 'suppliers'));
    }
}
