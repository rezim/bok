
<table class='tablesorter displaytable' id='tableReport' cellspacing=0 cellpadding=0>
    <thead>
        <tr>
            <th style='min-width: 105px;width:105px;'>
                umowa
            </th >
            <th style='min-width: 115px;width:115px;'>
                klient
            </th>
            <th style='min-width: 85px;width:85px;'>
                drukarka
            </th>
            <th style='min-width: 75px;width:75px;text-align: center;'>
                aktualny <br/>stan
            </th>
            <th style='min-width: 75px;width:75px;text-align: center;'>
                strony start<br/>
                data wczyt.
            </th>
            <th style='min-width: 90px;width:90px;text-align: center;'>
                strony koniec<br/>
                data wczyt.
            </th>
            <th style='min-width: 75px;width:75px;text-align: center;'>
                abonament
            </th>
            <th style='min-width: 75px;width:75px;text-align: center;'>
                stron<br/>powyżej
            </th>
            <th style='min-width: 75px;width:75px;text-align: center;'>
                netto
            </th>
        </tr>
    </thead>
    <tbody>

            {foreach from=$dataReports item=item key=key}
                <tr >
                    <td class='tdLink' style='vertical-align: top;' onClick='showNewAgreementAdd("{$item.rowidumowa}")'>{$item.nrumowy|escape:'htmlall'}</td>
                    <td class='tdLink' style='vertical-align: top;' onClick='showNewClientAdd("{$item.rowidclient}")'>{$item.nazwakrotka|escape:'htmlall'}</td>
                    <td class='tdLink' style='vertical-align: top;' onClick='showNewPrinterAdd("{$item.serial}")'>{$item.serial|escape:'htmlall'}</td>
                    <td class='tdNumber' style='padding-right:20px;vertical-align: top;'>
                    {if empty($item.currentiloscstron)}{else}{$item.currentiloscstron|number_format:0:",":" "|escape:'htmlall'}{/if}</td>
                    <td class='tdNumber' style='padding-right:20px;vertical-align: top;'>
                    {if empty($item.strony_start)}{else}{$item.strony_start|number_format:0:",":" "|escape:'htmlall'}<br/>{$item.data_wiadomosci_start|escape:'htmlall'}{/if}
                    </td>
                    <td class='tdNumber' style='padding-right:20px;vertical-align: top;'>
                    {if empty($item.strony_koniec)}{else}{$item.strony_koniec|number_format:0:",":" "|escape:'htmlall'}<br/>{$item.data_wiadomosci_koniec|escape:'htmlall'}{/if}</td>
                    <td class='tdNumber' style='padding-right:20px;vertical-align: top;'>
                    {if empty($item.stronwabonamencie)}{else}{$item.stronwabonamencie|number_format:0:",":" "|escape:'htmlall'}{/if}</td>
                    <td class='tdNumber' style='padding-right:20px;vertical-align: top;'>
                        {if !empty($item.strony_koniec) && !empty($item.strony_start) && !empty($item.stronwabonamencie)}
                                {if (($item.strony_koniec-$item.strony_start)-$item.stronwabonamencie)>=0}
                                    {(($item.strony_koniec-$item.strony_start)-$item.stronwabonamencie)|number_format:0:",":" "|escape:'htmlall'}
                                {else}
                                    0
                                {/if}
                        {/if}
                    </td>
                    <td class='tdNumber' style='padding-right:20px;vertical-align: top;'>
                        {if !empty($item.strony_koniec) && !empty($item.strony_start) && !empty($item.stronwabonamencie) && !empty($item.cenazastrone)}
                                {if (($item.strony_koniec-$item.strony_start)-$item.stronwabonamencie)>=0}
                                    {$item.abonament+((($item.strony_koniec-$item.strony_start)-$item.stronwabonamencie)*$item.cenazastrone)|number_format:2:",":" "|escape:'htmlall'}
                                {else}
                                    0
                                {/if}
                        {/if}
                    </td>
                </tr>
               
            {/foreach}


    </tbody>    
        
</table>