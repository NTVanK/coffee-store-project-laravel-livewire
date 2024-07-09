<?php
    namespace App\Helper;

use App\Models\Products;

    class Cart
    {
        public $items = [];
        public function __construct()
        {
            $this->items = session('carts') ?: [];
        }

        public function list()
        {
            return $this->items; 
        }

        public function add($id, $quantity = 1)
        {
            $product = Products::find($id);

            if($product) {
                $this->items[$id] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->image[0],
                    'price' => $product->price,
                    'quantity' => $quantity
                ];

                session(['carts' => $this->items]);
            }
        }

        public function updateQuantity($id, $quantity)
        {
            if(isset($this->items[$id])) $this->items[$id]['quantity'] = $quantity;
            session(['carts' => $this->items]);
        }

        public function totalPrice($id)
        {
            return $this->items[$id]['quantity'] * $this->items[$id]['price'] ?? null;
        }

        public function totalItems()
        {
            return array_reduce($this->items, function ($carry, $item) {
                return $carry + $item['quantity'] * $item['price'];
            }, 0);
        }


        public function delete($id)
        {
            if(isset($this->items[$id]))
            {
                unset($this->items[$id]);
            }
            session(['carts' => $this->items]);
        }

        public function destroy()
        {
            if(session('carts'))
            {
                session()->forget('carts');
            }
        }
    }
