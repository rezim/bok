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
                <input type="text" id='txtserial' autofocus
                       class='textBoxForm' maxlength="50" style='width:120px;min-width:120px;'
                       {if $serial!=''}value="{$dataPrinter[0].serial|escape:'htmlall'}"{/if}>
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
                <input type="text" id='txtmodel'
                       class='textBoxForm' maxlength="100" style='width:200px;min-width:200px;'
                       {if $serial!=''}value="{$dataPrinter[0].model|escape:'htmlall'}"{/if}>
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
                <input type="text" id='txtproduct_number'
                       class='textBoxForm' maxlength="100" style='width:120px;min-width:120px;'
                       {if $serial!=''}value="{$dataPrinter[0].product_number|escape:'htmlall'}"{/if}>
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
                <input type="text" id='txtnr_firmware'
                       class='textBoxForm' maxlength="100" style='width:120px;min-width:120px;'
                       {if $serial!=''}value="{$dataPrinter[0].nr_firmware|escape:'htmlall'}"{/if}>
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
                <input type="text" id='txtdate_firmware'
                       class='textBoxForm' maxlength="100" style='width:120px;min-width:120px;'
                       {if $serial!=''}value="{$dataPrinter[0].date_firmware|escape:'htmlall'}"{/if}>
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
                <input type="text" id='txtip'
                       class='textBoxForm' maxlength="100" style='width:120px;min-width:120px;'
                       {if $serial!=''}value="{$dataPrinter[0].ip|escape:'htmlall'}"{/if}>
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
                <input type="text" id='txtstan_fuser'
                       class='textBoxForm' maxlength="100"
                       style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                       {if $serial!='' && !empty($dataPrinter[0].stan_fuser)}value="{$dataPrinter[0].stan_fuser|number_format:2:",":" "|replace:',00':''|escape:'htmlall'}"{/if}>
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
                <input type="text" id='txtstan_adf'
                       class='textBoxForm' maxlength="100"
                       style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                       {if $serial!='' && !empty($dataPrinter[0].stan_adf)}value="{$dataPrinter[0].stan_adf|number_format:2:",":" "|replace:',00':''|escape:'htmlall'}"{/if}>
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
                <input type="text" id='txtblack_toner'
                       class='textBoxForm' maxlength="100"
                       style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                       {if $serial!=''}value="{$dataPrinter[0].black_toner|number_format:2:",":" "|replace:',00':''|escape:'htmlall'}"{/if}>
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
                <input type="text" id='txtiloscstron'
                       class='textBoxForm' maxlength="100"
                       style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                       {if $serial!=''}value="{$dataPrinter[0].iloscstron|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}"{/if}>
                <font style='font-size: 12px;color:black'>Stan na</font>
                <input type="text" id='txtstanna' class='textBoxForm' maxlength="10"
                       style='width:100px;min-width:100px;'>
                <font style='font-size: 12px;color:gray;cursor:hand;cursor:pointer;'
                      onClick="zapiszStanNa('{$serial}');">zapisz</font>

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
                <input type="text" id='txtiloscstronkolor'
                       class='textBoxForm' maxlength="100"
                       style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                       {if $serial!=''}value="{$dataPrinter[0].iloscstron_kolor|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}"{/if}>
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
                <input type="text" id='txtiloscstrontotal'
                       class='textBoxForm' maxlength="100"
                       style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                       {if $serial!=''}value="{$dataPrinter[0].iloscstron_total|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}"{/if}>
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
                                             maxlength="500">{if $serial!=''}{$dataPrinter[0].opis|escape:'htmlall'}{/if}</textarea>
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
                                             maxlength="500">{if $serial!=''}{$dataPrinter[0].lokalizacja|escape:'htmlall'}{/if}</textarea>
            </td>
        </tr>

        <tr>
            <td class='tdOpis'>
                Kolorowa
            </td>
            <td class='tdWartosc'>
                <input type="checkbox" id='checkKolorowa' class='checkBoxNormal'
                       {if $dataPrinter[0].type_color}checked{/if}
                />
            </td>
        </tr>
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
            <input type="text" id='txtnazwa'
                   class='textBoxForm' maxlength="100" style='min-width:130px;'
                   {if $serial!=''}value="{$dataPrinter[0].nazwa|escape:'htmlall'}"{/if}>
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
            <input type="text" id='txtulica'
                   class='textBoxForm' maxlength="100" style='min-width:130px;'
                   {if $serial!=''}value="{$dataPrinter[0].ulica|escape:'htmlall'}"{/if}>
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
            <input type="text" id='txtmiasto'
                   class='textBoxForm' maxlength="70" style='min-width:130px;'
                   {if $serial!=''}value="{$dataPrinter[0].miasto|escape:'htmlall'}"{/if}>
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
            <input type="text" id='txtkodpocztowy'
                   class='textBoxForm' maxlength="10" style='min-width:130px;'
                   {if $serial!=''}value="{$dataPrinter[0].kodpocztowy|escape:'htmlall'}"{/if}>
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
            <input type="text" id='txtosobakontaktowa'
                   class='textBoxForm' maxlength="100" style='min-width:130px;'
                   {if $serial!=''}value="{$dataPrinter[0].osobakontaktowa|escape:'htmlall'}"{/if}>
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
            <input type="text" id='txttelefon'
                   class='textBoxForm' maxlength="50" style='min-width:130px;'
                   {if $serial!=''}value="{$dataPrinter[0].telefon|escape:'htmlall'}"{/if}>
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
            <input type="text" id='txtmail'
                   class='textBoxForm' maxlength="50" style='min-width:130px;'
                   {if $serial!=''}value="{$dataPrinter[0].mail|escape:'htmlall'}"{/if}>
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
                <div wymaganylevel='w' wymaganyzrobiony='0' id='actionbuttonclick2' style="float: left"
                     class="buttonDeclin" onmousedown='usunDrukarke("{$serial}");return false;'>

                    <span>X Usuń</span>
                </div>
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
</table>
<script type="text/javascript">

    $("#txtstanna").datepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd", changeMonth: true,
        changeYear: true,
    });

</script>

</table>