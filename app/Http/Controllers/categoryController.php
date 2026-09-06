<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class categoryController extends Controller
{
    //
    public function create(Request $rq){
        $validator = Validator::make($rq->all(),[
            'category'=>'required|min:3',
        ]);
        if($validator->fails()){
        return back()->withErrors($validator)->withInput()->with('modal','categoryModal');
        }
        $name = $rq->category;
        Category::create(['name'=>$name]);
        return redirect('/products');
    }
    public function update(Request $rq){
        $cateId = Category::find($rq->id);
        $cateId->name = $rq->name;
        $cateId->save();
        return response()->json(['message' => 'Category updated successfully']);
    
    }
    public function destroy($id){
        $cateId = Category::find($id);
        $cateId->delete();
        
    }
}
