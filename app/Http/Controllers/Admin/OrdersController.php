<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Address;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'shippingAddress', 'billingAddress', 'payment']);
        
        // Filtering
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Sorting
        $sortField = $request->input('sort', 'order_date');
        $sortDirection = $request->input('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $orders = $query->paginate(15)->withQueryString();
        
        $statuses = [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled'
        ];
        
        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'shippingAddress', 'billingAddress', 'payment', 'shipments', 'promotions']);
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load(['user', 'shippingAddress', 'billingAddress', 'payment', 'promotions']);
        $users = User::select('user_id', 'first_name', 'email')->orderBy('first_name')->get();
        $addresses = Address::all();
        $statuses = [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled'
        ];
        $promotions = Promotion::all();
        
        return view('admin.orders.edit', compact('order', 'users', 'addresses', 'statuses', 'promotions'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'shipping_address_id' => 'required|exists:addresses,address_id',
            'billing_address_id' => 'required|exists:addresses,address_id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|string|max:20',
            'notes' => 'nullable|string',
            'promotion_ids' => 'nullable|array',
            'promotion_ids.*' => 'exists:promotions,id',
            'discount_amounts' => 'nullable|array',
            'discount_amounts.*' => 'numeric|min:0',
        ]);

        DB::beginTransaction();
        
        try {
            $order->update([
                'user_id' => $validated['user_id'],
                'shipping_address_id' => $validated['shipping_address_id'],
                'billing_address_id' => $validated['billing_address_id'],
                'total_amount' => $validated['total_amount'],
                'status' => $validated['status'],
                'notes' => $validated['notes'],
            ]);
            
            // Sync promotions with pivot data
            $promotionData = [];
            if (isset($validated['promotion_ids'])) {
                foreach ($validated['promotion_ids'] as $index => $promotionId) {
                    $promotionData[$promotionId] = [
                        'discount_amount' => $validated['discount_amounts'][$index] ?? 0
                    ];
                }
                $order->promotions()->sync($promotionData);
            } else {
                $order->promotions()->detach();
            }
            
            DB::commit();
            
            return redirect()->route('admin.orders.show', $order)
                ->with('success', 'Order updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update order: ' . $e->getMessage()]);
        }
    }

    public function destroy(Order $order)
    {
        try {
            // Check if the order can be deleted
            if ($order->status !== 'cancelled' && $order->status !== 'pending') {
                return back()->withErrors(['error' => 'Only cancelled or pending orders can be deleted']);
            }
            
            DB::beginTransaction();
            
            // Delete related records
            $order->promotions()->detach();
            $order->payments()->delete();
            $order->shipments()->delete();
            $order->delete();
            
            DB::commit();
            
            return redirect()->route('admin.orders.index')
                ->with('success', 'Order deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to delete order: ' . $e->getMessage()]);
        }
    }
}