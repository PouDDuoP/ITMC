<?php
require_once __DIR__ . '/../../inc/auth.php';
require_auth();
require_perfil();
//Head con todos los elementos de style y los script
date_default_timezone_set('America/La_Paz');
?>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>ITMC</title>
  <link rel="stylesheet" href="styles/index_style.css" />
  <link rel="stylesheet" href="styles/opcion_style.css" />
  <link rel="stylesheet" href="styles/mensajes.css"/>
  <link rel="stylesheet" href="styles/form.css" />
  <link rel="stylesheet" href="styles/menu.css"/>
  <link rel="stylesheet" href="styles/menu2.css"/>
  <link rel="stylesheet" href="css/index.css" type="text/css" media="all" />
  <link rel="stylesheet" href="css/styles.css" type="text/css" media="all" />
  <link rel="stylesheet" href="fonts/style.css"/>


  <!-- <link rel="stylesheet" href="des/datapicker.css" >
  <link rel="stylesheet" href="des/jquery-ui.css" >
  <link rel="stylesheet" href="des/bootstrap-datepicker.css">
  <link rel="stylesheet" href="des/jquery-ui.min.css" >
  <link rel="stylesheet" href="des/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="des/bootstrap-datetimepicker.css">

  <script type="text/javascript" src="des/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="des/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript" src="des/bootstrap-datetimepicker.js"></script>
  <script type="text/javascript" src="des/bootstrap-datetimepicker.min.js"></script>
  <script type="text/javascript" src="des/jquery-ui.js"></script>
  <script type="text/javascript" src="des/jquery-ui.min.js"></script>
  <script type="text/javascript" src="des/jquery.timepicker.js"></script>
  <script type="text/javascript" src="des/jquery.ui.datepicker-es.js"></script> -->

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
  <script type="text/javascript">
  $(document).ready(function () {
    $('body').on('paste', 'input', function (e) {
      e.preventDefault();
    });
  });  

  // $( function() {
  //   $( "#fecha_hasta" ).datepicker();
  // } );

    // var basicExampleEl = document.getElementById('fecha_hasta');
    // var datepair = new Datepair(basicExampleEl);
    //
    // $("#fecha_hasta").datepicker({
    // dateFormat: 'dd/mm/yy'
    //
    //       firstDay: 1
    // });

    function validarPass(pass1,pass2) {
      var pass = pass1.value;
      var confirm = pass2.value;

      if (pass == confirm && ( pass != '' || confirm != '')) {
          document.cambioPass.method = "post";
          document.cambioPass.action = "../controller/con_cambiar_pass.php";
          document.cambioPass.submit();
          // alert('ok');
      } else {
        alert('las claves que a indicado para el cambio no coinciden verifique e intente de nuevo');
      }
    }
    function cerrarSession() {
      var validar = confirm('¿Esta seguro de querer cerrar session?');
      if (validar == true) {
        location.href = "inc/logout.php";
      } else {
        return false;
      }
    }
  </script>
</head>
