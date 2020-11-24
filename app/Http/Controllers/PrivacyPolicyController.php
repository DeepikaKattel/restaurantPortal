<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class PrivacyPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $privacy = DB::table('privacy_policies')->get();
        return view('admin.privacy.index',compact('privacy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.privacy.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $privacy = new PrivacyPolicy();
        $privacy->heading = request('heading');
        $privacy->description = request('description');           
        $privacy->save();
        $privacySave = $privacy->save();
        if($privacySave) {
            return redirect('privacy')->with("status", "The record has been stored");
        } else {
            return redirect('privacy')->with("error", "There is an error");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Http\Response
     */
    public function show(PrivacyPolicy $privacyPolicy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $privacy = PrivacyPolicy::find($id);
        return view('admin.privacy.edit', compact('privacy'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $privacy= PrivacyPolicy::find($id);
        $privacy->heading = request('heading');
        $privacy->description = request('description');       
        $privacy->save();
        $privacySave = $privacy->save();
        if($privacySave) {
            return redirect('privacy')->with("status", "The record has been updated");
        } else {
            return redirect('privacy')->with("error", "There is an error");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $privacy = PrivacyPolicy::find($id)->delete();
        return redirect('privacy')->with('status','Deleted Successfully');
    }
}
