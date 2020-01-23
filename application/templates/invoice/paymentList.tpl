<script type="text/ng-template" id="paymentList.html">
    <div class="modal-header">
        <h3 class="modal-title" id="modal-title">
            Płatności.
        </h3>
        <div>Klient: [[$ctrl.data.clientName]]</div>
        <div>Okres: od '<b>[[$ctrl.data.dateFrom]]</b>' do '<b>[[$ctrl.data.dateTo]]</b>'</div>
    </div>
    <div class="modal-body" id="modal-body">
        <form class="form-horizontal" role="form">

            <div class="container-fluid">
                <div class="row header">
                    <div class="col-sm-2">Nazwa</div>
                    <div class="col-sm-2">Kwota</div>
                    <div class="col-sm-2">Rodzaj</div>
                    <div class="col-sm-2">Faktura</div>
                    <div class="col-sm-2">Kupujący</div>
                    <div class="col-sm-2">akcja</div>
                </div>
                <div class="row" ng-repeat="payment in $ctrl.getPayments($ctrl.data.clientId, $ctrl.data.dateFrom) track by $index">
                    <div class="col-sm-2" role="button">[[payment.name]]</div>
                    <div class="col-sm-2" role="button">[[payment.price]]</div>
                    <div class="col-sm-2" role="button">[[payment.provider]]</div>
                    <div class="col-sm-2" role="button">
                        <a href="[[payment.invoice.view_url]]" target="_blank" ng-click="$event.stopPropagation();">
                            [[payment.invoice.number]]
                        </a>
                    </div>
                    <div class="col-sm-2" role="button">[[payment.client_id]]</div>
                    <div class="col-sm-2" role="button">
                        <span class="action fa fa-times fa-3" ng-click="$ctrl.deletePayment(payment.id)"></span>
                    </div>
                </div>
            </div>

        </form>

    </div>
    <div class="modal-footer">
        <button class="btn btn-warning" type="button" ng-click="$ctrl.cancel()">Zamknij</button>
    </div>
</script>
