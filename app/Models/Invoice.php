<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded = [];

    use HasFactory;
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }
    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
