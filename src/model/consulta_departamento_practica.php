<style media="screen">
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
</style>
<?php
        /*Falto la conexion con la base de datos..*/
        /*----------------------------------------*/
        include('model/mod_conexion.php');
        $conexionPGSQL = new ConexionPGSQL();
        $pgconn = $conexionPGSQL->conectar();
        /*----------------------------------------*/
        // NOTA: si no estableces la conexion po podras realizar las operaciones en la base de datos


          // include('../src/mod_departamento.php');
        /*el "../" dentro es para ir a la raiz del sistema en este caso como tienes mod_departamento dntro de la misma raiz no es necesario   */

        include_once 'mod_departamento.php';
        $depart1 = new Departamento();

        // $depart2 = $depart1->consultar_departamento();
        /*Recuerda que en el mod_departament.php asignastes un parametro en el metodo consultar_departamento();
        En este caso el metodo consultar_departamento($pgconn); tiene que recibir el parametro "$pgconn"
        que es la conexion con la base de datos
        */

        $depart2 = $depart1->consultar_departamento($pgconn);

        //NOTA: Procura utilizar nombres de variables que describan para mejor lectura, ya que depart1 y depart2 es ambiguo para describir que esta almacenando la variable

          // $columna = pg_fetch_array($consultar);
?>
        <table class="1px">
          <thead>
            <tr>
              <th>id</th>
              <th>nombre</th>
              <th>descripcion</th>
              <th>status</th>
            </tr>
          </thead>
          <tbody>
<?php
  //NOTA: faltaron las etiquetas de tabla para almacenar los <tr>, <th>, <td>  -->>> no recorde decirte fue culpa mia
  //NOTA: tambien falto la asignacion de el encabezado de que posee cada registro --lo mismo de arriba--↥↥↥↥
        while($columna = pg_fetch_array($depart2)) {
?>
            <tr>
              <td>
                <?php echo $columna['id'];?>
              </td>
              <td>
                <?php
                    //echo $columna['nombre_empleado'];
                    /*Recuerda que cuando realizas una consulta a una tabla el resultado que reibie es segun los atributos de la tabla. la tabla departamento
                    no posee una columna llamada "nombre_empleado" y por ende te dara error la iteracion de la consulta
                    */

                    echo $columna['nombre'];
                ?>
              </td>
              <td>
                <?php echo $columna['descripcion'];?>
              </td>
              <td>
                <?php
                if ($columna['status'] == true)
                  echo "habilitado";
                else {
                  echo "inhabilitado";
                }
                ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
