<div ng-app="app" ng-controller="UserSharesCtrl as ctrl">
    <div class="divFilter">
        <label class="labelNormal" style="padding-right: 10px">
            rola <input type="text" class='textBoxNormal' ng-model="search.roleName">
        </label>
        <label class="labelNormal" style="padding-right: 10px">
            kontroler <input type="text" class='textBoxNormal' ng-model="search.controller">
        </label>
        <label class="labelNormal" style="padding-right: 30px">
            akcja <input type="text" class='textBoxNormal' ng-model="search.action">
        </label>
    </div>
    <table ng-if="lastActionResult">
        <tr><td colspan="8" style="text-align: center">
                [[lastActionResult]]
            </td></tr>
    </table>
    <table class='tablesorter displaytable' id='tableReport' cellspacing=0 cellpadding=0>
        <thead>
            <tr>
                <td style="cursor: pointer" width="200px" ng-click="order='roleName'">rola&nbsp;<i class="fa fa-sort-desc" aria-hidden="true" ng-if="order == 'nazwa'"></i></td>
                <td style="cursor: pointer" width="220px" ng-click="order='controller'">kontroler&nbsp;<i class="fa fa-sort-desc" aria-hidden="true" ng-if="order == 'controller'"></i></td>
                <td style="cursor: pointer" width="250px" ng-click="order='action'">akcja&nbsp;<i class="fa fa-sort-desc" aria-hidden="true" ng-if="order == 'action'"></i></td>
                <td style="cursor: pointer" width="50px" ng-click="order='activity'">aktywny&nbsp;<i class="fa fa-sort-desc" aria-hidden="true" ng-if="order == 'activity'"></i></td>
                <td style="cursor: pointer" width="250px" ng-click="order='id'">id&nbsp;<i class="fa fa-sort-desc" aria-hidden="true" ng-if="order == 'id'"></i></td>
                <td style="cursor: pointer" width="250px" ng-click="order='nazwa'">opis <i class="fa fa-sort-desc" aria-hidden="true" ng-if="order == 'nazwa'"></i></td>
                <td style="cursor: pointer" width="100px" ng-click="order='permission'">prawa&nbsp;<i class="fa fa-sort-desc" aria-hidden="true" ng-if="order == 'permission'"></i></td>
                <td width="100px" ></td>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color: lightgoldenrodyellow; border-bottom: solid 1px #000;">
                <td>
                    <select ng-model="newShare.roleRowId" ng-change="search.roleName = ctrl.getSelectedRoleName(newShare.roleRowId)">
                        <option ng-repeat="role in ctrl.getAvailableRoles()" value="[[role.rowid]]">[[role.nazwa]]</option>
                    </select>
                </td>
                <td>
                    <input type="text" ng-model="newShare.controller" ng-change="search.controller = newShare.controller" />
                </td>
                <td>
                    <input type="text" ng-model="newShare.action" ng-change="search.action = newShare.action" />
                </td>
                <td>
                    <input type="checkbox" ng-model="newShare.activity">
                </td>
                <td><input type="text" ng-model="newShare.id"/></td>
                <td><input type="text" ng-model="newShare.description" /></td>
                <td><input type="text" ng-model="newShare.permission" style="width: 50px;"/></td>
                <td style="text-align: center">
                    <span ng-click="ctrl.addPermission()" class="fa fa-user-plus fa-3" aria-hidden="true" style="color: green; cursor: pointer; font-size: 1.4em" title="zapisz"></span>
                    {*<span class="fa fa-times fa-3" aria-hidden="true" style="color: red; cursor: pointer; font-size: 1.4em" title="usuń"></span>*}
                </td>
            </tr>
            <tr ng-repeat="share in ctrl.getUserShares() | filter: search | orderBy: order">
                <td>[[share.roleName]]</td>
                <td>[[share.controller]]</td>
                <td>[[share.action]]</td>
                <td>[[share.activity]]</td>
                <td>[[share.id]]</td>
                <td>[[share.nazwa]]</td>
                <td><input type="text" ng-model="share.permission" style="width: 50px;" /></td>
                <td style="text-align: center">
                    <span ng-click="ctrl.updatePermission(share.permission, share.rowid)" class="fa fa-floppy-o fa-3" aria-hidden="true" style="color: green; cursor: pointer; font-size: 1.4em" title="zapisz"></span>
                    {*<span class="fa fa-times fa-3" aria-hidden="true" style="color: red; cursor: pointer; font-size: 1.4em" title="usuń"></span>*}
                </td>
            </tr>
        </tbody>


</div>
