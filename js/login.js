(function(){
    
    $('form').submit(function(e){
       e.preventDefault();
    });

    // ----------------------------------AJAX---------------------------
    $('#login').click(login);
    function login(){
        var datas = {
            'nick' : $('#nick').val(),
            'password' : $('#password').val()
        }
        datas = JSON.stringify(datas);
        $.ajax(
          {
            url: 'usuario/login',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data: datas
          } 
        ).done(
            function(json){
                if(json.error){
                    $('#mensaje').text(json.error);
                } else{
                    window.location.replace("https://proyecto-integrado-toril92.c9users.io/");       
                }
            }
        ).fail(
            function(){
                alert('error en la consulta login');
            }
        ).always(
            function() {
                
            }
        );
    }
    
    $(':input').click(borrarMensaje);
    function borrarMensaje(){
        $('#mensaje').text('');
    }
    
}());