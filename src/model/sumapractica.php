<?php
/**
 *
 */
class Operacion
{
  private $num1 = 99;
  private $nom2 = 10000;
  private $sum;
  function __construct()
  {
    $this->sum = $this->num1 + $this->nom2;

  }

  public function suma(){
    echo "$this->sum";
  }

}

$clase = new Operacion;

$fun= $clase->suma();





 ?>
