<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftBox;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class GiftBoxController extends Controller
{
    /**
     * Display a listing of gift boxes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $giftBoxes = GiftBox::with(['order', 'flower', 'chocolate', 'packaging'])->paginate(10);
        return view('admin.gift_boxes.index', compact('giftBoxes'));
    }

    /**
     * Show the form for creating a new gift box.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
{
    $orders = Order::all();

    $flowers = Product::whereHas('category', function($query) {
        $query->whereIn('name', ['flowers', 'bouquet']);
    })->get();

    $chocolates = Product::whereHas('category', function($query) {
        $query->where('name', 'chocolates');
    })->get();

    $packagings = Product::whereHas('category', function($query) {
        $query->where('name', 'packaging');
    })->get();

    return view('admin.gift_boxes.create', compact('orders', 'flowers', 'chocolates', 'packagings'));
}

    /**
     * Store a newly created gift box in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'nullable|exists:orders,order_id',
            'flower_id' => 'required|exists:products,product_id',
            'chocolate_id' => 'required|exists:products,product_id',
            'packaging_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'custom_message' => 'nullable|string|max:500',
        ]);

        GiftBox::create($validated);

        return redirect()->route('admin.gift-boxes.index')
            ->with('success', 'Gift box created successfully.');
    }

    /**
     * Display the specified gift box.
     *
     * @param  \App\Models\GiftBox  $giftBox
     * @return \Illuminate\Http\Response
     */
    public function show(GiftBox $giftBox)
    {
        // dd("any");
        $giftBox->load(['order', 'flower', 'chocolate', 'packaging']);
        return view('admin.gift_boxes.show', compact('giftBox'));
    }

    /**
     * Show the form for editing the specified gift box.
     *
     * @param  \App\Models\GiftBox  $giftBox
     * @return \Illuminate\Http\Response
     */
    public function edit(GiftBox $giftBox)
    {
        $orders = Order::all();

    $flowers = Product::whereHas('category', function($query) {
        $query->whereIn('name', ['flowers', 'bouquet']);
    })->get();

    $chocolates = Product::whereHas('category', function($query) {
        $query->where('name', 'chocolates');
    })->get();

    $packagings = Product::whereHas('category', function($query) {
        $query->where('name', 'packaging');
    })->get();
        
        return view('admin.gift_boxes.edit', compact('giftBox', 'orders', 'flowers', 'chocolates', 'packagings'));
    }

    /**
     * Update the specified gift box in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GiftBox  $giftBox
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GiftBox $giftBox)
    {
        // dd($giftBox->all());
        $validated = $request->validate([
            'order_id' => 'nullable|exists:orders,order_id',
            'flower_id' => 'required|exists:products,product_id',
            'chocolate_id' => 'required|exists:products,product_id',
            'packaging_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'custom_message' => 'nullable|string|max:500',
        ]);

        $giftBox->update($validated);

        return redirect()->route('admin.gift-boxes.index')
            ->with('success', 'Gift box updated successfully.');
    }

    /**
     * Remove the specified gift box from storage.
     *
     * @param  \App\Models\GiftBox  $giftBox
     * @return \Illuminate\Http\Response
     */
    public function destroy(GiftBox $giftBox)
    {
        $giftBox->delete();

        return redirect()->route('admin.gift-boxes.index')
            ->with('success', 'Gift box deleted successfully.');
    }
}