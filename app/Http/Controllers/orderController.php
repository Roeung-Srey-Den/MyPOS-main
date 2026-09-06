<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Table;
use Illuminate\Http\Request;

class orderController extends Controller
{
   public function updateOrder(Request $request, $orderId)
    {
        $request->validate([
            'cart' => 'required',
            'customer_id' => 'required|exists:customers,id',
            'note' => 'nullable|string',
            'table' => 'nullable|string',
            'order_type' => 'nullable|string',
        ]);

        $order = Order::findOrFail($orderId);

        $order->update([
            'customer_id' => $request->customer_id,
            'note' => $request->note,

        ]);

        $order->orderItems()->delete();

        $cartItems = json_decode($request->cart, true);

        foreach ($cartItems as $item) {
            $order->orderItems()->create([
                'product_id' => $item['product_id'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        return response()->json(['message' => 'Order updated successfully']);
    }

    public function saveOrder(Request $request)
    {
        $request->validate([
            'cart' => 'required|json',
            'customer_id' => 'nullable|exists:customers,id',
            'table_number_id' => 'nullable|exists:table_numbers,id',
        ]);

        $cartItems = json_decode($request->cart, true);

        if ($request->table_number_id) {
            $order = Order::where('table_number_id', $request->table_number_id)
                        ->where('status', 'unpaid') 
                        ->latest()
                        ->first();
        } elseif ($request->customer_id) {
            $order = Order::where('customer_id', $request->customer_id)
                        ->where('status', 'unpaid') 
                        ->latest()
                        ->first();
        }


        if (!$order) {
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'table_number_id' => $request->table_number_id,
                'shift_id' => null,
                'user_id' => auth()->id(),
                'note' => '',
                'subtotal' => 0,
                'tax' => 0,
                'total' => 0,
                'status' => 'unpaid',
            ]);
        } else {
            $order->orderItems()->delete();
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $order->orderItems()->create([
                'product_id' => $item['product_id'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
            $subtotal += $item['price'] * $item['quantity'];
        }

        $tax = $subtotal * 0.1;
        $total = $subtotal + $tax;

        $order->update([
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);

        if ($request->table_number_id) {
            Table::where('id', $request->table_number_id)
                ->update(['is_occupied' => true]);
        }

        return response()->json(['message' => 'Order saved successfully!', 'order_id' => $order->id]);
    }


    public function status($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'paid';
        $order->paid_at = now();
        $order->save();

        if ($order->table_number_id) {
            Table::where('id', $order->table_number_id)
                ->update(['is_occupied' => false]);
        }

        return response()->json(['success' => true]);
    }

    
    public function tableView()
    {
        
        $dineInOrders = Order::with(['tableNumber', 'orderItems.product'])
                            ->whereNotNull('table_number_id')
                            ->whereNull('customer_id') 
                            ->where('status', 'unpaid')
                            ->get();

        $deliveryOrders = Order::with(['customer', 'orderItems.product'])->whereHas('customer',function($query){
                                    $query->where('order_type','delivery');
                                })
                            ->whereNotNull('customer_id')
                            ->whereNull('table_number_id') 
                            ->where('status', 'unpaid')
                            ->get();
        $TakeawayOrders = Order::with(['customer', 'orderItems.product'])->whereHas('customer',function($query){
                                $query->where('order_type','takeaway');  
                                })
                            ->whereNotNull('customer_id')
                            ->whereNull('table_number_id') 
                            ->where('status', 'unpaid')
                            ->get();

        $customers = Customer::all();
        $tables =Table::all();
        $products = Product::all();

        return view('Layout.tables', [
            'order'     => $dineInOrders,
            'delivery'  => $deliveryOrders,
            'TakeawayOrders'=> $TakeawayOrders,
            'customers' => $customers,
            'tables'    => $tables,
            'products'  => $products,
        ]);
    }

    public function order(){
        $report = Order::with(['customer','orderItems.product'])->where('status','paid')->get();
        return view('Layout.orders',['report'=>$report]);
    }

    public function addItemToOrderBulk(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'table_number_id' => 'nullable|exists:table_numbers,id',
            'order_type' => 'required|string|in:dinein,delivery,takeaway',
            'product_id' => 'required|array',
            'product_id.*' => 'required|exists:products,id',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer|min:1',
            'price' => 'required|array',
            'price.*' => 'required|numeric|min:0',
        ]);


        if ($request->order_type === 'dinein') {
            $order = Order::where('table_number_id', $request->table_number_id)->latest()->first();

            if (!$order) {
                return back()->with('error', 'No active dine-in order found.');
            }
        } else {

            $customer = Customer::find($request->customer_id);

            if (!$customer) {
                return back()->with('error', 'Customer not found.');
            }

            if ($customer->order_type !== $request->order_type) {
                return back()->with('error', 'Customer order type mismatch.');
            }

            $order = Order::where('customer_id', $customer->id)->latest()->first();

            if (!$order) {
                return back()->with('error', 'No active order found for this customer.');
            }
        }


        foreach ($request->product_id as $i => $productId) {
            $qty = $request->quantity[$i];
            $price = $request->price[$i];

            $existing = $order->orderItems()->where('product_id', $productId)->first();

            if ($existing) {
                $existing->quantity += $qty;
                $existing->save();
            } else {
                $order->orderItems()->create([
                    'product_id' => $productId,
                    'price' => $price,
                    'quantity' => $qty,
                ]);
            }
        }

        $this->recalculateOrder($order);

        return redirect('/tables')->with('success', 'Items added successfully!');
    }

    public function removeItemFromOrder(Request $request)
    {
        $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
        ]);

        $orderItem = OrderItem::find($request->order_item_id);
        $order = $orderItem->order;

        $orderItem->delete();
        $this->recalculateOrder($order);

        return response()->json(['message' => 'Item removed successfully.']);
    }
    protected function recalculateOrder($order)
    {
        $subtotal = 0;

        foreach ($order->orderItems as $item) {
            $subtotal += $item->price * $item->quantity;
        }

        $tax = $subtotal * 0.1; 
        $total = $subtotal + $tax;

        $order->update([
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);
    }



}
