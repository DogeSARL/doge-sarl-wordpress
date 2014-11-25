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
                    alert("Such participation ! Many thanks !");
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
                    alert("Why you no stay?!");
                    $(".subscribeBox").html('<a href="#" id="participer">Je participe</a>');
                    inscrire();
                }
            });
    });
}

inscrire();
desinscrire();