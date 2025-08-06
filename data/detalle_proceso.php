<?php

include '../model/connections.php';
include '../model/functions.php';

$conn = new Connections();
$functions = new Functions();


$cliente = $_POST['cliente'];
$proceso = $_POST['proceso'];

$connnect = $conn->connectToServ();
$lotesDetalle = json_decode($functions->getLotesProceso($connnect, $cliente, $proceso));
if ($lotesDetalle[0]->error) {
    echo "<script>alert('No se encontró el número de traspaso para el cliente y proceso especificados.');</script>";
    exit;
} else {
?>

    <?php

    foreach ($lotesDetalle as $lote) {
    ?>
        <div class="card" id="<?= $lote->lote ?>_<?= $lote->orden ?>">
            <input type="number" id="<?= $lote->orden ?>" value="<?= $lote->orden ?>" style="display:none">
            <p id="<?= $lote->lote ?>" style="display:none"><?= $lote->lote ?></p>
            <div class="card-header">
                <div class="row justify-content-center align-items-center">
                    <div class="col-2">
                        <h6 class="text-center" id="show<?= $lote->orden ?>"><?= $lote->orden ?></h6>
                    </div>
                    <div class="col-2">
                        <h6 class="text-center"><?= $lote->lote ?></h6>
                    </div>
                    <div class="col-2">
                        <h6 class="text-center"><?= number_format($lote->kiloNeto, 2, ',', '.') ?></h6>
                    </div>
                    <div class="col-2">
                        <h6 class="text-center"><?= $lote->canBul ?></h6>
                    </div>
                </div>
            </div>
        </div>

    <?php

    }

    ?>
<?php
}
