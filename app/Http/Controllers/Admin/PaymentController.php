<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index(Request $request)
    {
        $query = Payment::with('order');
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhere('payment_method', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('payment_id', 'like', "%{$search}%")
                  ->orWhere('amount', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->has('payment_method') && $request->payment_method != '') {
            $query->where('payment_method', $request->payment_method);
        }

        // Sort
        $sort = $request->sort ?? 'payment_date';
        $direction = $request->direction ?? 'desc';
        $query->orderBy($sort, $direction);

        $payments = $query->paginate(10);
        $statuses = Payment::distinct()->pluck('status');
        $paymentMethods = Payment::distinct()->pluck('payment_method');
        
        return view('admin.payments.index', compact('payments', 'statuses', 'paymentMethods'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create()
    {
        $orders = Order::all();
        $paymentMethods = ['Credit Card', 'PayPal', 'Bank Transfer', 'Cash'];
        $statuses = ['pending', 'completed', 'failed', 'refunded'];
        
        return view('admin.payments.create', compact('orders', 'paymentMethods', 'statuses'));
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,order_id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
            'transaction_id' => 'nullable|string|max:100',
            'status' => 'required|string|max:20',
        ]);

        $payment = Payment::create($validated);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment created successfully.');
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        $payment->load('order');
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified payment.
     */
    public function edit(Payment $payment)
    {
        $orders = Order::all();
        $paymentMethods = ['Credit Card', 'PayPal', 'Bank Transfer', 'Cash'];
        $statuses = ['pending', 'completed', 'failed', 'refunded'];
        
        return view('admin.payments.edit', compact('payment', 'orders', 'paymentMethods', 'statuses'));
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,order_id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
            'transaction_id' => 'nullable|string|max:100',
            'status' => 'required|string|max:20',
        ]);

        $payment->update($validated);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified payment from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}