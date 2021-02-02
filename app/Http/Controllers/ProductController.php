<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Size;
use App\Stockpile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('products.index' , compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Get Sizes
        $sizes = Size::all();
        //Get Available
        $stockpiles = Stockpile::select('available')->distinct()->get();
        return view('products.create' , compact('sizes' , 'stockpiles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Get data from form
        $data = $request->all();
        //Validation with a private function
        $request->validate($this->ruleValidation());
        //Set product slug
        $data['slug'] = Str::slug($data['name'] , '-');
        //Img is set?
        if (!empty($data['path_img'])) {
            $data['path_img'] = Storage::disk('public')->put('images' , $data['path_img']);
        } 
        //Save to db
        $newProduct = new Product();
        $newProduct->fill($data); //<----Fillable in  model!!!
        $saved = $newProduct->save();
        //Stockpiles save to db
        $data['product_id'] = $newProduct->id; //Foreign Key
        $newStockpile = new Stockpile();
        $newStockpile->fill($data);//<-----fillable in model
        $stockpileSaved = $newStockpile->save();

        if ($saved && $stockpileSaved) {
            if(!empty($data['sizes'])) {
                $newProduct->sizes()->attach($data['sizes']); //Attach in pivot
            }
            return redirect()->route('products.index');
        } else {
            return redirect()->route('homepage');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug' , $slug)->first();
        $stockpile = Stockpile::where('product_id' , $product->id)->first();
        $sizes = Size::all();

        //Check
        if (empty($product)) {
            abort (404);
        }
        return view('products.show' , compact('product' , 'stockpile' , 'sizes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $product = Product::where('slug' , $slug)->first();
        $sizes = Size::all();
        $stockpile = Stockpile::where('product_id' , $product->id)->first();

        //Check
        if (empty('$product')) {
            abort(404);
        }

        return view('products.edit' , compact('product' , 'sizes' , 'stockpile' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         //Get data from form
         $data = $request->all();

         //Validation
         $request->validate($this->ruleValidation());
 
         //Get product to update
         $product = Product::find($id);
 
         //Slug generation
         $data['slug'] = Str::slug($data['name'] , '-');
 
         //If image changed?
         if(!empty($data['path_img'])) {
             if(!empty($product->path_img)) {
                 Storage::disk('public')->delete($product->path_img);
             }
             $data['path_img'] = Storage::disk('public')->put('images' , $data['path_img']);
         }
 
         //Update in database
         $updated = $product->update($data); //<---- Fillable in model!!
 
         //Stockpiles table update
         $data['product_id'] = $product->id; //Foreign Key
         $stockpile = Stockpile::where('product_id' , $product->id)->first();
         $stockpileUpdated = $stockpile->update($data); //<---- Fillable in model!!
 
 
         if($updated && $stockpileUpdated) {
             if (!empty($data['sizes'])) {
                 $product->sizes()->sync($data['sizes']);
             } else {
                 $product->sizes()->detach();
             }
             return redirect()->route('products.show' , $product->slug);
         } else {
             return redirect()->route('homepage');
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $name = $product->name;
        $image = $product->path_img;
        $product->sizes()->detach();
        $deleted = $product->delete();

        if ($deleted) {
            if (!empty($image)) {
                Storage::disk('public')->delete($image); 
            }
            return redirect()->route('products.index')->with('product-deleted' , $name); 
        } else {
            return redirect()->route('homepage');
        }
    }
    /**
     * FUNCTION VALIDATION
     */
    private function ruleValidation() {
        return [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stockpile' => 'required|numeric',
            'path_img' => 'image'
        ];
    }
}
