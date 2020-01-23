<?php 
    include('php/funciones.php');
?>

<!DOCTYPE html>
<html lang="es">
    <?php include('head.php');?>
<body>
    <?php include('nav.php');?>

    <div id="content">
      <div class="content-fluid p-5 shadow mb-5 bg-white" style="background:#fff;border-radius:15px;">
        <h3>Fichas Preventivas</h3>
        <form id="guardarDatos">
            <div class="form-row">
                <div class="form-group">
                    <div class="d-flex align-items-end">
                        <div class="col-4 p-0">
                            <label>Equipo:</label>
                            <select class="selectpicker form-control" data-live-search="true" name="equipo" id="equipo" onchange="load(1);">
                                <?php 
                                    $consulta = "call consulta_equipos()";
                                    $resultado = mysqli_query(conectar(), $consulta );
                                    while ($columna = mysqli_fetch_array( $resultado ))
                                    { 
                                        echo    "<option value='".$columna['id_equipo']."'>".$columna['equipo']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-8 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary agregar">
                                <img src="img/iconos/guardar.svg" alt="" style="width:34px; margin-right: 14px;"> Guardar Plantilla
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12 datos_ajax_delete mt-3"></div>
                <div class="col-12">
                    <textarea class="form-control" name="detalle" id="detalle" rows="20"></textarea>
                </div>
            </div>
        </form>
    </div>
  </div>
              
  <?php include('footer.php');?>
  <script src="js/funciones/plantilla.js"></script>

    <script>
		$(document).ready(function(){
            load(1);
		});
    </script>
</body>
</html>