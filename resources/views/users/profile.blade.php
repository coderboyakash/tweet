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
                        <div class="mt-3"><a href="" class="explore text-decoration-none pt-2 pl-3 pb-2 pr-3"><i class="fa fa-gear mr-2 fa-spin"></i> &nbsp;&nbsp;Settings</a></div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            
        </div>
        <div class="col-lg-3">
            @if(!Auth::user())
                <div class="mt-3"><a href="{{ route('login') }}" class="explore text-decoration-none pt-2 pl-3 pb-2 pr-3"><i class="fa fa-sign-in mr-2"></i> &nbsp;&nbsp;Login</a></div>
                <div class="mt-3"><a href="{{ route('register') }}" class="explore text-decoration-none pt-2 pl-3 pb-2 pr-3"><i class="fa fa-user-plus"></i> &nbsp;&nbsp;Signup</a></div>
            @else
                <a href="{{ route('user.show', Auth::user()->id) }}" class="explore dropdown-item mb-2 text-decoration-none"><i class="fa fa-user" aria-hidden="true"></i> &nbsp;&nbsp;My Profile</a>
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
