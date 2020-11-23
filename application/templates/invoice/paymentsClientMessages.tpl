<script type="text/ng-template" id="paymentsClientMessages.html">
    <div class="modal-header">
        <h3 class="modal-title" id="modal-title">
            Historia komunikacji z klientem.
        </h3>
        <div>Klient: [[$ctrl.data.clientName]]</div>
    </div>
    <div class="modal-body" id="modal-body">

        <form class="form-horizontal" role="form">
            <div class="container-fluid">
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label for="paymentdate" class="control-label">Data</label>
                        <div>
                            <input type="text" class="form-control" id="paymentdate" name="messagedate"
                                   placeholder="data wiadomości" ng-model="$ctrl.data.form.date" datepicker
                                   required>
                        </div>
                    </div>
                    <div class="form-group col-sm-9">
                        <label for="messagedescription" class="control-label">Treść:</label>
                        <div>
                    <textarea rows=4 type="text" class="form-control" id="messagedescription" name="messagedescription"
                              placeholder="treść wiadomości" ng-model="$ctrl.data.form.message"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-right">
                    <button class="btn btn-info" type="button" ng-click="$ctrl.save()">zapisz</button></div>
                </div>
            </div>
        </form>

        <form class="form-horizontal" role="form">

            <div class="container-fluid">
                <div class="row header">
                    <div class="col-sm-2">Data</div>
                    <div class="col-sm-6">Wiadomość</div>
                    <div class="col-sm-3">Pracownik</div>
                    <div class="col-sm-1"></div>
                </div>
                <div class="row"
                     ng-repeat="message in $ctrl.getMessages($ctrl.data.clientNip) track by $index">

                    <div class="col-sm-2" role="button">[[message.message_date]]</div>
                    <div class="col-sm-6" role="button">[[message.message]]</div>
                    <div class="col-sm-3" role="button">[[message.owner]]</div>
                    <div class="col-sm-1" role="button">
                        <span class="action fa fa-times fa-3" ng-click="$ctrl.removeMessage(message.rowid)"></span>
                    </div>
                </div>
            </div>

        </form>

    </div>
    <div class="modal-footer">
        <button class="btn btn-warning" type="button" ng-click="$ctrl.cancel()">Zamknij</button>
    </div>
</script>
