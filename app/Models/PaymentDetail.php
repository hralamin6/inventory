<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    use HasFactory;
    public function invoice()
    {
        return $this->belongsTo(Invoice::class)->withDefault();
    }
    public function bill()
    {
        return $this->belongsTo(Payment::class)->withDefault();
    }

}
