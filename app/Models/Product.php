<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'status', 'category_id', 'brand_id', 'quantity', 'unit_relation', 'buying_unit_id', 'selling_unit_id'
];
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class)->withDefault();
    }
    public function buyingUnit()
    {
        return $this->belongsTo(Unit::class, 'buying_unit_id', 'id')->withDefault();
    }
    public function sellingUnit()
    {
        return $this->belongsTo(Unit::class, 'selling_unit_id', 'id')->withDefault();
    }


}
