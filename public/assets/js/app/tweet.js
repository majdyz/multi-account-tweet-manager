$(function(){
    /**
     * all response will be in below format
     * {
     *     success : boolean,
     *     data : {resource_object} or null,
     *     message : string,
     *     code : integer
     * }
     */

    
    var $loader = $('#loader');

    /**
     * reset the form and show it!
     */
    $('#btn-tweet-add').click(function(e){
        e.preventDefault();
        $('#tweet-form-data').each(function(){
            this.reset();
        });
        $('#tweet_tweetset_id').hide();
        $('#tweet_tweetset_id_title').hide();
        $('#btn-tweet-save').attr('data-method', 'POST');
        $('#tweet-modal').modal('show');
    });

    /**
     * send GET request to display resource with specific id, and display it in modal form
     */
    $('#tweet-table').on('click', '.btn-tweet-edit', function(e){
        var $tweetid = $(this).attr('data-id');

        e.preventDefault();
        $loader.show();


        $.get(global.baseUrl+'admin/tweet/'+global.tweetset_id+'/'+$tweetid, function(resp){
            if(resp.success){
                $('#tweet-form-data').each(function(){
                    this.reset();
                });

                var $tweet = resp.data;

                $('#tweet_tweetset_id').show();
                $('#tweet_tweetset_id_title').show();

                for(var a in $tweet){
                    $('#tweet_'+a).val($tweet[a]);
                }

                $('#btn-tweet-save').attr('data-method', 'PUT');
                $('#tweet-modal').modal('show');
            }else{
                alert(resp.message);
                if(resp.code == 401){
                    location.reload();
                }
            }

            $loader.hide();
        });
    });

    /**
     * send DELETE request to the resouce server
     */
    $('#tweet-table').on('click', '.btn-tweet-delete', function(e){
        var $tweetid = $(this).attr('data-id');
        e.preventDefault();

        if(confirm('Are you sure to delete this tweet?')){
            $loader.show();
            $.ajax({
                url    : global.baseUrl+'admin/tweet/'+global.tweetset_id+'/'+$tweetid,
                method : 'DELETE',
                data   : {
                    id : $tweetid
                },
                success : function(resp){
                    if(resp.success){
                        $('#tweet-row-'+$tweetid).remove();
                    }else{
                        alert(resp.message);
                        if(resp.code == 401){
                            location.reload();
                        }
                    }
                    $loader.hide();
                }
            });
        }
    });

    /**
     * send POST request to save data to resource server
     * or send PUT request to update data on resource server
     * based on data-method value
     */
    $('#btn-tweet-save').click(function(e){
        e.preventDefault();

        var $button = $(this),
            $tweetdata = $('#tweet-form-data').serialize(),
            $method = $(this).attr('data-method'),
            $url = ($method == 'POST') ? global.baseUrl+'admin/tweet/'+global.tweetset_id : global.baseUrl+'admin/tweet/'+global.tweetset_id+'/'+$('#tweet_id').val();

        $button.prop('disabled', true);
        $button.html('saving...');
        $loader.show();


        $.ajax({
            url: $url,
            data: $tweetdata,
            method : $method,
            success: function(resp){

                $button.prop('disabled', false);
                $button.html('save');
                $loader.hide();

                if(resp.success){

                    tweet = resp.data;

                    if($method == 'POST'){
                        /** append tweet to new row */
                        $('#tweet-table').append(
                            '<tr id="tweet-row-'+resp.data.id+'">'+
                                '<td>'+tweet.id+'</td>'+
                                '<td>'+tweet.name+'</td>'+
                                '<td>'+tweet.text+'</td>'+
                                '<td>'+tweet.mentions+'</td>'+
                                '<td>'+tweet.hashtags+'</td>'+
                                '<td>'+tweet.updated_at+'</td>'+
                                '<td>'+tweet.created_at+'</td>'+
                                '<td class="text-center">'+
                                    '<a data-id="'+tweet.id+'" class="btn btn-xs btn-primary btn-tweet-edit" href="#"><i class="fa fa-edit fa-fw"></i>Edit</a>'+
                                    '<a data-id="'+tweet.id+'" class="btn btn-xs btn-danger btn-tweet-delete" href="#" style="margin-left: 5px"><i class="fa fa-times fa-fw"></i>Remove</a>'+
                                '</td>'+
                            '</tr>'
                        );
                    }else{
                        var $fields = $('#tweet-row-'+resp.data.id+' td');
                        if (tweet.tweetset_id != global.tweetset_id) {
                            $fields.hide();
                        }
                        $($fields[1]).html(tweet.name);
                        $($fields[2]).html(tweet.tweetset_name);
                        $($fields[3]).html(tweet.text);
                        $($fields[4]).html(tweet.mentions);
                        $($fields[5]).html(tweet.hashtags);
                        $($fields[6]).html(tweet.updated_at);
                        $($fields[7]).html(tweet.created_at);
                    }

                    /** reset the form and hide modal form */
                    $('#tweet-form-data').each(function(){
                        this.reset();
                    });
                    $('#tweet-modal').modal('hide');
                }else{
                    alert(resp.message);
                    if(resp.code == 401){
                        location.reload();
                    }
                }
            }
        });
    });
});