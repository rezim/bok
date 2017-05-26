<script type="text/ng-template" id="statusHistory.html">
    <div class="container-fluid table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        data
                    </th >
                    <th>
                        status
                    </th >
                    <th>
                        wykonywał
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="statusHistoy in $ctrl.getStatusHistory()">
                    <td>[[statusHistoy.date_insert]]</td>
                    <td>[[statusHistoy.statusName]]</td>
                    <td>[[statusHistoy.userName]]</td>
                </tr>
            </tbody>
        </table>

        <div class="modal-footer">
            <button class="btn btn-warning" type="button" ng-click="$ctrl.cancel()">Zamknij</button>
        </div>
    </div>
</script>