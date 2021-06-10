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



window.addEventListener("load", function(){

    // store tabs variables
    var tabs = document.querySelectorAll("ul.nav-tabs > li");

    for( i = 0; i < tabs.length; i++ ){
        tabs[i].addEventListener("click" , switchTab);
    }

    function switchTab( event ){

        event.preventDefault();

        document.querySelector("ul.nav-tabs li.active").classList.remove("active");
        document.querySelector(".tab-pane.active").classList.remove("active");

        var clickedTab = event.currentTarget;
        var anchor = event.target;
        var activePaneID = anchor.getAttribute("href");

        
        clickedTab.classList.add("active");
        document.querySelector(activePaneID).classList.add("active");
    }

});