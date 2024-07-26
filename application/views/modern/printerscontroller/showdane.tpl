<div class="container-fluid">
    <div class="table-responsive">

        {if isset($isEmptyMessage)}{$isEmptyMessage}{else}
            <table class='table table-hover table-sm tablesorter'>
                <thead class="thead-dark">
                <tr>
                    {foreach $columnNames as $columnName}
                        <th>{$columnName}</th>
                    {/foreach}
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                {foreach $data as $rowData}
                    <tr>
                        {foreach $rowData as $colData}
                            <td>{$colData}</td>
                        {/foreach}
                        <td>...</td>
                    </tr>
                {/foreach}
                <tfoot>
                <tr class="table-dark">
                    {foreach $columnSummaries as $columnSummary}
                        <th>{if $columnSummary > 0}{$columnSummary}{else}-{/if}</th>
                    {/foreach}
                </tr>
                </tfoot>
                </tbody>
            </table>
        {/if}


{*        <table class="table table-striped table-sm fs-9 mb-0" id="tablePrinter">*}
{*            <thead>*}
{*            <tr>*}
{*                <th>#</th>*}
{*                <th class="sort ps-3" data-sort="serial">Serial</th>*}
{*                <th class="sort" data-sort="model">Model</th>*}
{*                <th class="text-right sort" data-sort="czarne">Czarne</th>*}
{*                <th class="text-center sort" data-sort="kolorowe">Kolorowe</th>*}
{*                {if !$czycolorbox}*}
{*                    <th class="sort" data-sort="nrumowy">Nr umowy</th>*}
{*                    <th class="sort" data-sort="klient">Klient</th>*}
{*                {/if}*}
{*                <th class="sort" data-sort="datamail">Data mail</th>*}
{*                {if !$czycolorbox}*}
{*                    <th class="text-end align-middle pe-0">ACTION</th>*}
{*                {/if}*}
{*            </tr>*}
{*            </thead>*}
{*            <tbody class="list">*}
{*            {foreach from=$dataPrinters item=item key=key name=loopek}*}
{*                <tr {if $czycolorbox}*}
{*                    class="selectable-row"*}
{*                    data-source="devices"*}
{*                    data-modalselector="{$czycolorbox}"*}
{*                    data-serial="{$item.serial}"*}
{*                    data-clientname="{$item.nazwaklient}"*}
{*                    data-clientid="{$item.rowidclient}"*}
{*                    data-agreementnb="{$item.nrumowy}"*}
{*                    data-agreementid="{$item.rowidumowa}"*}
{*                    data-sla="{{$item.sla}}"*}
{*                    onclick="dataRowSelectedHandler(this); return false;"*}
{*                        {/if}>*}
{*                    <th scope="row">{$smarty.foreach.loopek.index+1}</th>*}
{*                    <td>{$item.serial|escape:'htmlall'}</td>*}
{*                    <td>{$item.model|escape:'htmlall'}</td>*}
{*                    <td class="text-right">*}
{*                        {if !isset($item.cnt_iloscstron) || $item.cnt_iloscstron==0}0{else}{$item.cnt_iloscstron|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}{/if}*}
{*                    </td>*}
{*                    <td class="text-right">*}
{*                        {if !isset($item.cnt_iloscstron_kolor) || $item.cnt_iloscstron_kolor==''}{else}{$item.cnt_iloscstron_kolor|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}{/if}*}
{*                    </td>*}
{*                    {if $czycolorbox==''}*}
{*                        <td onClick='showNewAgreementAdd("{$item.rowidumowa}")'>{$item.nrumowy|escape:'htmlall'}</td>*}
{*                        <td {if !empty($item.nazwaklient)}onClick='showNewClientAdd("{$item.rowidclient}")'{/if}>{$item.nazwaklient|escape:'htmlall'}</td>*}
{*                    {/if}*}
{*                    <td {if (!empty($item.cnt_datawiadomosci) && ($item.cnt_datawiadomosci|date_format:"%Y-%m-%d")<($smarty.now|date_format:"%Y-%m-%d"))}class="bg-warning text-light"{/if}>*}
{*                        {if (!empty($item.cnt_datawiadomosci))}*}
{*                            {assign var="dateTime" value=" "|explode:$item.cnt_datawiadomosci}*}
{*                            {$dateTime[0]|escape:'htmlall'}*}
{*                            <br/>*}
{*                            <small>{$dateTime[1]|escape:'htmlall'}</small>*}
{*                        {/if}*}
{*                    </td>*}
{*                    {if $czycolorbox==''}*}
{*                        <td class="text-end pe-0">*}
{*                            <div class="btn-reveal-trigger position-static">*}
{*                                <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">*}
{*                                    <i class="fas fa-ellipsis"></i>*}
{*                                </button>*}
{*                                <div class="dropdown-menu dropdown-menu-end py-2">*}
{*                                    <a class="editAction dropdown-item" href="#" onclick="onAddEditAction('{$item.serial}')"><i class="fas fa-edit"></i>&nbsp;&nbsp;Edycja</a>*}
{*                                    <div class="my-1"></div>*}
{*                                    <a href="javascript:void(0)" class="dropdown-item" onClick="showPrinterMessages('{$item.serial}', '{$item.model}')"><i class="fas fa-comment-dots"></i>&nbsp;&nbsp;Notatki</a>*}
{*                                    <a class="dropdown-item" href="#" onClick='pokazLogi("{$item.serial}")'><i class="fas fa-history"></i>&nbsp;&nbsp;Logi</a>*}
{*                                    <a class="dropdown-item" href="#" onClick='historiaTonerow("{$item.serial}")'>Historia Tonerów</a>*}
{*                                    <a class="dropdown-item" href="#" onClick='historiaTonerow("{$item.serial}")'>Historia Serwisu</a>*}
{*                                    <a class="dropdown-item text-danger" href="#" onClick='usunDrukarke("{$item.serial}")'>*}
{*                                        <i class="fas fa-print"></i><span class="font-weight-bold f">x</span>&nbsp;Usuń Urządzenie</a>*}
{*                                </div>*}
{*                            </div>*}
{*                        </td>*}
{*                    {/if}*}
{*                </tr>*}
{*            {/foreach}*}
{*            </tbody>*}
{*        </table>*}
    </div>
</div>
