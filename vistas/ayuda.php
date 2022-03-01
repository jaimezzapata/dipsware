<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
} else {

  require 'header.php';

  if ($_SESSION['escritorio'] == 1) {

?>
    <div class="content-wrapper">
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Soporte y manual de usuario </h1>
              </div>
              <div class="panel-body">
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <div class="small-box bgVerde colorBlanco videos" style="height: 300px;">
                    <div class="inner">
                      <h4 style="font-size: 40px; text-align: center;">
                        Soporte
                      </h4>
                      <hr>
                      <div>
                        <a href="https://api.whatsapp.com/send?phone=0123456789" target="_blanck">
                          <i class="fa fa-whatsapp" style=" display:flex; justify-content: center; font-size:  110px; align-items: center; color: #fff;"></i>
                        </a>
                      </div>
                    </div>
                    <a class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <div class="small-box bgCafe colorBlanco videos" style="height: 300px;">
                    <div class="inner">
                      <h4 style="font-size: 40px;">
                        Manual de usuario
                      </h4>
                      <hr>
                      <div>
                        <a href="Manual de Usuario.pdf" target="_blanck">
                          <i class="fa fa-file" style=" display:flex; justify-content: center; font-size:  110px; align-items: center; color: #fff;"></i>
                        </a>
                      </div>
                    </div>
                    <a class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script src="../public/js/Chart.bundle.min.js"></script>
  <script src="../public/js/Chart.min.js"></script>
<?php
}

ob_end_flush();
?>