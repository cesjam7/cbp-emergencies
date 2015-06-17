<?php
include('simple_html_dom.php');

    // create HTML DOM
$html = file_get_html('http://bomberosperu.gob.pe/po_diario.asp');

$cont = 0;
$emergencias = array();

foreach($html->find('tr') as $div) {

  $cont++;
  $id = $div->find('td.lineaizq', 1)->plaintext;
  if($id && $cont>10){
    $emergencia = array();

    // Traer ID
    $emergencia["nro_parte"] = $id;

    // Traer fecha
    $fecha = $div->find('td.lineaizq', 2)->plaintext;
    $date = explode(" ", $fecha);
    $emergencia["fecha"] = $date[0];
    $emergencia["hora"] = $date[1];

    //Traer dirección
    $direccion = $div->find('td.lineaizq', 3)->plaintext;
    $emergencia["direccion"] = $direccion;

    //Traer tipo de emergencia
    $tipo = $div->find('td.lineaizq', 4)->plaintext;
    $emergencia["tipo"] = $tipo;

    //Traer estado
    $estado = $div->find('td.lineaizq', 5)->plaintext;
    $emergencia["estado"] = $estado;

    //Traer unidades
    $unidades = $div->find('td.lineaizq', 6)->plaintext;
    $emergencia["unidades"] = $unidades;

    //Traer mapa
    $mapa = $div->find('img', 0);
    $valores = str_replace("javascript:mapa('","", $mapa->onclick);
      $valor = explode("','", $valores);
      $emergencia["lat"] = $valor[0];
      $emergencia["lng"] = $valor[1];

      array_push($emergencias, $emergencia);
    }
  }
    // clean up memory
  $html->clear();
  unset($html);

  echo "<h1>Emergencias del día</h1>";
  foreach ($emergencias as $datos) {
    echo "<p>";
    echo "ID: ".$datos["nro_parte"];
    echo "<br>Fecha: ".$datos["fecha"];
    echo "<br>Hora: ".$datos["hora"];
    echo "<br>Direccion: ".$datos["direccion"];
    echo "<br>Tipo: ".$datos["tipo"];
    echo "<br>Estado: ".$datos["estado"];
    echo "<br>Unidades: ".$datos["unidades"];
    echo "<br>Mapa: lat(".$datos["lat"].") long(".$datos["lng"].")";
    echo "</p>";
  }
  ?>