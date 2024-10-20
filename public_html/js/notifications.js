async function onChangeWarehouse(warehouseid) {

    const products = JSON.parse(await loadAsyncData('/notifications/getproductsinwarehouse/notemplate', {warehouseid}));

    const warehouseProducts = $('#product_id');

    warehouseProducts.empty().selectpicker('refresh');

    warehouseProducts.append('<option value="" selected></option>');
    for (const product of products) {
        const warehouseQuantityInt = parseInt(product.warehouse_quantity, 10);
        warehouseProducts.append(`<option data-quantity="${warehouseQuantityInt}" value="${product.id}">${product.name} - (${warehouseQuantityInt})</option>`);
    }

    warehouseProducts.selectpicker('refresh');
}

function onSelectProduct(event) {
    const selectedOption = event.target.options[event.target.selectedIndex];
    const selectedOptionQuantity = selectedOption.getAttribute('data-quantity') ?? 0;

    $('#quantity').attr('max', selectedOptionQuantity);

    $('#quantity').off('input');
    $('#quantity').on('input', function () {
        const value = parseInt(this.value);
        const min = parseInt(this.min);
        const max = parseInt(this.max);

        if (value < min) {
            this.value = min;
        } else if (value > max) {
            this.value = max;
        }
    });
}

async function addEditWarehouseDocument(notificationId) {
    const result = await callServiceAction('/notifications/addwarehousedocument/notemplate', 'warehouseDocuments', null, null);
    const data = JSON.parse(result);

    const dataForm = $("#warehouseDocuments");
    let message = null;
    if (data?.status === 0) {
        message = dataForm.find('.alert-success');
        message.html(data.info ?? "Dane zapisane poprawnie");
    } else {
        message = dataForm.find('.alert-danger');
        message.html(data?.info ?? "Błąd zapisu danych");
    }

    if (message) {
        message.show();
    }

    setTimeout(() => {
        onAddEditNotificationAction(notificationId);
    }, 3000);

}

function removeWarehouseDocument(documentId, documentNumber, notificationId) {
    if (!confirm('Czy na pewno usunąć dokument ?')) {
        return false;
    }
    callServiceWithDataAction('/notifications/removewarehousedocument/notemplate', {
        documentId,
        documentNumber
    }, 'warehouseDocuments');

    setTimeout(() => {
        onAddEditNotificationAction(notificationId);
    }, 3000);
}
