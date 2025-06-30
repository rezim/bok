<div class="container-fluid agreements">
    {include file="$templates/partials/filters/notifications.tpl"}
    {include file="$templates/partials/main.tpl" mainId="divRightCenter"}
</div>

<script>
    function renderNotification(rowid) {

    }
</script>
<script type="text/javascript">
    $('#txtfilterklient').unbind("keypress");
    $('#txtfilterklient').keypress(function (event) {
        if (event.keyCode == 13) {
            showListOfNotifications();
            return false;
        }
    });
    $('#txtfilternrseryjny').unbind("keypress");
    $('#txtfilternrseryjny').keypress(function (event) {
        if (event.keyCode == 13) {
            showListOfNotifications();
            return false;
        }
    });
    $('#txtfilternrzlecenia').unbind("keypress");
    $('#txtfilternrzlecenia').keypress(function (event) {
        if (event.keyCode == 13) {
            showListOfNotifications();
            return false;
        }
    });
    $('#txtfilterdataod').unbind("keypress");
    $('#txtfilterdataod').keypress(function (event) {
        if (event.keyCode == 13) {
            showListOfNotifications();
            return false;
        }
    });
    $('#txtfilterdatado').unbind("keypress");
    $('#txtfilterdatado').keypress(function (event) {
        if (event.keyCode == 13) {
            showListOfNotifications();
            return false;
        }
    });
    $("#txtfilterdataod").datepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd", changeMonth: true,
        changeYear: true,
    });
    $("#txtfilterdatado").datepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd", changeMonth: true,
        changeYear: true,
    });
    {if isset($queryString) && $queryString[0]=='addeditnoti'}
    $("#divFilterNoti").hide();
    showNewNotiAdd('{$queryString[1]}', '{$queryString[2]}', '{$queryString[3]}')
    {elseif isset($queryString) && isset($queryString[0])}
    onAddEditNotificationAction({$queryString[0]});
    {else}
    $("#divFilterNoti").show();
    showListOfNotifications();
    {/if}
</script>
<script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/notifications.js?{$smarty.const.APPVERSION}"></script>

