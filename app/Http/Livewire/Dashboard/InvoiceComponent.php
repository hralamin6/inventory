<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use PDF;
class InvoiceComponent extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use LivewireAlert;
    public $invoice;
    public $invoiceDetails;
    public $payment;
    public $paymentDetail;
    public $paymentDetails;
    public $products;
    public $date, $paid_amount=0, $customer_id, $note, $grand_total, $discount=0, $total, $invoice_no, $product_id;
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
        'customer_id' => 'Customer',
    ];
    public function generate_pdf()
    {
        return response()->streamDownload(function () {
            $items = Product::all();
            $pdf = PDF::loadView('pdf.products', compact('items'));
            return $pdf->stream('document.pdf');
        }, 'products.pdf');

    }
    public function mount()
    {
        $this->fill([
            'inputs' => collect([]),
        ]);
        $this->products = $this->product;
        $this->setValue();
        $this->invoiceDetails = [];
        $this->paymentDetails = [];

    }

    public function PaidNew()
    {
        $data = $this->validate([
            'date' => ['required','date'],
            'paid_amount' => ['required', 'numeric'],
        ]);
        if ($this->paid_amount<=$this->payment->due_amount){
            $data = PaymentDetail::create(['current_paid_amount'=>$this->paid_amount, 'date'=>$this->date, 'invoice_id'=> $this->invoice->id]);
            $this->payment->paid_amount += ((float)$this->paid_amount);
            $this->payment->due_amount -= ((float)$this->paid_amount);
            $this->payment->save();
            $this->payment = Payment::where('invoice_id', $this->invoice->id)->first();
            $this->paymentDetails = PaymentDetail::where('invoice_id', $this->invoice->id)->get();
            $this->reset('date', 'paid_amount');
            $this->emit('dataAdded', ['dataId' => 'item-id-'.$data->id]);
            $this->alert('success', __('Data updated successfully'));
        }else{
            $this->alert('error', __('Your Due Amount is not so much'));

        }

    }

    public function setValue()
    {
        $this->date = date('Y-m-d');
        $last_id = Invoice::orderBy('id', 'desc')->first();
        if ($last_id!=null){
            $this->invoice_no = $last_id->id+1;
        }else{
            $this->invoice_no = 1;
        }
    }
    public function add()
    {
        $data = $this->validate([
            'invoice_no' => ['required'],
            'date' => ['required'],
            'product_id' => ['required'],
        ]);
        foreach ($this->inputs as $key => $input) {
            if ($this->inputs[$key]['product_id'] == $this->product_id){
                $this->alert('error', __('You can not select same product'));

                return false;
            }
        }

            $this->inputs->push(['product_id'=>$this->product_id, 'quantity'=>null, 'unit_price'=>Product::find($this->product_id)->regular_price]);
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

    public function loadData(Invoice $invoice)
    {
        $this->reset('invoice_no', 'date', 'customer_id', 'total', 'grand_total', 'discount', 'note', 'paid_amount');
        $this->invoice_no = $invoice->invoice_no;
        $this->date = $invoice->date;
        $this->grand_total = $invoice->total;
        $this->note = $invoice->note;
        $this->customer_id = $invoice->user_id;
        $discount_amount = Payment::where('invoice_id', $invoice->id)->first()->discount_amount;
        $this->paid_amount = Payment::where('invoice_id', $invoice->id)->first()->paid_amount;
        $this->discount = $discount_amount;
        $this->total = $this->grand_total+$discount_amount;
        $this->invoice = $invoice;
        $this->invoiceDetails = InvoiceDetail::where('invoice_id', $invoice->id)->get();
        $this->payment = Payment::where('invoice_id', $invoice->id)->first();
        $this->paymentDetail = PaymentDetail::where('invoice_id', $invoice->id)->first();
        foreach ($this->invoiceDetails as $key => $invoiceDetail){
            $this->inputs->push(['product_id'=>$invoiceDetail->product_id, 'quantity'=>$invoiceDetail->quantity, 'unit_price'=>$invoiceDetail->unit_price]);
        }
    }
    public function viewProduct(Invoice $invoice)
    {
        $this->invoice = $invoice;
        $this->invoiceDetails = InvoiceDetail::where('invoice_id', $invoice->id)->get();
        $this->payment = Payment::where('invoice_id', $invoice->id)->first();
        $this->paymentDetails = PaymentDetail::where('invoice_id', $invoice->id)->get();
    }

    public function openModal()
    {
        $this->reset('invoice_no', 'date', 'customer_id', 'total', 'grand_total', 'discount', 'note', 'paid_amount');
        $this->emit('openModal');

    }
    public function editData()
    {
        $data = $this->validate([
            'date' => ['required','date'],
            'invoice_no' => ['required', 'numeric', Rule::unique('invoices', 'invoice_no')->ignore($this->invoice['id'])],
            'customer_id' => ['required', 'numeric'],
            'paid_amount' => ['required', 'numeric'],
            'note' => ['nullable'],
            'discount' => ['required'],
        ]);
        $this->validate();
        if (count($this->inputs)>=1){
            if ($this->paid_amount>$this->grand_total) {
                $this->alert('error', __('You can not paid more than grand total'));
            }else{
                foreach ($this->inputs as $key => $input) {
                    if (Product::find($this->inputs[$key]['product_id'])->quantity<$this->inputs[$key]['quantity']/Product::find($this->inputs[$key]['product_id'])->unit_relation){
                        $this->alert('error', __('you do not have enough stock'));
                        return false;
                    }
                }

                $this->invoice->invoice_no = $this->invoice_no;
                $this->invoice->total = $this->grand_total;
                $this->invoice->note = $this->note;
                $this->invoice->date = $this->date;
                $this->invoice->user_id = $this->customer_id;
                $this->invoice->status = 'inactive';
                $this->invoice->save();

                foreach ($this->invoiceDetails as $key => $invoiceDetail) {
                    $invoiceDetail->invoice_no = $this->invoice_no;
                    $invoiceDetail->quantity = $this->inputs[$key]['quantity'];
                    $invoiceDetail->unit_price = $this->inputs[$key]['unit_price'];
                    $invoiceDetail->total_price = $this->inputs[$key]['unit_price'] * $this->inputs[$key]['quantity'];
                    $invoiceDetail->product_id = $this->inputs[$key]['product_id'];
                    $invoiceDetail->invoice_id = $this->invoice->id;
                    $invoiceDetail->user_id = $this->customer_id;
                    $invoiceDetail->status = 'inactive';
                    $invoiceDetail->save();
                    $this->inputs->pull($key);


                }
                $this->payment->invoice_no = $this->invoice_no;
                $this->payment->total_amount = $this->grand_total;
                $this->payment->discount_amount = $this->discount;
                $this->payment->paid_amount = $this->paid_amount;
                $this->payment->due_amount = $this->grand_total - $this->paid_amount;
                $this->payment->invoice_id = $this->invoice->id;
                $this->payment->user_id = $this->customer_id;
                if ($this->paid_amount == $this->grand_total) {
                    $this->payment->paid_status = 'paid';
                } elseif ($this->paid_amount > 0) {
                    $this->payment->paid_status = 'partial';
                } else {
                    $this->payment->paid_status = 'due';
                }
                $this->payment->save();

                $this->paymentDetail->invoice_id = $this->invoice->id;
                $this->paymentDetail->date = $this->date;
                $this->paymentDetail->current_paid_amount = $this->paid_amount;
                $this->paymentDetail->save();
                $this->emit('dataAdded', ['dataId' => 'item-id-'.$this->invoice->id]);
                $this->alert('success', __('Data updated successfully'));
                $this->reset('invoice_no', 'date', 'customer_id', 'total', 'grand_total', 'discount', 'note', 'paid_amount');
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
            'invoice_no' => ['required', 'numeric', Rule::unique('invoices')],
            'customer_id' => ['required', 'numeric'],
            'paid_amount' => ['required', 'numeric'],
            'note' => ['nullable'],
            'discount' => ['required'],
        ]);
        $this->validate();
        if (count($this->inputs)>=1){
            if ($this->paid_amount>$this->grand_total) {
                $this->alert('error', __('You can not paid more than grand total'));
            }else{
                foreach ($this->inputs as $key => $input) {
                    if (Product::find($this->inputs[$key]['product_id'])->quantity<$this->inputs[$key]['quantity']/Product::find($this->inputs[$key]['product_id'])->unit_relation){
                        $this->alert('error', __('you do not have enough stock'));
                        return false;
                    }
                }
                    $invoice = new Invoice();
                $invoice->invoice_no = $this->invoice_no;
                $invoice->total = $this->grand_total;
                $invoice->note = $this->note;
                $invoice->date = $this->date;
                $invoice->user_id = $this->customer_id;
                $invoice->status = 'inactive';
                $invoice->save();

                foreach ($this->inputs as $key => $input) {
                    $invoiceDetail = new InvoiceDetail();
                    $invoiceDetail->invoice_no = $this->invoice_no;
                    $invoiceDetail->quantity = $this->inputs[$key]['quantity'];
                    $invoiceDetail->unit_price = $this->inputs[$key]['unit_price'];
                    $invoiceDetail->total_price = $this->inputs[$key]['unit_price'] * $this->inputs[$key]['quantity'];
                    $invoiceDetail->product_id = $this->inputs[$key]['product_id'];
                    $invoiceDetail->invoice_id = $invoice->id;
                    $invoiceDetail->user_id = $this->customer_id;
                    $invoiceDetail->status = 'inactive';
                    $invoiceDetail->save();
                    $this->inputs->pull($key);

                }
                $payment = new Payment();
                $payment->invoice_no = $this->invoice_no;
                $payment->total_amount = $this->grand_total;
                $payment->discount_amount = $this->discount;
                $payment->paid_amount = $this->paid_amount;
                $payment->due_amount = $this->grand_total - $this->paid_amount;
                $payment->invoice_id = $invoice->id;
                $payment->user_id = $this->customer_id;
                if ($this->paid_amount == $this->grand_total) {
                    $payment->paid_status = 'paid';
                } elseif ($this->paid_amount > 0) {
                    $payment->paid_status = 'partial';
                } else {
                    $payment->paid_status = 'due';
                }
                $payment->save();

                $paymentDetail = new PaymentDetail();
                $paymentDetail->invoice_id = $invoice->id;
                $paymentDetail->date = $this->date;
                $paymentDetail->current_paid_amount = $this->paid_amount;
                $paymentDetail->save();
                $this->reset('invoice_no', 'date', 'customer_id', 'total', 'grand_total', 'discount', 'note', 'paid_amount');
                $this->goToPage($this->getDataProperty()->lastPage());
                $this->emit('dataAdded', ['dataId' => 'item-id-'.$invoice->id]);
                $this->alert('success', __('Data saved successfully'));
                $this->setValue();

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
    public function changeStatus(Invoice $invoice)
    {
        $this->alert('success', __('Data updated successfully'));
            foreach ($invoice->invoiceDetails as $key => $invoiceDetail) {

                $product = Product::where('id', $invoiceDetail->product_id)->first();
                $pd = InvoiceDetail::where('id', $invoiceDetail->id)->first();
                if ($invoice->status=='inactive' && $product->quantity<$pd->quantity/$product->unit_relation){
                    $this->alert('error', __('you do not have enough stock'));
                    return false;
                }

                if ($invoice->status=='inactive'){
                    $product->quantity -= ((float)$invoiceDetail->quantity/$product->unit_relation);
                    $product->selling_quantity += ((float)$invoiceDetail->quantity/$product->unit_relation);
                    $pd->status='active';
                }else{
                    $product->quantity += ((float)$invoiceDetail->quantity/$product->unit_relation);
                    $product->selling_quantity -= ((float)$invoiceDetail->quantity/$product->unit_relation);

                    $pd->status='inactive';
                }
                $product->save();
                $pd->save();
            }
        $invoice->status=='active'?$invoice->update(['status'=>'inactive']):$invoice->update(['status'=>'active']);
    }
    public function deleteMultiple()
    {
        Invoice::whereIn('id', $this->selectedRows)->delete();
        $this->selectPageRows = false;
        $this->selectedRows = [];
        $this->alert('success', __('Data deleted successfully'));
    }
    public function deleteSingle(Invoice $invoice)
    {
        $invoice->delete();
        $this->alert('success', __('Data deleted successfully'));
    }
    public function getDataProperty()
    {
        return Invoice::with( 'customer')
            ->where($this->searchBy, 'like', '%'.$this->search.'%')->orderBy($this->orderBy, $this->orderDirection)
            ->paginate($this->itemPerPage, ['id', 'status', 'invoice_no', 'total', 'note', 'date', 'user_id', 'created_at'])
            ->withQueryString();
    }
    public function getProductProperty()
    {
        return Product::where('status', 'active')->get();
    }

    public function resetData()
    {
        $this->reset('invoice_no', 'date', 'customer_id', 'total', 'grand_total', 'discount', 'note', 'paid_amount');
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
        $customers = User::where('type', 'customer')->get();
        $brands = Brand::where('status', 'active')->get();
        $units = Unit::where('status', 'active')->get();
        return view('livewire.dashboard.invoice-component', compact('items', 'categories', 'brands', 'units', 'customers'));
    }
}
