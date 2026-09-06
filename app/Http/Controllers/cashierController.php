<?php

namespace App\Http\Controllers;
use App\Models\Cashier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class cashierController extends Controller
{
    public function index(){
        $cashier = Cashier::where("role","Cashier")->get();
        $admin = Cashier::where("role","Admin")->get();
        return view('Layout.cashiers',['cashier'=>$cashier,'admin'=>$admin]);
    }
    public function create(Request $rq){
        $validator = Validator::make($rq->all(),[
            'name'=>'required|min:3',
            'email'=>'required|unique',
            'email' => 'required|email|unique:user,email',
        ]);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('modal','cashierModalCreate');
        }
        $name = $rq->name;
        $email = $rq->email;
        $password = $rq->password;
        $role = $rq->role;
        Cashier::create([
            'name'=>$name,
            'email'=>$email,
            'password'=>$password,
            'role'=>$role,
        ]);
        return redirect('/cashiers');
    }
    public function update(Request $rq){
        $Cashier_id = Cashier::find($rq->id);
        $Cashier_id->name = $rq->name;
        $Cashier_id->email = $rq->email;
        if(!empty($rq->password)){
            $Cashier_id->password = $rq->password;
        }
        $Cashier_id->role = $rq->role;
        $Cashier_id->save();

    }
    public function delete($id){
        $Cashier_id = Cashier::find($id);
        $Cashier_id->delete();
    }
}
