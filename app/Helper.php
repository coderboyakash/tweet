<?php
use App\Follower;
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
?>