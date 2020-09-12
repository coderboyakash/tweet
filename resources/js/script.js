$( "#newTweet" ).submit(function( event ) {
    var str = $(this.title).val();
    if(str == ''){
        alert('Tweet is blank')
    }else{
        data = $( this ).serializeArray();
        var url = $( "#newTweet" ).attr("action");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
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
    }
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
    var str = $(this.title).val();
    if(str == ''){
        alert('Tweet Cannot be empty')
    }else{
        var url = $(this).data('url');
        data = $( this ).serializeArray();
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
    }
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