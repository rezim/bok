const callServiceWithDataAction = (serviceUrl, data, dataContainerId, success = successCallback, error = errorCallback) => {
    return $.ajax({
        type: 'POST',
        url: sciezka + serviceUrl,
        async: true,
        data,
        success: function (dane) {
            if (success) {
                try {
                    success($.parseJSON(dane), dataContainerId);
                } catch (e) {
                    error(dane, dataContainerId);
                }
            }
            return false;
        },
        error: function (dane) {
            if (error) {
                try {
                    error($.parseJSON(dane), dataContainerId);
                } catch (e) {
                    error(dane, dataContainerId);
                }
            }
            return false;
        }
    });
}

const callServiceAction = (serviceUrl, dataContainerId, success = successCallback, error = errorCallback) => {
    const dataContainer = getContainerById(dataContainerId);

    if (!dataContainer && dataContainerId) {
        console.error(`Can't call service action. Form container: ${dataContainerId} NOT FOUND !!!`);
        return;
    }
    const data = dataContainer ? getDataFromContainer(dataContainer) : {};

    return callServiceWithDataAction(serviceUrl, data, dataContainerId, success, error);
}
const successCallback = (success, dataFormId, timeout = 3000) => {
    const defaultSuccessMessage = 'Dane zapisane poprawnie.';
    const dataForm = $(`#${dataFormId}`);
    if (dataForm) {
        const message = dataForm.find('.alert-success');
        if (success?.info) {
            message.html(success.info);
        } else {
            message.html(defaultSuccessMessage);
        }
        message.show();
        setTimeout(() => {
            message.hide();
        }, timeout);
    }
}
const errorCallback = (error, dataFormId, timeout = 20000) => {
    const dataForm = $(`#${dataFormId}`);
    if (dataForm) {
        const message = dataForm.find('.alert-danger');
        if (error?.responseText) {
            message.html(error.responseText);
        } else {
            message.html(error ?? 'Wystąpił nieoczekiwany błąd.');
        }
        message.show();
        setTimeout(() => {
            message.hide();
        }, timeout);
    }
}
const getContainerById = (containerId) => {
    const containerSelector = `#${containerId}[data-form]`;

    return document.querySelector(containerSelector);
}
const getTemplateContainerById = (containerId) => {
    const containerSelector = `#${containerId}`;

    return document.querySelector(containerSelector);
}
const getDataFromContainer = (container) => {
    const selectedData = Array.from(container.querySelectorAll('[data-ref]'));
    return Object.fromEntries(selectedData.map(d => [d.id, d.type === 'checkbox' ? d.checked : d.value]));
}
const clearDataFromContainer = (containerId) => {
    const container = document.querySelector(`#${containerId}`);
    const selectedData = Array.from(container.querySelectorAll('[data-clear-ref]'));
    selectedData.forEach(d => d.value = '');
}
const renderTemplateAction = (templateUrl, dataContainerId, templateContainerId, skeletonLoaderId) => {
    const dataContainer = getContainerById(dataContainerId);

    if (!dataContainer && dataContainerId) {
        console.error(`Can't call template action. Form container: ${dataContainerId} NOT FOUND !!!`);
        return;
    }

    const data = dataContainer ? getDataFromContainer(dataContainer) : {};

    renderTemplateWithDataAction(templateUrl, data, templateContainerId, skeletonLoaderId);
}

const renderTemplateWithDataAction = async (templateUrl, data, templateContainerId, skeletonLoaderId) => {
    const templateContainer = getTemplateContainerById(templateContainerId);

    if (!templateContainer) {
        console.error(`Can't find template container. Template container: ${templateContainerId} NOT FOUND !!!`);
        return;
    }

    const skeletonLoaderContainer = getTemplateContainerById(skeletonLoaderId);

    $(skeletonLoaderContainer).show();
    templateContainer.innerHTML = '';

    return $.ajax({
        type: 'POST',
        url: sciezka + templateUrl,
        async: true,
        data,
        success: function (template) {
            $(skeletonLoaderContainer).hide();
            templateContainer.innerHTML = template;
            // $(".tablesorter").tablesorter();
            return false;
        },
        error: function (dane) {
            templateContainer.innerHTML = "Nie można pobrać templatu.";
            return false;
        }
    });
}