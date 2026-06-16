<?php
session_start();
date_default_timezone_set('America/La_Paz');

$cedula_id = $_POST['cedula'];
$clave = $_POST['clave'];
if (isset($cedula_id) && !empty($cedula_id) && isset($clave) && !empty($clave)) {

	$status = TRUE;

	include('../model/mod_conexion.php');
	$conexionPGSQL = new ConexionPGSQL();
	$pgconn = $conexionPGSQL->conectar();

	include('../model/mod_usuario.php');
	$usuario = new Usuario();

	if (isset($_POST['perfil']) && !empty($_POST['perfil'])) {
		$perfil = $_POST['perfil'];
		$resultado = $usuario->autenticar_usuario_perfil ($cedula_id,$clave,$perfil,$status,$pgconn);
	} else {
		$autenticar = $usuario->contar_perfiles ($cedula_id,$pgconn);
		$resultado = $usuario->autenticar_usuario ($cedula_id,$clave,$status,$pgconn);
	}

	// Si el modelo devolvió false, la autenticación falló
	if (!$resultado) {
		file_put_contents("../bitacora.log", "Usuario: [".$cedula_id."] Perfil: [0] Fecha: [".date('l jS \of F Y H:i:s A')."] Evento: [Ingresar] Estado: [0]\r\n", FILE_APPEND | LOCK_EX );
		?>
			<script type="text/javascript">
				alert('Los datos ingresados no coinciden con los registros por favor verificar');
				window.location="../index.php";
			</script>
		<?php
		exit;
	}

	$rows = pg_num_rows($resultado);

	if ($rows > 1 && isset($autenticar)) {
		$arraydatos = array();
		$i = 0;
			while ($columna = pg_fetch_array($autenticar)) {
				$arraydatos[$i] = $columna;
				$i++;
			}
			$json = json_encode($arraydatos);
			// echo "$json";
			echo "<form name='datos'>";
			echo "<input type='hidden' name='consulta' value='$json'>";
			echo "</form>";
			echo "<script type='text/javascript'>
							document.datos.method = 'POST';
							document.datos.action = '../index.php';
							document.datos.submit();
						</script>";
	} else {

		$consulta = pg_fetch_array($resultado);

		if($consulta != 0  && $consulta != false) {

			if ($consulta['cedula_empleado'] == $cedula_id) {
				$_SESSION['cedula_empleado'] = $consulta['cedula_empleado'];
				// ponytail: $consulta['clave'] was stored here (security issue removed)
				$_SESSION['perfil'] = $consulta['perfil'];
				$_SESSION['id'] = $consulta['id'];

				if ($consulta['status'] == 't') {
					$_SESSION['status'] = TRUE;
				} else {
					$_SESSION['status'] = FALSE;
				}

				file_put_contents("../bitacora.log", "Usuario: [".$cedula_id."] Perfil: [".$_SESSION['perfil']."] Fecha: [".date('l jS \of F Y H:i:s A')."] Evento: [Ingresar] Estado: [1]\r\n", FILE_APPEND | LOCK_EX );

				switch ($_SESSION['perfil']) {
					case '4':
					// echo  'Estado >> ' .$_SESSION['status'] . ' Perfil >> ' . $_SESSION['perfil'];
							header("location: ../view/view_menu.php");
					break;
					case '3':
							header("location: ../view/view_menu.php");
					// echo  'Estado >> ' .$_SESSION['status'] . ' Perfil >> ' . $_SESSION['perfil'];
					break;
					case '2':
							header("location: ../view/view_menu.php");
					// echo  'Estado >> ' .$_SESSION['status'] . ' Perfil >> ' . $_SESSION['perfil'];
					break;
					case '1':
							header("location: ../view/view_menu.php");
					// echo  'Estado >> ' .$_SESSION['status'] . ' Perfil >> ' . $_SESSION['perfil'];
					break;
					default:
					?>
							<script type="text/javascript">
								alert('perfil '+<?php $_SESSION['perfil'] ?>+' no esta registrado');
								window.location="../index.php";
							</script>
					<?php
					break;
				}
		}else {
			?>
					<script type="text/javascript">
						alert('Usuario o clave incorrecta');
						window.location="../index.php";
					</script>
			<?php
		}
		}else {
			file_put_contents("../bitacora.log", "Usuario: [".$cedula_id."] Perfil: [0] Fecha: [".date('l jS \of F Y H:i:s A')."] Evento: [Ingresar] Estado: [0]\r\n", FILE_APPEND | LOCK_EX );
			?>
		 	   <script type="text/javascript">
		       alert('Los datos ingresados no coinciden con los registros por favor verificar');
		       window.location="../index.php";
		 	   </script>
		 	<?php
		}
	}
}else{
	header("location: ../index.php");
}
?>
