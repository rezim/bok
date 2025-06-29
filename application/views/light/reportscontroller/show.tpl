<div class="container-fluid reports">
    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-auto">
            <form id="dataFilter" data-form>
                <div class="form-group">
                    <label for="txtdataod">data od</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtdataod' class="form-control"
                           aria-describedby="dateFromHelp">
                    <small id="dateFromHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę
                        początkową.</small>
                </div>

                <div class="form-group">
                    <label for="txtdatado">data do</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtdatado' class="form-control"
                           aria-describedby="dateToHelp">
                    <small id="dateToHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę
                        końcową.</small>
                </div>

                <div class="form-group">
                    <label for="txtdatado">miesiąc</label>
                </div>
                <div class="form-group">
                    <select id='txtmiesiac' class="form-control"
                            onchange="changeMiesiac(this);" aria-describedby="monthHelp">
                        <option value="" selected></option>
                        {foreach from=$months item=item key=key}
                            <option value="{$rok}-{$key}-01">{$item}</option>
                        {/foreach}
                    </select>
                    <small id="monthHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Wybierz
                        miesiąc.</small>
                </div>

                <div class="border-top my-4 otus-separator"></div>

                <div class="w-100"></div>

                <div class="form-group">
                    <label for="txtklient">klient</label>
                </div>
                <div class="form-group">
                    <input data-ref type="text" id='filterklient' class="form-control"
                           aria-describedby="clientHelp">
                    <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj nazwę
                        klienta</small>
                </div>

                <div class="form-group">
                    <label for="txtserial">drukarka</label>
                </div>
                <div class="form-group">
                    <input data-ref type="text" id='filterserial' class="form-control"
                           aria-describedby="deviceHelp">
                    <small id="deviceHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj serial
                        urządzenia</small>
                </div>

                <div class="form-group mt-4">
                    <input type="checkbox" id='checkShowClientWithAllIssuedInvoices'
                           aria-describedby="showClientWithAllIssuedInvoices"
                           onclick="invMgr.showClientWithAllIssuedInvoices(!this.checked)"/>
                    <label for="checkShowClientWithAllIssuedInvoices">Ukryj klientów z wystawionymi fakturami</label>
                    <small id="closedAgreementsHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i>
                        Ukryj klientów z wystawionymi fakturami.</small>
                </div>

                <div class="border-top my-4 otus-separator"></div>

                <div class="form-group">
                    <button class="btn btn-info btn-block" type="submit"
                            onClick='startReportGeneration();return false;'>
                        Generuj
                    </button>
                </div>
                <div class="form-group">
                    <button class="btn btn-success btn-block" type="button" data-toggle="modal"
                            data-target="#exampleModal">
                        Wystaw faktury
                    </button>
                </div>

                <div class="form-group">
                    <button class="btn btn-danger btn-block" type="button"
                            onclick="fixDeviceCounters(invMgr.getReportData())">
                        Popraw Liczniki Urządzeń
                    </button>
                </div>
            </form>
        </div>

        <main id='divRightCenter' class="col-12 col-md-12 col-xl">

        </main>
    </div>
</div>

<!-- Confirm Issue All Invoices Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Czy wystawić wszystkie faktury w tym miesiącu ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onClick="invMgr.addAll();">Wystaw
                </button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    const invMgr = new InvoiceManager('{$smarty.const.FAKTUROWNIA_INVOICE_NUMBER_LENGTH}');

    function startReportGeneration() {
        generujRaport(function (data, params) {literal}{
            invMgr.refreshInvoices(params, () => invMgr.showClientWithAllIssuedInvoices(!$(`#checkShowClientWithAllIssuedInvoices`).prop(`checked`)));
            invMgr.showAgreementWarnings(params);
        }{/literal});
    }
</script>
<script type="text/javascript">
    $('#txtklient').unbind("keypress");
    $('#txtklient').keypress(function (event) {
        if (event.keyCode == 13) {
            startReportGeneration();
            return false;
        }
    });
    $('#txtserial').unbind("keypress");
    $('#txtserial').keypress(function (event) {
        if (event.keyCode == 13) {
            startReportGeneration();
            return false;
        }
    });
    $("#txtdataod").datepicker
    ($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true
    });
    $("#txtdatado").datepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true
    });
    setDateDefault();
    $('#txtdataod').unbind("keypress");
    $('#txtdataod').keypress(function (event) {
        if (event.keyCode == 13) {
            startReportGeneration();
            return false;
        }
    });
    $('#txtdatado').unbind("keypress");
    $('#txtdatado').keypress(function (event) {
        if (event.keyCode == 13) {
            startReportGeneration();
            return false;
        }
    });
    $('#txtmiesiac').unbind("keypress");
    $('#txtmiesiac').keypress(function (event) {
        if (event.keyCode == 13) {
            startReportGeneration();
            return false;
        }
    });
</script>

<script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/printer_counters.js?{$smarty.now}"></script>