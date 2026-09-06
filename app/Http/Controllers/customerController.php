<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class customerController extends Controller
{
    //
    public function create( Request $request){
        $validator = Validator::make($request->all(), [
        'customer' => 'required|min:3',
        'phone'  => 'numeric',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'customerModalCreate'); 
        }
        // Create or find customer (simplified here: always create new)
        $customer = Customer::create([
            'name' => $request->customer,
            'phone' => $request->phone,
            'address' => $request->address,
            'order_type' => $request->order_type,
        ]);

        return redirect('/');
    }
}
