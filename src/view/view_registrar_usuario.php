<?php
session_start();
if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3) {
    if($_POST){
      //echo "recibo algo POST";

      //recibo los datos y los decodifico con PHP
      $misDatosJSON = json_decode($_POST["consulta"]);
      $cedula = $_POST['cedula'];
      ?>
      <!DOCTYPE html>
      <html lang="es">
      <head>
        <?php include_once 'inc/head.php'; ?>
      </head>
      <script type="text/javascript">
      function enviar(input){
        if (input.cedula.value.length === 0 || input.password.value.length === 0 ||
          input.config_password.value.length === 0 ||  input.perfil.value.length === 0) {
            alert('Falto algun campo por rellenar');
            return (false);
          } else {
            if (  input.password.value ===   input.config_password.value  ) {
              document.datos.method = "post";
              document.datos.action = "../controller/con_registrar_usuario.php";
              document.datos.submit();
            } else {
              alert('Las contraseñas no coinciden recuerde que deben ser iguales');
              return (false);
            }
            // console.log(valida.value +"-----"+ form.value);
          }
        }
        </script>
        <style type="text/css">


        /* Datagrid */
        body {
          font: normal medium/1.4 sans-serif;
          background: rgba(188,232,245,1);
          background: -moz-linear-gradient(top, rgba(188,232,245,1) 0%, rgba(247,213,172,1) 100%);
          background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(188,232,245,1)), color-stop(100%, rgba(247,213,172,1)));
          background: -webkit-linear-gradient(top, rgba(188,232,245,1) 0%, rgba(247,213,172,1) 100%);
          background: -o-linear-gradient(top, rgba(188,232,245,1) 0%, rgba(247,213,172,1) 100%);
          background: -ms-linear-gradient(top, rgba(188,232,245,1) 0%, rgba(247,213,172,1) 100%);
          background: linear-gradient(to bottom, rgba(188,232,245,1) 0%, rgba(247,213,172,1) 100%);
          filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#bce8f5', endColorstr='#f7d5ac', GradientType=0 );}
          table {
            border-collapse: collapse;
            width: 100%;
          }
          th, td {
            padding: 0.25rem;
            border: 1px solid #ccc;
          }
          tbody tr:nth-child(odd) {
            background: #eee;
          }
          .centro{
            padding: 0.5rem;
            background: #484848 ;
            color: white;
            text-align: center;
            font-size: 21px;

          }

          #cuadro{
            width: 90%;
            background: #F8F8F8 ;
            padding: 25px;
            margin: 5px auto;
            border: 3px solid #D8D8D8;
          }
          #titulo{
            width: 100%;
            background: #282828;
            color:white;

          }
          </style>
        </head>
        <body>
          <header id="header">
            <?php include_once 'inc/header.php'; ?>
          </header>
          <?php include_once 'inc/nav.php'; ?>
          <section>
            <div class="form-group">
              <form name="datos" action="#" method="post">
                <table>
                  <thead>
                    <tr class="centro">
                      <td>Registro de perfil</td>
                    </tr>
                    <tr class="centro">
                      <td>Usuario</td>
                      <td>Perfil</td>
                      <td>Clave</td>
                      <td>Confirme clave</td>
                    </tr>
                  </thead>
                  <tbody>
                    <td>
                      <input type="text" required autocomplete="off" onkeypress="return justNumbers(event);" maxlength="8" id="cedula" name="cedula" title="Ingrese la Cedula"  value="<?php echo $cedula;?>" readonly="readonly"/>
                    </td>
                    <td>
                      <select name="perfil">
                        <option value="">Seleccione el Perfil:</option>
                        <option value="1">Empleado</option>
                        <option value="2">Analista de Talento Humano</option>
                        <option value="3">Analista de Tecnolog&iacute;a</option>
                        <option value="4">Administrador</option>
                      </select>
                    </td>
                    <td>
                      <input type="password" required autocomplete="off" id="password" name="password" title="Ingrese su Contrase&ntilde;a" required />
                    </td>
                    <td>
                      <input type="password" required autocomplete="off" id="config_password" name="config_password" title="Confirme su Contrase&ntilde;a" required />
                    </td>
                  </tr>
                </tbody>
              </table>
              <button type="button" onclick="javascript: enviar(document.datos);"/>Registrar</button>
              <hr>
              <table>
                <thead>
                  <tr class="centro">
                    <td>Perfiles del usuario registrados</td>
                  </tr>
                  <tr class="centro">
                    <td>Usuario</td>
                    <td>Perfil</td>
                    <td>Status</td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 0;
                  foreach ($misDatosJSON as $key => $subArry[$i]) {
                    foreach ($subArry[$i] as $keyID => $valueID) {
                    }
                    ?>
                    <tr>
                      <td><?php echo $subArry[$i]->{'cedula_empleado'};?>
                      </td>
                      <td>
                        <?php echo $subArry[$i]->{'nombre'};?>
                      </td>
                      <td>
                        <?php
                        if ($subArry[$i]->{'status'} == 't'){
                          echo "habilitado";
                        }else {
                          echo "inhabilitado";
                        }
                        ?>
                      </td>
                    </tr>
                    <?php

                    $i++;
                  }
                  ?>
                </tbody>
              </table>
            </form>
          </div>
        </section>
        <?php include_once 'inc/script-lib.php'; ?>
      </body>
      </html>
      <?php
    }else{
      ?>
      <script type="text/javascript">
      alert('no se ha resibido ningun parametro');
      window.location="../view/view_registrar_usuario_consulta.php";
      </script>
      <?php
    }
  }else {
    header('location: view_menu.php');
  }
}else {
  header('location: ../index.php');
  session_destroy();
}
?>
