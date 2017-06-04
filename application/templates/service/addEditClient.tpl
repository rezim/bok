<script type="text/ng-template" id="addEditClient.html">
    <div class="modal-header">
        <h3 class="modal-title" id="modal-title" ng-if="!$ctrl.addMode">Edycja klienta [[$ctrl.client.getValue('nazwa:s')]]</h3>
        <h3 class="modal-title" id="modal-title" ng-if="$ctrl.addMode">Nowy klient</h3>
    </div>
    <form name="$ctrl.form.addEdit" class="form-horizontal" ng-submit="$ctrl.save()" novalidate>
        <div class="modal-body" id="modal-body">

            <div class="form-group" ng-repeat="data in $ctrl.client">
                <label for="email" class="col-sm-2 control-label">[[data.title]]</label>
                <div class="col-sm-10" ng-switch="data.type">
                    <input ng-switch-when="text" type="text" name='[[data.key]]' class="form-control" ng-model="data.value" ng-required="!!data.required"  />
                    <textarea ng-switch-when="textarea" type="text" name='editobj' class="form-control" ng-model="data.value" ng-required="!!data.required"></textarea>
                    <div class="alert alert-danger" ng-show="!!data.required && $ctrl.form.addEdit[data.key].$invalid && ($ctrl.form.addEdit.$submitted || $ctrl.form.addEdit[data.key].$dirty)">
                        <strong>Uwaga!</strong> Pole <b>'[[data.title]]'</b> jest wymagane.
                    </div>
                </div>
            </div>

            {*<table class='tableform' cellpadding='0' cellspacing='0'>*}
                {*<tbody>*}
                {*<tr id='tr' ng-repeat="data in $ctrl.client">*}
                    {*<td  class='tdOpis'><span>[[data.title]]</span></td>*}
                    {*<td class='tdWartosc' ng-switch="data.type">*}
                        {*<input ng-switch-when="text" type="text" name='[[data.key]]' class="textBoxForm" ng-model="data.value" ng-required="!!data.required"  />*}
                        {*<textarea ng-switch-when="textarea" type="text" name='editobj' class="textareaForm" ng-model="data.value" ng-required="!!data.required"></textarea>*}
                        {*<div class="alert alert-danger" ng-show="!!data.required && $ctrl.form.addEdit[data.key].$invalid && ($ctrl.form.addEdit.$submitted || $ctrl.form.addEdit[data.key].$dirty)">*}
                            {*<strong>Uwaga!</strong> Pole <b>'[[data.title]]'</b> jest wymagane.*}
                        {*</div>*}
                    {*</td>*}
                {*</tr>*}
                {*</tbody>*}
            {*</table>*}
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="submit" name="choose" ng-if="$ctrl.addMode">Dodaj i Wybierz</button>
            <button class="btn btn-primary" type="submit" name="add" ng-if="$ctrl.addMode">Dodaj</button>
            <button class="btn btn-primary" type="submit" name="choose" ng-if="!$ctrl.addMode">Zapisz i Wybierz</button>
            <button class="btn btn-primary" type="submit" name="save" ng-if="!$ctrl.addMode">Zapisz</button>
            <button class="btn btn-warning" type="button" ng-click="$ctrl.cancel()">Anuluj</button>
        </div>
    </form>
</script>