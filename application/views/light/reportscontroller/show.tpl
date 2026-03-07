<div class="container-fluid position-relative reports">
    {include file="$templates/partials/filters/reports.tpl"}
    {include file="$templates/partials/main.tpl" mainId="divRightCenter"}
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
    window.ENABLE_ADD_INTEREST_NOTES_TO_INVOICE = {if $smarty.const.ENABLE_ADD_INTEREST_NOTES_TO_INVOICE}true{else}false{/if};
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