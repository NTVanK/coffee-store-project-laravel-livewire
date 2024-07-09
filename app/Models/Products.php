<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'category_id',
        'brand_id',
        'import_id',
        'name',
        'slug',
        'image',
        'description',
        'price',
        'is_active',
        'is_featured',
        'is_stock',
        'is_sale'
    ];

    protected $casts = [
        'image' => 'array',
    ];

    public function category() {
        return $this->belongsTo(Categories::class);
    }

    public function brand() {
        return $this->belongsTo(Brands::class);
    }

    public function import()
    {
        return $this->belongsTo(Imports::class);
    }

    public function comment()
    {
        $comments = $this->hasMany(Comments::class, 'product_id')->get();
        if ($comments->isEmpty()) {
            return 0;
        }

        $totalStars = 0;
        foreach ($comments as $comment) {
            $totalStars += $comment->star;
        }

        $averageStars = $totalStars / $comments->count();

        return ceil($averageStars);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class, 'product_id');
    }
}
