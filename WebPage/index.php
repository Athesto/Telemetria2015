<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false"></script>
    <title>TransLoc - Geolocalización en Tiempo Real</title>
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link href="style.css" rel="stylesheet" type="text/css"/>
  </head>

  <body>

    <?php
      $con = mysqli_connect("us-cdbr-azure-southcentral-e.cloudapp.net","bfb33240729490","cb24cf9d","tranlocmysqltestdb");
      if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
      }
      $query ="select fecha, latitud, longitud from gps where id=(select max(id) from gps);";
      $result = $con->query($query);

      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $fecha = $row["fecha"];
          $lat  = floatval($row["latitud"]);
          $long = floatval($row["longitud"]);
          echo $fecha. " ". $lat. " ". $long;
        }
      } 
      else {
        echo "0 results";
      }
      $con->close();
    ?>

    <script>
      var fecha = "<?php print($fecha); ?>";
      var lat   = <?php echo "[ ". $lat. ", ]"; ?>;
      var long  = <?php echo "[ ". $long. ", ]"; ?>;
    </script>

    <script>

      setTimeout(function () {
       window.location.reload();
      }, 10000);
      function toggletext(cid){
        if ( document.getElementById(cid).style.display == "none" ){
          document.getElementById(cid).style.display = "block";
        }
        else{
          document.getElementById(cid).style.display = "none";
        };
      }
      //var lat = [12, 14.23, 42.12];
      //var long = [-12, -14, -12];
      // functions below
      
      //Make an array with the coordinates from the db
      function initialize() {
        var map;
        var posicion= [];
        for (var i=0; i< lat.length; i++){
        posicion.push(new google.maps.LatLng(lat[i], long[i])); // Add the coordinates
        }

        var mapOptions = {  // Refresco guardar, Default
          zoom: 18,
          center: posicion[lat.length-1],
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById('mainimg'), mapOptions);  // Render our map within the empty div
        var myLatlng = posicion[lat.length-1];
        var marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          icon:"http://maps.google.com/mapfiles/ms/micons/blue.png",
          title: ''+fecha+''
        });

        var linea = new google.maps.Polyline({
          path: posicion,
          geodesic: true,
          strokeColor: '#FF0000',
          strokeOpacity: 1.0,
          strokeWeight: 2
        });
        linea.setMap(map);
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>

    <div id="topbanner">
      <div class="container">
        <h1 id="sitename"><a href="index.php">TranLoc</a> <span>Geolocalización Vehicular</span></h1>
        <div id="mainnav">
          <ul>
            <li class="active"><a href="index.php">Geolocalización<span>En Tiempo Real</span></a></li>
            <li><a href="historico.php">Archivo<span>Consulta histórica</span></a></li>
            <li><a href="nosotros.php">Nosotros<span>Sobre TransLoc</span></a></li>
            <li><a href="bitacora.php">Bitácora <span>Registros de avances</span></a></li>
          </ul>
        </div>
        <div class="clear"></div>
      </div>
    </div>

    <div id="pagewrap">
      <div id="wrap">

        <div id="homeheader">
          <div id="mainimg" style="height: 330px; width: 700px;"></div>
          <div id="rightboxes">
            <div class="box1">
              <p class="rotate"> <a href="nosotros.php"><span>¿ Qué es ?</span> </a></p>
            </div>
            <div class="box2">
              <p class="rotate"> <a href="nosotros.php"><span>¿ Cómo funciona ?</span> </a></p>
            </div>
            <div class="box3">
              <p class="rotate"> <a href="nosotros.php"><span>¿ Para quién ?</span> </a></p>
            </div>
          </div>
          <div class="clear"></div>
        </div>

        <div id="maincontent">
          <div id="threecol">

            <div class="col1">
              <h2>Últimas Coordenadas: </h2>
              <h2><script>document.write(fecha);</script></h2>
              <table width="100%" border="0" align="center">
                <tbody>
                  <tr>
                    <td width="298" height="60"><table width="300" height="60" border="0" align="center">
                        <tr>
                          <td width="148" height="25"><strong><font face="verdana">Última Latitud</font></strong></td>
                          <td width="148"><strong><font face="verdana">Última Longitud</font></strong></td>
                        </tr>
                        <tr>
                          <td align="center"><script>document.write(lat);</script></td>
                          <td align="center"><script>document.write(long);</script></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col2">
              <h2>Consulta Histórica </h2>
              <p align="justify">Permite la consulta de intervalos de tiempo específicos. Solo es cuestión de llenar los parámetros de búsqueda y listo. </p>
            </div>
            <div class="col3">
              <h2>Localización en Tiempo Real </h2>
              <p align="justify">Monitorea en tiempo real la ubicación de sus vehículos a través de un modem GPS referencia Syrus, y a su vez se muestra su posición mediante el uso de Google Maps. </p>
            </div>
            <div class="clear"></div>
          </div>
          <div class="clear bordered"></div>
          <div class="clear"></div>
        </div>
      </div>
    </div>

    <div id="bottom">
      <div id="btmcontent">
        <div class="col1">
          <h2>Recursos Web</h2>
          <p align="justify">Enlaces de los principales recursos utilizados para este proyecto. </p>
          <ul>
            <li><a href="https://developers.google.com/maps/" target="_blank">Google Map API</a></li>
            <li><a href="https://azure.microsoft.com/en-us/" target="_blank">Microsoft Azure</a></li>
            <li><a href="http://www.wampserver.com/en/" target="_blank">WampServer</a></li>
          </ul>
        </div>
        <div class="col2">
          <h2>Diseño Electrónico</h2>
          <p align="justify">Realizado como proyecto para la materia de Diseño Electrónico, Facultad de Ingeniería Electrónica, Universidad del Norte. </p>
          <ul>
            <li><a href="http://www.uninorte.edu.co" target="_blank">Universidad del Norte</a></li>
            <li><a href="http://www.uninorte.edu.co/web/ingenieria-electronica" target="_blank">Facultad de Ingeniería Electrónica</a></li>
          </ul>
        </div>
        <div class="col3">
          <h2>Github</h2>
          <p align="justify">Repositorio del proyecto en la plataforma de Github.</p>
          <ul>
            <li><a href="https://github.com/nestornesus/TransLocGPS" target="_blank">Repositorio de TransLoc </a></li>
          </ul>
        </div>
          


        <div class="clear"></div>
      </div>
      <div id="footer">
        <div id="copyright">
          <p class="left">Copyright &copy; 2015. Diseño Electrónico, Universidad del Norte</p>
          <p class="right">Bernal G. Néstor, Jordan N. Jhoyner &amp; Mejía S. Gustavo</p>
          <div class="clear"></div>
        </div>
      </div>
    </div>
  </body>
</html>