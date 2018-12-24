<?php

namespace App\Http\Controllers;

use App\Item;
use App\Picture;
use App\Category;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    private $photos_path;
 
    public function __construct()
    {
        $this->photos_path = public_path('/itemImages');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Item::with('picture','category')->get());
    }

    public function trash(){
        $trash = Item::onlyTrashed()->with('picture','category')
                ->get();
        return $trash;
    }

    public function restore($id){
        Item::withTrashed()
        ->find($id)
        ->restore();

        return "Success";
    }
    public function search($cat,$search){
        if($cat == 'All'){
            return response()->json(Item::where('name', 'LIKE', '%'.$search.'%')->with('picture','category')->get());
        }else{
            $cat_id = Category::where('name',$cat)->first()->id;
            return response()->json(Item::where([['category_id',$cat_id],['name', 'LIKE', '%'.$search.'%']])->with('picture','category')->get());
        }
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'filename' => 'required',
            'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'slug' => 'required',
            'stock' => 'required',
            'merk' => 'required',
            'type' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'description' => 'required',
        ]);

        $item = new Item();
        $item->name = $request->name;
        $item->slug = $request->slug;
        $item->stock = $request->stock;
        $item->merk = $request->merk;
        $item->type = $request->type;
        $item->price = $request->price;
        $item->description = $request->description;
        $item->category_id = $request->category_id;
        $item->save();

        if($request->hasfile('filename'))
         {

            foreach($request->file('filename') as $image)
            {
                $name = sha1(date('YmdHis') . str_random(30));
                $save_name = $name . '.' . $image->getClientOriginalExtension();

                $original_name =$image->getClientOriginalName();
                $image->move($this->photos_path, $save_name);  

                $picture= new Picture();
                $picture->filename=$save_name;
                $picture->originalName = $original_name;
                $picture->item_id = $item->id;
               $picture->save();
            }
         }

        return $picture;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Item::find($id)->with('picture','category')->first());
    }
    public function showByCategory($type, $cat)
    {
        $cat_id = Category::where('name',$cat)->first()->id;
        if($type == 'All'){
            return response()->json(Item::where('category_id',$cat_id)->with('picture','category')->get());
        }else{
            return response()->json(Item::where([['category_id',$cat_id],['type',$type]])->with('picture','category')->get());
        }
    }
    public function showBySlug($slug)
    {
        return response()->json(Item::where('slug', $slug)->with('picture','category')->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'stock' => 'required',
            'merk' => 'required',
            'type' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'description' => 'required',
        ]);

        $item = Item::findOrFail($id);
        $item->name = $request->name;
        $item->stock = $request->stock;
        $item->merk = $request->merk;
        $item->type = $request->type;
        $item->price = $request->price;
        $item->description = $request->description;
        $item->category_id = $request->category_id;
        $item->save();

        if($request->hasfile('filename'))
         {

            foreach($request->file('filename') as $image)
            {
                $name = sha1(date('YmdHis') . str_random(30));
                $save_name = $name . '.' . $image->getClientOriginalExtension();

                $original_name =$image->getClientOriginalName();
                $image->move($this->photos_path, $save_name);  

                $picture= new Picture();
                $picture->filename=$save_name;
                $picture->originalName = $original_name;
                $picture->item_id = $item->id;
               $picture->save();
            }
         }

        return 'update';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
 
        if (empty($item)) {
            return response()->json(['message' => 'Sorry file does not exist'], 400);
        }

        $item->delete();

        return "Terhapus";
    }

    public function permanentDestroy($id){

        $item = Item::withTrashed()->findOrFail($id);
 
        if (empty($item)) {
            return response()->json(['message' => 'Sorry file does not exist'], 400);
        }

        $uploaded_image = Picture::where('item_id', $item->id)->get();
        
        foreach($uploaded_image as $image)
        {
            $file_path = $this->photos_path . '/' . $image->filename;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
     
            if (!empty($image)) {
                $image->delete();
            }
        }
        $item->forceDelete();
        return 'Terhapus';
    }

    public function apiCheckUnique(Request $request)
    {
        return json_encode(!Item::where('slug', '=', $request->slug)->exists());
    }
}
