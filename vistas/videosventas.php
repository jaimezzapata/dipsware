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
                        <a style="margin-left: 18px;" href="videos.php" class="btn bgVerde colorBlanco">
                            <i class="fa fa-arrow-left"></i> Menú anterior
                        </a><br><br>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="small-box bgVerde colorBlanco videos" style="height: 200px;">
                                <div class="inner">
                                    <h4 style="font-size: 30px;">
                                        Registro nuevo usuario
                                    </h4>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-youtube" aria-hidden="true"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-youtube" style="font-size: 30px; color: #773611;"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="small-box bgVerde colorBlanco videos" style="height: 200px;">
                                <div class="inner">
                                    <h4 style="font-size: 30px;">
                                        Editar usuario
                                    </h4>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-youtube" aria-hidden="true"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-youtube" style="font-size: 30px; color: #773611;"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="small-box bgVerde colorBlanco videos" style="height: 200px;">
                                <div class="inner">
                                    <h4 style="font-size: 30px;">
                                        Desactivar usuario
                                    </h4>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-youtube" aria-hidden="true"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-youtube" style="font-size: 30px; color: #773611;"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="small-box bgVerde colorBlanco videos" style="height: 200px;">
                                <div class="inner">
                                    <h4 style="font-size: 30px;">
                                        Activar usuario
                                    </h4>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-youtube" aria-hidden="true"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-youtube" style="font-size: 30px; color: #773611;"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="small-box bgVerde colorBlanco videos" style="height: 200px;">
                                <div class="inner">
                                    <h4 style="font-size: 30px;">
                                        Cambiar contraseña usuario
                                    </h4>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-youtube" aria-hidden="true"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-youtube" style="font-size: 30px; color: #773611;"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="small-box bgVerde colorBlanco videos" style="height: 200px;">
                                <div class="inner">
                                    <h4 style="font-size: 30px;">
                                        Descargar listado de usuarios
                                    </h4>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-youtube" aria-hidden="true"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-youtube" style="font-size: 30px; color: #773611;"></i></a>
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