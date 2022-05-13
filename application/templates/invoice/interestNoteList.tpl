<script type="text/ng-template" id="interestNoteList.html">
    <div class="modal-header">
        <h3 class="modal-title" id="modal-title">
            Noty odsetkowe.
        </h3>
        <div>Klient: [[$ctrl.data.clientName]]</div>
    </div>
    <div class="modal-body" id="modal-body">
        <form class="form-horizontal" role="form">

            <div class="container-fluid">
                <div class="row header">
                    <div class="col-sm-2">data</div>
                    <div class="col-sm-2">nota</div>
                    <div class="col-sm-2">kwota FV</div>
                    <div class="col-sm-3">płatne do / opłacone</div>
                    {*                    <div class="col-sm-2">Data Płatności</div>*}
                    <div class="col-sm-1">dni</div>
                    <div class="col-sm-2">akcja</div>
                </div>
                <div class="row" ng-repeat="note in $ctrl.data.interestNotesWithInvoices track by $index ">
                    <div class="col-sm-2" role="button">[[note.date]]</div>
                    <div class="col-sm-2" role="button"><a href="[['.' + note.path]]" target=”_blank”>[[note.name]]</a>
                    </div>
                    <div class="col-sm-2" role="button">[[note.invoice.paid | currency: '']]</div>
                    <div class="col-sm-3" role="button">[[note.invoice.payment_to]] / [[note.invoice.paid_date]]</div>
                    {*                    <div class="col-sm-2" role="button">[[note.invoice.paid_date]]</div>*}
                    <div class="col-sm-1" role="button">[[note.invoice.is_late_days]]</div>
                    <div class="col-sm-2" role="button">
                        <button class="btn btn-primary" style="font-size: 10px"
                                ng-click="$ctrl.interestNotePaid(note.invoice.buyer_tax_no, note.name, note.invoice.number)">opłacona
                        </button>
                    </div>
                </div>
            </div>

        </form>

    </div>
    <div class="modal-footer">
        <button class="btn btn-warning" type="button" ng-click="$ctrl.cancel()">Zamknij</button>
    </div>
</script>
