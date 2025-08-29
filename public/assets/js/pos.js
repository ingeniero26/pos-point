// Actualizar stock cuando se seleccione un almacén
$('#warehouse-select').on('change', function() {
    var warehouseId = $(this).val();
    if (warehouseId) {
        $.ajax({
            url: '/admin/pos/get-stock',
            type: 'POST',
            data: {
                warehouse_id: warehouseId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Actualizar el stock en la tabla
                    response.stock.forEach(function(item) {
                        var stockElement = $(`.stock-amount[data-product-id="${item.product_id}"]`);
                        if (stockElement.length) {
                            stockElement.text(item.stock);
                        }
                    });
                }
            }
        });
    }
});