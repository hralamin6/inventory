<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class Product extends Model implements HasMedia
{
    use HasFactory;
    protected $guarded = [];
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
    public function invoiceDetails()
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

    use InteractsWithMedia;
//    public function registerMediaConversions(Media $media = null): void
//    {
//        $this
//            ->addMediaConversion('preview')
//            ->fit(Manipulations::FIT_CROP, 300, 300)
//            ->nonQueued();
//    }
    public function registerMediaConversions(Media $media = null) : void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_values');
    }
    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'product_id', 'id');
    }

}
