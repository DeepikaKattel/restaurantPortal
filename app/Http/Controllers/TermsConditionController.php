<?php

namespace App\Http\Controllers;

use App\Models\TermsCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class TermsConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = DB::table('terms_conditions')->get();
        return view('admin.terms.index',compact('terms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.terms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $terms = new TermsCondition();
        $terms->heading = request('heading');
        $terms->description = request('description');           
        $terms->save();
        $termsSave = $terms->save();
        if($termsSave) {
            return redirect('terms')->with("status", "The record has been stored");
        } else {
            return redirect('terms')->with("error", "There is an error");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TermsCondition  $termsCondition
     * @return \Illuminate\Http\Response
     */
    public function show(TermsCondition $termsCondition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TermsCondition  $termsCondition
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $terms = TermsCondition::find($id);
        return view('admin.terms.edit', compact('terms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TermsCondition  $termsCondition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $terms= TermsCondition::find($id);
        $terms->heading = request('heading');
        $terms->description = request('description');       
        $terms->save();
        $termsSave = $terms->save();
        if($termsSave) {
            return redirect('terms')->with("status", "The record has been updated");
        } else {
            return redirect('terms')->with("error", "There is an error");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TermsCondition  $termsCondition
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $terms = TermsCondition::find($id)->delete();
        return redirect('terms')->with('status','Deleted Successfully');
    }
}
