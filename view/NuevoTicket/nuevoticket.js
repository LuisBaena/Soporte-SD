
function init(){
   
    $("#ticket_form").on("submit",function(e){
        guardaryeditar(e);	
    });
    
}

$(document).ready(function() {

     //ACTIVA EL SUMMERNOTE MEDIANTE ID
    $('#tick_descrip').summernote({
        height: 150,
        lang: "es-ES",
        callbacks: {
            onImageUpload: function(image) {
                console.log("Image detect...");
                myimagetreat(image[0]);
            },
            onPaste: function (e) {
                console.log("Text detect...");
            }
        },
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ],
        popover: {
            image: [],
            link: [],
            air: []
        }
       
    });
    
    //MUESTRA EL TIPO DE SOLICITUD EN EL SELECT
    $.post("../../controller/ticket.php?op=tipoSolicitud", function(data, status, e){
        $('#tipoSolicitud').html(data);
    });
    //MUESTRA LA SUCURSAL EN EL SELECT
    $.post("../../controller/ticket.php?op=sucursal", function(data, status, e){
        $('#sucursal').html(data);
    });
    //MUESTRA LAS AREAS EN EL SELECT
    $.post("../../controller/ticket.php?op=areas", function(data, status, e){
        $('#areas').html(data);
    });

    //MUESTRA LA PRIORIDAD EN EL SELECT
    $.post("../../controller/ticket.php?op=prioridad", function(data, status, e){
        $('#prioridad').html(data);
    });

    // MUESTRA LA CATEGORIA PRINCIPAL
    $.post("../../controller/ticket.php?op=categoria",function(data, status,e){
        $('#cat_id').html(data);                     
    });
   
    // MUESTRA LAS SUBCATEGORIAS PERTENECIENTES A LA CATEGORIA PRINCIPAL MEDIANTE EL EVENTO ONCHANGE DEL SELECT
    $("#cat_id").change(function(){
        var idCategoria = $(this).val();
        $.post("../../controller/ticket.php?op=subcategoria", {idCategoria : idCategoria},function(data, status,e){
            $('#subcat_id').html(data);                     
        });
    });

    // MUESTRA EL ARTICULO QUE HEREDA DE LA SUBCATEGORIA Y CATEGORIA PRINCIPAL
    $("#subcat_id").change(function(){
        var idSubCategoria = $(this).val();
        
        $.post("../../controller/ticket.php?op=articuloSubcategoria", {idSubCategoria : idSubCategoria},function(data, status,e){
            $('#articulo_id').html(data);                     
        });
    });
    // MUESTRA LOS USUARIOS REGISTRADOS CON EL ROL DE SOPORTE TECNICO   2        
        $.post("../../controller/ticket.php?op=rolSoporte",function(data, status,e){
            $('#soporte').html(data);                     
        });
    // MUESTRA LOS USUARIOS REGISTRADOS CON EL ROL DE SUPERVISOR         3  
    $.post("../../controller/ticket.php?op=rolSupervisor",function(data, status,e){
        $('#supervisor').html(data);                     
    });    
    
   
   
});

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#ticket_form")[0]);
  
    if ($('#tick_descrip').summernote('isEmpty') || $('#tick_titulo').val()==''){
        swal("Advertencia!", "Campos Vacios", "warning");
    }else{
        var totalfiles = $('#fileElem').val().length;
        for (var i = 0; i < totalfiles; i++) {
            formData.append("files[]", $('#fileElem')[0].files[i]);
            console.log(formData);
        }

        $.ajax({
            url: "../../controller/ticket.php?op=insert",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data){
                data = JSON.parse(data);
                console.log(data[0].tick_id);

                $.post("../../controller/email.php?op=ticket_abierto", {tick_id : data[0].tick_id}, function (data) {

                });

                $('#tick_titulo').val('');
                $('#tick_descrip').summernote('reset');
                swal("Correcto!", "Registrado Correctamente", "success");
            }
        });
    }
}

init();