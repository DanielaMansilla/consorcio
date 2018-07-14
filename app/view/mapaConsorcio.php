<?php
require_once '../config/Conexion.php';
session_start();
if(!isset($_SESSION['admin']) && !isset($_SESSION['operador'])) {
	header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<?php include('template/head.php'); ?>
  <head>
    <title>Geocoding service</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      #map {
        height: 35em;
        width: 80em;
      }
    </style>
  </head>
  <body>
    <?php 
        include('template/nav.php');  
        include('template/header.php'); 
    ?>
    <title>Consorcios del Valle - Pagar Expensa</title>

    <div class="container">
        <?php
            if (!isset($_GET["id"]) || empty($_GET["id"]) ) {
                echo '<div class="alert alert-danger alert-dismissable">Error: El consorcio indicado no existe o no tiene acceso a él.</div>';
            } else {
                $idConsorcio = mysqli_real_escape_string($conexion,(strip_tags($_GET["id"],ENT_QUOTES)));
                
                $selectConsorcio = mysqli_query($conexion, 
                "SELECT *
                FROM consorcio
                WHERE idConsorcio = '$idConsorcio'") or die(mysqli_error($conexion));

                if (!$selectConsorcio || mysqli_num_rows($selectConsorcio) == 0){
					echo '<div class="alert alert-danger alert-dismissable">Error: El consorcio indicado no existe o no tiene acceso a él.</div>';
				} else {
                    $consorcio = mysqli_fetch_assoc($selectConsorcio);
                    $direccion = $consorcio['direccion'];
                    $nombre = $consorcio['nombre'];
                    $codigoPostal = $consorcio['codigoPostal'];
                    $telefono = $consorcio['telefono'];
                    $correo = $consorcio['correo'];
                    $cuit = $consorcio['cuit'];
                    ?>
                    <h4 class="text-center"><?php echo $nombre?> - Mapa</h4>
                    
                    <div style="text-align:center;" id="loadingSpinner">
                        <br>
                        <i class="fa fa-spinner fa-pulse fa-2x fa-fw" ></i>
                        <span class="sr-only">Cargando...</span>
                        <br>
                    </div>
                    
                    <div id="errors"></div>

                    <div id="map" class="img-thumbnail mx-auto" style="display: none;"></div>
                    <script>
                    function showLoadingSpinner(show) {
                        var loadingSpinner = document.getElementById('loadingSpinner');
                        loadingSpinner.style.display = (show === true ? '' : 'none');
                    }

                    function showMessageError(errorMessage) {
                        var errorsDiv = document.getElementById("errors");
                        errorsDiv.innerHTML = '<br><div class="alert alert-danger alert-dismissable">Error: ' + errorMessage + '</div>';
                    }

                    function showMap(show) {
                        var map = document.getElementById('map');
                        map.style.display = (show === true ? '' : 'none');
                    }

                    function onGoogleMapsLoadingError() {
                        showLoadingSpinner(false);
                        showMessageError('No se ha podido cargar el mapa por problemas de conexión con Google Maps.');
                    }

                    function initMap() {
                        var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 15
                        });
                        var geocoder = new google.maps.Geocoder();
                        geocodeAddress(geocoder, map);
                    }
                    
                    // En base a una dirección obtiene las coordenadas y actualiza el mapa
                    function geocodeAddress(geocoder, resultsMap) {
                        var address = '<?php echo $direccion?>';
                        geocoder.geocode({'address': address}, function(results, status) {
                        if (status === 'OK') {
                            showLoadingSpinner(false);
                            showMap(true);
                            
                            resultsMap.setCenter(results[0].geometry.location);
                            // Datos del Consorcio
                            var contentString = '<b><?php echo $nombre?></b><br><br>' + 
                            '<p><?php echo $direccion?></p>' + 
                            '<p>CP: <?php echo $codigoPostal?></p>' +
                            '<p>Tel.: <?php echo $telefono?></p>' +
                            '<p>E-mail: <?php echo $correo?></p>' +
                            '<p>CUIT: <?php echo $cuit?></p>';
                            
                            var infowindow = new google.maps.InfoWindow({
                                content: contentString
                            });

                            var marker = new google.maps.Marker({
                            map: resultsMap,
                            position: results[0].geometry.location
                            });
                            // Cartel abierto por default
                            infowindow.open(map, marker);
                            marker.addListener('click', function() {
                                infowindow.open(map, marker);
                            });
                        } else {
                            showLoadingSpinner(false);
                            showMessageError('No se ha podido determinar la ubicación exacta del consorcio.');
                        }
                        });
                    }

                    </script>
                        <script async defer onerror="onGoogleMapsLoadingError()"
                        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcf7cJonjwmrFflzRAF6lDf09sYMMY_DQ&callback=initMap">
                        </script>
                    <?php
				}
            }
        ?>
        <br>
        <a href="listaConsorcio.php" class="btn btn-sm btn-info">Volver</a>
    </div>
    
    <div class="corte"></div>
    <?php include('template/footer.php'); ?>
  </body>
</html>