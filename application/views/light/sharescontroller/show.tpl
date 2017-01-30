<div ng-app="app" ng-controller="UserSharesCtrl as ctrl" ng-init="order = 'nazwa'">
    <div class="divFilter">
        <label class="labelNormal" style="padding-right: 10px">
            rola <input type="text" class='textBoxNormal' ng-model="search.nazwa">
        </label>
        <label class="labelNormal" style="padding-right: 10px">
            kontroler <input type="text" class='textBoxNormal' ng-model="search.controller">
        </label>
        <label class="labelNormal" style="padding-right: 30px">
            akcja <input type="text" class='textBoxNormal' ng-model="search.action">
        </label>
    </div>
    <table class='tablesorter displaytable' id='tableReport' cellspacing=0 cellpadding=0>
        <thead>
            <tr>
                <td style="cursor: pointer" width="200px" ng-click="order='nazwa'">rola&nbsp;<i class="fa fa-sort-desc" aria-hidden="true" ng-if="order == 'nazwa'"></i></td>
                <td style="cursor: pointer" width="200px" ng-click="order='controller'">kontroler&nbsp;<i class="fa fa-sort-desc" aria-hidden="true" ng-if="order == 'controller'"></i></td>
                <td style="cursor: pointer" width="200px" ng-click="order='action'">akcja&nbsp;<i class="fa fa-sort-desc" aria-hidden="true" ng-if="order == 'action'"></i></td>
                <td style="cursor: pointer" width="200px" ng-click="order='activity'">aktywny&nbsp;<i class="fa fa-sort-desc" aria-hidden="true" ng-if="order == 'activity'"></i></td>
                <td style="cursor: pointer" width="200px" ng-click="order='id'">id&nbsp;<i class="fa fa-sort-desc" aria-hidden="true" ng-if="order == 'id'"></i></td>
                <td style="cursor: pointer" width="100px" ng-click="order='permission'">prawa&nbsp;<i class="fa fa-sort-desc" aria-hidden="true" ng-if="order == 'permission'"></i></td>
                <td width="100px" ></td>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="share in ctrl.getUserShares() | filter:search | orderBy: order">
                <td>[[share.nazwa]]</td>
                <td>[[share.controller]]</td>
                <td>[[share.action]]</td>
                <td>[[share.activity]]</td>
                <td>[[share.id]]</td>
                <td><input type="text" ng-model="share.permission" /></td>
                <td style="text-align: center">
                    <span ng-click="ctrl.updatePermission(share.permission, share.rowid)" class="fa fa-floppy-o fa-3" aria-hidden="true" style="color: green; cursor: pointer; font-size: 1.4em" title="zapisz"></span>
                    {*<span class="fa fa-times fa-3" aria-hidden="true" style="color: red; cursor: pointer; font-size: 1.4em" title="usuń"></span>*}
                </td>
            </tr>
        </tbody>


</div>
