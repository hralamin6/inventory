<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    protected $guarded = [];

    use HasFactory;
    public function purchase()
    {
        return $this->belongsTo(Purchase::class)->withDefault();
    }
    public function bill()
    {
        return $this->belongsTo(Bill::class)->withDefault();
    }

}
