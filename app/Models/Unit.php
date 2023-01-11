<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
    ];
    public function buyingProducts()
    {
        return $this->hasMany(Product::class, 'buying_unit_id', 'id');
    }
    public function sellingProducts()
    {
        return $this->hasMany(Product::class, 'selling_unit_id', 'id');
    }

}
