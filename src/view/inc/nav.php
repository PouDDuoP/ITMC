<?php
require_once __DIR__ . '/../../inc/auth.php';
require_auth();
require_perfil();
//barra de navegacion del sistema
?>
<nav>
  <div id='cssmenu'>
    <ul>
      <li class='active'><a href='../view/view_menu.php'>Men&uacute;</a></li>
      <?php
        if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 2) {
      ?>
      <li class='has-sub '><a href='#'>Gesti&oacute;n de Empleado</a>
        <ul>
          <li><a href='view_registrar_empleado.php' id="registrar_empleado">Registro de Empleado</a></li>
          <li><a href='view_consulta_empleado_hijo.php' id="registrar_hijo">Registrar Hijo de Empleado</a></li>
          <li><a href='view_consulta_empleado.php' id="consulta_empleado">Consultar Empleado</a></li>
          <li><a href='view_listar_empleados.php' id="consulta_general">Listar Empleado</a></li>
        </ul>
      </li>
      <?php
        }
        if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3) {
      ?>
      <li class='has-sub '><a href='#'>Gesti&oacute;n de Usuario</a>
        <ul>
          <li><a href='view_registrar_usuario_consulta.php' id="registrar_usuario">Registro de Usuario</a></li>
          <li><a href='view_consulta_usuario.php' id="consulta_usuario">Consultar Usuario</a></li>
          <li><a href='view_listar_usuario.php' id="consulta_general">Listar Usuarios</a></li>
        </ul>
      </li>
      <li class='has-sub '><a href='#'>Centro Estadistico</a>
        <ul>
          <li><a href='../controller/con_empleados_con_hijo.php' id="empleados_activos_hijos">Empleados Activos con Hijos</a></li>
          <li><a href='view_hijos_edad_comprendida.php' id="hijos_edad_comprendida">Hijos de Edad Comprendida</a></li>
          <li><a href='../controller/con_usuarios_perfiles.php' id="usuarios_perfiles">Usuarios y Perfiles</a></li>
        </ul>
      </li>
      <li><a href='view_listar_cambios_realizados.php' id="cambios_realizados">Bitacora de cambios</a></li>
      <?php
        }
        if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3 || $_SESSION['perfil'] == 2 || $_SESSION['perfil'] == 1) {
      ?>
      <li class='has-sub '><a href='#'>Solicitudes</a>
        <ul>
          <li class='has-sub '><a href='#'>Talento Humano</a>
            <ul>
              <li class='has-sub '><a href='#'>Recibos</a>
                <ul>
                  <li><a href='view_solicitud_constancia_trabajo.php'>Constancia de Trabajo</a></li>
                  <li><a href='view_solicitud_recibo_pago.php'>Recibo de Pago</a></li>
                  <li><a href='view_consulta_solicitudes.php'>Consulta de Solicitudes</a></li>
                </ul>
              </li>
              <li class='has-sub '><a href='view_solicitud_beneficio.php'>Beneficios</a>
                <ul>
                  <li><a href='view_solicitud_beneficio.php'>Solicitud de Beneficios</a></li>
                  <li><a href='view_consulta_beneficios.php'>Consulta de Beneficios</a></li>
                </ul>
              </li>

            </ul>
          </li>
          <!-- <li class='has-sub '><a href='#'>Tecnolog&iacute;a</a>
            <ul>
              <li><a href='#' id="pagsoportred.php">Soporte de Red</a></li>
              <li><a href='#' id="pagsoportequip.php">Soporte de Equipo</a></li>
            </ul>
          </li> -->
        </ul>
      </li>
      <?php }  ?>
      <li><a href="#" data-toggle="modal" data-target="#camibar_pass">Cambiar Contrase&ntilde;a</a></li>
      <li><a href="#" onclick="javascript: cerrarSession();">Cerrar Sesi&oacute;n</a></li>
    </ul>
  </div>
  <div id="camibar_pass" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h4 class="text-center">Ingrese nueva contrase&ntilde;a</h4>
              </div>
              <div class="modal-body row">
                  <form class="col-md-10 col-md-offset-1 col-xs-12 col-xs-offset-0" name="cambioPass" method="post">
                      <div class="form-group">
                          <input type="password" class="form-control input-lg" name="clave" placeholder="Contraseña">
                      </div>
                      <div class="form-group">
                          <input type="password" class="form-control input-lg" name="confirm" placeholder="Confirmar contraseña">
                      </div>
                      <div class="form-group">
                          <button type="button" class="btn btn-info btn-lg btn-block" style="background-color: #555; border-color: #cc720f;" onclick="javascript: validarPass(document.cambioPass.clave,document.cambioPass.confirm);">Cambiar contraseña</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</nav>
