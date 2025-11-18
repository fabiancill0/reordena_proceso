<?php

include '../model/connections.php';
include '../model/functions.php';

$conn = new Connections();
$functions = new Functions();


$cliente = $_POST['cliente'];
$proceso = $_POST['proceso'];
if ($cliente == 15) {
    $connnect = $conn->connectToRK();
} else {
    $connnect = $conn->connectToServ();
}
$nuevoOrden = json_decode($_POST['nuevoOrden'], true);
$procesoDetalle = json_decode($functions->getProcesoDetalle($connnect, $cliente, $proceso));
if ($procesoDetalle[0]->error) {
    echo json_encode(['error' => 'si', 'message' => 'No se encuentra información relativa a la orden de proceso']);
    exit;
} else {
    $queryUpdate = "UPDATE dba.spro_ordenprocdeta SET orpd_secuen = ? WHERE lote_codigo = ? and plde_codigo = ? and orpr_tipord = ? and orpr_numero = ? and clie_codigo = ?";
    $result = odbc_prepare($connnect, $queryUpdate);
    $i = count($nuevoOrden);
    foreach ($nuevoOrden as $el) {
        $i++;
        if (!odbc_execute($result, [$i, $el['lote'], $procesoDetalle[0]->planta, $procesoDetalle[0]->tipoOrd, $proceso, $cliente])) {
            echo json_encode(['error' => 'si', 'message' => 'Error orden provisional: ' . odbc_errormsg($connnect)]);
            exit;
        }
    }
    foreach ($nuevoOrden as $el) {
        if (!odbc_execute($result, [$el['orden'], $el['lote'], $procesoDetalle[0]->planta, $procesoDetalle[0]->tipoOrd, $proceso, $cliente])) {
            echo json_encode(['error' => 'si', 'message' => 'Error nuevo orden: ' . odbc_errormsg($connnect)]);
            exit;
        }
    }
    echo json_encode(['error' => 'no', 'message' => 'Orden de lotes actualizado']);
}
