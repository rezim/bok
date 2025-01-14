<div class="container-fluid">

    <div class="row">
        {* TODO: check if we can hide sidebar in different way *}
        <div id="divFilterNoti" class="otus-sidebar col-12 col-md-12 col-xl-auto">
            <form>
                {if
                isset($smarty.session.przypisanemenu['but_addcase']) &&
                $smarty.session.przypisanemenu['but_addcase']['permission'] === 'rw'
                }
                    <div class="form-group otus-addnew otus-section">
                        <a href="#" class="btn btn-block btn-outline-warning otus-action-btn" onclick="editNotification('0'); return false;">
                            <i class="fas fa-plus"></i>&nbsp;Nowe Zgłoszenie
                        </a>
                    </div>
                    <div class="border-top mt-4 mb-2 otus-separator"></div>
                {/if}
                <div class="form-group">
                    <label for="txtfilterklient">Klient</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilterklient' class="form-control" aria-describedby="clientHelp">
                    <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj nazwę
                        klient.</small>
                </div>
                <div class="form-group">
                    <label for="txtfilternrseryjny">Nr seryjny</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilternrseryjny' class="form-control" aria-describedby="modelHelp"
                           value="{if isset($get_data) && isset($get_data.filternrseryjny)}{$get_data.filternrseryjny}{/if}">
                    <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj numer
                        seryjny.</small>
                </div>
                <div class="form-group">
                    <label for="txtfilternrzlecenia">Nr zlecenia</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilternrzlecenia' class="form-control" aria-describedby="modelHelp">
                    <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj numer
                        zlecenia.</small>
                </div>
                <div class="w-100"></div>
                <div class="form-group">
                    <label for="txtfilterdataod">Data od</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilterdataod' class="form-control" aria-describedby="modelHelp">
                    <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę
                        początkową.</small>
                </div>
                <div class="form-group">
                    <label for="txtfilterdatado">Data do</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilterdatado' class="form-control" aria-describedby="modelHelp">
                    <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę
                        końcową.</small>
                </div>

                {foreach from=$statusZgloszenie item=item key=key}
                    {*
                       TR NOTE: this is kind of work arround to not show closed option for 'service' group
                                see also nottification->createFilter where we use the same condition,
                                it should be changed to something more readable ...
                     *}
                    {if !array_key_exists('widok_przypisane', $smarty.session.przypisanemenu) || $item.nazwa != 'Zamknięte' }
                        <div class="form-group mt-4">
                            <input name='txtstatus' type="checkbox" id='txtstatus{$item.rowid}'
                                   {if $item.czydefault=='1' || (isset($get_data) && isset($get_data.showall))}checked{/if} aria-describedby="txtstatus{$item.rowid}Help">
                            <label for='txtstatus{$item.rowid}'>
                                {$item.nazwa}
                            </label>
                            <small id="txtstatus{$item.rowid}Help" class="form-text text-muted"><i
                                        class="fa fa-info-circle"></i> Pokaż zlecenia {$item.nazwa|lower} </small>
                        </div>
                    {/if}
                {/foreach}

                <div class="border-top my-4 otus-separator"></div>

                <div class="form-group">
                    <button class="btn btn-info btn-block" type="submit"
                            onClick="showListOfNotifications();return false;">
                        Filtruj
                    </button>
                </div>

            </form>
        </div>

        <main id='divRightCenter' class="col-12 col-md-12 col-xl">

        </main>

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

