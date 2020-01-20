<script type="text/ng-template" id="addPayment.html">
    <div class="modal-header">
        <h3 class="modal-title" id="modal-title">
            <div>Dodaj płatność dla faktury [[$ctrl.data.invoice.number]]</div>
        </h3>
        <div>Kwota: [[$ctrl.data.invoice.price_gross | number : 2]]</div>
        <div>Zapłacono: [[$ctrl.data.invoice.paid | number : 2]]</div>
        <div>Termin płatności: [[$ctrl.data.invoice.payment_to]]</div>
    </div>
    <div class="modal-body" id="modal-body">
        <form class="form-horizontal" role="form">

            <div class="form-group">
                <label for="payment" class="col-sm-3 control-label">Kwota:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="amount" name="amount"
                           placeholder="kwota" ng-model="$ctrl.data.form.paid">
                </div>
            </div>
            <div class="form-group">
                <label for="paymentname" class="col-sm-3 control-label">Nazwa:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="paymentname" name="paymentname"
                           placeholder="Nazwa" ng-model="$ctrl.data.form.paymentname">
                </div>
            </div>
            <div class="form-group">
                <label for="paymentdate" class="col-sm-3 control-label">Data płatności:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="paymentdate" name="paymentdate"
                           placeholder="data płatności" ng-model="$ctrl.data.form.paymentdate" datepicker required>
                </div>
            </div>
            <div class="form-group">
                <label for="paymentdescription" class="col-sm-3 control-label">Opis:</label>
                <div class="col-sm-9">
                    <textarea rows=2 type="text" class="form-control" id="paymentdescription" name="paymentdescription"
                              placeholder="opis" ng-model="$ctrl.data.form.paymentdescription"></textarea>
                </div>
            </div>
        </form>

    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" type="button" ng-click="$ctrl.save()">Zapisz</button>
        <button class="btn btn-warning" type="button" ng-click="$ctrl.cancel()">Anuluj</button>
    </div>
</script>