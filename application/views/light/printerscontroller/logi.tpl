
<table class='displaytable'  cellspacing=0 cellpadding=0 style='margin-top:10px;'>
    <thead>
        <tr>
            <th style='min-width: 50px;width:50px;'>
                Lp
            </th >
            <th style='min-width: 100px;width:100px;'>
                kod
            </th>
          
            <th style='min-width: 250px;width:250px;'>
                opis
            </th>
           
            <th style='min-width: 70px;width:70px;'>
                data
            </th>
            <th style='min-width: 100px;width:100px;'>
                stron
            </th>
            
        </tr>
    </thead>
    <tbody>

            {foreach from=$dataLogi item=item key=key}
                <tr>
                    <td>{$item.sequencenumber|escape:'htmlall'}</td>
                    <td>{$item.eventcode|escape:'htmlall'} </td>
                    
                    <td>{$item.description|escape:'htmlall'}</td>
                    <td>{$item.timestamp|escape:'htmlall'}</td>
                   
                    
                    <td class='tdNumber'>{$item.valuefloat|number_format:0:",":" "}</td>
                    
                </tr>
              
            {/foreach}


    </tbody>    
        
</table>