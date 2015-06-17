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
    $emergencia["Nro Parte"] = $id;

    // Traer fecha
    $fecha = $div->find('td.lineaizq', 2)->plaintext;
    $date = explode(" ", $fecha);
    $emergencia["Fecha"] = $date[0];
    $emergencia["Hora"] = $date[1];

    //Traer dirección
    $direccion = $div->find('td.lineaizq', 3)->plaintext;
    $emergencia["Direccion"] = $direccion;

    //Traer tipo de emergencia
    $tipo = $div->find('td.lineaizq', 4)->plaintext;
    $emergencia["Tipo"] = $tipo;

    //Traer estado
    $estado = $div->find('td.lineaizq', 5)->plaintext;
    $emergencia["Estado"] = $estado;

    //Traer unidades
    $unidades = $div->find('td.lineaizq', 6)->plaintext;
    $emergencia["Unidades"] = $unidades;

    //Traer mapa
    $mapa = $div->find('img', 0);
    $valores = str_replace("javascript:mapa('","", $mapa->onclick);
      $valor = explode("','", $valores);
      $emergencia["Lat"] = $valor[0];
      $emergencia["Lng"] = $valor[1];

      array_push($emergencias, $emergencia);
    }
  }
    // clean up memory
  $html->clear();
  unset($html);

echo json_encode($emergencias);
  ?>