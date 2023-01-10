(function($){
    $("#categoria-tutoriales").change(function(){
        $.ajax({
            url:pg.ajaxurl,
            method:"POST",
            data:{
                "action":"filtreTutorials",
                "categoria":$(this).find(':selected').val()
            },
            beforeSend:function(){
                $("#resultado-tutoriales").html("Cargando...")
            },
            success:function(data){
                console.log(data);
            },
            error:function(error){
                console.log(error);
            }

        });
    });



})(jQuery);