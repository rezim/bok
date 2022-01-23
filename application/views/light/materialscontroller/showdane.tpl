<div class="table-responsive-sm">
    <table class='table table-hover table-sm' id='materialsTable'>
        <thead class="thead-dark">
        <tr>
            <th>
                #
            </th>
            <th>
                nazwa krótka
            </th>
            <th>
                ilość umów
            </th>
            <th>
                bilans czarny
            </th>
            <th>
                bilans magenta
            </th>
            <th>
                bilans cyan
            </th>
            <th>
                bilans yellow
            </th>
            <th>

            </th>
        </tr>
        </thead>
        <tbody>

        {foreach from=$dataMaterials item=item key=key name=loopek}
            <tr onclick="$('#agreementsRow_{$key}').toggle()">
                <td scope="row">
                    {$smarty.foreach.loopek.index+1}</td>
                <td>{$item.clientName|escape:'htmlall'}</td>
                <td>{$item.agreementCount|escape:'htmlall'}</td>
                <td>{$item.blackCount|escape:'htmlall'}</td>
                <td>{$item.cyanCount|escape:'htmlall'}</td>
                <td>{$item.magentaCount|escape:'htmlall'}</td>
                <td>{$item.yellowCount|escape:'htmlall'}</td>

                <td>
                    <div class="dropdown show">
                        <button class="btn border border-secondary dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <i class="fas fa-cog"></i>
                        </button>
                        {*                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">*}
                        {*                                <a class="dropdown-item" href="#" onClick='showNewClientAdd("{$item.rowid}")'><i*}
                        {*                                            class="fas fa-edit"></i>&nbsp;&nbsp;Edycja</a>*}
                        {*                                <div class="border-top my-1"></div>*}
                        {*                                <a class="dropdown-item" href="#" onClick='showDrukarkiDoKlienta("{$item.rowid}")'><i*}
                        {*                                            class="fas fa-print"></i>&nbsp;&nbsp;&nbsp;Urządzenia klienta</a>*}
                        {*                                <a class="dropdown-item" href="#" onClick='showUmowyDoKlienta("{$item.rowid}")'><i*}
                        {*                                            class="far fa-handshake"></i>&nbsp;&nbsp;Umowy klienta</a>*}
                        {*                                <div class="border-top my-1"></div>*}
                        {*                                <a class="dropdown-item text-danger" href="#" onClick='usunKlienta("{$item.rowid}")'>*}
                        {*                                    <i class="fas fa-user-times"></i>&nbsp;&nbsp;Usuń Klienta</a>*}
                        {*                            </div>*}
                    </div>
                </td>

            </tr>
            <tr id="agreementsRow_{$key}" class="agreementsRow bg-light" style="display: none">
                <td colspan="8" class="p-5">
                    <table class='table table-hover table-sm pt-1 pb-1 pl-5 pr-5'>
                        <thead class="thead-light">
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                numer umowy
                            </th>
                            <th>
                                ilość zdarzeń
                            </th>
                            <th>
                                bilans czarny
                            </th>
                            <th>
                                bilans magenta
                            </th>
                            <th>
                                bilans cyan
                            </th>
                            <th>
                                bilans yellow
                            </th>
                            <th>

                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach from=$item.agreements item=agreement key=agreementKey name=agreementsLoop}
                            <tr onclick="$('#eventRow_{$key}_{$agreementKey}').toggle()">
                                <td>{$smarty.foreach.agreementsLoop.index+1}</td>
                                <td>{$agreement.agreementNb|escape:'htmlall'}</td>
                                <td>{$agreement.eventsCount|escape:'htmlall'}</td>
                                <td>{$agreement.blackCount|escape:'htmlall'}</td>
                                <td>{$agreement.magentaCount|escape:'htmlall'}</td>
                                <td>{$agreement.cyanCount|escape:'htmlall'}</td>
                                <td>{$agreement.yellowCount|escape:'htmlall'}</td>
                                <td></td>
                            </tr>
                            <tr id="eventRow_{$key}_{$agreementKey}" style="display: none">

                                <td colspan="8" class="p-3">
                                    <table class='table inner-table table-hover table-sm pt-3 pb-3 pl-5 pr-5'>
                                        <thead>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                data
                                            </th>
                                            <th>
                                                serial
                                            </th>
                                            <th>
                                                bilans czarny
                                            </th>
                                            <th>
                                                bilans magenta
                                            </th>
                                            <th>
                                                bilans cyan
                                            </th>
                                            <th>
                                                bilans yellow
                                            </th>
                                            <th>
                                                typ
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {foreach from=$agreement.events item=event key=eventKey name=eventsLoop}
                                            <tr class="{if $event.eventType === 2}text-danger{else}text-success{/if}" onclick="editNotification('{$event.eventId}')" style="cursor: pointer">
                                                <td>{$smarty.foreach.eventsLoop.index+1}</td>
                                                <td>{$event.eventDate|escape:'htmlall'}</td>
                                                <td>{$event.deviceId|escape:'htmlall'}</td>
                                                <td>{$event.blackCount|escape:'htmlall'}</td>
                                                <td>{$event.magentaCount|escape:'htmlall'}</td>
                                                <td>{$event.cyanCount|escape:'htmlall'}</td>
                                                <td>{$event.yellowCount|escape:'htmlall'}</td>
                                                <td>{if $event.eventType === 2}wysyłka{else}zwrot{/if}</td>
                                            </tr>
                                        {/foreach}
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </td>
            </tr>
        {/foreach}
        </tbody>

    </table>
</div>

<script type="text/javascript">
    $(".clientRow").click(function () {
        console.log($(this));
        $(this).toggle();
    });
</script>
