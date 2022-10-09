
    <div class="container-fluid">
        {if $messages|@count > 0}
            <div class="row header">
                <div class="col-sm-2">Data</div>
                <div class="col-sm-6">Wiadomość</div>
                <div class="col-sm-3">Pracownik</div>
                <div class="col-sm-1"></div>
            </div>
            {foreach from=$messages item=item key=key}
            <div class="row messages">
                <div class="col-sm-2" role="button">
                    {$item.message_date}<br/>
                    <small>{$item.created}</small>
                </div>
                <div class="col-sm-6" role="button">{$item.message}</div>
                <div class="col-sm-3" role="button">{$item.imie} {$item.nazwisko}</div>
                <div class="col-sm-1" role="button">
                    <span class="action fa fa-times fa-3" onclick="removeMessage({$item.rowid}, {$type}, '{$foreignkey}', '{$containerId}')"></span>
                </div>
            </div>
            {/foreach}
        {else}
        <div class="row header text-muted">
            <div class="text-left"><i class="fa fa-info-circle text-muted"></i> Na chwilę obecną nie ma żadnych notatek.</div>
        </div>
        {/if}
    </div>
