<script type="text/ng-template" id="interestNoteList.html">
    <div class="modal-header">
        <h3 class="modal-title" id="modal-title">
            Noty odsetkowe.
        </h3>
        <div>Klient: [[$ctrl.data.clientName]]</div>

    </div>
    <div class="modal-body" id="modal-body">
        <form class="form-horizontal" role="form">
            <div class="container-fluid interest-notes">
                <div class="row pb-4">
                    <div class="col-sm-10 text-right">Data dokonania płatności za notę odsetkową:</div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control"
                               ng-model="$ctrl.data.paymentDate" datepicker required>
                    </div>
                </div>
                <div class="row header">
                    <div class="col-sm-2">data</div>
                    <div class="col-sm-3">numer</div>
                    <div class="col-sm-2 text-right">kwota</div>
                    <div class="col-sm-2 text-right">FVat</div>
                    <div class="col-sm-1 text-right">dni</div>
                    <div class="col-sm-2 text-right">akcja</div>
                </div>
                <div class="row" ng-repeat="note in $ctrl.data.interestNotesWithInvoices track by $index ">
                    <div ng-class="(note.name.startsWith('paid-')) ? 'paid' : ''" class="col-sm-2" role="button">[[note.date]]</div>
                    <div class="col-sm-3" role="button"><a href="[['.' + note.path]]" target=”_blank”>[[$ctrl.normalizeNoteName(note.name)]]</a>
                    </div>
                    <div class="col-sm-2 text-right" role="button">[[note.amount | currency: '']]</div>
                    <div class="col-sm-2 text-right" role="button">[[note.invoice.paid | currency: '']]</div>
                    <div class="col-sm-1 text-right" role="button">[[note.invoice.is_late_days]]</div>
                    <div class="col-sm-2 text-right action" role="button">
                        <button ng-if="!note.name.startsWith('paid-')" class="btn btn-warning" style="font-size: 10px " title="usuń"
                                ng-click="$ctrl.removeInterestNote(note.invoice.buyer_tax_no, note.name, note.invoice.number, $ctrl.data.paymentDate)">
                            X
                        </button>
                        <button ng-if="!note.name.startsWith('paid-')" class="btn btn-primary" style="font-size: 10px " title="zapłać"
                                ng-click="$ctrl.interestNotePaid(note.invoice.buyer_tax_no, note.name, note.invoice.number, $ctrl.data.paymentDate)">
                            zapłać
                        </button>
                        <div class="small" ng-if="note.name.startsWith('paid-')">[[$ctrl.resolvePaidDateFromNoteName(note.name)]]</div>
                    </div>
                </div>
            </div>

        </form>

    </div>
    <div class="modal-footer">
        <button class="btn btn-warning" type="button" ng-click="$ctrl.cancel()">Zamknij</button>
    </div>
</script>
