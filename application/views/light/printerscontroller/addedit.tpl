<script type="text/javascript">
    {if isset($uprawnienia)}
    val2 = '{$uprawnienia}';
    {/if}
</script>
<div wymaganylevel='w' wymaganyzrobiony='0'>
    <table id='tableform' class='tableform' cellspacing=0 cellpadding=0>
        <tr>
            <td class='tdOpis'>
                Serial
            </td>
            <td class='tdWartosc'>
                <input data-ref type="text" id='txtserial' autofocus
                       class='textBoxForm' maxlength="50" style='width:120px;min-width:120px;'
                       {if $serial!=''}value="{$dataPrinter.serial|escape:'htmlall'}"{/if}>
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
                <input data-ref type="text" id='txtmodel'
                       class='textBoxForm' maxlength="100" style='width:200px;min-width:200px;'
                       {if $serial!=''}value="{$dataPrinter.model|escape:'htmlall'}"{/if}>
            </td>
        </tr>
        <tr>
            <td style='height:5px;min-height: 5px;' colspan=2></td>
        </tr>

        <tr>
            <td class='tdOpis'>
                Product number
            </td>
            <td class='tdWartosc'>
                <input data-ref type="text" id='txtproduct_number'
                       class='textBoxForm' maxlength="100" style='width:120px;min-width:120px;'
                       {if $serial!=''}value="{$dataPrinter.product_number|escape:'htmlall'}"{/if}>
            </td>
        </tr>
        <tr>
            <td style='height:5px;min-height: 5px;' colspan=2></td>
        </tr>

        <tr>
            <td class='tdOpis'>
                Nr firmware
            </td>
            <td class='tdWartosc'>
                <input data-ref type="text" id='txtnr_firmware'
                       class='textBoxForm' maxlength="100" style='width:120px;min-width:120px;'
                       {if $serial!=''}value="{$dataPrinter.nr_firmware|escape:'htmlall'}"{/if}>
            </td>
        </tr>
        <tr>
            <td style='height:5px;min-height: 5px;' colspan=2></td>
        </tr>


        <tr>
            <td class='tdOpis'>
                Data firmware
            </td>
            <td class='tdWartosc'>
                <input data-ref type="text" id='txtdate_firmware'
                       class='textBoxForm' maxlength="100" style='width:120px;min-width:120px;'
                       {if $serial!=''}value="{$dataPrinter.date_firmware|escape:'htmlall'}"{/if}>
            </td>
        </tr>
        <tr>
            <td style='height:5px;min-height: 5px;' colspan=2></td>
        </tr>


        <tr>
            <td class='tdOpis'>
                Ip
            </td>
            <td class='tdWartosc'>
                <input data-ref type="text" id='txtip'
                       class='textBoxForm' maxlength="100" style='width:120px;min-width:120px;'
                       {if $serial!=''}value="{$dataPrinter.address_ip|escape:'htmlall'}"{/if}>
            </td>
        </tr>
        <tr>
            <td style='height:5px;min-height: 5px;' colspan=2></td>
        </tr>

        <tr>
            <td class='tdOpis'>
                Stan fuser
            </td>
            <td class='tdWartosc'>
                <input data-ref type="text" id='txtstan_fuser'
                       class='textBoxForm' maxlength="100"
                       style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                       {if $serial!='' && !empty($dataPrinter.stan_fuser)}value="{$dataPrinter.stan_fuser|number_format:2:",":" "|replace:',00':''|escape:'htmlall'}"{/if}>
                %
            </td>
        </tr>
        <tr>
            <td style='height:5px;min-height: 5px;' colspan=2></td>
        </tr>

        <tr>
            <td class='tdOpis'>
                Stan ADF
            </td>
            <td class='tdWartosc'>
                <input data-ref type="text" id='txtstan_adf'
                       class='textBoxForm' maxlength="100"
                       style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                       {if $serial!='' && !empty($dataPrinter.stan_adf)}value="{$dataPrinter.stan_adf|number_format:2:",":" "|replace:',00':''|escape:'htmlall'}"{/if}>
                %
            </td>
        </tr>
        <tr>
            <td style='height:5px;min-height: 5px;' colspan=2></td>
        </tr>

        <tr>
            <td class='tdOpis'>
                Toner czarny
            </td>
            <td class='tdWartosc'>
                <input data-ref type="text" id='txtblack_toner'
                       class='textBoxForm' maxlength="100"
                       style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                       {if $serial!=''}value="{$dataPrinter.black_toner|number_format:2:",":" "|replace:',00':''|escape:'htmlall'}"{/if}>
                %
            </td>
        </tr>
        <tr>
            <td style='height:5px;min-height: 5px;' colspan=2></td>
        </tr>


        <tr>
            <td class='tdOpis'>
                Ilość stron black
            </td>
            <td class='tdWartosc' colspan="3">
                <input data-ref type="text" id='iloscstron'
                       class='textBoxForm' maxlength="100"
                       style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                       {if $serial!=''}value="{$dataPrinter.iloscstron|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}"{/if}>
                <span style='font-size: 12px;color:black'>Stan na</span>
                <input data-ref type="text" id='stanna' class='textBoxForm' maxlength="10"
                       style='width:100px;min-width:100px;'>
                <button class="btn btn-info" type="button"
                      onClick="zapiszStanNa('{$serial}');">zapisz</button>
            </td>
        </tr>
        <tr>
            <td style='height:5px;min-height: 5px;' colspan=2></td>
        </tr>
        <tr>
            <td class='tdOpis'>
                Ilość stron kolor
            </td>
            <td class='tdWartosc'>
                <input data-ref type="text" id='iloscstronkolor'
                       class='textBoxForm' maxlength="100"
                       style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                       {if $serial!=''}value="{$dataPrinter.iloscstron_kolor|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}"{/if}>
            </td>
        </tr>
        <tr>
            <td style='height:5px;min-height: 5px;' colspan=2></td>
        </tr>
        <tr>
            <td class='tdOpis'>
                Ilość stron total
            </td>
            <td class='tdWartosc'>
                <input data-ref type="text" id='iloscstrontotal'
                       class='textBoxForm' maxlength="100"
                       style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                       {if $serial!=''}value="{$dataPrinter.iloscstron_total|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}"{/if}>
            </td>
        </tr>
        <tr>
            <td style='height:5px;min-height: 5px;' colspan=2></td>
        </tr>
        <tr>
            <td class='tdOpis'>
                Ilość skanów
            </td>
            <td class='tdWartosc'>
                <input data-ref type="text" id='iloscscans'
                       class='textBoxForm' maxlength="100"
                       style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                       {if $serial!=''}value="{$dataPrinter.iloscscans|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}"{/if}>
            </td>
        </tr>
        <tr>
            <td style='height:5px;min-height: 5px;' colspan=2></td>
        </tr>

        <tr>
            <td class='tdOpis' style='height:50px;min-height: 50px;max-height: 50px;'>
                Krótki opis
            </td>
            <td class='tdWartosc'>
                                   <textarea id="txtopis" class="textareaForm" style='height:80px;min-height: 80px;'
                                             maxlength="500">{if $serial!=''}{$dataPrinter.opis|escape:'htmlall'}{/if}</textarea>
            </td>
        </tr>
        <tr>
            <td style='height:3px;min-height: 3px;' colspan=2></td>
        </tr>

