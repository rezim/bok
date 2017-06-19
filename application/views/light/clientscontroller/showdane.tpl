
<table class='tablesorter displaytable' id='tableClient'>
    <thead>
        <tr>
            <th>
                Lp
            </th >
            <th>
                nazwa krótka
            </th >
            <th>
                kod/miasto
            </th>
            <th>
                adres
            </th>
            <th>
                nip
            </th>
            <th>
                telefon
            </th>
            {if $czycolorbox==''}
            <th>
                umowy
            </th>
            <th>
                drukarki
            </th>
            <th>
            </th>
            {/if}
        </tr>
    </thead>
    <tbody>

            {foreach from=$dataClient item=item key=key name=loopek}
                <tr
                    {if $czycolorbox=='1'}
                        style='cursor:hand;cursor:pointer;'
                          onClick="
                            $('#idclientspan').html('{$item.rowid}');
                            $('#rowid_client').val('{$item.nazwakrotka}');
                            if($('#email').val()=='')
                            {
                                $('#email').val('{$item.mail}');
                            }
                            $.colorbox.close();
                        "
                    {/if}
                    >
                    <td>{$smarty.foreach.loopek.index+1}</td>
                    <td>{$item.nazwakrotka|escape:'htmlall'}</td>
                    <td>{$item.kodpocztowy|escape:'htmlall'} {$item.miasto|escape:'htmlall'}</td>
                    <td>{$item.ulica|escape:'htmlall'}</td>
                    <td>{$item.nip|escape:'htmlall'}</td>
                    <td>{$item.telefon|escape:'htmlall'}</td>
                        {if $czycolorbox==''}    
                    <td class='tdLink' style='text-align:center;' onClick='showUmowyDoKlienta("{$item.rowid}")'>{$item.drukumowy|escape:'htmlall'}</td>
                    <td class='tdLink' style='text-align:center;' onClick='showDrukarkiDoKlienta("{$item.rowid}")'>{$item.drukumowy|escape:'htmlall'}</td>
                    <td style='text-align:right;'>
                
                        <img wymaganylevel='w' wymaganyzrobiony='0' class='imgAkcja imgedit' onClick='showNewClientAdd("{$item.rowid}")' src='{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/fake.png' alt="Edycja" title='Edycja' />
                        
                        
                    </td>
                    {/if}
                </tr>
            {/foreach}


    </tbody>    
        
</table>
           