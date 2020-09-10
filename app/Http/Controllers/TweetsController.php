<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;
use Auth;
class TweetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $tweet = Tweet::create([
            'title' => $request->title,
            'user_id' => Auth::user()->id
        ]);
        $msg = "Tweet Published";
        return response()->json(array('msg'=> $msg), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        Tweet::whereId($id)->update([
            'title' => $request->title,
        ]);
        $msg = "Tweet Updated";
        return response()->json(array('msg'=> $msg), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tweet::whereId($id)->delete();
        $msg = "Data Deleted Successfully";
        return response()->json(array('msg'=> $msg), 200);
    }
    public function search(Request $request)
    {
        $query = $request->search;
        $tweets = Tweet::where('title', 'like', '%'.$query.'%')->get();
        return view('users.search', compact('tweets'));
    }
}
