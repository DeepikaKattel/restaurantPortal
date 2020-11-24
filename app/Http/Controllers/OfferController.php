<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offer = DB::table('offers')->get();
        return view('admin.offer.index', compact('offer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.offer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $offer = new Offer();
        $offer->name = request('name');
        if ($request->hasFile('image')) {
            $image = $request->image;
            $fileName = rand() . "." . $image->getClientOriginalExtension();
            $destination_path = public_path("offerImage/");
            $image->move($destination_path, $fileName);
            $offer->image = 'offerImage/' . $fileName;
        }       
        $offer->description = request('description');
        $offer->offerCode = request('offerCode');
        $offer->save();
        $offerSave = $offer->save();
        if($offerSave) {
            return redirect('/offer')->with("status", "The record has been stored");
        } else {
            return redirect('/offer')->with("error", "There is an error");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $offer = Offer::find($id);
        return view('admin.offer.edit', compact('offer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $offer = Offer::find($id);
        $offer->name = request('name');
        if ($request->hasFile("image")) {
            if ($offer->image) {
                File::delete(public_path($offer->image));
            }
            $image = $request->image;
            $fileName = time() . "." . $image->getClientOriginalExtension();
            $destination_path = public_path("offerImage/");
            $image->move($destination_path, $fileName);

            $offer->image = 'offerImage/' . $fileName;
        }
        $offer->description = request('description');
        $offer->offerCode = request('offerCode');
        $offer->save();
        $offerSave = $offer->save();
        if ($offerSave) {
            return redirect('/offer')->with("status", "The record has been updated");
        } else {
            return redirect('/offer')->with("error", "There is an error");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offer = Offer::find($id)->delete();
        return redirect('/offer')->with('status','Deleted Successfully');
    }
}
