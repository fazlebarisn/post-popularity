jQuery(function($){
    $('#like_dislike a').on('click', function(){
        
        let state = $(this).data('val');

        $.ajax({
            url: ajax_object.url,
            method: 'post',
            data:{
                action: 'likes_dislikes_action',
                post: ajax_object.post,
                state: state,
            }
        }).success(function(e){
            data = JSON.parse(e);
            //console.log(data);
            $('#like_dislike li').each(function(){
                let state = $(this).find('a').data('val');
                //console.log(state);
                $(this).find('span').text("["+data[state]+"]");
                //console.log($(this).find('span').text("["+data[state]+"]"));
            });
        });
    });
});