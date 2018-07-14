<?php
require_once '../config/Conexion.php'; 
session_start();
if(!isset($_SESSION['propietario'])){
    header("Location: index.php");} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('template/head.php'); ?>

    <body>
    <?php 
        include('template/nav.php');  
        include('template/header.php'); ?>
    
    <title>Consorcios del Valle - Propietario</title>

  <div class="album py-5 bg-light">
        <div class="container">

          <div class="row">
            <div class="col-md-6">
              <div class="card mb-4 box-shadow">
              <img class="card-img-top" src="../../public/img/expensas.jpg?text=Expensas">
                <div class="card-body">
                  <p class="card-text">En esta sección encontraras todas las expensas de cada mes pagas e impagas de tu propiedad.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <a href="listaExpensas.php" class="btn btn-primary">Ir a Expensas</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card mb-4 box-shadow">
              <img class="card-img-top" src="../../public/img/deudas.jpg?text=Deudas">
                <div class="card-body">
                  <p class="card-text">En esta sección encontraras el monto total que adeudas por tus propiedades.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <a href="deudasPropietario.php" class="btn btn-primary">Ir a Deudas</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card mb-4 box-shadow">
              <img class="card-img-top" src="../../public/img/informeMensual.jpg?text=InformeMensual">
                <div class="card-body">
                  <p class="card-text">Aquí podrás encontrar una minuta detallada de la liquidación mensual integrada por gastos realizados por la administración y pagos de cada propietario con un resumen final.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <a href="informePropietario.php" class="btn btn-primary">Ir a Informe Mensual</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card mb-4 box-shadow">
              <img class="card-img-top" src="../../public/img/reclamos.jpg?text=Reclamos">
                <div class="card-body">
                  <p class="card-text">Aquí podrás contactarte con nuestros administradores sobre algún problema que tenga tu propiedad o el edificio, para poder solucionarlo lo más rápido y efectivo posible.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <a href="listaReclamos.php" class="btn btn-primary">Ir a Reclamos</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    <div class="corte">
    </div>
    <?php include('template/footer.php'); ?>
    </body>
</html>