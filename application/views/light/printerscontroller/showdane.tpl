<div class="table-responsive-sm">
    <table class='table table-hover table-sm' id='tablePrinter'>
        <thead class="thead-dark">
        <tr>
            <th>
                #
            </th>
            <th>
                serial
            </th>
            <th>
                model
            </th>
            <th class="text-right">
                black
            </th>
            <th class="text-center">
                color
            </th>
            {if !$czycolorbox}
                <th>
                    nr umowy
                </th>
                <th>
                    klient
                </th>
            {/if}
            <th>
                data mail
            </th>
            {if !$czycolorbox}
                <th>
                </th>
            {/if}
        </tr>
        </thead>
        <tbody>
        {foreach from=$dataPrinters item=item key=key name=loopek}
            <tr {if $czycolorbox}
                class="selectable-row"
                data-source="devices"
                data-modalselector="{$czycolorbox}"
                data-serial="{$item.serial}"
                data-clientname="{$item.nazwaklient}"
                data-clientid="{$item.rowidclient}"
                data-agreementnb="{$item.nrumowy}"
                data-agreementid="{$item.rowidumowa}"
                data-sla="{{$item.sla}}"
                onclick="dataRowSelectedHandler(this); return false;"
                    {/if}>
                <th scope="row">{$smarty.foreach.loopek.index+1}</th>
                <td>{$item.serial|escape:'htmlall'}</td>
                <td>{$item.model|escape:'htmlall'} </td>
                <td class="text-right">
                    {if !isset($item.cnt_iloscstron) || $item.cnt_iloscstron==0}0{else}{$item.cnt_iloscstron|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}{/if}
                </td>
                <td class="text-right">
                    {if !isset($item.cnt_iloscstron_kolor) || $item.cnt_iloscstron_kolor==''}{else}{$item.cnt_iloscstron_kolor|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}{/if}</td>
                {if $czycolorbox==''}
                    <td onClick='showNewAgreementAdd("{$item.rowidumowa}")'>{$item.nrumowy|escape:'htmlall'}</td>
                    <td {if !empty($item.nazwaklient)}onClick='showNewClientAdd("{$item.rowidclient}")'{/if}>{$item.nazwaklient|escape:'htmlall'}</td>
                {/if}
                <td
                        {if (!empty($item.cnt_datawiadomosci) && ($item.cnt_datawiadomosci|date_format:"%Y-%m-%d")<($smarty.now|date_format:"%Y-%m-%d"))}class="bg-danger text-light" {/if}
                >
                    {if (!empty($item.cnt_datawiadomosci))}
                        {assign var="dateTime" value=" "|explode:$item.cnt_datawiadomosci}
                        {$dateTime[0]|escape:'htmlall'}<br />
                        <small>{$dateTime[1]|escape:'htmlall'}</small>
                    {/if}
                </td>
                {if $czycolorbox==''}
                    <td>
                        <div class="dropdown show">
                            <button class="btn border border-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#" onClick='showNewPrinterAdd("{$item.serial}")'><i
                                            class="fas fa-edit"></i>&nbsp;&nbsp;Edycja</a>
                                <div class="border-top my-1"></div>

                                <a href="javascript:void(0)" class="dropdown-item"
                                   onClick="showPrinterMessages('{$item.serial}', '{$item.model}')"><i
                                            class="fas fa-comment-dots"></i>&nbsp;&nbsp;notatki</a>

                                <a class="dropdown-item" href="#" onClick='pokazLogi("{$item.serial}")'><i
                                            class="fas fa-history"></i>&nbsp;&nbsp;Logi</a>
                                <a class="dropdown-item" href="#" onClick='historiaTonerow("{$item.serial}")'>Historia
                                    Tonerów</a>
                                <a class="dropdown-item" href="#" onClick='historiaTonerow("{$item.serial}")'>Historia
                                    Serwisu</a>
                                <a wymaganylevel='w' wymaganyzrobiony='0' class="dropdown-item text-danger" href="#"
                                   onClick='usunDrukarke("{$item.serial}")'>
                                    <i class="fas fa-print"></i><span class="font-weight-bold f">x</span>&nbsp;Usuń
                                    Urządzenie</a>
                            </div>
                        </div>
                    </td>
                {/if}
            </tr>
        {/foreach}
        </tbody>

    </table>
</div>