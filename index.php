<?php
include 'model/connections.php';
include 'model/functions.php';
$conn = new Connections();
$functions = new Functions();
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <title>Reordena Procesos</title>
    <link rel="icon" href="img/favicon.ico" sizes="32x32">
    <link rel="apple-touch-icon" href="img/apple-touch-icon.png" type="image/png">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://kit.fontawesome.com/34afac4ad4.js" crossorigin="anonymous"></script>
    <script src="js/main.js?<?= md5(time()) ?>"></script>
    <style>
        .draggable {

            cursor: move;
        }

        .draggable.dragging {
            background-color: green;
            opacity: .5;
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Vaciado lotes orden de proceso</h3>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-5">
                        <label for="cliente" class="form-label">Cliente</label>
                        <select name="cliente" id="cliente" class="form-select">
                            <?php
                            $functions->getClientesCodOrden($conn->connectToServ());
                            ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <label for="proceso" class="form-label">Proceso</label>
                        <input type="number" name="proceso" id="proceso" class="form-control">
                    </div>
                    <div class="col-4 d-flex align-items-middle justify-content-center">
                        <button type="submit" name="search" class="btn btn-primary col-12">Cargar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="prod"></div>
        <div class="row" id="info" style="display:none">
            <div class="col-6" id="orden">
                <div class="card" style="position: sticky; top: 0; z-index: 1; background-color: #343a40; color: white;">
                    <div class="card-header">
                        <div class="row justify-content-center">
                            <h6 class="text-center">Orden original</h6>
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="row justify-content-center">
                            <div class="col-2">
                                <h6 class="text-center">Orden</h6>
                            </div>
                            <div class="col-2">
                                <h6 class="text-center">Lote</h6>
                            </div>
                            <div class="col-2">
                                <h6 class="text-center">Kilos</h6>
                            </div>
                            <div class="col-2">
                                <h6 class="text-center">Bultos</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" id="deta_orden" style="height: 50vh"></div>
            </div>
            <div class="col-6" id="new_orden">
                <div class="card" style="position: sticky; top: 0; z-index: 1; background-color: #343a40; color: white;">
                    <div class="card-header">
                        <div class="row justify-content-center">
                            <h6 class="text-center">Nuevo orden</h6>
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="row justify-content-center">
                            <div class="col-2">
                                <h6 class="text-center">Orden</h6>
                            </div>
                            <div class="col-2">
                                <h6 class="text-center">Lote</h6>
                            </div>
                            <div class="col-2">
                                <h6 class="text-center">Kilos</h6>
                            </div>
                            <div class="col-2">
                                <h6 class="text-center">Bultos</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" id="deta_new_orden" style="height: 50vh">
                </div>
            </div>
        </div>
        <br>
        <div class="container-fluid" id="act" style="display:none">
            <div class="col-12 d-flex align-items-middle justify-content-center fixed-bottom">
                <button onclick="actualizar()" class="btn btn-success col-12"><i class="fa-solid fa-arrows-rotate"></i> Actualizar Orden</button>
            </div>
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://unpkg.com/sortablejs-make/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>