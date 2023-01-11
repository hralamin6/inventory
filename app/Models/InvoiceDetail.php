<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    use HasFactory;
    public function invoice()
    {
        return $this->belongsTo(Invoice::class)->withDefault();
    }
    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }

}
