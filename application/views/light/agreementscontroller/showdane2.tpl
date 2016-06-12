
<table class='tablesorter displaytable' id='tableUmowy' cellspacing=0 cellpadding=0>
    <thead>
        <tr>
             <th style='min-width: 50px;width:50px;'>
                Lp
            </th >
            <th style='min-width: 115px;width:115px;'>
                nr umowy
            </th >
        
            <th style='min-width: 155px;width:155px;'>
                klient
            </th>
            <th style='min-width: 115px;width:115px;'>
                drukarka
            </th>
         
            
             <th style='min-width: 30px;width:30px;text-align: center;' titla="1-tak; 0-nie">
                aktywna
            </th>
          
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
                     
                    <td class='tdLink' >{$item.nazwakrotka|escape:'htmlall'}</td>
                    <td class='tdLink' >{$item.serial|escape:'htmlall'}</td>
                  
                  
                    <td class='tdNumber'>{$item.activity}</td>
                   
                </tr>
            {/foreach}


    </tbody>    
        
</table>
       