<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->quantity > $product->stock) {
            return response()->json([
                'message' => 'Insufficient stock'
            ], 400);
        }

        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id()
        ]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $item->quantity += $request->quantity;
            $item->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }

        return response()->json([
            'message' => 'Added to cart'
        ]);
    }

    public function view()
    {
        $cart = Cart::with('items.product')
            ->where('user_id', auth()->id())
            ->first();

        return response()->json($cart);
    }

    public function update(Request $request, $id)
    {
        $item = CartItem::findOrFail($id);

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($request->quantity > $item->product->stock) {
            return response()->json([
                'message' => 'Insufficient stock'
            ], 400);
        }

        $item->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'message' => 'Cart updated'
        ]);
    }

    public function remove($id)
    {
        CartItem::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Item removed'
        ]);
    }

    public function clear()
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if ($cart) {
            $cart->items()->delete();
        }

        return response()->json([
            'message' => 'Cart cleared'
        ]);
    }
}