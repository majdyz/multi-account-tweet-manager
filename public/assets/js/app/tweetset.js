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
    $('#btn-tweetset-add').click(function(e){
        e.preventDefault();
        $('#tweetset-form-data').each(function(){
            this.reset();
        });

        $('#btn-tweetset-save').attr('data-method', 'POST');
        $('#tweetset-modal').modal('show');
    });

    /**
     * sen GET request to display resource with specific id, and display it in modal form
     */
    $('#tweetset-table').on('click', '.btn-tweetset-edit', function(e){
        var $tweetsetid = $(this).attr('data-id');

        e.preventDefault();
        $loader.show();


        $.get(global.baseUrl+'admin/tweetset/'+$tweetsetid, function(resp){
            if(resp.success){
                $('#tweetset-form-data').each(function(){
                    this.reset();
                });

                var $tweetset = resp.data;

                for(var a in $tweetset){
                    $('#tweetset_'+a).val($tweetset[a]);
                }

                $('#btn-tweetset-save').attr('data-method', 'PUT');
                $('#tweetset-modal').modal('show');
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
    $('#tweetset-table').on('click', '.btn-tweetset-delete', function(e){
        var $tweetsetid = $(this).attr('data-id');
        e.preventDefault();

        if(confirm('Are you sure to delete this tweetset?')){
            $loader.show();
            $.ajax({
                url    : global.baseUrl+'admin/tweetset/'+$tweetsetid,
                method : 'DELETE',
                data   : {
                    id : $tweetsetid
                },
                success : function(resp){
                    if(resp.success){
                        $('#tweetset-row-'+$tweetsetid).remove();
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
    $('#tweetset-form-data').submit(function(e){
        e.preventDefault();
        var $button = $("#btn-tweetset-save"),
            $tweetsetdata = $('#tweetset-form-data').serialize(),
            $method = $($button).attr('data-method'),
            $url = ($method == 'POST') ? global.baseUrl+'admin/tweetset' : global.baseUrl+'admin/tweetset/'+$('#tweetset_id').val();

        $button.prop('disabled', true);
        $button.html('saving...');
        $loader.show();


        $.ajax({
            url: $url,
            data: $tweetsetdata,
            method : $method,
            success: function(resp){

                $button.prop('disabled', false);
                $button.html('save');
                $loader.hide();

                if(resp.success){

                    tweetset = resp.data;

                    if($method == 'POST'){
                        /** append tweetset to new row */
                        $('#tweetset-table').append(
                            '<tr id="tweetset-row-'+resp.data.id+'">'+
                                '<td>'+tweetset.id+'</td>'+
                                '<td>'+tweetset.name+'</td>'+
                                '<td>'+tweetset.user_involved+'</td>'+
                                '<td>'+tweetset.updated_at+'</td>'+
                                '<td>'+tweetset.created_at+'</td>'+
                                '<td class="text-center">'+
                                    '<a data-id="'+tweetset.id+'"class="btn btn-xs btn-warning btn-tweetset-random" href="tweetset/random-tweet/'+tweetset.id+'"><i class="fa fa-fire fa-fw"></i>Randomize</a>'+
                                    '<a data-id="'+tweetset.id+'"class="btn btn-xs btn-success btn-tweetset-view" href="tweetset/show-tweet/'+tweetset.id+'"><i class="fa fa-comment fa-fw"></i>Tweets</a>'+
                                    '<a data-id="'+tweetset.id+'"class="btn btn-xs btn-primary btn-tweetset-edit" href="#"><i class="fa fa-edit fa-fw"></i>Edit</a>'+
                                    '<a data-id="'+tweetset.id+'"class="btn btn-xs btn-danger btn-tweetset-delete" href="#"><i class="fa fa-times fa-fw"></i>Remove</a>'+
                                '</td>'+
                            '</tr>'
                        );
                    }else{
                        var $fields = $('#tweetset-row-'+resp.data.id+' td');
                        $($fields[1]).html(tweetset.name);
                        $($fields[2]).html(tweetset.user_involved);
                        $($fields[3]).html(tweetset.updated_at);
                        $($fields[4]).html(tweetset.created_at);
                    }

                    /** reset the form and hide modal form */
                    $('#tweetset-form-data').each(function(){
                        this.reset();
                    });
                    $('#tweetset-modal').modal('hide');
                }else{
                    console.log($url);
                    alert(resp.message);
                    if(resp.code == 401){
                        location.reload();
                    }
                }
            }
        });
    });
});