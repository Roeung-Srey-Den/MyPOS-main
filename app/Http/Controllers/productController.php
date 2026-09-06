<?php

namespace App\Http\Controllers;
use App\Models\Table;

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class productController extends Controller
{   
    public function table()
    {
        $pro = Product::paginate(5);
        $cate = Category::all();
        return view('Layout.products', ['pro' => $pro, 'cate' => $cate]);
    }

    public function index()
    {
        $pro = Product::with('category')->get();
        $cate = Category::all();
        $customer = Customer::latest()->get();
        $table = Table::where('is_occupied', 0)->orderBy('id', 'asc')->get();

        return view('Layout.home', ['pro' => $pro, 'cate' => $cate, 'customer' => $customer,'table'=>$table]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|min:3',
            'price'=>'required|numeric',
            'pic' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ]);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('modal','exampleModal');
        }
        $image = $request->file('pic');

        /** @var Cloudinary $cloudinary */
        $cloudinary = app(Cloudinary::class);

        // Upload image to Cloudinary
        $uploadResult = $cloudinary->uploadApi()->upload($image->getRealPath());

        $uploadedFileUrl = $uploadResult['secure_url']; 

        Product::create([
            'pro_name' => $request->name,
            'pro_price' => $request->price,
            'cate_id' => $request->category,
            'pro_pic' => $uploadedFileUrl,
        ]);

        return redirect()->back()->with('success', 'Product created successfully!');
    }

    public function update(Request $rq)
    {
        $product = Product::find($rq->id);

        $product->pro_name = $rq->name;
        $product->pro_price = $rq->price;
        $product->cate_id = $rq->category;

        if ($rq->hasFile('pic')) {
            $image = $rq->file('pic');

            /** @var Cloudinary $cloudinary */
            $cloudinary = app(Cloudinary::class);

            // Upload image to Cloudinary
            $uploadResult = $cloudinary->uploadApi()->upload($image->getRealPath());

            $uploadedFileUrl = $uploadResult['secure_url']; 

            $product->pro_pic = $uploadedFileUrl;
        }

        $product->save();

        return response('Successfully Updated');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response('Successfully Deleted');
    }
}
