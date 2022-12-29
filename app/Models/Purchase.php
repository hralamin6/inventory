<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded = [];

    use HasFactory;
    public function supplier()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }
    public function PurchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }


}
