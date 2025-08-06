$(document).ready(function () {
    $('button[name="search"]').on('click', function (event) {
        var proceso = $('#proceso').val();
        var cliente = $('#cliente').val();
        $.ajax({
            type: "POST",
            url: "./data/productor.php",
            data: {
                proceso: proceso,
                cliente: cliente
            },
            dataType: "html",
            beforeSend: function () {
                $('#info').show();
                $('#act').show();
                $('#prod').html('<div class="d-flex justify-content-center mt-3"><div class="spinner-border" role="status"></div></div>');
            },
            success: function (response) {
                $('#new_orden').show();
                $('#orden').show();
                $('#prod').html(response);
            },
        });
        $.ajax({
            type: "POST",
            url: "./data/detalle_proceso.php",
            data: {
                proceso: proceso,
                cliente: cliente
            },
            dataType: "html",
            success: function (response) {
                $('#deta_new_orden').html('');
                $('#deta_orden').html(response);
                var oldO = document.getElementById('deta_orden');
                var sortableOld = Sortable.create(oldO, {
                    group: {
                        name: 'deta_orden',
                        pull: true
                    },
                    animation: 200
                });
                var newO = document.getElementById('deta_new_orden');
                var sortableNew = Sortable.create(newO, {
                    group: {
                        name: 'deta_new_orden',
                        put: true
                    },
                    animation: 200,
                    onAdd: () => {
                        var items = Array.from(newO.children);
                        var newOrder = items.map((i, idx) => {
                            $('#' + parseInt(i.id.split('_')[1])).val(parseInt(idx + 1))
                            $('#show' + parseInt(i.id.split('_')[1])).html(parseInt(idx + 1))
                        });
                    },
                    onEnd: () => {
                        var items = Array.from(newO.children);
                        var newOrder = items.map((i, idx) => {
                            $('#' + parseInt(i.id.split('_')[1])).val(parseInt(idx + 1))
                            $('#show' + parseInt(i.id.split('_')[1])).html(parseInt(idx + 1))
                        });
                    },
                    onRemove: () => {
                        var items = Array.from(newO.children);
                        var newOrder = items.map((i, idx) => {
                            $('#' + parseInt(i.id.split('_')[1])).val(parseInt(idx + 1))
                            $('#show' + parseInt(i.id.split('_')[1])).html(parseInt(idx + 1))
                        });
                    },
                });

            },
        });
    });
});
function actualizar() {
    if (confirm('Actualizando orden de proceso, continuar?')) {
        var proceso = $('#proceso').val();
        var cliente = $('#cliente').val();
        var newO = document.querySelector('#deta_new_orden');
        var items = [...newO.getElementsByTagName('input')];
        var lotes = [...newO.getElementsByTagName('p')];
        var nuevoOrden = []
        items.forEach(function (e, i) {
            nuevoOrden.push({ lote: parseInt(lotes[i].innerHTML), orden: parseInt(e.value) })
        })
        $.ajax({
            type: "POST",
            url: "./data/actualizar_orden.php",
            data: {
                proceso: proceso,
                cliente: cliente,
                nuevoOrden: JSON.stringify(nuevoOrden)
            },
            dataType: "json",
            beforeSend: function () {
                $('#prod').html('<div class="d-flex justify-content-center mt-3"><div class="spinner-border" role="status"></div></div>');
                $('#info').hide();
                $('#deta_orden').html('');
                $('#deta_new_orden').html('');
            },
            success: function (responseDel) {
                if (responseDel.error == 'si') {
                    alert(responseDel.message);
                } else {
                    $('#info').show();
                    $('#prod').load('./data/productor.php', { proceso: proceso, cliente: cliente });
                    $('#deta_orden').load('./data/detalle_proceso.php', { proceso: proceso, cliente: cliente });
                    alert(responseDel.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud:", status, error);
                console.error("Detalles de la respuesta:", xhr.responseText);
                alert('Error al procesar la solicitud' + xhr.responseText);
            }
        });
    } else {
        alert('No se actualizó la orden.');
    }

}