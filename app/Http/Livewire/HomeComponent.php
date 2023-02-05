<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class HomeComponent extends Component
{use WithPagination;
    use LivewireAlert;

    public $itemPerPage;
    public $orderBy = 'id';
    public $searchBy = 'id';
    public $orderDirection = 'asc';
    public $search = '';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function addCart($id, $name, $quantity, $price)
    {
        Cart::instance('cart')->add($id, $name, $quantity, $price)->associate('Product');;
    }

    public function render()
    {
//        dd(Cart::instance('cart')->content());

        $cart=Cart::instance('cart')->content()->pluck('id');
        $products = Product::where('status', 'active')->get();
        $categories = Product::where('status', 'active')->get();

        $items = Product::with('category', 'brand', 'buyingUnit', 'sellingUnit', 'invoiceDetails', 'purchaseDetails')
            ->where($this->searchBy, 'like', '%'.$this->search.'%')->orderBy($this->orderBy, $this->orderDirection)
            ->paginate($this->itemPerPage, ['id', 'regular_price', 'name', 'status', 'category_id', 'brand_id', 'quantity', 'unit_relation', 'buying_unit_id', 'selling_unit_id', 'created_at'])
            ->withQueryString();
        return view('livewire.home-component', compact('products', 'categories', 'items', 'cart'))->layout('layouts.web');
    }
}
