<?php

namespace App\Http\Controllers;

use App\Picture;
use Illuminate\Http\Request;

class PictureController extends Controller
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
            'itemId' => 'required',
        ]);

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
                $picture->item_id = $request->itemId;
               $picture->save();
            }
         }

        return $picture;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function show($itemId)
    {
        $uploaded_image = Picture::where('item_id', $itemId)->get();
        return $uploaded_image;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function edit(Picture $picture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Picture $picture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Picture::findOrFail($id);
        
        $file_path = $this->photos_path . '/' . $image->filename;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    
        if (!empty($image)) {
            $image->delete();
        }
        return "terhapus";
    }
}
