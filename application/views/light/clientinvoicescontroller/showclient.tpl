<div class="container-fluid position-relative">
    {include file="$templates/partials/filters/debit-credit.tpl"}
    {include file="$templates/partials/main.tpl" mainId="divRightCenter"}
</div>
<script>
    const startAndEndDate = {
        startDate: new Date('2021-12-31'),
        endDate: new Date()
    };

    // startAndEndDate.startDate.setMonth(0,1);

    $("#startDate").datepicker
    ($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true
    }).val($.datepicker.formatDate('yy-mm-dd', startAndEndDate.startDate));
    $("#endDate").datepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true
    }).val($.datepicker.formatDate('yy-mm-dd', startAndEndDate.endDate));

    $("#month").on('change', (event) => {
        const selectedDate = $(event.target).val();
        const startAndEndDate = getStartAndEndDate(selectedDate);
        $("#startDate").val($.datepicker.formatDate('yy-mm-dd', startAndEndDate.startDate));
        $("#endDate").val($.datepicker.formatDate('yy-mm-dd', startAndEndDate.endDate));
    });
</script>

<script>
    const dataContainerId = 'dataFilter';
    const templateId = 'divRightCenter';

    const syncGroupedViewHiddenField = () => {
        const groupedViewSwitch = document.getElementById('groupByInvoiceWithPaymentsSwitch');
        const groupedViewHiddenInput = document.getElementById('groupByInvoiceWithPayments');

        if (!groupedViewSwitch || !groupedViewHiddenInput) {
            return;
        }

        groupedViewHiddenInput.value = groupedViewSwitch.checked ? 'true' : 'false';
    };

    const renderTemplate = () => renderTemplateAction(
        "/clientinvoices/showclientdata/todiv",
        dataContainerId,
        templateId,
        null,
        syncGroupedViewHiddenField
    );

    $("#applyFilter").on('click', renderTemplate);

    $(document)
        .off('change', '#groupByInvoiceWithPaymentsSwitch')
        .on('change', '#groupByInvoiceWithPaymentsSwitch', function () {
            const groupedViewHiddenInput = document.getElementById('groupByInvoiceWithPayments');
            if (groupedViewHiddenInput) {
                groupedViewHiddenInput.value = this.checked ? 'true' : 'false';
            }

            renderTemplate();
        });

    renderTemplate();
</script>

<script>
    const clientChannel = new BroadcastChannel("client-channel");

    clientChannel.onmessage = function (event) {

        if (!event || !event.data) return;

        const type = event.data.type;
        const nip = event.data.nip;

        if (type !== "CLIENT_INVOICES_OPENED" || !nip) return;

        const url = new URL(window.location.href);
        const pathParts = url.pathname.split("/").filter(Boolean);

        const basePath = "/bok/clientinvoices/showclient";

        const currentNip = pathParts[pathParts.length - 1];
        if (currentNip === nip) return;

        url.pathname = basePath + "/" + encodeURIComponent(nip);
        window.location.href = url.toString();
    };
</script>

{literal}
<script>
    let currentClientPaymentMessagesNip = null;
    let currentClientPaymentMessages = [];

    function escapeClientPaymentMessageHtml(value) {
        return $('<div/>').text(value || '').html();
    }

    function renderClientPaymentMessages(messages) {
        const listContainer = $('#clientPaymentMessagesList');
        if (!listContainer.length) {
            return;
        }

        if (!messages || !messages.length) {
            listContainer.html('<div class="row py-2"><div class="col-sm-12 text-muted">Brak notatek.</div></div>');
            return;
        }

        const rowsHtml = messages.map(function (message) {
            return '' +
                '<div class="row py-2 border-bottom">' +
                '<div class="col-sm-2">' + escapeClientPaymentMessageHtml(message.message_date) + '</div>' +
                '<div class="col-sm-6">' + escapeClientPaymentMessageHtml(message.message) + '</div>' +
                '<div class="col-sm-3">' + escapeClientPaymentMessageHtml(message.owner) + '</div>' +
                '<div class="col-sm-1">' +
                '<span class="action fa fa-times fa-3 text-danger" role="button" onclick="removeClientPaymentMessage(' + Number(message.rowid) + ')"></span>' +
                '</div>' +
                '</div>';
        }).join('');

        listContainer.html(rowsHtml);
    }

    function fetchClientPaymentMessages() {
        if (!currentClientPaymentMessagesNip) {
            return;
        }

        $.ajax({
            url: sciezka + '/clientinvoices/getpaymentclientmessages/notemplate',
            type: 'POST',
            dataType: 'json',
            data: {client_nip: currentClientPaymentMessagesNip},
            success: function (messages) {
                currentClientPaymentMessages = Array.isArray(messages) ? messages : [];
                renderClientPaymentMessages(currentClientPaymentMessages);
            },
            error: function () {
                $('#clientPaymentMessagesList').html('<div class="row py-2"><div class="col-sm-12 text-danger">Problem z pobraniem notatek.</div></div>');
            }
        });
    }

    window.openClientPaymentMessagesModal = function (nip, clientName) {
        currentClientPaymentMessagesNip = nip;
        $('#clientPaymentMessagesSubtitle').text('Klient: ' + (clientName || '') + ', NIP: ' + nip);
        $('#clientPaymentMessageText').val('');
        $('#clientPaymentMessageDate').datepicker({dateFormat: 'yy-mm-dd'}).datepicker('setDate', 'today');
        fetchClientPaymentMessages();
        $('#clientPaymentMessagesModal').modal({keyboard: true});
    };

    window.removeClientPaymentMessage = function (rowid) {
        if (!confirm('Czy na pewno usunąć wiadomość?')) {
            return;
        }

        $.ajax({
            url: sciezka + '/clientinvoices/removeclientmessage/notemplate',
            type: 'POST',
            data: {rowid: rowid},
            success: function () {
                currentClientPaymentMessages = currentClientPaymentMessages.filter(function (item) {
                    return Number(item.rowid) !== Number(rowid);
                });
                renderClientPaymentMessages(currentClientPaymentMessages);
            },
            error: function () {
                alert('Nie można usunąć wiadomości.');
            }
        });
    };

    $(document)
        .off('click', '#clientPaymentMessagesSaveBtn')
        .on('click', '#clientPaymentMessagesSaveBtn', function () {
            const messageDate = $('#clientPaymentMessageDate').val();
            const messageText = $('#clientPaymentMessageText').val();

            if (!currentClientPaymentMessagesNip || !messageDate || !messageText) {
                alert('Uzupełnij datę i treść wiadomości.');
                return;
            }

            $.ajax({
                url: sciezka + '/clientinvoices/addpaymentclientmessage/notemplate',
                type: 'POST',
                dataType: 'json',
                data: {
                    client_nip: currentClientPaymentMessagesNip,
                    message_date: messageDate,
                    message: messageText
                },
                success: function (newMessages) {
                    const inserted = Array.isArray(newMessages) ? newMessages : [];
                    currentClientPaymentMessages = inserted.concat(currentClientPaymentMessages);
                    renderClientPaymentMessages(currentClientPaymentMessages);
                    $('#clientPaymentMessageText').val('');
                },
                error: function () {
                    alert('Nie można zapisać wiadomości.');
                }
            });
        });

    $(document)
        .off('keypress', '#clientPaymentMessageText')
        .on('keypress', '#clientPaymentMessageText', function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                $('#clientPaymentMessagesSaveBtn').trigger('click');
            }
        });
</script>
{/literal}