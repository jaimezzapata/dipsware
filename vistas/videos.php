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
                                <h1 class="box-title">Vídeos de ayuda </h1>
                            </div>
                            <div class="panel-body">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="small-box bgVerde colorBlanco videos" style="height: 300px;">
                                        <div class="inner">
                                            <h4 style="font-size: 40px;">
                                                Módulo Acceso
                                            </h4>
                                            <hr>
                                            <div>
                                                <i class="fa fa-users" style=" display:flex; justify-content: center; font-size:  110px; align-items: center;"></i>
                                            </div>
                                        </div>
                                        <a href="https://drive.google.com/drive/folders/1qICMF25TeskHi7pjxeI9EMW_-ytdWmUq?usp=sharing" target="_blanck" class="small-box-footer">Ver vídeos <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="small-box bgCafe colorBlanco videos" style="height: 300px;">
                                        <div class="inner">
                                            <h4 style="font-size: 40px;">
                                                Módulo Compras
                                            </h4>
                                            <hr>
                                            <div>
                                                <i class="fa fa-shopping-cart" style=" display:flex; justify-content: center; font-size:  110px; align-items: center;"></i>
                                            </div>
                                        </div>
                                        <a href="https://drive.google.com/drive/folders/11bzM3iPeTX1-jZAwSEFDgYDPln1PoLjI?usp=sharing" target="_blanck" class="small-box-footer">Ver vídeos <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="small-box bgVerde colorBlanco videos" style="height: 300px;">
                                        <div class="inner">
                                            <h4 style="font-size: 40px;">
                                                Módulo Ventas
                                            </h4>
                                            <hr>
                                            <div>
                                                <i class="fa fa-money" style=" display:flex; justify-content: center; font-size:  110px; align-items: center;"></i>
                                            </div>
                                        </div>
                                        <a href="https://drive.google.com/drive/folders/1rW9hJkepG1UGsPPlj88MsnO4ZqR1ZbVL?usp=sharing" target="_blanck" class="small-box-footer">Ver vídeos <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
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