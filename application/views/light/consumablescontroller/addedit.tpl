<table id='consumableAddEdit' class='tableform' cellspacing=0 cellpadding=0>

    <tr>
        <td style='text-align: right;' colspan="2">
            <div id='actionerror' class='actionerror'><span>Błąd zapisu danych.</span></div>
            <div id='actionok' class='actionok'><span style='margin-top:6px;'>Dane zapisane poprawnie</span></div>
        </td>
    </tr>

    <tr>
        <td class='tdOpis'>
            Kod Produktu
        </td>
        <td class='tdWartosc'>
            <input type="text" id='txtcode'
                   class='textBoxForm' maxlength="150" style='width:300px;min-width:300px;'
                   {if isset($dataConsumables)}value="{$dataConsumables.code|escape:'htmlall'}"{/if}>
        </td>
    </tr>
    <tr>
        <td style='height:3px;min-height: 3px;' colspan=2></td>
    </tr>

    <tr>
        <td class='tdOpis'>
            Nazwa
        </td>
        <td class='tdWartosc'>
            <input type="text" id='txtname'
                   class='textBoxForm' maxlength="150" style='width:300px;min-width:300px;'
                   {if isset($dataConsumables)}value="{$dataConsumables.name|escape:'htmlall'}"{/if}>
        </td>
    </tr>
    <tr>
        <td style='height:3px;min-height: 3px;' colspan=2></td>
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
                   {if isset($dataConsumables)}value="{$dataConsumables.price|escape:'htmlall'}"{/if}>
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
                   {if isset($dataConsumables)}value="{$dataConsumables.yield|escape:'htmlall'}"{/if}>
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
            <select id='txtmodel' multiple class="selectpicker" data-size="10"
                    data-width="300px"
                    data-none-selected-text="Nie wybrano żadnego modelu"
                    data-none-results-text="Nie znaleziono wyników dla podanego filtra"
                    data-live-search-placeholder="Wpisz filtr aby zawęzić opcje"
                    data-live-search="true">
                {foreach from=$dataPrinterModels item=item key=key}
                    <option value="{$item.model}"
                            {if isset($dataConsumables) && $item.model|in_array:$dataConsumables.models}selected{/if}>
                        {$item.model}
                    </option>
                {/foreach}
            </select>
        </td>
    </tr>
</table>

<div class="container text-right" style="position: absolute; bottom: 15px;">
    <a href="#" class="btn btn-outline-success active" role="button" aria-pressed="true"
       onmousedown='saveConsumable("{if isset($dataConsumables)}{$dataConsumables.rowid}{/if}");return false;'><i
                class="fas fa-save"></i>&nbsp; Zapisz</a>
    <a href="#" class="btn btn-outline-secondary" role="button" onclick="$.colorbox.close();">Anuluj</a>
</div>

<script type="text/javascript">
    $('.selectpicker').selectpicker();
</script>