<?php

namespace App\Http\Controllers;
use App\Tweet;
use App\User;
use App\Follower;
use Auth;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tweets = Tweet::whereUser_id(Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        return view('home', compact('tweets'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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
        $data = $request->validate([
            'name' => 'required',
            'email' => 'email|required|unique:users,email,'.$id,
        ]);
        User::whereId($id)->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        $msg = "Profile Updated";
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
        //
    }

    public function follow($id)
    {
        if(Auth::user()->id != $id){
            $user = Follower::updateOrCreate([
                'user_id' => $id,
                'follower_id' => Auth::user()->id
            ]);
        }
        return redirect()->back();
    }

    public function unfollow($id)
    {
        Follower::where('user_id', $id)->where('follower_id', Auth::user()->id)->delete();
        return redirect()->back();
    }

    public function followings()
    {
        $followings = Follower::whereFollower_id(auth()->user()->id)->get();
        return view('users.followings', compact('followings'));
    }
}
