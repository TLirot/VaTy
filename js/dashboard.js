(function(){
    
$('a').click(function(e){
   if($(this).attr('href')==''){
       e.preventDefault();
   } 
});

$('body').mouseup(function(){
    $('.mensaje').text('');
})

$('#sidebar-menu').click(function(){
    if(window.rol == 'RES'){
        $('.col-sm-6').addClass('ocultar');           //Por el tema de tablas de citas en acompañante
    }
    $('.info_table').addClass('ocultar');
    $('.editar').removeClass('ocultar')
    $('.guardar').addClass('ocultar');
    $('.cancelar').addClass('ocultar');
    $('.info_table .title_table').text('');
   remove_tables_fam_res();
});

$('.dashboard').click(function(){
    $('.modify_profile').parent('.info').addClass('ocultar');
    $('.familiar_info').parent('.info').addClass('ocultar');
   fill_info();
   $('.createUserFields').parent('.info').addClass('ocultar');
});
getUserData();
function getUserData (){
   $.ajax(
      {
        url: 'usuario/getUserData',
        type: 'post',
        dataType: 'json',
        contentType: 'aplication/json'
      }
    ).done(
        function(json){
            window.rol = json.rol;
            window.userData = json.usuario;
            console.log(window.userData);
            fill_menu_dashboard();
            fill_info();
        }
    ).fail(
        function(){
            alert('error en la consulta de datos');
        }
    ).always(
        function() {
            
        }
    );
};

function fill_menu_dashboard(){
    switch (window.rol) {
        case 'RES':
            $('.residentes_menu').removeClass('ocultar');
            $('.familiares_menu').removeClass('ocultar');
            $('.acompaniantes_menu').removeClass('ocultar');
            $('.createUser').removeClass('ocultar');
            $('.createUser').find('span').text('Crear Usuario');
            break;
        case 'FAM':
            $('.residentes_menu').removeClass('ocultar');
            // $('.residencias_menu').removeClass('ocultar');
             $('.createUser').removeClass('ocultar');
            $('.createUser').find('span').text('Modificar perfil');
            break;
        case 'ACO':
            // $('.residencias_menu').removeClass('ocultar');
            $('.citas_aceptadas').removeClass('ocultar');
            $('.citas_disponibles').removeClass('ocultar');
            $('.historial_citas').removeClass('ocultar');
            $('.createUser').removeClass('ocultar');
            $('.createUser').find('span').text('Modificar perfil');
            break;
    }
}

function fill_info(){
     switch (window.rol) {
        case 'RES':
            $('.residencia_info .nombre').val(window.userData.nombre);
            $('.residencia_info .direccion').val(window.userData.direccion);
            $('.residencia_info .cp').val(window.userData.cp);
            $('.residencia_info .telefono').val(window.userData.telefono);
            $('.residencia_info').parent('.info').removeClass('ocultar');
            break;
        case 'FAM':
            $('.familiar_info .nombre').val(window.userData.nombre);
            $('.familiar_info .apellidos').val(window.userData.apellidos);
            $('.familiar_info .dni').val(window.userData.dni);
            $('.familiar_info .direccion').val(window.userData.direccion);
            $('.familiar_info .correo').val(window.userData.correo);
            $('.familiar_info .cp').val(window.userData.cp);
            $('.familiar_info .telefono').val(window.userData.telefono);
            $('.familiar_info').parent('.info').removeClass('ocultar');
            break;
        case 'ACO':
            $('.familiar_info .nombre').val(window.userData.nombre);
            $('.familiar_info .apellidos').val(window.userData.apellidos);
            $('.familiar_info .dni').val(window.userData.dni);
            $('.familiar_info .direccion').val(window.userData.direccion);
            $('.familiar_info .correo').val(window.userData.correo);
            $('.familiar_info .cp').val(window.userData.cp);
            $('.familiar_info .telefono').val(window.userData.telefono);
            $('.familiar_info').parent('.info').removeClass('ocultar');
            break;
    }
}

$('.editar').click(open_edit);
function open_edit(){
    $('.newUser_Residente').attr('disabled', true);
    $('.editar').addClass('ocultar');
    $('.guardarResidente').addClass('ocultar');
    $('.ver_citas').removeClass('ocultar');
     $('.cancelar').removeClass('ocultar');
    if(window.rol == 'RES'){
    $('.guardar').removeClass('ocultar');
    $('.info input').attr('disabled', false);
    $('.residente_info').find('select').attr('disabled', false);
    $('.add_fam_res').removeClass('ocultar');
     $('.eliminar').removeClass('ocultar');
    }
}

$('.cancelar').click(cancel_edit);
function cancel_edit(){
    if($('.info_table').hasClass('ocultar')){
    fill_info();
    }else{
    $('.info').addClass('ocultar');
    }
    $('.newUser_Residente').attr('disabled', false);
    $('.editar').removeClass('ocultar')
    $('.guardar').addClass('ocultar');
    $('.cancelar').addClass('ocultar');
    $('.info input').attr('disabled', true);
    $('.residente_info').find('select').attr('disabled', false);
    $('.fam_res_table').addClass('ocultar');
     $('.all_fam_res_table').addClass('ocultar');
    remove_tables_citas();
    $('.cita_info').parent('.info').addClass('ocultar');
}

$('.guardar').click(function(){
    if($('.info_table').hasClass('ocultar')){
        save();
    }else if($(this).parent('.residente_info')){
         saveResidenteFromList();
    } else if($(this).parent('.cita_info')){
         saveCita();
    }
});

// NUEVO USUARIO
$('.createUser').click(openCreateUserFields);

function removeCreateUserFields(){
     $('.createUserFields').find('input').val('');
}

function openCreateUserFields(){
    $('.info').addClass('ocultar');
    if(window.rol=='RES'){
    removeCreateUserFields();
    $('.createUserFields').find('input').removeClass('ocultar');
    $('.createUserFields').find('input').attr('disabled', false);
    $('.createUserFields').find('.rol').attr('disabled', false);
    $('.createUserFields').parent('.info').removeClass('ocultar');
    $('.createUserFields').find('button').removeClass('ocultar');
    }else{
        $('.modify-profile').parent('.info').removeClass('ocultar');
        $('.modify-profile').find('input').attr('disabled', false);
        open_modify_profile(window.userData);
    }
}

$('.guardarNewUser').click(function(){
    if(window.rol='RES'){
        var datas = {
            'nick' : $('.createUserFields').find('.nick').val(),
            'nombre' : $('.createUserFields').find('.nombre').val(),
            'apellidos' : $('.createUserFields').find('.apellidos').val(),
            'dni' : $('.createUserFields').find('.dni').val(),
            'direccion' : $('.createUserFields').find('.direccion').val(),
            'cp' : $('.createUserFields').find('.cp').val(),
            'rol' : $('.createUserFields').find('.rol option:selected').val(),
            'telefono' : $('.createUserFields').find('.telefono').val(),
            'correo' : $('.createUserFields').find('.correo').val(),
            'id_residencia' : window.userData.id
        };
        var url = 'usuario/addUsuario';
    }else if(window.rol="FAM"){
        var url = 'usuario/editFamiliar';
    } else if(window.fol="ACO"){
        var url = 'usuario/editAcompaniante';
    }
 saveUser(datas, url);   
});

function saveUser(datas, url){
    datas = JSON.stringify(datas);
     $.ajax(
              {
                url: url,
                type: 'post',
                dataType: 'json',
                contentType: 'aplication/json',
                data : datas
              } 
            ).done(
                function(json){
                  $('.mensaje').text(json.mensaje);
                }
            ).fail(
                function(){
                  $('.mensaje').text('Error en la inserción');
                }
            ).always(
                function() {
                }
            );
}

function save(){
         switch (window.rol) {
        case 'RES':
            var datas = {
                'id'            : window.userData.id,
                'id_usuario'    : window.userData.id_usuario,
                'nombre'        : $('.residencia_info .nombre').val(),
                'direccion'     : $('.residencia_info .direccion').val(),
                'cp'            : $('.residencia_info .cp').val(),
                'telefono'      : $('.residencia_info .telefono').val()
            };
            var url = 'residencia/editResidencia';
            break;
            
        case 'FAM':
            var datas = {
              'id'              : window.userData.id,
              'id_usuario'      : window.userData.id_usuario,
              'nombre'          : $('.familiar_info .nombre').val(),
              'apellidos'       : $('.familiar_info .apellidos').val(),
              'dni'             : $('.familiar_info .dni').val(),
              'direccion'       : $('.familiar_info .direccion').val(),
              'cp'              : $('.familiar_info .cp').val(),
              'telefono'        : $('.familiar_info .telefono').val()
            };
            var url = 'familiar/editFamiliar';
            break;
            
        case 'ACO':
            var datas = {
              'id'              : window.userData.id,
              'id_usuario'      : window.userData.id_usuario,
              'nombre'          : $('.familiar_info .nombre').val(),
              'apellidos'       : $('.familiar_info .apellidos').val(),
              'dni'             : $('.familiar_info .dni').val(),
              'direccion'       : $('.familiar_info .direccion').val(),
              'cp'              : $('.familiar_info .cp').val(),
              'telefono'        : $('.familiar_info .telefono').val()
            };
            var url = 'acompaniante/editAcompaniante';
            break;
    }
            datas = JSON.stringify(datas);
            $.ajax(
              {
                url: url,
                type: 'post',
                dataType: 'json',
                contentType: 'aplication/json',
                data : datas
              } 
            ).done(
                function(json){
                  $('.mensaje').text(json.mensaje);
                }
            ).fail(
                function(){
                    alert('error en la consulta de datos');
                }
            ).always(
                function() {
                    getUserData();
                    cancel_edit();
                }
            );
    
}

function removeInfo(){
    $('.info input').val('');
}
function removeInfoTable(){
    $('thead th').remove();
    $('tbody tr').remove();
}

$('.residentes_menu').click(fill_residentes_list);
$('.familiares_menu').click(fill_familiares_list);
$('.acompaniantes_menu').click(fill_acompaniantes_list);
function fill_residentes_list(){
    switch (window.rol) {
        case 'RES':
            $('.newUser_Residente').removeClass('ocultar');
            var url = 'residencia/getAllResidentesFromResidencia';
            var datas = '';
            break;
        case 'FAM':
            $('.newUser_Residente').addClass('ocultar');
            var url = 'familiar/getAllResidentesFromFamiliar';
            var datas = {
              'id' : window.userData.id
            };
            break;
        default:
            // code
    }
    $('.info').addClass('ocultar');
    removeInfoTable();
    fill_thead_residentes();
    getAllResidentesFromRol(url, datas);
}
function fill_familiares_list(){
    $('.info').addClass('ocultar');
    $('.newUser_Residente').addClass('ocultar');
    removeInfoTable();
    fill_thead_familiares_aco();
    getAllFamiliares();
}
function fill_acompaniantes_list(){
    $('.info').addClass('ocultar');
    $('.newUser_Residente').addClass('ocultar');
    removeInfoTable();
    fill_thead_familiares_aco();
    getAllAcompaniantes();
}
function getAllResidentesFromRol(url, datas){
    datas = JSON.stringify(datas);
    $.ajax(
      {
        url: url,
        type: 'post',
        dataType: 'json',
        contentType: 'aplication/json',
        data : datas
      } 
    ).done(
        function(json){
           var usuarios = json.usuarios;
           var i;
           for(i in usuarios){
           fill_tbody_residentes(usuarios[i]);
           }
            $('.info_table td').click(callEditResidente);
            $('.info_table .title_table').text('Residentes');
            $('.info_table').removeClass('ocultar');
            $('.newUser_Residente').attr('disabled', false);
           
          
        }
    ).fail(
        function(){
            
        }
    ).always(
        function() {
            
        }
    );
    
}
function fill_thead_residentes(){
    var $th = $('<th>Nombre</th>'
            +'<th>Apellidos</th>'
            +'<th>Dni</th>'
             +'<th>Fecha Alta</th>'
             +'<th>Centro Médico</th>');
    $('.info_table thead > tr').append($th);
}
function fill_tbody_residentes(residente){
    var $tr = $('<tr><td>'+residente.nombre+'</td>'
             +'<td>'+residente.apellidos+'</td>'
             +'<td>'+residente.dni+'</td>'
             +'<td>'+residente.fecha_alta+'</td>'
             +'<td>'+residente.centro+'</td>'
             +'<td class="ocultar id_fila">'+residente.id+'</td></tr>');
    $('.info_table tbody').append($tr);
}
function fill_thead_familiares_aco(){
    var $th = $('<th>Nombre</th>'
            +'<th>Apellidos</th>'
            +'<th>Dni</th>'
             +'<th>Dirección</th>'
             +'<th>Cp</th>'
             +'<th>Teléfono</th>');
    $('.info_table thead > tr').append($th);
}
function fill_tbody_familiares_aco(usuario){
    var $tr = $('<tr><td>'+usuario.nombre+'</td>'
             +'<td>'+usuario.apellidos+'</td>'
             +'<td>'+usuario.dni+'</td>'
             +'<td>'+usuario.direccion+'</td>'
             +'<td>'+usuario.cp+'</td>'
             +'<td>'+usuario.telefono+'</td>'
             +'<td class="ocultar id_fila">'+usuario.id+'</td></tr>');
    $('.info_table tbody').append($tr);
}
function fill_thead_fam_res_table(){
    var $th = $('<th>Nombre</th>'
            +'<th>Apellidos</th>'
            +'<th>Dni</th>'
            +'<th>Télefono</th>');
    $('.fam_res_table thead > tr').append($th);
}
function fill_tbody_fam_res_table(usuario){
    if(usuario.telefono == undefined){usuario.telefono = 'N/A'}
    var $tr = $('<tr><td>'+usuario.nombre+'</td>'
             +'<td>'+usuario.apellidos+'</td>'
             +'<td>'+usuario.dni+'</td>'
             +'<td>'+usuario.telefono+'</td>'
             +'<td class="ocultar id_fila">'+usuario.id+'</td></tr>');
    $('.fam_res_table tbody').append($tr);
}
function fill_thead_all_fam_res(){
     var $th = $('<th>Nombre</th>'
            +'<th>Apellidos</th>'
            +'<th>Dni</th>');
    $('.all_fam_res_table thead > tr').append($th);
}
function fill_tbody_all_fam_res(usuario){
     var $tr = $('<tr><td>'+usuario.nombre+'</td>'
             +'<td>'+usuario.apellidos+'</td>'
             +'<td>'+usuario.dni+'</td>'
             +'<td class="ocultar id_fila">'+usuario.id+'</td></tr>');
    $('.all_fam_res_table tbody').append($tr);
}
function fill_thead_citas(){
     var $th = $('<th>Fecha</th>'
            +'<th>Motivo</th>'
            +'<th>Tipo</th>');
    $('.citas_table thead > tr').append($th);
}
function fill_tbody_citas(cita){
     var $tr = $('<tr><td>'+cita.fecha+'</td>'
             +'<td>'+cita.motivo+'</td>'
             +'<td>'+cita.tipo+'</td>'
             +'<td class="ocultar id_fila">'+cita.id+'</td></tr>');
    $('.citas_table tbody').append($tr);
}
function fill_thead_his_citas(){
     var $th = $('<th>Fecha</th>'
            +'<th>Motivo</th>'
            +'<th>Tipo</th>');
    $('.his_citas_table thead > tr').append($th);
}
function fill_tbody_his_citas(cita){
     var $tr = $('<tr><td>'+cita.fecha+'</td>'
             +'<td>'+cita.motivo+'</td>'
             +'<td>'+cita.tipo+'</td>'
             +'<td class="ocultar id_fila">'+cita.id+'</td></tr>');
    $('.his_citas_table tbody').append($tr);
}

getAllCentros();
function callEditResidente(){
    var id = $(this).parent('tr').find('.id_fila').text();
    getResidente(id);
    $('.residente_info').parent('.info').removeClass('ocultar');
    open_edit();
}
function getResidente(id){
    datas = {
      'id' : id  
    };
    datas = JSON.stringify(datas);
    $.ajax(
      {
        url: 'usuario/getResidente',
        type: 'post',
        dataType: 'json',
        contentType: 'aplication/json',
        data: datas
      }
    ).done(
        function(json){
            var residente = json.residente;
            fillEdit(residente)
        }
    ).fail(
        function(){
            alert('error en la consulta de datos');
        }
    ).always(
        function() {
           
        }
    );
}
function getAllCentros(){
    $.ajax(
      {
        url: 'usuario/getAllCentros',
        type: 'post',
        dataType: 'json',
        contentType: 'aplication/json'
      }
    ).done(
        function(json){
            var centros = json.centros;
            var i;
            removeSelectCentros();
            for(i in centros){
                fillSelectCentros(centros[i]);
            }
        }
    ).fail(
        function(){
            alert('error en la consulta de datos');
        }
    ).always(
        function() {
            
        }
    );
}
function fillEdit(usuario){
            $('.residente_info').find('.id').val(usuario.id);
            $('.residente_info').find('.nombre').val(usuario.nombre);
            $('.residente_info').find('.apellidos').val(usuario.apellidos);
            $('.residente_info').find('.dni').val(usuario.dni);
            $('.residente_info').find('.centro_medico').val(usuario.id_centro_medico);
}
function fillSelectCentros(centro){
    
    var $option = $('<option value="'+centro.id+'">'+centro.nombre+'</option>');
    $('.residente_info').find('select').append($option);
}
function removeSelectCentros(){
    $('.residente_info').find('select option').remove();
}

function saveResidenteFromList(){
    datas = {
        'id' : $('.residente_info .id').val(),
        'nombre' : $('.residente_info .nombre').val(),
        'apellidos' : $('.residente_info .apellidos').val(),
        'dni' : $('.residente_info .dni').val(),
        'id_centro_medico' : $('.residente_info .centro_medico option:selected').val()
    };
    datas=JSON.stringify(datas);
    $.ajax(
      {
        url: 'residencia/editResidente',
        type: 'post',
        dataType: 'json',
        contentType: 'aplication/json',
        data : datas
      }
    ).done(
        function(json){
            $('.mensaje').text(json.mensaje);
            cancel_edit();
            fill_residentes_list();
        }
    ).fail(
        function(){
            alert('error en la consulta de datos');
        }
    ).always(
        function() {
            
        }
    );
}

$('.newUser_Residente').click(newUser_Residente);
function newUser_Residente(){
    open_edit();
    $('.ver_viaje').addClass('ocultar');
    $('.add_fam_res').addClass('ocultar');
    $('.ver_citas').addClass('ocultar');
    removeInfo();
    $('.guardar').addClass('ocultar');
     $('.eliminar').addClass('ocultar');
    $('.guardarResidente').removeClass('ocultar');
    newResidente();
}
function newResidente(){
    $('.residente_info').parent('.info').removeClass('ocultar');
    getAllCentros();
}
$('.guardarResidente').click(saveNewResidente);
function saveNewResidente(){
    datas = {
        'nombre' : $('.residente_info .nombre').val(),
        'apellidos' : $('.residente_info .apellidos').val(),
        'dni' : $('.residente_info .dni').val(),
        'id_centro_medico' : $('.residente_info .centro_medico option:selected').val()
    };
    datas=JSON.stringify(datas);
    $.ajax(
      {
        url: 'residencia/addResidente',
        type: 'post',
        dataType: 'json',
        contentType: 'aplication/json',
        data : datas
      }
    ).done(
        function(json){
            $('.mensaje').text(json.mensaje);
            cancel_edit();
            fill_residentes_list();
        }
    ).fail(
        function(){
            alert('error en la consulta de datos');
        }
    ).always(
        function() {
            
        }
    );
}


$('.eliminar').click(function(){
    var tipo = $('.info_table .title_table').text();
    if(tipo == 'Residentes'){
        remove('residente')    
    } else if(tipo == 'Familiares' || tipo == 'Acompañantes'){
        remove('familiar_acompaniante');
    } else if(!$('.cita').hasClass('ocultar')){
        remove('cita');
    }
    
});
function remove(tipo){
    switch (tipo) {
        case 'residente':
                var datas = {
                    'id' : $('.residente_info').find('.id').val()
                };
                var url = 'residencia/removeResidente';
            break;
        case 'familiar_acompaniante':
                var datas = {
                    'id' : $('.familiar_info').find('.id_usuario').val()
                };
                var url = 'usuario/removeUsuario';
            break;
        case 'cita':
                var datas = {
                    'id' : $('.cita').find('.id').val()
                };
                var url = 'residencia/removeCita';
            break;
        
        default:
            // code
    }
    datas = JSON.stringify(datas);
    $.ajax(
        {
            url: url,
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
        } 
        ).done(
        function(json){
           $('.mensaje').text(json.mensaje)
        }
        ).fail(
        function(){
            
        }
        ).always(
        function() {
            
        }
    );
}
function remove_tables_fam_res(){
     $('.fam_res_table').addClass('ocultar');
    $('.fam_res_table thead th').remove();
    $('.fam_res_table tbody tr').remove();
    $('.all_fam_res_table').addClass('ocultar');
    $('.all_fam_res_table thead th').remove();
    $('.all_fam_res_table tbody tr').remove();
}

$('.add_fam_res').click(fill_tables_fam_res);

function fill_tables_fam_res(){
     remove_tables_fam_res();
     $('.fam_res_table').removeClass('ocultar');
     $('.all_fam_res_table').removeClass('ocultar');
     $('.fam_res_table .title_table').text('Familiares del residente');
     fill_thead_fam_res_table();
     getAllFam_res();
     $('.all_fam_res_table .title_table').text('Familiares para asignar');
     fill_thead_all_fam_res();
     getAllFamiliares();
    
}

function getAllFamiliares(){
    datas ={
      'id' : window.userData.id  
    };
    datas = JSON.stringify(datas);
     $.ajax(
        {
            url: 'familiar/getAllFamiliares',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
        } 
        ).done(
        function(json){
           var familiares = json.familiares;
           var i;
                if($('.info_table .title_table').text()=='Residentes'){
                    for(i in familiares){
                    fill_tbody_all_fam_res(familiares[i]);
                    }
                    $('.all_fam_res_table td').click(bindFam_res);
                }else{
                    for(i in familiares){
                    fill_tbody_familiares_aco(familiares[i]);
                    }
                    $('.info_table .title_table').text('Familiares');
                    $('.info_table').removeClass('ocultar');
                    $('.info_table td').unbind('click');
                    $('.info_table td').click(getFamiliar);
                }
        }
        ).fail(
        function(){
            
        }
        ).always(
        function() {
            
        }
    );
}

function getAllAcompaniantes(){
    var datas ={
      'id' : window.userData.id
    };
    datas = JSON.stringify(datas);
     $.ajax(
        {
            url: 'acompaniante/getAllAcompaniantes',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
        } 
        ).done(
        function(json){
           var acompaniantes = json.acompaniantes;
           var i;
                for(i in acompaniantes){
                fill_tbody_familiares_aco(acompaniantes[i]);
                }
                $('.info_table .title_table').text('Acompañantes');
                $('.info_table').removeClass('ocultar');
                $('.info_table td').unbind('click');
                $('.info_table td').click(getAcompaniante);
        }
        ).fail(
        function(){
            
        }
        ).always(
        function() {
            
        }
    );
}
function getAllFam_res(){
    datas = {
        'id' : $('.residente_info .id').val()
    };
    datas = JSON.stringify(datas);
    $.ajax(
        {
            url: 'familiar/getAllFam_res',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
        } 
        ).done(
        function(json){
           var familiares = json.familiares;
           var i;
           for(i in familiares){
               fill_tbody_fam_res_table(familiares[i]);
           }
            $('.fam_res_table td').click(unBindFam_res);
           
        }
        ).fail(
        function(){
            
        }
        ).always(
        function() {
            
        }
    );
    
}
function bindFam_res(){
    if($('.familiar_info').hasClass('ocultar')){
        datas = {
        'id_residente' : $(this).parent('tr').find('.id_fila').text(),
        'id_familiar' : $('.familiar_info .id').val()
        }
    }else{
        datas = {
        'id_familiar' : $(this).parent('tr').find('.id_fila').text(),
        'id_residente' : $('.residente_info .id').val()
        }
    }
    datas = JSON.stringify(datas);
        $.ajax(
          {
            url: 'familiar/addFam_res',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
          } 
        ).done(
            function(json){
               $('.mensaje').text(json.mensaje);
               remove_tables_fam_res();
            }
        ).fail(
            function(){
                
            }
        ).always(
            function() {
            
        }
    );
    
}
function unBindFam_res(){
    if($('.familiar_info').hasClass('ocultar')
    ){
        datas = {
        'id_residente' : $(this).parent('tr').find('.id_fila').text(),
        'id_familiar' : $('.familiar_info .id').val()
        }
    }else{
        datas = {
        'id_familiar' : $(this).parent('tr').find('.id_fila').text(),
        'id_residente' : $('.residente_info .id').val()
        }
    }
    datas = JSON.stringify(datas);
        $.ajax(
          {
            url: 'familiar/removeFam_res',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
          } 
        ).done(
            function(json){
              $('.mensaje').text(json.mensaje);
              remove_tables_fam_res();
            }
        ).fail(
            function(){
                
            }
        ).always(
            function() {
            
        }
    );
}

$('.ver_citas').click(fill_tables_citas);
function remove_tables_citas(){
    $('.citas_table').addClass('ocultar');
    $('.citas_table thead th').remove();
    $('.citas_table tbody td').remove();
    $('.his_citas_table').addClass('ocultar');
    $('.his_citas_table thead th').remove();
    $('.his_citas_table tbody td').remove();
}
function getAllCitas(){
    if(window.rol == 'ACO'){
         var id = window.userData.id;
         var url = 'acompaniante/getCitas';
    }else if(window.rol=='RES' || window.rol== 'FAM'){
        var id = $('.residente_info .id').val();
        var url = 'residencia/getCitasFromResidente';
    }
    var datas = {
        'id' : id
    };
    datas = JSON.stringify(datas);
    $.ajax(
        {
            url: url,
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
        } 
        ).done(
        function(json){
           var citas = json.citas;
           var i;
           var dateNow = new Date();
           var dateCita;
           for(i in citas){
               dateCita = new Date(citas[i].fecha);
               if(dateCita > dateNow){
                   fill_tbody_citas(citas[i]);  
               }else{
                  fill_tbody_his_citas(citas[i]);
               }
               dateCita = '';
               
           }
           $('.citas_table td').click(getCita);
           $('.his_citas_table td').click(getCita);
           
        }
        ).fail(
        function(){
            
        }
        ).always(
        function() {
            
        }
    );
}
function fill_tables_citas(){
    remove_tables_citas();
    fill_thead_citas();
    $('.citas_table').removeClass('ocultar');
    if(window.rol == 'RES'){
        $('.citas_table').find('.addCita').removeClass('ocultar');
        fill_thead_his_citas();
         $('.his_citas_table').removeClass('ocultar');
    }else if(window.rol=='ACO'){
         
    }
    getAllCitas();
}
function removeInfoCita(){
    $('.cita_info').find('input').val('');
    $('.cita_info').find('textarea').val('');
    $('.cita_info').find('button').addClass('ocultar');
    $('.cita_info').find('input').attr('disabled', true);
    $('.cita_info').find('select').attr('disabled', true);
    $('.cita_info').find('textarea').attr('disabled', true);
    $('.cita_info').parent('.info').addClass('ocultar');
}
$('.addCita').click(function(){
    open_info_cita();
});
function open_info_cita(cita){
    removeInfoCita();
    $('.cita_info').parent('.info').removeClass('ocultar');
    $('.cita_info').find('.cita').removeClass('ocultar');
    $('.viaje_info').addClass('ocultar');
    // Si hay cita rellenamos los datos
    if(cita != undefined){
        $('.fecha_picker').addClass('ocultar');
        $('.cita .fecha').removeClass('ocultar');
        $('.cita .fecha').val(cita.fecha);
        $('.cita .motivo').val(cita.motivo);
        $('.cita .tipo').val(cita.tipo);
        $('.cita .fam_bool').val(cita.fam_disponible);
        $('.cita .descripcion').val(cita.descripcion);
        $('.cita .id').val(cita.id);
        $('.ver_viaje').removeClass('ocultar');
    } else{
        $('.fecha_picker').removeClass('ocultar');
        $('.cita .fecha').addClass('ocultar');
    }
    // Si es la residencia habilitamos GUARDAR
     if(window.rol == 'RES'){
         if(cita === undefined){
             $('.guardar_cita').removeClass('ocultar');
             $('.cita').find('input').attr('disabled', false);
             $('.cita').find('select').attr('disabled', false);
             $('.cita').find('textarea').attr('disabled', false);
         }
         $('.eliminar_cita').removeClass('ocultar');
        //  Si es el acompañante habilitamos INICIAR Y FINALIZAR
     } else if(window.rol == 'ACO'){
         $('.aceptar_cita').removeClass('ocultar');
     } else if(window.rol=='FAM'){
         $('.cita').find('.fam_bool').attr('disabled', false);
        //  Si es el familiar habilitamos BOOLEANOS IR CITA
         if(cita.fam_disponible == 0){
             $('.change_fam_cita').text('No ir');
            
         } else{
             $('.change_fam_cita').text('Ir');
         }
         $('.change_fam_cita').removeClass('ocultar');
     }
     $('.cancelar').removeClass('ocultar');
     
}

$('.cita').find('.fam_bool').change(function(){
     if($('.fam_bool').val()==0){
         $('.change_fam_cita').text('No ir');
     }else{
         $('.change_fam_cita').text('ir');
     }
    
    
});

function getCita(){
    var datas = {
        'id' : $(this).parent('tr').find('.id_fila').text()
    };
    datas = JSON.stringify(datas);
    $.ajax(
        {
            url: 'residencia/getCita',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
        } 
        ).done(
        function(json){
           open_info_cita(json.cita);
        }
        ).fail(
        function(){
            
        }
        ).always(
        function() {
            
        }
    );
}


$('.guardar_cita').click(addCita);
function addCita(){
    var datas = {
      'id_residente' : $('.residente_info').find('.id').val(),
      'fecha' : $('.cita_info').find('.fecha_picker').val(),
      'motivo' : $('.cita_info').find('.motivo').val(),
      'tipo' : $('.cita_info').find('.tipo').val(),
      'fam_disponible' : $('.cita_info').find('.fam_bool').val(),
      'descripcion' : $('.cita_info').find('.descripcion').val()
    };
    datas = JSON.stringify(datas);
    $.ajax(
        {
            url: 'residencia/addCita',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
        } 
        ).done(
        function(json){
           $('.mensaje').text(json.mensaje);
           fill_tables_citas();
        }
        ).fail(
        function(){
            
        }
        ).always(
        function() {
            $('.cita_info').parent('.info').addClass('ocultar');
           
        }
    );
}

$('.eliminar_cita').click(removeCita);
function removeCita(){
     var datas = {
      'id' : $('.cita_info').find('.id').val()
    };
    datas = JSON.stringify(datas);
    $.ajax(
        {
            url: 'residencia/removeCita',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
        } 
        ).done(
        function(json){
           $('.mensaje').text(json.mensaje);
           getAllCitas();
           
        }
        ).fail(
        function(){
            
        }
        ).always(
        function() {
            $('.cita_info').parent('.info').addClass('ocultar');
            
        }
    );
}


function removeInfoViaje(){
    $('.viaje_info').find('input').val('');
}
$('.ver_viaje').click(getViaje);
function getViaje(){
    var datas = {
      'id_cita' : $('.cita_info').find('.id').val()  
    };
    datas = JSON.stringify(datas);
     $.ajax(
        {
            url: 'residencia/getViaje',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
        } 
        ).done(
        function(json){
           if(json.mensaje){
               $('.mensaje').text(json.mensaje);
           }else{
               open_info_viaje(json.viaje);
           }
        }
        ).fail(
        function(){
            
        }
        ).always(
        function() {
            
        }
    );
}
function open_info_viaje(viaje){
    removeInfoViaje();
    $('.viaje_info').removeClass('ocultar');
    $('.viaje_info').find('.id').val(viaje.id);
    $('.viaje_info').find('.acompaniante').val(viaje.acompaniante);
    $('.viaje_info').find('.h_salida').val(viaje.h_salida);
    $('.viaje_info').find('.h_llegada').val(viaje.h_llegada);
    $('.viaje_info').find('.estado').val(viaje.estado);
    if(viaje.estado == 'PENDIENTE'){
       $('.cita_info').find('.iniciar').removeClass('ocultar');
       $('.cita_info').find('.cancelar_cita').removeClass('ocultar');
       $('.cita_info').find('.aceptar_cita').addClass('ocultar');
    }else if(viaje.estado == 'INICIADO'){
        $('.cita_info').find('.finalizar').removeClass('ocultar');
        $('.cita_info').find('.iniciar').addClass('ocultar');
        $('.cita_info').find('.cancelar_cita').addClass('ocultar');
        $('.cita_info').find('.aceptar_cita').addClass('ocultar');
    } else if(viaje.estado == 'TERMINADO'){
        $('.cita_info').find('.finalizar').addClass('ocultar');
        $('.cita_info').find('.iniciar').addClass('ocultar');
        $('.cita_info').find('.cancelar_cita').addClass('ocultar');
        $('.cita_info').find('.aceptar_cita').addClass('ocultar');
    }
}

function getFamiliar(){
    var datas = {
      'id' : $(this).parent('tr').find('.id_fila').text()
    };
    datas = JSON.stringify(datas);
     $.ajax(
        {
            url: 'familiar/getFamiliar',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
        } 
        ).done(
        function(json){
            remove_familiar_aco_info();
            open_familiar_aco_info(json.familiar);
        }
        ).fail(
        function(){
            
        }
        ).always(
        function() {
            
        }
    );
}

function getAcompaniante(){
    var datas = {
      'id' : $(this).parent('tr').find('.id_fila').text()
    };
    datas = JSON.stringify(datas);
     $.ajax(
        {
            url: 'acompaniante/getAcompaniante',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
        } 
        ).done(
        function(json){
            remove_familiar_aco_info();
            open_familiar_aco_info(json.acompaniante);
        }
        ).fail(
        function(){
            
        }
        ).always(
        function() {
            
        }
    );
}

function remove_familiar_aco_info(){
    $('.familiar_info').find('input').val('');
}

function open_familiar_aco_info(usuario){
    $('.familiar_info').find('.id').val(usuario.id);
    $('.familiar_info').find('.id_usuario').val(usuario.id_usuario);
    $('.familiar_info').find('.nombre').val(usuario.nombre);
    $('.familiar_info').find('.apellidos').val(usuario.apellidos);
    $('.familiar_info').find('.dni').val(usuario.dni);
    $('.familiar_info').find('.direccion').val(usuario.direccion);
    $('.familiar_info').find('.correo').val(usuario.correo);
    $('.familiar_info').find('.cp').val(usuario.cp);
    $('.familiar_info').find('.telefono').val(usuario.telefono);
    $('.familiar_info').find('.eliminar').removeClass('ocultar');
    $('.familiar_info').find('.cancelar').removeClass('ocultar');
    $('.familiar_info').parent('.info').removeClass('ocultar');
}
function remove_modify_profile(){
    $('.modify_profile').find('input').val('');
}

function open_modify_profile(usuario){
    remove_modify_profile();
    $('.modify_profile').find('.id').val(usuario.id);
    $('.modify_profile').find('.id_usuario').val(usuario.id_usuario);
    $('.modify_profile').find('.direccion').val(usuario.direccion);
    $('.modify_profile').find('.cp').val(usuario.cp);
    $('.modify_profile').find('.telefono').val(usuario.telefono);
    $('.modify_profile').parent('.info').removeClass('ocultar');
}

$('.save_modify_profile').click(function(){
    check_modify_password();
    save_profile();
});

function check_modify_password(){
    var password =  $('.modify_profile').find('.password').val();
    var re_password = $('.modify_profile').find('.re_password').val();
    if(password === re_password && password != ''){
        var datas = {
          'password' : password,
          'old_password' : $('.modify_profile').find('.old_password').val()
        };
        datas = JSON.stringify(datas);
         $.ajax(
        {
            url: 'usuario/editPassword',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
        } 
        ).done(
        function(json){
           $('.mensaje').text(json.mensaje)
        }
        ).fail(
        function(){
            
        }
        ).always(
        function() {
            
        }
    );
    }else if(password != ''){
        $('.mensaje').text('Las contraseñas no coinciden');
    }
}

function save_profile(){
    var datas = {
        'id' :  $('.modify_profile').find('.id').val(),
        'direccion' : $('.modify_profile').find('.direccion').val(),
        'cp' : $('.modify_profile').find('.cp').val(),
        'telefono' : $('.modify_profile').find('.telefono').val(),
    };
    if(window.rol=='FAM'){
        var url = 'familiar/editFamiliar';    
    }else{
        var url = 'acompaniante/editAcompaniante';
    }
    datas = JSON.stringify(datas);
     $.ajax(
        {
            url: url,
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
        } 
        ).done(
        function(json){
           $('.mensaje').text(json.mensaje);
           $('.reload_profile').click(function(){
              window.location.href = window.location.href;
           });
        }
        ).fail(
        function(){
            
        }
        ).always(
        function() {
            
        }
    );
}



// BOOLEANO CITA FAMILIAR DISPONIBLE


$('.change_fam_cita').click(change_fam_cita);
function change_fam_cita(){
   var datas = {
     'id_cita' : $('.cita').find('.id').val(),
     'fam_disponible' : $('.fam_bool').val()
   }
   datas = JSON.stringify(datas);
    $.ajax(
        {
            url: 'familiar/editFam_disponible',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
        } 
        ).done(
        function(json){
           if($('.fam_bool').val() == 0 && json.respuesta == 1){
               $('.change_fam_cita').text('No ir');
           }else if(json.respuesta == 1){
               $('.change_fam_cita').text('Ir');
           }
           if(json.respuesta == 1){
           $('.mensaje').text('Actualizado.');    
           }else{
               $('.mensaje').text('Error.');
           }
           
        }
        ).fail(
        function(){
            
        }
        ).always(
        function() {
            
        }
    );
   
}


//FUNCIONALIDAD COMPAÑANTES Y CITAS
$('.citas_aceptadas').click(removeInfoCita);
$('.citas_disponibles').click(removeInfoCita);
$('.historial_citas').click(removeInfoCita);
$('.citas_disponibles').click(getCitasAvaiableFromResidencia);

function getCitasAvaiableFromResidencia(){
    $('.citas_table').find('.title_table').text('Citas disponibles');
    fill_tables_citas();
    var datas = {
      'id_acompaniante' : window.userData.id  
    };
     datas = JSON.stringify(datas);
     $.ajax(
        {
            url: 'acompaniante/getCitasAvaiableFromResidencia',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
        } 
        ).done(
        function(json){
            var citas = json.citas;
            var i;
            for(i in citas){
                fill_tbody_citas(citas[i]);
            }
            $('.citas_table td').click(getCita);
        }
        ).fail(
        function(){
            $('.mensaje').text('Fallo en la consulta.');
        }
        ).always(
        function() {
            
        }
    );
}

$('.aceptar_cita').click(addViaje);
function addViaje(){
    var datas = {
      'id_acompaniante' : window.userData.id,
      'id_cita' : $('.cita_info').find('.id').val()
    };
     datas = JSON.stringify(datas);
     $.ajax(
        {
            url: 'acompaniante/addViaje',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
        } 
        ).done(
        function(json){
            $('.mensaje').text(json.mensaje);
        }
        ).fail(
        function(){
            $('.mensaje').text('Fallo en la consulta.');
        }
        ).always(
        function() {
            
        }
    );
}

$('.citas_aceptadas').click(getCitasAceptadas);
function getCitasAceptadas(){
    $('.citas_table').find('.title_table').text('Citas aceptadas');
    fill_tables_citas();
    var datas = {
      'id_acompaniante' : window.userData.id,
    };
     datas = JSON.stringify(datas);
     $.ajax(
        {
            url: 'acompaniante/getCitasAceptadas',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
        } 
        ).done(
        function(json){
            var citas = json.citas;
            var i;
            for(i in citas){
                fill_tbody_citas(citas[i]);
            }
            $('.citas_table td').click(getCita);
        }
        ).fail(
        function(){
            $('.mensaje').text('Fallo en la consulta.');
        }
        ).always(
        function() {
            
        }
    );
}

$('.historial_citas').click(getCitasHistorial);
function getCitasHistorial(){
    $('.citas_table').find('.title_table').text('Historial de citas');
    fill_tables_citas();
    var datas = {
      'id_acompaniante' : window.userData.id,
    };
     datas = JSON.stringify(datas);
     $.ajax(
        {
            url: 'acompaniante/getCitasHistorial',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data : datas
        } 
        ).done(
        function(json){
            var citas = json.citas;
            var i;
            for(i in citas){
                fill_tbody_citas(citas[i]);
            }
            $('.citas_table td').click(getCita);
        }
        ).fail(
        function(){
            $('.mensaje').text('Fallo en la consulta.');
        }
        ).always(
        function() {
            
        }
    );
}

$('.iniciar').click(editViajeIniciar)

function editViajeIniciar(){
    var datas = {
        'id_viaje' :  $('.viaje_info').find('.id').val()
    }
    datas = JSON.stringify(datas);
     $.ajax(
        {
            url: 'acompaniante/editViajeIniciar',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data: datas
        } 
        ).done(
        function(json){
            $('.mensaje').text(json.mensaje);
            getViaje();
        }
        ).fail(
        function(){
            $('.mensaje').text('Fallo en la consulta.');
        }
        ).always(
        function() {
            
        }
    );
}

$('.finalizar').click(editViajeFinalizar)

function editViajeFinalizar(){
    var datas = {
        'id_viaje' :  $('.viaje_info').find('.id').val()
    }
    datas = JSON.stringify(datas);
     $.ajax(
        {
            url: 'acompaniante/editViajeFinalizar',
            type: 'post',
            dataType: 'json',
            contentType: 'aplication/json',
            data: datas
        } 
        ).done(
        function(json){
            $('.mensaje').text(json.mensaje);
            getViaje();
        }
        ).fail(
        function(){
            $('.mensaje').text('Fallo en la consulta.');
        }
        ).always(
        function() {
            
        }
    );
}

}());