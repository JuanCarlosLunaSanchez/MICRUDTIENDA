// --------------------------------------------------------------------------------------------------------------------------------------------------------
// FUNCION PARA LOS BOTONES DE EDITAR Y ELEMINAR 
$(document).ready(function () {
    tablaproductos = $("#tablaproductos").DataTable({
        "searching": true,
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'>"+
            // BOTON EDITAR DENTRO DE LA TABLA
            "<button class='btn btn-warning btnEditar'><i class='bi bi-pencil-fill'></i></button>&nbsp;&nbsp;"+
            // BOTON BORRAR DENTRO DE LA TABLA
            "<button class='btn btn-danger btnBorrar'><i class='bi bi-trash3-fill'></i></button></div></div></div>"
        }],

        // --------------------------------------------------------------------------------------------------------------------------------------------------------
        // CAMBIADO DEL LENGUAJE EN ESPAÑOL
        "language": {
            "lengthMenu": "MOSTRAR _MENU_ REGISTROS",
            "zeroRecords": "No se encontraron resultados",
            "info": "MOSTRANDO REGISTROS DEL _START_ AL _END_ DE UN TOTAL DE _TOTAL_ REGISTROS",
            "infoEmpty": "MOSTRANDO REGISTROS DEL 0 AL 0 DE UN TOTAL DE 0 REGISTROS",
            "infoFiltered": "(FILTRADO DE UN TOTAL DE _MAX_ REGISTROS)",
            "sSearch": "BUSCAR:",
            "oPaginate": {
                "sFirst": "PRIMERO", 
                "sLast": "ÚLTIMO",
                "sNext": "SIGUIENTE",
                "sPrevious": "ANTERIOR"
            },
            "sProcessing": "PROCESANDO...",
        }
    });

// -------------------------------------------------------------------------------------------------------------------------------------------------------- 
    // LLAMADO DEL MODAL NUEVO
    $("#btnNuevo").click(function () {
        // BORRADO DE LOS DATOS EN LOS INPUTS
        $("#formProductos").trigger("reset");
        // COLOR ENCABEZADO MODAL
        $(".modal-header").css("background-color", "#3498DB");
        // COLOR LETRA TITULO MODAL 
        $(".modal-header").css("color", "white");
        // TITULO DEL MODAL
        $(".modal-title").text("NUEVO PRODUCTO");
        // VISUALIZAR MODAL
        $("#modalCRUD").modal("show");
        idproducto = null;
        // VARIABLE PARA ENTRAR EN EL SWITCH DEL CRUD.PHP
        opcion = 1;
    });

// --------------------------------------------------------------------------------------------------------------------------------------------------------
    //REGISTRO DE LOS DATOS     
$("#formProductos").submit(function (e) {
        // VARIABLES PARA TOMAr LOS VALORES DEL MODAL
        idproducto = $.trim($("#idproducto").val());
        nombre = $.trim($("#nombre").val()); 
        descripcion = $.trim($("#descripcion").val());
        precio = $.trim($("#precio").val());
        cantidad = $.trim($("#cantidad").val());
        // HACE REFERENCIA CON EL ARCHIVO A INTERACTUAR Y LOS DATOS A ENVIAR       
        e.preventDefault();
        $.ajax({
            url: "bd/crud.php",
            type: "POST",
            dataType: "json",
            data: { idproducto: idproducto, nombre: nombre, descripcion: descripcion, precio: precio, cantidad: cantidad, opcion: opcion },
            // FUNCION PARA DEVOLVER LOS DATOS 
            success: function (data) {
                // VERIFICACION POR CONSOLA DE LOS DATOS QUE RECIBO
                row=JSON.stringify(data);
                if (opcion == 1) {
                    // SWEETALERT2 DATOS REGISTRADOS
                    Swal.fire({
                        icon: 'success',
                        iconColor: '#28B463',
                        title: '¡REGISTRADO!',
                        text: 'PRODUCTO REGISTRADO CORRECTAMENTE',
                        showConfirmButton: false,
                        confirmButtonColor: '#FF0000',
                        timer: 2000
                    }).then(function () {
                        location.reload();
                    })                    
                } else {
                    // SWEETALERT2 DATOS ELIMINADOS 
                    Swal.fire({
                        icon: 'success',
                        iconColor: '#28B463',
                        title: '¡ACTUALIZADO!',
                        text: 'PRODUCTO ACTUALIZADO CORRECTAMENTE',
                        showConfirmButton: false,
                        confirmButtonColor: '#FF0000',
                        timer: 2000
                    }).then(function () {
                        location.reload();
                    })
                }             
            },
            Error:function(error){
                console.log(error);
                alert("error")
            }
        });
        // CERRAR EL MODAL
        $("#modalCRUD").modal("hide");
    });

