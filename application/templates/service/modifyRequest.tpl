<script type="text/ng-template" id="modifyRequest.html">
    <div class="modal-header">
        <h3 class="modal-title" id="modal-title">Modyfikuj Zgłoszenie</h3>
    </div>
    <form name="$ctrl.form.updateRequest" class="form-horizontal" role="form" ng-submit="$ctrl.updateRequest()" novalidate>
        <div class="modal-body" id="modal-body">
            <div class="form-group" ng-repeat="data in $ctrl.request" ng-if="data.title && (!data.hide || !data.hide())">
                <label for="email" class="col-sm-2 control-label">[[data.title]]</label>
                <div class="col-sm-10" ng-switch="data.type">
                    <input name='[[data.key]]' ng-disabled="data.readonly" ng-switch-when="text" type="text" class="form-control" ng-model="data.value" ng-required="!!data.required" />
                    <input name='[[data.key]]' ng-disabled="data.readonly" ng-switch-when="time" min="0" type="number" ng-model="data.value" ng-pattern="{literal}/^[0-9]+(\.[0,5]{1})?$/{/literal}" step="0.5" class="form-control" ng-required="!!data.required" />
                    <textarea name='[[data.key]]' ng-disabled="data.readonly" ng-switch-when="textarea" rows="4" type="text" class="form-control" ng-model="data.value" ng-required="!!data.required" ></textarea>
                    <select name='[[data.key]]' ng-disabled="data.readonly" ng-switch-when="select" ng-model="data.value" class="form-control" ng-options="option.id as option.name for option in data.availableOptions()">
                    </select>
                    <div class="alert alert-danger" ng-show="!!data.required && $ctrl.form.updateRequest[data.key].$invalid && ($ctrl.form.updateRequest.$submitted || $ctrl.form.updateRequest[data.key].$dirty)">
                        <strong>Uwaga!</strong> Pole <b>'[[data.title]]'</b> jest wymagane.
                    </div>
                    <div class="alert alert-danger" ng-show="!$ctrl.form.updateRequest[data.key].$valid && $ctrl.form.updateRequest[data.key].$error.pattern">
                        <strong>Uwaga!</strong> Wpisana wartość jest niepoprawna. Czas może być podany z dokładnością do pół godziny.
                    </div>
                    <div class="alert alert-danger" ng-show="!$ctrl.form.updateRequest[data.key].$valid && $ctrl.form.updateRequest[data.key].$error.number">
                        <strong>Uwaga!</strong> Wpisana wartość nie jest liczbą.
                    </div>
                    <div class="alert alert-danger" ng-show="!$ctrl.form.updateRequest[data.key].$valid && $ctrl.form.updateRequest[data.key].$error.notZero && !($ctrl.form.updateRequest[data.key].$modelValue > 0)">
                        <strong>Uwaga!</strong> Wartość musi być większa od zera.
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="submit">Zapisz</button>
            <button class="btn btn-warning" type="button" ng-click="$ctrl.cancel()">Anuluj</button>
        </div>
    </form>
</script>