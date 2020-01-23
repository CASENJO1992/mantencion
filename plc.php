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
        <h3>PLC</h3>
        
        <div class='w-100 d-flex outer_div mt-5'></div> 
    </div>
  </div>
              
  <?php include('footer.php');?>
  <script src="js/funciones/plc.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
        function changeNumber() {
            load(1);
            }
        
        setInterval(changeNumber, 1000);
    });
</script>
</body>
</html>