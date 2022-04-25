<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function product_list(Request $request)
    {
        if($request->title)
        {
            $title = Product::orderBy('id','desc')->where('title','like','%'.$request->title.'%')->paginate(10);
        }

        if($request->subcategory)
        {
            $sub_category = SubCategory::orderBy('id','desc')->where('title','like','%'.$request->subcategory.'%')->paginate(10);
        }

        if($request->category)
        {
            $category = Category::orderBy('id','desc')->where('title','like','%'.$request->category.'%')->paginate(10);
        }

        if($request->min_price && $request->max_price)
        {
            $price = Product::where('price','>=',$request->min_price)->paginate(10);
            $price = Product::where('price','<=',$request->max_price)->paginate(10);
        }

        return view('products_list', compact('title','sub_category','category','price'));
    }

    public function product_create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;

        $image=$request->file('thumbnail');
        if($image)
        {
            $image_name=time();
            $ext=strtolower($image->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='product/';
            $image_url=$upload_path.$image_full_name;
            $success=$image->move($upload_path,$image_full_name);
            if($success)
            {
                $product->thumbnail=$image_url;
            }
        }

        $product->save();

        $subcategories = new SubCategory();
        $subcategories->title = $request->title;
        $subcategories->description = $request->description;
        $product->categories()->save($subcategories);
        $subcategories->save();

        return view('add_product', compact('product'));
    }

    public function product_delete($id)
    {
        $product_delete = Product::where('id',$id)->first();

        if (!$product_delete)
        {
            Session::put('message','Product not found');
        }

        unlink($product_delete->thumbnail); //Old image delete

        $product_delete->delete();

        Session::put('message','Deleted Successfully!!');
        return Redirect::to('/list');
    }
}
