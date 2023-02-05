<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id', 'id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'attribute_values');
    }

}
