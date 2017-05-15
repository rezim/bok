<script type="text/ng-template" id="emailList.html">
    <div class="modal-header">
        <h3 class="modal-title" id="modal-title">Korespondencja do zgłoszenia serwisowego nr [[$ctrl.requestData.revers_number]]</h3>
    </div>
    <div class="modal-body" id="modal-body">
        <form class="form-horizontal" role="form">

            <button class="btn btn-info" type="button" ng-click="$ctrl.openSendEmail($ctrl.requestData)">Wyślij Zapytanie o Wycenę</button>

            <div class="container-fluid">
                <div class="row header">
                    <div class="col-sm-3">Data</div>
                    <div class="col-sm-3">Adres Email</div>
                    <div class="col-sm-5">Temat</div>
                    <div class="col-sm-1"></div>
                </div>
                <div class="row" ng-class="!mail.wasread ? 'strong': ''" ng-repeat="mail in $ctrl.getEmails($ctrl.requestData.revers_number)">
                    <div class="col-sm-3" role="button" ng-click="$ctrl.openEmail(mail)">[[mail.date_email]]</div>
                    <div class="col-sm-3" role="button" ng-click="$ctrl.openEmail(mail)">[[mail.email]]</div>
                    <div class="col-sm-5" role="button" ng-click="$ctrl.openEmail(mail)">[[mail.temat]]</div>
                    <div class="col-sm-1" ng-if="!mail.wassent"><i class="fa fa-reply fa-2x" ng-click="$ctrl.replyEmail(mail)" title="odpowiedz"></i></div>
                </div>
            </div>

        </form>

    </div>
    <div class="modal-footer">
        <button class="btn btn-warning" type="button" ng-click="$ctrl.cancel()">Zamknij</button>
    </div>
</div>