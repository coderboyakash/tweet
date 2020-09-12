<?php
use App\Follower;
use App\User;
use App\Tweet;
    function following_or_not($id){
        $check = Follower::where('follower_id', Auth::user()->id)->where('user_id', $id)->get();
        if(count($check) == 0){
            return true;
        }else{
            return false;
        }
    }
    function following_or_not2($id){
        $check = Follower::where('follower_id', Auth::user()->id)->where('user_id', $id)->get();
        if(count($check) == 0){
            return true;
        }else{
            return false;
        }
    }

    function getFollowingDetail($id){
        $check = Follower::whereFollower_id($id)->whereUser_id(auth()->user()->id)->get();
        // dd($check);
        if(count($check) == 0){
            $return = Tweet::whereUser_id($id)->get();
        }else{
            $return = NULL;
        }
        return $return;
    }
?>