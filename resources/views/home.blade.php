@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-9">
                    <a href="{{ route('home') }}"><i class="fa fa-twitter twitterLogo p-1 rounded-circle"></i></a>
                    <div class="mt-3"><a href="{{ route('welcome') }}" class="explore text-decoration-none pt-2 pl-3 pb-2 pr-3"><i class="fa fa-hashtag mr-2"></i> &nbsp;&nbsp;Explore</a></div>
                    @if(auth()->user())
                    <div class="mt-3"><a href="javascript:void(0)" class="explore text-decoration-none pt-2 pl-3 pb-2 pr-3" data-toggle="modal" data-target="#setting"><i class="fa fa-gear mr-2 fa-spin"></i> &nbsp;&nbsp;Settings</a></div>
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
                            <form id="profileUpdate"  data-url="{{ route('user.update', auth()->user()->id) }}">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="name">Email Address</label>
                                    <input type="email" class="form-control" name="email" value={{ auth()->user()->email }}>
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
            @if(auth()->user())
    <form id="newTweet">
        @csrf
        <div class="form-group">
          <input type="text" class="form-control pb-5 pt-3" name="title" placeholder="What's on Your Mind">
        </div>
        <input class="btn btn-success mb-4" type="submit" value="Tweet">
    </form>
    @endif
    <div class="row">
        <a class="col-lg-6 text-center text-decoration-none pt-3 pb-3" href="{{ route('home') }}">Tweets</a>
        <a class="col-lg-6 text-center text-decoration-none pt-3 pb-3" href="{{ route('followings') }}">Followings</a>
    </div>
    @foreach($tweets as $tweet)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $tweet->title }}</h5><span> by <a class="text-decoration-none" href="{{ route('user.show', $tweet->user->id) }}">{{ $tweet->user->name }}</a></span>
                <p class="card-text"><small class="text-muted">{{ $tweet->created_at }}</small></p>
                @if( auth()->user() ? auth()->user()->id == $tweet->user->id : false)
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
                    <div>
                        @if(following_or_not($tweet->user->id))
                            <a class="btn btn-primary" href="{{ route('user.follow', $tweet->user->id) }}">Follow</a>
                        @elseif(!(following_or_not($tweet->user->id)))
                            <a class="btn btn-warning" href="{{ route('user.unfollow', $tweet->user->id) }}">Following</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endforeach
        </div>
        <div class="col-lg-3">
            @if(!auth()->user())
                <div class="mt-3"><a href="{{ route('login') }}" class="explore text-decoration-none pt-2 pl-3 pb-2 pr-3"><i class="fa fa-sign-in mr-2"></i> &nbsp;&nbsp;Login</a></div>
                <div class="mt-3"><a href="{{ route('register') }}" class="explore text-decoration-none pt-2 pl-3 pb-2 pr-3"><i class="fa fa-user-plus"></i> &nbsp;&nbsp;Signup</a></div>
            @else
                <a href="{{ route('user.show', auth()->user()->id) }}" class="explore dropdown-item mb-2"><i class="fa fa-user" aria-hidden="true"></i> &nbsp;&nbsp;My Profile</a>
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
