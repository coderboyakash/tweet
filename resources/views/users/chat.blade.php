@extends('layouts.app')
@section('content')
<div class="container">
   <h3 class=" text-center">Messaging</h3>
   <div class="messaging">
      <div class="inbox_msg">
         <div class="inbox_people">
            <div class="headind_srch">
               <div class="recent_heading">
                  <h4>Recent</h4>
               </div>
               <!-- search bar start -->
               <div class="srch_bar">
                  <div class="stylish-input-group">
                     <input type="text" class="search-bar"  placeholder="Search" >
                     <span class="input-group-addon">
                     <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                     </span> 
                  </div>
               </div>
               <!-- search bar ended -->
            </div>
            <div class="inbox_chat">
                <!-- foreach followings start -->
                @foreach(auth()->user()->followers as $follower)
               <div class="chat_list active_chat">
                  <div class="chat_people">
                     <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                     <div class="chat_ib">
                        <h5>{{ $follower->user->name }} <span class="chat_date">Dec 25</span></h5>
                     </div>
                  </div>
               </div>
               @endforeach
               <!-- foreach followings ended -->
            </div>
         </div>
         <div class="mesgs">
            <div class="msg_history">
                <!-- char hist person start -->
               <div class="incoming_msg">
                  <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                  <div class="received_msg">
                     <div class="received_withd_msg">
                        <p>Test which is a new approach to have all
                           solutions
                        </p>
                        <span class="time_date"> 11:01 AM    |    June 9</span>
                     </div>
                  </div>
               </div>
               <div class="outgoing_msg">
                  <div class="sent_msg">
                     <p>Test which is a new approach to have all
                        solutions
                     </p>
                     <span class="time_date"> 11:01 AM    |    June 9</span> 
                  </div>
               </div>
            </div>
            <!-- chat history person ended -->
            <!-- send msg start -->
            <div class="type_msg">
               <div class="input_msg_write">
                  <input type="text" class="write_msg" placeholder="Type a message" />
                  <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
               </div>
            </div>
            <!-- send msg end -->
         </div>
      </div>
   </div>
</div>
@endsection