// --------------------------------------------------------------------------------------------------------------------------------------------------------
// VARIABLE DE LA FILA DEL REGISTRO A EDITAR O ELIMINAR   
    var fila;  

// --------------------------------------------------------------------------------------------------------------------------------------------------------
//EDICION DE LOS DATOS
$(document).on("click", ".btnEditar", function () {
    // llama los label del modal
    fila = $(this).closest("tr");
    console.log($(fila).attr("dataid"));
    idproducto = parseInt(fila.find('td:eq(0)').text());
    nombre = fila.find('td:eq(1)').text();
    descripcion = fila.find('td:eq(2)').text();
    precio = parseInt(fila.find('td:eq(3)').text());
    cantidad = parseInt(fila.find('td:eq(4)').text());

    //Muestra los datos 
    $("#idproducto").val(idproducto);
    $("#nombre").val(nombre);
    $("#descripcion").val(descripcion);
    $("#precio").val(precio);
    $("#cantidad").val(cantidad);
    // VARIABLE PARA ENTRAR EN EL SWITCH DEL CRUD.PHP
    opcion = 2;         
    
    // activa el modal   
    $(".modal-header").css("background-color", "#3498DB");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("EDITAR PRODUCTO");
    $("#modalCRUD").modal("show");
});

// --------------------------------------------------------------------------------------------------------------------------------------------------------
//ELIMINACION DE LOS DATOS
    // VARIABLE PARA ENTRAR EN EL SWITCH DEL CRUD.PHP
    opcion = 3
    $(document).on("click", ".btnBorrar", function () {
        fila = $(this);
        idproducto = parseInt($(this).closest("tr").find('td:eq(0)').text());
        // SWEETALERT2 DATOS ELIMINADOS
        Swal.fire({
          title: 'ESTAS SEGURO DE ELIMINAR EL PRODUCTO CON #: ' +idproducto+ '?',
          text: "¡NO PODRAS REVERTIR ESTO!",
          icon: 'warning',
          iconColor: '#FF5733',
          showCancelButton: true,
          confirmButtonColor: '#FF0000',
          confirmButtonText: 'ACEPTAR',
          cancelButtonColor: '#000000',
          cancelButtonText: 'CANCELAR',
        }).then((respuesta)=>{
            if(respuesta.value){
                $.ajax({
                    url: "bd/crud.php",
                    type: "POST",
                    dataType: "json",
                    data: { opcion: opcion, idproducto: idproducto },

                    success: function () {
                        tablaproductos.row(fila.parents('tr')).remove().draw();
                        Swal.fire({
                            icon: 'success',
                            iconColor: '#28B463',
                            title: '¡ELIMINADO!',
                            text: 'PRODUCTO ELIMINADO CORRECTAMENTE',
                            showConfirmButton: false,
                            timer: 2000

                        }).then(function () {
                            // REFRESCAMIENTO DE LA PAGINA AUTOMATICAMENTE
                            location.reload();
                        });
                    },
                });
            };
        });
    });
});
