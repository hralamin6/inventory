<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DashboardComponent extends Component
{
    use LivewireAlert;

    public $itemPerPage;
    public $orderBy = 'id';
    public $searchBy = 'id';
    public $orderDirection = 'asc';
    public $search = '';
    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function render()
    {
        $products = Product::where('status', 'active')->get();
        $categories = Product::where('status', 'active')->get();

        $items = Product::with('category', 'brand', 'buyingUnit', 'sellingUnit', 'invoiceDetails', 'purchaseDetails')
            ->where($this->searchBy, 'like', '%'.$this->search.'%')->orderBy($this->orderBy, $this->orderDirection)
            ->paginate($this->itemPerPage, ['id', 'regular_price', 'name', 'status', 'category_id', 'brand_id', 'quantity', 'unit_relation', 'buying_unit_id', 'selling_unit_id', 'created_at'])
            ->withQueryString();

        return view('livewire.dashboard.dashboard-component', compact('products', 'categories', 'items'));
    }
}
