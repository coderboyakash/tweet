@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-9">
                    <a href="{{ route('home') }}"><i class="fa fa-twitter twitterLogo p-1 rounded-circle"></i></a>
                    <div class="mt-3"><a href="/" class="explore text-decoration-none pt-2 pl-3 pb-2 pr-3"><i class="fa fa-hashtag mr-2"></i> &nbsp;&nbsp;Explore</a></div>
                    @if(Auth::user())
                        <div class="mt-3"><a href="" class="explore text-decoration-none pt-2 pl-3 pb-2 pr-3" data-toggle="modal" data-target="#setting"><i class="fa fa-gear mr-2 fa-spin"></i> &nbsp;&nbsp;Settings</a></div>
                        <!-- Modal -->
                        <div class="modal fade" id="setting" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <form id="profileUpdate"  data-url="{{ route('user.update', Auth::user()->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Email Address</label>
                                        <input type="email" class="form-control" name="email" value={{ Auth::user()->email }}>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Update Profile">
                                </form>
                                </div>
                            </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
        <h3>Your Profile</h3>
        <div class="row">
            <div class="col-lg-7 offset-lg-3">
                <div>Name : {{$user->name}}</div>
                <div>Followers : {{count($user->followers)}}</div>
            </div>
            <div class="row">
                <div class="col-lg-5">
                    @if(Auth::user()->id != $user->id)
                        @if(following_or_not2($user->id))
                            <a class="btn btn-primary" href="{{ route('user.follow', $user->id) }}">Follow</a>
                        @elseif(!following_or_not2($user->id))
                            <a class="btn btn-warning" href="{{ route('user.unfollow', $user->id) }}">Following</a>
                        @endif
                    @endif
                </div> 
            </div>
        </div>
        <h3 class="mt-5">Followers</h3>
        <div class="row">
            <div class="col-lg-5 offset-lg-4">   
                @foreach($user->followers as $follower)
                    <h4><a class="text-decoration-none" href="{{ route('user.show', $follower->user->id) }}">{{ ucfirst($follower->user->name) }}</a></h4>
                @endforeach
            </div>
        </div>
        <h3 class="mt-5">Your Tweets</h3>
        @foreach($user->tweets as $tweet)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $tweet->title }}</h5><span> by {{ $tweet->user->name }}</span>
                <p class="card-text"><small class="text-muted">{{ $tweet->created_at }}</small>
                @if( Auth::user() ? Auth::user()->id == $tweet->user->id : false)
                    <a href="javascript:void(0)" class="danger deletebtn" data-url="{{ route('tweet.destroy', $tweet->id) }}">Delete</a>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#edittweet{{$tweet->id}}">Edit</a>
                    <!-- Modal -->
                    <div class="modal fade" id="edittweet{{$tweet->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <form id="updateTweet" data-url="{{ route('tweet.update', $tweet->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <input type="text" class="form-control pb-5 pt-3" name="title" value="{{ $tweet->title }}">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <input class="btn btn-success mb-4" type="submit" value="Update Tweet">
                            </form>
                            </div>
                        </div>
                        </div>
                    </div>
                    @else
                    
                @endif
            </div>
        </div>
    @endforeach
        </div>
        <div class="col-lg-3">
            @if(!Auth::user())
                <div class="mt-3"><a href="{{ route('login') }}" class="explore text-decoration-none pt-2 pl-3 pb-2 pr-3"><i class="fa fa-sign-in mr-2"></i> &nbsp;&nbsp;Login</a></div>
                <div class="mt-3"><a href="{{ route('register') }}" class="explore text-decoration-none pt-2 pl-3 pb-2 pr-3"><i class="fa fa-user-plus"></i> &nbsp;&nbsp;Signup</a></div>
            @else
                <a href="{{ route('user.show', Auth::user()->id) }}" class="explore dropdown-item mb-2"><i class="fa fa-user" aria-hidden="true"></i> &nbsp;&nbsp;My Profile</a>
                <a class="explore dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;&nbsp;{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endif
        </div>
    </div>
    
</div>
<div aria-live="polite" aria-atomic="false" class="d-flex justify-content-center align-items-center" style="height: 200px;">
    <div class="toast" role="alert" aria-live="polite" aria-atomic="false">
      <div class="toast-body" id="msg">
      </div>
    </div>
</div>
@endsection
@section('scripts')
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
    $( "#newTweet" ).submit(function( event ) {
        data = $( this ).serializeArray();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url:'{{ route('tweet.store') }}',
            data:data,
            success:function(response) {
                $(".toast-body").html(response.msg);
                $('.toast').toast('show');
                setTimeout(function() {
                    location.reload();
                }, 500);
            }
        });
        event.preventDefault();
    });

    $(document).on('click', '.deletebtn', function() {
        var url = $(this).data('url');
        var check = confirm('Are You Sure ?');
        if(check == true){
            $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'DELETE',
            url:url,
            success:function(response) {
                $(".toast-body").html(response.msg);
                $('.toast').toast('show');
                setTimeout(function() {
                    location.reload();
                }, 500);
            }
        });
        }
        event.preventDefault();
    });
    $( "#updateTweet" ).submit(function( event ) {
        var url = $(this).data('url');
        console.log(url);
        data = $( this ).serializeArray();
        console.log(data)
        $('#name').val(""); 
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'PATCH',
            url:url,
            data:data,
            success:function(response) {
                $(".toast-body").html(response.msg);
                $('.toast').toast('show');
                setTimeout(function() {
                    location.reload();
                }, 500);
            }
        });
        event.preventDefault();
    });
    $( "#profileUpdate" ).submit(function( event ) {
        data = $( this ).serializeArray();
        var url = $(this).data('url');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'PATCH',
            url:url,
            data:data,
            success:function(response) {
                $(".toast-body").html(response.msg);
                $('.toast').toast('show');
                setTimeout(function() {
                    location.reload();
                }, 500);
            }
        });
        event.preventDefault();
    });
    $( "#follow" ).submit(function( event ) {
        data = $( this ).serializeArray();
        console.log(data)
        var url = $(this).data('url');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url:url,
            data:data,
            success:function(response) {
                    console.log(response.msg);
                $(".toast-body").html(response.msg);
                $('.toast').toast('show');
                setTimeout(function() {
                    location.reload();
                }, 500);
            }
        });
        event.preventDefault();
    });
    $( "#unfollow" ).submit(function( event ) {
        var check = confirm('Are You Sure to Unfollow ?');
        data = $( this ).serializeArray();
        console.log(data)
        var url = $(this).data('url');
        if(check == true){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'POST',
                url:url,
                data:data,
                success:function(response) {
                    console.log(response.msg);
                    $(".toast-body").html(response.msg);
                    $('.toast').toast('show');
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                }
            });
        }
        event.preventDefault();
    });
</script>    
@endsection
@section('styles')
    <style>
        #mainContent{
            border-left:1px solid grey;
            border-right:1px solid grey;
            padding:0px;
        }
        #searchBox{
            border-bottom:1px solid grey;
        }
        #mainContent .card{
            border:none;
            border-bottom:1px solid grey;
            border-radius:0px;
            color:aliceblue;
        }
        .category{
            color:grey;
            
        }
        .twitterLogo{
            font-size:35px;
            color:black;
        }
        .twitterLogo:hover{
            background-color:rgb(15, 87, 87);
            transition-duration: 0.7s;
        }
        .explore{
            transition-duration: 0.7s;
            font-size:20px;
            color:black;
            border-radius:25px;
        }
        .explore:hover{
            background-color:rgb(15, 87, 87);
            transition-duration: 0.3s;
            color:rgb(93, 93, 252);
        }
        .categories{
            overflow:hidden;
            height:40px;
            border-bottom:1px solid grey;
        }
    </style>
@endsection
