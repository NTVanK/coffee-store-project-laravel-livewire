<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'user1_id', 'product_id', 'star', 'note'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function commentChildren()
    {
        return $this->hasMany(CommentChilds::class, 'comment_id');
    }
}
