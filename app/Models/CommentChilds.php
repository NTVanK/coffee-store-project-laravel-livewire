<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentChilds extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'comment_id', 'product_id', 'user_id', 'note'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comment()
    {
        return $this->belongsTo(Comments::class, 'comment_id');
    }
}
