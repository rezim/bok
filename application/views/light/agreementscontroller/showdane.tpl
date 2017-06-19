
<table class='tablesorter displaytable table table-striped' id='tableUmowy'>
    <thead>
        <tr>
             <th style='min-width: 50px;width:50px;'>
                Lp
            </th >
            <th style='min-width: 115px;width:115px;'>
                nr umowy
            </th >
             {if $czycolorbox==''}  
            <th style='min-width: 155px;width:155px;'>
                klient
            </th>
            <th style='min-width: 115px;width:115px;'>
                drukarka
            </th>
            {/if}
            <th wymaganylevel='w' wymaganyzrobiony='0' style='min-width: 75px;width:75px;'>
                data od
            </th>
            <th wymaganylevel='w' wymaganyzrobiony='0'  style='min-width: 75px;width:75px;'>
                data do
            </th>
            <th wymaganylevel='w' wymaganyzrobiony='0'  style='min-width: 65px;width:65px;text-align: center;'>
                stron <br/> abonam.
            </th>
            <th wymaganylevel='w' wymaganyzrobiony='0'  style='min-width: 65px;width:65px;text-align: center;'>
                cena <br/> strona
            </th>
            <th wymaganylevel='w' wymaganyzrobiony='0'  style='min-width: 65px;width:65px;text-align: center;'>
                rozliczenie
            </th>
            <th wymaganylevel='w' wymaganyzrobiony='0'  style='min-width: 65px;width:65px;text-align: center;'>
                abonament
            </th>
             <th style='min-width: 30px;width:30px;text-align: center;' titla="1-tak; 0-nie">
                aktywna
            </th>
            {if $czycolorbox==''}  
            <th style='min-width: 75px;width:75px;'>
            </th>
            {/if}
        </tr>
    </thead>
    <tbody>

            {foreach from=$dataAgreements item=item key=key name=loopek}
                <tr
                     {if $czycolorbox=='1'}
                        style='cursor:hand;cursor:pointer;'
                          onClick="
                            $('#idumowaspan').html('{$item.rowid}');
                            $('#rowid_agreements').val('{$item.nrumowy}');
                            $('#sla').val('{$item.sla}');
                            $.colorbox.close();
                        "
                    {/if}
                    >
                      <td>{$smarty.foreach.loopek.index+1}</td>
                    <td>{$item.nrumowy|escape:'htmlall'}</td>
                     {if $czycolorbox==''}  
                    <td class='tdLink' onClick='showNewClientAdd("{$item.rowidclient}")'>{$item.nazwakrotka|escape:'htmlall'}</td>
                    <td class='tdLink' onClick='showNewPrinterAdd("{$item.serial}")'>{$item.serial|escape:'htmlall'}</td>
                    {/if}
                    <td wymaganylevel='w' wymaganyzrobiony='0' >{$item.dataod|escape:'htmlall'}</td>
                    <td wymaganylevel='w' wymaganyzrobiony='0' 
                         {if ($item.datado|date_format:"%Y-%m")==($smarty.now|date_format:"%Y-%m")}style='background-color:red'{/if}
                        >
                        {$item.datado|escape:'htmlall'}
                    </td>
                    <td wymaganylevel='w' wymaganyzrobiony='0'  class='tdNumber'>{$item.stronwabonamencie|number_format:2:",":" "|replace:',00':''}
                    </td>
                    <td wymaganylevel='w' wymaganyzrobiony='0'  class='tdNumber'>{$item.cenazastrone|number_format:3:",":" "|replace:',00':''|escape:'htmlall'}
                    </td>    
                    <td wymaganylevel='w' wymaganyzrobiony='0'  class='tdNumber'>{$item.rozliczenie|escape:'htmlall'}</td>
                    <td wymaganylevel='w' wymaganyzrobiony='0'  class='tdNumber'>{if !empty($item.abonament)}{$item.abonament|number_format:2:",":" "|replace:',00':''|escape:'htmlall'}{/if}
                    </td>  
                    <td class='tdNumber'>{$item.activity}</td>
                    {if $czycolorbox==''}  
                    <td style='text-align: right;'>
                         
                        <img wymaganylevel='r' wymaganyzrobiony='0' class='imgAkcja imgedit' onClick='showNewAgreementAdd("{$item.rowid}")' src='{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/fake.png' alt="Edycja" title='Edycja' />
                        {if !empty($item.serial)}
                            {if empty($item.blad)}
                            <img class='imgAkcja imgNormalLogs' onClick='pokazLogi("{$item.serial}")' src='{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/fake.png' alt="Usuń klienta" title='Pokaż logi' />    
                            {else}
                            <img class='imgAkcja imgIstniejeLogs' onClick='pokazLogi("{$item.serial}")' src='{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/fake.png' alt="Usuń klienta" title='Pokaż logi' />        
                            {/if}
                        {/if}
                        
                    </td>
                    {/if}
                </tr>
            {/foreach}


    </tbody>    
        
</table>
       