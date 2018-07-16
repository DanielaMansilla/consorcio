<?php /* Mostrar monto total de expensas impagas O mostrar lista de expensas pasadas de fecha*/
require_once '../config/Conexion.php'; 
session_start();
if (!isset($_SESSION['propietario'])) {
    header("Location: index.php");
} 
?>

<!DOCTYPE html>
<html lang="es">
<?php include('template/head.php'); ?>
    <body>
    <?php 
        include('template/nav.php');  
        include('template/header.php'); ?>
    
    <title>Consorcios del Valle - Deudas</title>

    <div class="container">
        <div class="content">
            <h2>Mis Deudas</h2>
            <hr />
            
            <!-- <label><b>Mis Deudas:</b></label> -->

    <?php
        $idUsuario = $_SESSION['idUsuario'];

        $queryDeudasUsuario = mysqli_query($conexion,
                        "SELECT *, expensa.importe as importeExpensa
                        FROM expensa 
                        JOIN liquidacion ON expensa.idLiquidacion = liquidacion.idLiquidacion
                        JOIN propiedad ON expensa.idPropiedad = propiedad.idPropiedad
                        WHERE propiedad.idUsuarios = '$idUsuario' 
                        AND expensa.estado = 'Impago'") or die(mysqli_error($conexion));  

        $cantidadDeudasUsuario = mysqli_num_rows($queryDeudasUsuario);
        if ($cantidadDeudasUsuario == 0) {
            echo '<div class="alert alert-info alert-dismissable">Usted no posee deudas.</div>';
        } else {
            $querySumaTotalDeudas = mysqli_query($conexion,
                "SELECT SUM(expensa.importe) as total
                FROM expensa 
                JOIN liquidacion ON expensa.idLiquidacion = liquidacion.idLiquidacion
                JOIN propiedad ON expensa.idPropiedad = propiedad.idPropiedad
                JOIN usuarios ON propiedad.idUsuarios = usuarios.IdUsuarios
                WHERE propiedad.idUsuarios = '$idUsuario' 
                AND expensa.estado = 'Impago'") or die(mysqli_error($conexion));
                
                $totalDeudaPropietario = (float) 0.0;
                if ($querySumaTotalDeudas) {
                    $totalDeudaPropietario = number_format((float)mysqli_fetch_assoc($querySumaTotalDeudas)["total"], 2, '.', '');
                }
                echo "<br><strong>TOTAL:</strong> $ $totalDeudaPropietario";
            ?>
            <div class="table-responsive">
            <table class="table table-striped table-hover">
                <tr>
                    <th>Id Expensa</th>
                    <th>Propiedad</th>
                    <th>Vencimiento</th>
                    <th>Importe</th>
                    <th style="text-align:center;">Acciones</th>

                </tr>
                
            <?php
            while ($deuda = mysqli_fetch_assoc($queryDeudasUsuario)) {
                ?>
                    <tr>
                        <td><?php echo $deuda['idExpensa'] ?></td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#modal-propiedad-<?php echo $deuda['idPropiedad']?>">
                                <span class="fas fa-info-circle" aria-hidden="true"></span> Piso: <?php echo $deuda['piso'] ?> - Dpto: <?php echo $deuda['departamento'] ?>
                            </a>
                        </td>
                        <td><?php echo $deuda['vencimiento'] ?></td>
                        <td>$ <?php echo $deuda['importeExpensa'] ?></td>
                        <td style="text-align:center;"><a href="abm/pagarExpensa.php?id=<?php echo $deuda['idExpensa'] ?>" title="Pagar" class="btn btn-primary btn-sm btn-block"><span class="fas fa-shopping-cart" aria-hidden="true"></span></a></td>

                    </tr>

                    <!-- Modal Propiedad-->
                    <div class="modal fade" id="modal-propiedad-<?php echo $deuda['idPropiedad'] ?>" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Propiedad Nro: <?php echo $deuda['idPropiedad'] ?></h4>
                                </div>
                                <div class="modal-body">
                                    <p><b>Piso:</b> <?php echo $deuda['piso'] ?></b></p>
                                    <p><b>Departamento:</b> <?php echo $deuda['departamento'] ?></b></p>
                                    <p><b>Lote Unidad Funcional:</b> <?php echo $deuda['unidadFuncionalLote'] ?></p>
                                    <p><b>Porcentaje Participación:</b> <?php echo $deuda['porcentajeParticipacion'] ?> %</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
            }
            ?> 
                </table>
            </div>
            <?php
        } 
    ?>
        
        </div>
    </div>




    <div class="corte">
    </div>
        <?php include('template/footer.php'); ?>
    </body>
</html>