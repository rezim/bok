
<table class='tablesorter displaytable' id='tableToner' cellspacing=0 cellpadding=0>
    <thead>
        <tr>
            <th style='min-width: 115px;width:115px;'>
                serial drukarka
            </th >
            <th style='min-width: 100px;width:100px;'>
                serial
            </th>
            <th style='min-width: 50px;width:50px;'>
                typ
            </th>
            <th style='min-width: 70px;width:70px;'>
                number
            </th>
            <th style='min-width: 120px;width:120px;'>
                opis
            </th>
            <th style='min-width: 70px;width:70px;'>
                data instalacji
            </th>
            <th style='min-width: 70px;width:70px;'>
                pozostało
            </th>
            <th style='min-width: 90px;width:90px;'>
                strona max / stron pozos.
            </th>
              <th style='min-width: 70px;width:70px;'>
                ostatnie użycie
            </th>
            {if isset($czyhistoria) && $czyhistoria==1}
                <th style='min-width: 90px;width:90px;'>
                    licznik start<br/>licznikkoniec
                </th>
            {/if}
         <th style='min-width: 60px;width:60px;'>
                
            </th>
        </tr>
    </thead>
    <tbody>

            {foreach from=$dataToners item=item key=key}
                <tr>
                    <td title='{$item.model}--{$item.nazwakrotka}'>{$item.serialdrukarka|escape:'htmlall'}</td>
                    <td>{$item.serial|escape:'htmlall'} </td>
                    <td style='color:{$item.typ}'>{$item.typ|escape:'htmlall'} </td>
                    <td>{$item.number|escape:'htmlall'}</td>
                    <td>{$item.description|escape:'htmlall'}</td>
                    <td>{$item.datainstalacji|escape:'htmlall'}</td>
                     <td class='tdNumber' style='padding-right:20px;'>
                        {$item.procentpozostalo|number_format:2:",":" "|replace:',00':''|escape:'htmlall'} %
                    </td>
                    <td class='tdNumber' style='padding-right:20px;'>
                        {$item.stronmax|escape:'htmlall'}<br/>{$item.stronpozostalo|escape:'htmlall'}
                    </td>
                   
                    <td>{$item.ostatnieuzycie|escape:'htmlall'}</td>
                    {if isset($czyhistoria) && $czyhistoria==1}
                        <td class='tdNumber' style='padding-right:20px;'>
                            {$item.licznikstart|number_format:0:",":" "|escape:'htmlall'}<br/>
                            {$item.licznikkoniec|number_format:0:",":" "|escape:'htmlall'}
                        </td>
                    {/if}
                    <td style='text-align:right;'>
                        <img wymaganylevel='w' wymaganyzrobiony='0'  class='imgAkcja imgedit' onClick='showNewTonerAdd("{$item.rowid}","{$item.typ}")' src='{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/fake.png' alt="Edycja" title='Edycja' />
                        <img wymaganylevel='w' wymaganyzrobiony='0'  class='imgAkcja imgusun' onClick='usunToner("{$item.rowid}","{$item.typ}")' src='{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/fake.png' alt="Usuń klienta" title='Usuń toner' />
                    </td>
                </tr>
                
            {/foreach}
    </tbody>    
        
</table>
    <br/><br/>