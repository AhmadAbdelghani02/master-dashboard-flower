<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the shipments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipments = Shipment::with('order')->paginate(10);
        return view('admin.shipments.index', compact('shipments'));
    }

    /**
     * Show the form for creating a new shipment.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $orders = Order::all();
        return view('admin.shipments.create', compact('orders'));
    }

    /**
     * Store a newly created shipment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,order_id',
            'shipping_date' => 'nullable|date',
            'estimated_delivery' => 'nullable|date|after_or_equal:shipping_date',
            'actual_delivery' => 'nullable|date',
            'status' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Shipment::create($request->all());

        return redirect()->route('admin.shipments.index')
            ->with('success', 'Shipment created successfully.');
    }

    /**
     * Display the specified shipment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shipment = Shipment::with('order')->findOrFail($id);
        return view('admin.shipments.show', compact('shipment'));
    }

    /**
     * Show the form for editing the specified shipment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shipment = Shipment::findOrFail($id);
        $orders = Order::all();
        return view('admin.shipments.edit', compact('shipment', 'orders'));
    }

    /**
     * Update the specified shipment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,order_id',
            'shipping_date' => 'nullable|date',
            'estimated_delivery' => 'nullable|date|after_or_equal:shipping_date',
            'actual_delivery' => 'nullable|date',
            'status' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $shipment = Shipment::findOrFail($id);
        $shipment->update($request->all());

        return redirect()->route('admin.shipments.index')
            ->with('success', 'Shipment updated successfully.');
    }

    /**
     * Remove the specified shipment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->delete();

        return redirect()->route('admin.shipments.index')
            ->with('success', 'Shipment deleted successfully.');
    }
}