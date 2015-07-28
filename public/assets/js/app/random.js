$(function(){

    /**
     * send POST request to send account and tweet data
     */
    $('#btn-random-post').click(function(e){
        e.preventDefault();

        var $button = $(this),
            $random_result = global.random_result,
            $tweetset_id = global.tweetset_id,
            $url = global.baseUrl+'admin/tweetset/post-tweet';


        $button.addClass('disabled');
        $button.removeAttr('data-toggle');
        $button.html('Please wait..');

        $.ajax({
            url: $url,
            data: {'value' : $random_result, 'tweetset_id' : $tweetset_id},
            method : 'POST',
            success: function(resp){

                if(resp.success){
                    $button.html('successfully posted');

                    alert(resp.message);
                }else{
                    $button.removeClass('disabled');
                    $button.attr("data-toggle", "modal");
                    $button.html('Try Again');

                    if(resp.code == 401){
                        location.reload();
                    }

                    alert(resp.message);
                }
            }
        });

    });
});