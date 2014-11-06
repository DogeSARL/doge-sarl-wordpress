function inscrire(){
    $("#participer").bind('click',function(){
        $.ajax(
            {"method":"POST",
                "url": ajax_options.ajax_link,
                "data": {"action":"subscribe","post_id":ajax_options.post_id,"user_id":ajax_options.user_id}
            }
        ).done( function(data){
                if( data == 0 ){
                    alert("Une erreut s'est produite...");
                }
                else if (data == 1){
                    alert("GG");
                    $(".subscribeBox").html('<a href="#" id="desinscrire">Je me désinscris</a>');
                    desinscrire();
                }
            });
    });
}

function desinscrire(){
    $("#desinscrire").bind('click',function(){
        $.ajax(
            {"method":"POST",
                "url": ajax_options.ajax_link,
                "data": {"action":"unsubscribe","post_id":ajax_options.post_id,"user_id":ajax_options.user_id}
            }
        ).done( function(data){
                if( data == 0 ){
                    alert("Une erreut s'est produite...");
                }
                else if (data == 1){
                    alert("T'es un pussy");
                    $(".subscribeBox").html('<a href="#" id="participer">Je participe</a>');
                    inscrire();
                }
            });
    });
}

inscrire();
desinscrire();