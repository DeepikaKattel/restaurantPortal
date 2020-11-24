<?php

namespace App\Http\Controllers;


use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about = DB::table('about')->get();
        return view('admin.about.index',compact('about'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.about.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $about = new About();
        $about->heading = request('heading');
        $about->description = request('description');
        if ($request->hasFile('image')) {
            $image = $request->image;
            $fileName = rand() . "." . $image->getClientOriginalExtension();
            $destination_path = public_path("aboutImage/");
            $image->move($destination_path, $fileName);
            $about->image = 'aboutImage/' . $fileName;
        }            
        $about->save();
        $aboutSave = $about->save();
        if($aboutSave) {
            return redirect('adminAbout')->with("status", "The record has been stored");
        } else {
            return redirect('adminAbout')->with("error", "There is an error");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function show(About $about)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $about = About::find($id);
        return view('admin.about.edit', compact('about'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $about= About::find($id);
        $about->heading = request('heading');
        $about->description = request('description');
        if ($request->hasFile("image")) {
            if ($about->image) {
                File::delete(public_path($about->image));
            }
            $image = $request->image;
            $fileName = time() . "." . $image->getClientOriginalExtension();
            $destination_path = public_path("aboutImage/");
            $image->move($destination_path, $fileName);

            $about->image = 'aboutImage/' . $fileName;
        }    
        $about->save();
        $aboutSave = $about->save();
        if($aboutSave) {
            return redirect('adminAbout')->with("status", "The record has been updated");
        } else {
            return redirect('adminAbout')->with("error", "There is an error");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $about = About::find($id)->delete();
        return redirect('adminAbout')->with('status','Deleted Successfully');
    }
}
