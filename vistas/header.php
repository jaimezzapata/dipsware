 <?php
  if (strlen(session_id()) < 1)
    session_start();
  require_once "../modelos/Negocio.php";
  $cnegocio = new Negocio();
  $rsptan = $cnegocio->listar();
  $regn = $rsptan->fetch_object();
  if (empty($regn)) {
    $nombrenegocio = 'Configurar datos de su Empresa';
  } else {
    $nombrenegocio = $regn->nombre;
    $logo = $regn->logo;
  };
  ?>
 <!DOCTYPE html>
 <html lang="es">

 <head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title><?php echo $nombrenegocio; ?></title>
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <link rel="stylesheet" href="../public/css/bootstrap.min.css">
   <link rel="stylesheet" href="../public/css/font-awesome.css">
   <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
   <link rel="stylesheet" href="../public/css/_all-skins.min.css">
   <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
   <link rel="shortcut icon" href="../public/img/icono.png">
   <link rel="stylesheet" href="../public/css/style.css">

   <!-- DATATABLES -->
   <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">
   <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet" />
   <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet" />

   <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">
   <link rel="stylesheet" href="../public/css/ticket.css">
   <link rel="preconnect" href="https://fonts.gstatic.com">
   <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">

 </head>
 <?php $side = '';
  if (empty($_GET['op'])) {
    $side = 'skin-green-light sidebar-mini';
  } else {
    $side = 'skin-green-light sidebar-mini sidebar-collapse';
  }
  ?>

 <body class="hold-transition <?php echo $side; ?>">
   <div class="wrapper">
     <header class="main-header">
       <a href="escritorio.php" class="logo">
         <span class="logo-mini"><img src="../public/img/icono.png" alt=""></span>
         <span class="logo-lg"><img class="logoImg" src="../public/img/Logo.png" alt=""></span>
       </a>
       <nav class="navbar navbar-static-top">
         <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
           <span class="sr-only">Navegación</span>
         </a>
         <div class="navbar-custom-menu">
           <ul class="nav navbar-nav">
             <li class="dropdown user user-menu">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                 <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
                 <span class="hidden-xs">Bienvenido, <?php echo $_SESSION['nombre']; ?></span>
               </a>
               <ul class="dropdown-menu">
                 <li class="user-header">
                   <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                   <p>
                     <img src="<?php echo $_SESSION['imagen']; ?>" alt="">
                     <?php echo $_SESSION['nombre'] . ' </br> ' . $_SESSION['cargo']; ?>
                   </p>
                 </li>
                 <li class="user-footer bgVerde">
                   <div class="pull-right">
                     <a href="../ajax/usuario.php?op=salir" class="btn bgCafe colorBlanco btn-flat">Cerrar sesión</a>
                   </div>
                 </li>
               </ul>
             </li>
           </ul>
         </div>
       </nav>
     </header>
     <aside class="main-sidebar">
       <section class="sidebar">
         <div class="user-panel">
           <div class="pull-left image">
             <img src="../files/negocio/<?php echo $logo; ?>" class="img-circle" style="width: 50px; height: 50px; margin-left:-10px;" alt="User Image">
           </div>
           <div class="pull-left info">
             <p><?php echo $nombrenegocio; ?></p>
             <a href="escritorio.php"><i class="fa fa-circle text-success"></i> Online</a>
           </div>
         </div>
         <ul class="sidebar-menu" data-widget="tree">
           <li class="header">MENÚ DE NAVEGACIÓN</li>

           <?php
            if ($_SESSION['escritorio'] == 1) {
              echo
              '<li>
                <a href="escritorio.php">
                  <i class="fa fa-dashboard"></i>
                  <span>Inicio</span>
                </a>
              </li>';
            }
            ?>


           <?php
            if ($_SESSION['acceso'] == 1) {
              echo
              '<li class="treeview">
                <a href="#">
                  <i class="fa fa-folder"></i> <span>Gestión de Acceso</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                  <li><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
                </ul>
              </li>';
            }
            ?>


           <?php
            if ($_SESSION['compras'] == 1) {
              echo
              '<li class="treeview">
                <a href="#">
                  <i class="fa fa-th"></i><span>Gestión de Compras</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                <li><a href="categoria.php"><i class="fa fa-circle-o"></i> Categorias</a></li>
                <li><a href="articulo.php"><i class="fa fa-circle-o"></i> Productos</a></li>
                <li><a href="proveedor.php"><i class="fa fa-circle-o"></i> Proveedores</a></li>
                  <li><a href="ingreso.php"><i class="fa fa-circle-o"></i> Compras</a></li>
                </ul>
              </li>';
            }
            ?>

           <?php
            if ($_SESSION['ventas'] == 1) {
              echo
              '<li class="treeview">
                <a href="#">
                  <i class="fa fa-shopping-cart"></i> <span>Gestión de Ventas</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                <li><a href="comprobantes.php"><i class="fa fa-circle-o"></i> Comprobantes de pago </a></li>
                <li><a href="tipopago.php"><i class="fa fa-circle-o"></i> Tipos de pago </a></li>                  
                  <li><a href="crearventa.php?op=new"><i class="fa fa-circle-o"></i> Registrar Venta</a></li>
                  <li><a href="cliente.php"><i class="fa fa-circle-o"></i> Clientes</a></li>
                  <li><a href="venta.php"><i class="fa fa-circle-o"></i> Ventas</a></li>                  
                  <li><a href="negocio.php"><i class="fa fa-circle-o"></i> Datos Generales</a></li>
                  <li><a href="../jolydips/index.html" target="_blanck"><i class="fa fa-circle-o"></i> Página Web (Catálogo)</a></li>
                </ul>
              </li>';
            }
            ?>
           <hr>
           <li class="header">Ayuda y soporte técnico</li>

           <?php {
              echo
              '<li class="treeview">
                <a href="#">
                  <i class="fa fa-folder"></i> <span> Ayuda en línea</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="ayuda.php"><i class="fa fa-circle-o"></i> Manual de Usuario</a></li>
                  <li><a href="videos.php"><i class="fa fa-circle-o"></i> Videos de ayuda</a></li>
                </ul>
              </li>';
            }
            ?>
         </ul>
       </section>
     </aside>