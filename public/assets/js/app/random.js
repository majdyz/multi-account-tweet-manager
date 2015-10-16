$(function(){

    /* realtime report variable */
    var report        = $('#realtime-report ul');
    var loader        = $('#progress-bar');
    var random_result = global.random_result;
    var tweetset_id   = global.tweetset_id;
    var $url          = global.baseUrl+'admin/tweetset/post-tweet';
    var counter = 0, success = 0, array_size = random_result.length;


    /* helper for tweeting */
    function postTweet(i) {
        report.append("<li>'" + random_result[i].account.username + "' try to tweet '" + random_result[i].tweet.name +"'</li>");

        /* ajax to post one tweet */
        $.ajax({
            url: $url,
            data: {'value' : random_result[i], 'tweetset_id' : tweetset_id, 'index' : i},
            method : 'POST',
            success: function(resp) {

                var idx = resp.data;
                if(resp.success){
                    success++;
                    report.append("<li style='color:green'>'" + random_result[idx].account.username + "' successfully tweeted '" + random_result[idx].tweet.name +"'</li>");
                }else{
                    report.append("<li style='color:red'>'" + random_result[idx].account.username + "' error tweeting '" + random_result[idx].tweet.name +"'  ["+ resp.message + "] => <a href='#' data-id='"+idx+"' class='repost'> try again </a> </li>");
                }

                /* update progress bar */
                counter++;
                loader.css("width",counter*100.0/array_size+"%");

                /* finish check */
                if (counter == array_size) {
                    $('#btn-random-post').html('successfully posted');
                    report.append("<li style='color:blue'> Done! </li>");
                    alert("All tweets has been processed")

                    if (success*2 < array_size) {
                        $('#btn-random-post').removeClass('disabled');
                        $('#btn-random-post').attr("data-toggle", "modal");
                        $('#btn-random-post').html('Try Again');
                    }
                }
            }
        });
    }

    /**
     * send POST request to send account and tweet data
     */
    $('#btn-random-post').click(function(e){
        e.preventDefault();

        $button = $(this);
        $button.addClass('disabled');
        $button.removeAttr('data-toggle');
        $button.html('Please wait..');

        /* clear report */
        report.empty();
        loader.css("width","0%");
        counter = 0, success = 0;
        $('#realtime-report').show();

        /* post all tweets */
        for (var i=0; i<array_size; i++) {
            postTweet(i);
        }
    });

    /* repost method */
    $('#realtime-report').on('click', '.repost', function(e){
        e.preventDefault();
        postTweet($(this).attr('data-id'));
    });
});