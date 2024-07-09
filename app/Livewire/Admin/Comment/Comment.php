<?php

namespace App\Livewire\Admin\Comment;

use App\Models\CommentChilds;
use App\Models\Comments;
use App\Models\Products;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Comment extends Component
{
    public $star = [];
    public $comment_id;
    public $user;
    public $event = false;
    public $number;
    public $note;

    public $product_id = '';

    public function showComment($id = null, $user = null)
    {
        $this->user = null;
        $this->star = [];
        $this->note = '';
        $this->comment_id = '';

        if($user == null)
        {
            $this->event = $this->event == false ? true : false;
        } 
        else
        {
            $this->event = true;
            $this->comment_id = $id;
            $this->user = User::where('id', $user)->first();
        }

    }

    public function addStar($id)
    {
        $this->star = [];
        for($i=1; $i <= $id; $i++)
        {
            $this->star[] = $i;
        }
    }

    public function addComment()
    {
        
        if(!Auth::check())
        {
            return $this->dispatch('show-toast',['type' => 'error', 'message' => 'Vui lòng đăng nhập để bình luận!']);
        }

        try
        {
            if(!$this->user)
            {
                $comment = Comments::create([
                    'user1_id' => Auth::user()->id, 
                    'product_id' => $this->product_id,
                    'star' => count($this->star), 
                    'note' => $this->note
                ]);
            }
            else
            {
                $comment = CommentChilds::create([
                    'comment_id' => $this->comment_id, 
                    'product_id' => Comments::where('id', $this->comment_id)->first()->product->id, 
                    'user_id' => Auth::user()->id, 
                    'note' => $this->note
                ]);
            }

            $this->comment_id = '';
            $this->event = false;
            $this->user = null;
            $this->star = [];
            $this->note = '';
        }
        catch (\Exception $e)
        {
            return $this->dispatch('show-toast',['type' => 'error', 'message' => 'Lỗi! '.$e->getMessage()]);
        }
        
    }

    public function filter($number = null)
    {
        $this->number = $number;
    }
    public function render()
    {
        $query = Comments::query();

        if (!is_null($this->number) && $this->number !== '') {
            $query->where('star', $this->number);
        }

        if (!is_null($this->product_id) && $this->product_id !== '') {
            $query->where('product_id', $this->product_id);
        }

        $comments = $query->orderBy('created_at', 'desc')->paginate(4);

        return view('livewire.admin.comment.comment', [
            'comments' => $comments,
            'products' => Products::all()
        ]);

    }
}
