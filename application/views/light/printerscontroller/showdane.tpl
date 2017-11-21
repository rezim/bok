
<table class='tablesorter displaytable' id='tablePrinter' cellspacing=0 cellpadding=0>
    <thead>
        <tr>
             <th style='min-width: 15px;width:15px;'>
                Lp
            </th >
            <th style='min-width: 115px;width:115px;'>
                serial
            </th >
            <th style='min-width: 195px;width:195px;'>
                model
            </th>

            <th style='min-width: 85px;width:85px;'>
                lokalizacja
            </th>
            <th style='min-width: 55px;width:55px;'>
                toner
            </th>
            <!-- <th style='min-width: 70px;width:70px;'>
                fuser
            </th>-->
            <th style='min-width: 75px;width:75px;text-align: center;'>
                black
            </th>
            <th style='min-width: 70px;width:70px;text-align: center;'>
                color
            </th>
             {if $czycolorbox==''}    
            <th style='min-width: 85px;width:85px;'>
                nr umowy
            </th>
              <th style='min-width: 85px;width:85px;'>
                klient
            </th>
            {/if}
            <th style='min-width: 120px;width:120px;'>
                adres IP
            </th>
            <th style='min-width: 85px;width:85px;'>
                data mail
            </th>
            <th style='min-width: 80px;width:80px;'>
                
            </th>
        </tr>
    </thead>
    <tbody>

            {foreach from=$dataPrinters item=item key=key name=loopek}
                <tr
                     {if $czycolorbox=='1'}
                        style='cursor:hand;cursor:pointer;'
                          onClick="
                            $('#idserialspan').html('{$item.serial}');
                            $('#serial').val('{$item.serial}');
                            
                            $('#rowid_client').val('{$item.nazwaklient}');
                            $('#idclientspan').html('{$item.rowidclient}');
                            
                            $('#rowid_agreements').val('{$item.nrumowy}');
                            $('#idumowaspan').html('{$item.rowidumowa}');
                            
                            $('#sla').val('{$item.sla}');
                            
                            $.colorbox.close();
                        "
                    {/if}
                    >
                    <td>{$smarty.foreach.loopek.index+1}</td>
                    <td>{$item.serial|escape:'htmlall'}</td>
                    <td>{$item.model|escape:'htmlall'} </td>

                    <td align="center">
                        {if !empty($item.miasto)} {$item.miasto}{/if}
                    </td>


                    <td >
                        {if !empty($item.black_toner)}
                            {$item.black_toner|number_format:2:",":" "|replace:',00':''|escape:'htmlall'} %
                        {/if}

                            <img class='{if $item.type_color}imgColor{else}imgBlack{/if}' onClick='showTonersInfo("{$item.serial}");'
                                 src='{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/fake.png' />

                    </td>
                    <!-- <td class='tdNumber'>
                        {if !empty($item.stan_fuser)}
                            {$item.stan_fuser|number_format:2:",":" "|replace:',00':''|escape:'htmlall'} %
                        {/if}
                     </td>-->
                    <td class='tdNumber text-nowrap' style='padding-right:20px;'>{if $item.iloscstron==0}0{else}{$item.iloscstron|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}{/if}</td>
                    <td class='tdNumber text-nowrap' style='padding-right:20px;'>{if $item.iloscstron_kolor==''}{else}{$item.iloscstron_kolor|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}{/if}</td>
                     {if $czycolorbox==''}    
                    <td class='tdLink' onClick='showNewAgreementAdd("{$item.rowidumowa}")'>{$item.nrumowy|escape:'htmlall'}</td>
                    <td class='tdLink' {if !empty($item.nazwaklient)}onClick='showNewClientAdd("{$item.rowidclient}")'{/if}>{$item.nazwaklient|escape:'htmlall'}</td>
                    {/if}
                    <td class="text-center">
                        {$item.address_ip|escape:'htmlall'}
                    </td>
                    <td 
                        {if (!empty($item.datawiadomosci) && ($item.datawiadomosci|date_format:"%Y-%m-%d")<($smarty.now|date_format:"%Y-%m-%d"))}style='background-color:red'{/if}
                    >
                        {$item.datawiadomosci|escape:'htmlall'}
                    </td>
                    
                    <td style='text-align:right;'>
                         {if $czycolorbox==''}    
                        <img wymaganylevel='r' wymaganyzrobiony='0'  class='imgAkcja imgedit' onClick='showNewPrinterAdd("{$item.serial}")' src='{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/fake.png' alt="Edycja" title='Edycja' />
                        {if empty($item.blad)}
                        <img  class='imgAkcja imgNormalLogs' onClick='pokazLogi("{$item.serial}")' src='{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/fake.png' alt="Usuń klienta" title='Pokaż logi' />    
                        {else}
                        <img  class='imgAkcja imgIstniejeLogs' onClick='pokazLogi("{$item.serial}")' src='{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/fake.png' alt="Usuń klienta" title='Pokaż logi' />        
                        {/if}
                        <img wymaganylevel='w' wymaganyzrobiony='0' class='imgAkcja imgtonery' onClick='historiaTonerow("{$item.serial}")' src='{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/fake.png' alt="Pokaż historię tonerów" title='Pokaż historię tonerów' />
                        {/if}

                        <img class='imgAkcja' onclick='alert("nie zaimplementowane");' src='{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/fake.png' title='Pokaż Historię serwisu' /><!-- //showPrinterService("{ $ item.serial }") -->
                    </td>
                </tr>
                
                <tr id='tonertr{$item.serial}' style='display:none;' vis='0'>
                    <td colspan=12 id='tonertd{$item.serial}'>
                        
                    </td>
                </tr>    
                
            {/foreach}


    </tbody>    
        
</table>