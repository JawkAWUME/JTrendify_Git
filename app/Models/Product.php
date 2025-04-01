<?php

namespace App\Models;

use App\Events\LowStockEvent;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'stock', 'category_id'];
    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function averageRating() {
        return $this->reviews()->avg('rating');
    }

    public static function boot() {
        parent::boot();

        static::updating(function ($product) {
            if ($product-> stock < 5) {
                event(new LowStockEvent($product));
            }
        });
    }
    
}

