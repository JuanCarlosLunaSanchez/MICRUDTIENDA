<!-- Codigo que sirve para la conexion, llenado y consulta de los datos de la BD con el template----------------------------------------->
<?php
session_start();

include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT * FROM PRODUCTOS";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
<!-- LINKS -->
<head>
    <title>Examen | App Tienda</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- llamado de los servicios de bootstrap -->
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="main.css">
    <!-- llamado de los servicios de dataTables -->
    <link rel="stylesheet" type="text/css" href="plugins/datatables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <!-- llamado de los iconos de bootstrap -->
    <link rel="stylesheet" href="plugins/icons/font/bootstrap-icons.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="plugins/micss/fonts.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="plugins/micss/ionicons.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- sweet alert -->
    <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #3498DB ;">
            <ul class="navbar-nav ml-auto">
                <div class="row">
                    <div class="col-lg-12">
                        <button id="btnNuevo" type="button" class="btn" data-toggle="modal" style="color:#3498DB ">
                            <i class="bi bi-file-earmark-plus" style="color: white;"></i>
                            <b>
                                <font style="color: white;">NUEVO PRODUCTO</font>
                            </b>
                        </button>
                    </div>
                </div>
            </ul>
        </nav>

        <div class="content-wrapper">
            <div class="content">
                <div class="table-responsive">
                    <div class="col-lg-12">
                        <div class="card p-4">
                            <div class="table-responsive">
                                <table id="tablaproductos" class="table table-active table-bordered table-condensed">
                                    <thead class="text-center" style="color: white;">
                                        <tr style="background-color:#3498DB ">
                                            <th>#</th>
                                            <th>NOMBRE</th>
                                            <th>DESCRIPCIÓN</th>
                                            <th>PRECIO</th>
                                            <th>CANTIDAD</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($data as $dat) {
                                        ?>
                                        <tr>
                                            <td style="text-transform:uppercase" align="center"><?php echo $dat['idproducto'] ?></td>
                                            <td style="text-transform:uppercase"><?php echo $dat['nombre'] ?></td>
                                            <td style="text-transform:uppercase"><?php echo $dat['descripcion'] ?></td>
                                            <td style="text-transform:uppercase" align="right"><?php echo $dat['precio'] ?></td>
                                            <td style="text-transform:uppercase" align="right"><?php echo $dat['cantidad'] ?></td>
                                            <?php echo '<td></td>'; ?>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div class="modal fade" id="modalCRUD" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formProductos">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" value="0" id="idproducto">
                        </div>
                        <div class="form-group">
                            <label for="nombre" class="col-form-label"> NOMBRE: </label>
                            <input type="text" class="form-control" id="nombre" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-form-label"> DESCRIPCIÓN: </label>
                            <input type="text" class="form-control" id="descripcion" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="precio" class="col-form-label"> PRECIO: </label>
                            <input type="text" class="form-control" id="precio" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="cantidad" class="col-form-label"> CANTIDAD: </label>
                            <input type="text" class="form-control" id="cantidad" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" id="btnGuardar">GUARDAR</button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal">CANCELAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jquery, popper, bootstrap, datatable, js, scripts opcionales  -->
    <script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.js"></script>
    <script type="text/javascript" src="plugins/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="main.js"></script>
    <script src="plugins/chart.js/Chart.min.js"></script>

</body>
</html>