<div>

    <p>Rozliczenie szczegółowe dla: <b>{$client['nazwakrotka']}</b>, NIP: <b>{$client['nip']}</b></p>
    <p>
        <a class="btn btn-sm btn-outline-primary"
           href="javascript:void(0)"
           onclick="openClientPaymentMessagesModal('{$client.nip|escape:'javascript'}', '{$client.nazwakrotka|escape:'javascript'}'); return false;">
            Notatki klienta
        </a>
        <a class="btn btn-sm btn-outline-secondary" data-toggle="collapse" href="#clientDetails" role="button" aria-expanded="false" aria-controls="clientDetails">
            Pokaż dane klienta
        </a>
    </p>
    <div class="collapse" id="clientDetails">
        <table class='table table-sm table-bordered mb-3'>
            <tbody>
            <tr>
                <th style="width: 280px;">Pełny adres klienta</th>
                <td>
                    {if !empty($client['ulica']) || !empty($client['kodpocztowy']) || !empty($client['miasto'])}
                        {$client['ulica']|escape:'html'}{if !empty($client['ulica']) && (!empty($client['kodpocztowy']) || !empty($client['miasto']))}, {/if}{$client['kodpocztowy']|escape:'html'}{if !empty($client['kodpocztowy']) && !empty($client['miasto'])} {/if}{$client['miasto']|escape:'html'}
                    {else}
                        -
                    {/if}
                </td>
            </tr>
            <tr>
                <th>Email faktury</th>
                <td>{if !empty($client['mailfaktury'])}{$client['mailfaktury']|escape:'html'}{else}-{/if}</td>
            </tr>
            <tr>
                <th>Termin płatności</th>
                <td>{if !empty($client['terminplatnosci'])}{$client['terminplatnosci']|escape:'html'} dni{else}-{/if}</td>
            </tr>
            <tr class="table-active">
                <th colspan="2">Osoba odpowiedzialna za płatności</th>
            </tr>
            <tr>
                <th>Imię i nazwisko</th>
                <td>{if !empty($client['fakturyimienazwisko'])}{$client['fakturyimienazwisko']|escape:'html'}{else}-{/if}</td>
            </tr>
            <tr>
                <th>Adres email</th>
                <td>{if !empty($client['fakturyemail'])}{$client['fakturyemail']|escape:'html'}{else}-{/if}</td>
            </tr>
            <tr>
                <th>Telefon komórkowy</th>
                <td>{if !empty($client['fakturykomorka'])}{$client['fakturykomorka']|escape:'html'}{else}-{/if}</td>
            </tr>
            <tr>
                <th>Telefon stacjonarny</th>
                <td>{if !empty($client['fakturytelefon'])}{$client['fakturytelefon']|escape:'html'}{else}-{/if}</td>
            </tr>
            <tr>
                <th>Stanowisko</th>
                <td>{if !empty($client['fakturystanowisko'])}{$client['fakturystanowisko']|escape:'html'}{else}-{/if}</td>
            </tr>
            <tr>
                <th>Uwagi / notatki</th>
                <td>{if !empty($client['fakturyuwagi'])}{$client['fakturyuwagi']|escape:'html'}{else}-{/if}</td>
            </tr>
            </tbody>
        </table>
    </div>
    {if isset($isEmptyMessage)}{$isEmptyMessage}{else}
    <table class='table table-hover table-sm tablesorter'>
        <thead class="thead-dark">
        <tr>
            {foreach $columnNames as $columnName}
                <th>{$columnName}</th>
            {/foreach}
        </tr>
        </thead>
        <tbody>
        <tr class="table-dark text-dark text-b">
            {foreach $columnSummaries as $columnSummary}
                <th><h5><strong>{if $columnSummary != 0}{$columnSummary}{else}-{/if}</strong></h5></th>
            {/foreach}
        </tr>
        {foreach $accountingSettlements as $rowScan}
            <tr{if isset($rowScan[$rowClassName])} class="{$rowScan[$rowClassName]}"{/if}>
                {foreach $columnNames as $key}
                    <td>
                        {if isset($isGroupedView) && $isGroupedView && ($key === 'treść' || $key === 'data płatności' || $key === 'saldo' || $key === 'uwagi')}
                            {$rowScan[$key] nofilter}
                        {else}
                            {$rowScan[$key]}
                        {/if}
                    </td>
                {/foreach}
            </tr>
        {/foreach}
        </tbody>
    </table>
    {/if}
</div>

<div class="modal fade" id="clientPaymentMessagesModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h3 class="modal-title">Historia komunikacji z klientem.</h3>
                <div id="clientPaymentMessagesSubtitle"></div>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" id="clientPaymentMessagesForm">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="form-group col-sm-3">
                                <label for="clientPaymentMessageDate" class="control-label">Data</label>
                                <div>
                                    <input type="text" class="form-control" id="clientPaymentMessageDate" name="message_date" placeholder="data wiadomości">
                                </div>
                            </div>
                            <div class="form-group col-sm-9">
                                <label for="clientPaymentMessageText" class="control-label">Treść:</label>
                                <div>
                                    <textarea rows="4" class="form-control" id="clientPaymentMessageText" name="message" placeholder="treść wiadomości"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <button class="btn btn-info" type="button" id="clientPaymentMessagesSaveBtn">zapisz</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="container-fluid mt-3">
                    <div class="row header font-weight-bold border-top border-bottom py-2">
                        <div class="col-sm-2">Data</div>
                        <div class="col-sm-6">Wiadomość</div>
                        <div class="col-sm-3">Pracownik</div>
                        <div class="col-sm-1"></div>
                    </div>
                    <div id="clientPaymentMessagesList"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Zamknij</button>
            </div>
        </div>
    </div>
</div>

{literal}
<script>
    let currentClientPaymentMessagesNip = null;
    let currentClientPaymentMessages = [];

    function escapeClientPaymentMessageHtml(value) {
        return $('<div/>').text(value || '').html();
    }

    function renderClientPaymentMessages(messages) {
        const listContainer = $('#clientPaymentMessagesList');
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

    function openClientPaymentMessagesModal(nip, clientName) {
        currentClientPaymentMessagesNip = nip;
        $('#clientPaymentMessagesSubtitle').text('Klient: ' + (clientName || '') + ', NIP: ' + nip);
        $('#clientPaymentMessageText').val('');
        $('#clientPaymentMessageDate').datepicker({dateFormat: 'yy-mm-dd'}).datepicker('setDate', 'today');
        fetchClientPaymentMessages();
        $('#clientPaymentMessagesModal').modal({keyboard: true});
    }

    function removeClientPaymentMessage(rowid) {
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
    }

    $('#clientPaymentMessagesSaveBtn').off('click').on('click', function () {
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

    $('#clientPaymentMessageText').off('keypress').on('keypress', function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            $('#clientPaymentMessagesSaveBtn').trigger('click');
        }
    });
</script>
{/literal}