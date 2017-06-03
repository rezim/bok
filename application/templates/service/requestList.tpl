<div class="container table-responsive">
    <div>
        <div class="btn-group">
            <label class="btn btn-success" ng-model="requestAgreementsType" uib-btn-radio="'open'" uncheckable>Otwarte</label>
            <label class="btn btn-success" ng-model="requestAgreementsType" uib-btn-radio="'closed'" uncheckable>Zamknięte</label>
        </div>
    </div>

    <div ng-if="requestAgreementsType == 'open' || !requestAgreementsType">
    {include file="$templates/service/openRequestList.tpl"}
    </div>

    <div ng-if="requestAgreementsType == 'closed'">
        {include file="$templates/service/closedRequestList.tpl"}
    </div>

    <i ng-if="isPending" class="fa fa-spinner fa-spin fa-5x" aria-hidden="true" style="margin-top: 50px;"></i>
</div>