{*        <tr>*}
{*            <td class='tdOpis'>*}
{*                Kolorowa*}
{*            </td>*}
{*            <td class='tdWartosc'>*}
{*                <input data-ref type="checkbox" id='checkKolorowa' class='checkBoxNormal'*}
{*                       {if $dataPrinter.type_color}checked{/if}*}
{*                />*}
{*            </td>*}
{*        </tr>*}
        <tr>
            <td style='height:3px;min-height: 3px;' colspan=2></td>
        </tr>
    </table>
</div>
<table class='tableform' cellspacing=0 cellpadding=0>
    <!-- device localization -->
    <tr>
        <td class='tdOpis' colspan="4">
            Lokalizacja Urządzenia
        </td>
    </tr>
    <tr>
        <td style='height:3px;min-height: 3px;' colspan=2></td>
    </tr>
    <!-- name -->
    <tr>
        <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;">
            nazwa
        </td>
        <td class='tdWartosc' colspan="3">
            <input data-ref type="text" id='txtnazwa'
                   class='textBoxForm' maxlength="100" style='min-width:130px;'
                   {if $serial!=''}value="{$dataPrinter.nazwa|escape:'htmlall'}"{/if}>
        </td>
    </tr>
    <tr>
        <td style='height:3px;min-height: 3px;' colspan=2></td>
    </tr>

    <!-- street -->
    <tr>
        <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;">
            ulica
        </td>
        <td class='tdWartosc' colspan="3">
            <input data-ref type="text" id='txtulica'
                   class='textBoxForm' maxlength="100" style='min-width:130px;'
                   {if $serial!=''}value="{$dataPrinter.ulica|escape:'htmlall'}"{/if}>
        </td>
    </tr>
    <tr>
        <td style='height:3px;min-height: 3px;' colspan=2></td>
    </tr>

    <!-- city -->
    <tr>
        <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;">
            miasto
        </td>
        <td class='tdWartosc' colspan="3">
            <input data-ref type="text" id='txtmiasto'
                   class='textBoxForm' maxlength="70" style='min-width:130px;'
                   {if $serial!=''}value="{$dataPrinter.miasto|escape:'htmlall'}"{/if}>
        </td>
    </tr>
    <tr>
        <td style='height:3px;min-height: 3px;' colspan=2></td>
    </tr>

    <!-- postal code -->
    <tr>
        <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;">
            kod pocztowy
        </td>
        <td class='tdWartosc' colspan="3">
            <input data-ref type="text" id='txtkodpocztowy'
                   class='textBoxForm' maxlength="10" style='min-width:130px;'
                   {if $serial!=''}value="{$dataPrinter.kodpocztowy|escape:'htmlall'}"{/if}>
        </td>
    </tr>
    <tr>
        <td style='height:3px;min-height: 3px;' colspan=2></td>
    </tr>
    <!-- contact information -->
    <tr>
        <td class='tdOpis' colspan="4">
            Dane kontaktowe
        </td>
    </tr>
    <tr>
        <td style='height:3px;min-height: 3px;' colspan=2></td>
    </tr>

    <!-- contact person -->
    <tr>
        <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;">
            osoba kontaktowa
        </td>
        <td class='tdWartosc' colspan="3">
            <input data-ref type="text" id='txtosobakontaktowa'
                   class='textBoxForm' maxlength="100" style='min-width:130px;'
                   {if $serial!=''}value="{$dataPrinter.osobakontaktowa|escape:'htmlall'}"{/if}>
        </td>
    </tr>
    <tr>
        <td style='height:3px;min-height: 3px;' colspan=2></td>
    </tr>
    <!-- phone -->
    <tr>
        <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;">
            telefon
        </td>
        <td class='tdWartosc' colspan="3">
            <input data-ref type="text" id='txttelefon'
                   class='textBoxForm' maxlength="50" style='min-width:130px;'
                   {if $serial!=''}value="{$dataPrinter.telefon|escape:'htmlall'}"{/if}>
        </td>
    </tr>
    <tr>
        <td style='height:3px;min-height: 3px;' colspan=2></td>
    </tr>

    <!-- mail -->
    <tr>
        <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;">
            adres email
        </td>
        <td class='tdWartosc' colspan="3">
            <input data-ref type="text" id='txtmail'
                   class='textBoxForm' maxlength="50" style='min-width:130px;'
                   {if $serial!=''}value="{$dataPrinter.mail|escape:'htmlall'}"{/if}>
        </td>
    </tr>
    <tr>
        <td style='height:3px;min-height: 3px;' colspan=2></td>
    </tr>

    <tr>
        <td class='tdOpis' style='height:50px;min-height: 50px;max-height: 50px;'>
            Uwagi
        </td>
        <td class='tdWartosc'>
                                   <textarea id="txtlokalizacja" class="textareaForm"
                                             style='height:80px;min-height: 80px;'
                                             maxlength="500">{if $serial!=''}{$dataPrinter.lokalizacja|escape:'htmlall'}{/if}</textarea>
        </td>
    </tr>

    <tr>
        <td style='text-align: right;' colspan="2">

            <div class='divSave'>
                <div id='actionerror' class='actionerror'><span>Błąd zapisu danych.</span></div>
                <div id='actionok' class='actionok'><span style='margin-top:6px;'>Dane zapisane poprawnie</span></div>
                <div wymaganylevel='r' wymaganyzrobiony='0' id='actionbuttonclick' class="actionbuttonZapisz"
                     onmousedown='zapiszDrukarke("{$serial}");return false;'>
                    <span>Zapisz >></span>
                </div>
                <div id='actionloader' class="actionloader">
                    <img src="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/smallLoader.GIF"
                         style='display:inline;'/>przetwarzanie
                </div>
                <div style='clear:both'></div>
            </div>
        </td>
    </tr>
    {*    placeholder , TODO: introduce bootstrap *}
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>
<script type="text/javascript">

    $("#stanna").datepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd", changeMonth: true,
        changeYear: true,
    });

</script>

</table>