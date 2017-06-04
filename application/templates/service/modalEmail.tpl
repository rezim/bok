<script type="text/ng-template" id="emailTemplate.html">
    <div class="modal-header">
        <h3 class="modal-title" id="modal-title">[[$ctrl.data.title]]</h3>
    </div>
    <div class="modal-body" id="modal-body">
        <form class="form-horizontal" role="form">

            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Do:</label>
                <div class="col-sm-10">
                    <input ng-disabled="$ctrl.readonly" type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" ng-model="$ctrl.data.email">
                </div>
            </div>
            <div class="form-group">
                <label for="topic" class="col-sm-2 control-label">Temat:</label>
                <div class="col-sm-10">
                    <input ng-disabled="$ctrl.readonly" type="message" class="form-control" id="topic" name="topic" placeholder="temat wiadomości" ng-model="$ctrl.data.temat">
                </div>
            </div>
            <div class="form-group">
                <label for="message" class="col-sm-2 control-label">Wiadomość</label>
                <div class="col-sm-10">
                    <textarea ng-disabled="$ctrl.readonly" class="form-control" rows="16" name="message" ng-model="$ctrl.data.tresc_wiadomosci"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <!-- Will be used to display an alert to the user -->
                </div>
            </div>
        </form>

    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" type="button" ng-click="$ctrl.send()" ng-if="!$ctrl.readonly">Wyślij</button>
        <button class="btn btn-warning" type="button" ng-click="$ctrl.cancel()" ng-if="!$ctrl.readonly">Anuluj</button>
        <button class="btn btn-warning" type="button" ng-click="$ctrl.cancel()" ng-if="$ctrl.readonly">Zamknij</button>
    </div>
</script>