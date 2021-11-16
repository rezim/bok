<table id='tableform' class='tableform' cellspacing=0 cellpadding=0>

    <tr>
        <td class='tdOpis'>
            Nazwa
        </td>
        <td class='tdWartosc'>
            <input type="text" id='txtname'
                   class='textBoxForm' maxlength="150" style='width:300px;min-width:300px;'
                   {if isset($rowid) && $rowid!=0}value="{$dataConsumables[0].name|escape:'htmlall'}"{/if}>
        </td>
    </tr>
    <tr>
        <td style='height:3px;min-height: 3px;' colspan=2></td>
    </tr>

    <tr>
        <td class='tdOpis'>
            Model
        </td>
        <td class='tdWartosc'>
            <select id='txtmodel' class="comboboxForm" style='width:300px;min-width:300px;'>
                <option value="" selected></option>
                {foreach from=$dataPrinterModels item=item key=key}
                    <option value="{$item.model}"
                            {if isset($rowid) && $rowid!=0 && $dataConsumables[0].model==$item.model}selected{/if}>
                        {$item.model}
                    </option>
                {/foreach}
            </select>
        </td>
    </tr>
    <tr>
        <td style='height:3px;min-height: 3px;' colspan=2></td>
    </tr>

    <tr>
        <td class='tdOpis'>
            Cena
        </td>
        <td class='tdWartosc'>
            <input type="text" id='txtprice'
                   class='textBoxForm' maxlength="150" style='width:300px;min-width:300px;'
                   {if isset($rowid) && $rowid!=0}value="{$dataConsumables[0].price|escape:'htmlall'}"{/if}>
        </td>
    </tr>
    <tr>
        <td style='height:3px;min-height: 3px;' colspan=2></td>
    </tr>

    <tr>
        <td class='tdOpis'>
            Wydajność
        </td>
        <td class='tdWartosc'>
            <input type="text" id='txtyield'
                   class='textBoxForm' maxlength="150" style='width:300px;min-width:300px;'
                   {if isset($rowid) && $rowid!=0}value="{$dataConsumables[0].yield|escape:'htmlall'}"{/if}>
        </td>
    </tr>
    <tr>
        <td style='height:3px;min-height: 3px;' colspan=2></td>
    </tr>

    <tr>
        <td style='text-align: right;' colspan="2">
            <div class='divSave'>
                <div id='actionerror' class='actionerror'><span>Błąd zapisu danych.</span></div>
                <div id='actionok' class='actionok'><span style='margin-top:6px;'>Dane zapisane poprawnie</span></div>
                <div id='actionbuttonclick' class="actionbuttonZapisz"
                     {if isset($rowid) && $rowid!=0}onmousedown='saveConsumable("{$rowid}");return false;'
                     {else}onmousedown='saveConsumable("0");return false;'
                        {/if}
                >
                    <span>Zapisz</span>
                </div>
                <div id='actionloader' class="actionloader">
                    <img src="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/smallLoader.GIF"
                         style='display:inline;'/>przetwarzanie
                </div>
                <div style='clear:both'></div>
            </div>
        </td>
    </tr>
</table>