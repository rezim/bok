<div class="container mt-3">
    <div class="container">
        <div id='actionok' class="actionok alert alert-success" role="alert">
            <strong>Dane zapisane poprawnie</strong>
        </div>
        <div id='actionerror' class="actionerror alert alert-danger" role="alert">
            <strong>Błąd zapisu danych.</strong>
        </div>
    </div>

    <div class="row container">
        <div class="col">
            <table class='table table-sm bok-two-column-layout'>
                <tr>
                    <th>
                        Nr umowy&nbsp;<span class="text-danger">*</span>
                    </th>
                    <td class='tdWartosc' colspan="3">
                        <input type="text" id='txtnrumowy' autofocus
                               class="form-control form-control-md" maxlength="40"
                               {if $rowid!=0}value="{$dataUmowa[0].nrumowy|escape:'htmlall'}"{/if}>
                    </td>
                </tr>
                <tr>
                    <th class='tdOpis'>
                        Typ umowy
                    </th>
                    <td class='tdWartosc' colspan="3">
                        <select id='txttypumowy' class="form-control form-control-md">
                            <option value="" selected></option>
                            {foreach from=$dataAgreementTypes item=item key=key}
                                <option value="{$item.rowid}"
                                        {if $rowid!=0 && $dataUmowa[0].rowid_type==$item.rowid}selected{/if}>{$item.description}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <th class='tdOpis'>
                        Klient&nbsp;<span class="text-danger">*</span>
                    </th>
                    <td>
                        <select id='txtklient' class="form-control form-control-md selectpicker"
                                data-size="10"
                                data-width="340px"
                                data-none-selected-text="Nie wybrano żadnego klient"
                                data-none-results-text="Nie znaleziono wyników dla podanego filtra"
                                data-live-search-placeholder="Wpisz filtr aby zawęzić liste klientów"
                                data-live-search="true">
                            <option value="" selected></option>
                            {foreach from=$dataClients item=item key=key}
                                <option value="{$key}"
                                        {if $rowid!=0 && $dataUmowa[0].rowidclient==$key}selected{/if}>{$item.nazwakrotka}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <th class='tdOpis'>
                        id odbiorcy [fakturownia]
                    </th>
                    <td class='tdWartosc' colspan="3">
                        <input type="text" id='txtodbiorca_id'
                               class="form-control form-control-md" maxlength="20"
                               {if $rowid!=0}value="{$dataUmowa[0].odbiorca_id|escape:'htmlall'}"{/if}>

                    </td>
                </tr>
                <tr>
                    <th class='tdOpis'>
                        Drukarka&nbsp;<span class="text-danger">*</span>
                    </th>
                    <td class='tdWartosc' colspan="3">

                        <select id='txtdrukarka' class="form-control form-control-md selectpicker"
                                onchange="updateAgreementWithPrinter({$rowid}, this.value)"
                                data-size="10"
                                data-width="340px"
                                data-none-selected-text="Nie wybrano żadnej drukarki"
                                data-none-results-text="Nie znaleziono wyników dla podanego filtra"
                                data-live-search-placeholder="Wpisz filtr aby zawęzić list drukarek"
                                data-live-search="true">
                            <option value="" selected></option>

                            {foreach from=$dataPrinters item=item key=key}
                                <option value="{$item.serial}"
                                        {if $rowid!=0 && $dataUmowa[0].serial==$item.serial}selected{/if}>{$item.serial}
                                    - {$item.model}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr id='trtxtrozliczenie'>
                    <th class='tdOpis'>
                        Rozliczenie
                    </th>
                    <td class='tdWartosc' colspan="3">
                        <select id='txtrozliczenie' class="form-control form-control-md">
                            <option value="miesięczne"
                                    {if $rowid!=0 && $dataUmowa[0].rozliczenie=='miesięczne'}selected{/if}>
                                miesięczne
                            </option>
                            <option value="roczne" {if $rowid!=0 && $dataUmowa[0].rozliczenie=='roczne'}selected{/if}>
                                roczne
                            </option>
                        </select>
                    </td>
                </tr>
                <tr id="trtxtabonament">
                    <th class='tdOpis'>
                        abonament
                    </th>
                    <td class='tdWartosc' colspan="3">
                        <input type="text" id='txtabonament'
                               class="form-control form-control-md" maxlength="10"
                               {if $rowid!=0}value="{$dataUmowa[0].abonament|number_format:2:",":" "|escape:'htmlall'}"{/if}>
                    </td>
                </tr>
                <tr id="trtxtabonament">
                    <th class='tdOpis'>
                        kwota w abonamencie
                    </th>
                    <td class='tdWartosc' colspan="3">
                        <input type="text" id='txtkwotawabonamencie'
                               class="form-control form-control-md" maxlength="10"
                               {if $rowid!=0}value="{$dataUmowa[0].kwotawabonamencie|number_format:2:",":" "|escape:'htmlall'}"{/if}>
                    </td>
                </tr>
                <tr id="trtxtdataod">
                    <th class='tdOpis'>
                        Data od&nbsp;<span class="text-danger">*</span>
                    </th>
                    <td class='tdWartosc' colspan="3">
                        <input type="text" id='txtdataod'
                               class="form-control form-control-md" maxlength="10"
                               {if $rowid!=0}value="{$dataUmowa[0].dataod|escape:'htmlall'}"{/if}>
                    </td>
                </tr>
                <tr id="trtxtdataod">
                    <th class='tdOpis'>
                        Data do
                    </th>
                    <td class='tdWartosc' colspan="3">
                        <input type="text" id='txtdatado'
                               class="form-control form-control-md" maxlength="10"
                               {if $rowid!=0}value="{$dataUmowa[0].datado|escape:'htmlall'}"{/if}>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col">
            <table class='table table-sm bok-two-column-layout'>
                <tr id="trtxtiloscstron">
                    <th class='tdOpis'>
                        stron black w abonam.
                    </th>
                    <td class='tdWartosc'>
                        <input type="text" id='txtiloscstron'
                               class="form-control form-control-md" maxlength="10"
                               {if $rowid!=0}value="{$dataUmowa[0].stronwabonamencie|number_format:0:",":" "|escape:'htmlall'}"{/if}>
                    </td>
                    <th class='tdOpis'>
                        cena za stronę black
                    </th>
                    <td class='tdWartosc'>
                        <input type="text" id='txtcenazastrone'
                               class="form-control form-control-md" maxlength="10"
                               {if $rowid!=0}value="{$dataUmowa[0].cenazastrone|number_format:3:",":" "|escape:'htmlall'}"{/if}>
                    </td>
                </tr>

                <tr id="trtxtiloscstron_kolor">
                    <th class='tdOpis'>
                        stron kolor w abonam.
                    </th>
                    <td class='tdWartosc'>
                        <input type="text" id='txtiloscstron_kolor'
                               class="form-control form-control-md" maxlength="10"
                               {if $rowid!=0 && !empty($dataUmowa[0].iloscstron_color)}value="{$dataUmowa[0].iloscstron_color|number_format:0:",":" "|escape:'htmlall'}"{/if}>
                    </td>

                    <th class='tdOpis'>
                        cena za stronę kolor
                    </th>
                    <td class='tdWartosc'>
                        <input type="text" id='txtcenazastrone_kolor'
                               class="form-control form-control-md" maxlength="10"
                               {if $rowid!=0 && !empty($dataUmowa[0].cenazastrone_kolor)}value="{$dataUmowa[0].cenazastrone_kolor|number_format:3:",":" "|escape:'htmlall'}"{/if}>
                    </td>
                </tr>

                <tr id="trtxtiloscskanow">
                    <th class='tdOpis'>
                        skanów w abonam.
                    </th>
                    <td class='tdWartosc'>
                        <input type="text" id='txtiloscskanow'
                               class="form-control form-control-md" maxlength="10"
                               {if $rowid!=0 && !empty($dataUmowa[0].iloscskans)}value="{$dataUmowa[0].iloscskans|number_format:0:",":" "|escape:'htmlall'}"{/if}>
                    </td>

                    <th class='tdOpis'>
                        cena za skan
                    </th>
                    <td class='tdWartosc'>
                        <input type="text" id='txtcenazaskan'
                               class="form-control form-control-md" maxlength="10"
                               {if $rowid!=0 && !empty($dataUmowa[0].cenazascan)}value="{$dataUmowa[0].cenazascan|number_format:3:",":" "|escape:'htmlall'}"{/if}>
                    </td>
                </tr>


                <tr id="trtxtcenazastrone">
                    <th class='tdOpis'>
                        cena instalacji
                    </th>
                    <td class='tdWartosc'>
                        <input type="text" id='txtcenainstalacji'
                               class="form-control form-control-md" maxlength="10"
                               {if $rowid!=0 && !empty($dataUmowa[0].cenainstalacji)}value="{$dataUmowa[0].cenainstalacji|number_format:0:",":" "|escape:'htmlall'}"{/if}>
                    </td>
                    <th class='tdOpis'>
                        prowizja partn.[%]
                    </th>
                    <td class='tdWartosc'>
                        <input type="text" id='txtprowizjapartnerska'
                               class="form-control form-control-md" maxlength="10"
                               {if $rowid!=0 && !empty($dataUmowa[0].prowizjapartnerska)}value="{$dataUmowa[0].prowizjapartnerska|number_format:0:",":" "|escape:'htmlall'}"{/if}>
                    </td>
                </tr>
                <tr id="trtxtrabatdoabonamentu">
                    <th class='tdOpis'>
                        rabat do abonamentu[%]
                    </th>
                    <td class='tdWartosc'>
                        <input type="text" id='txtrabatdoabonamentu'
                               class="form-control form-control-md" maxlength="10"
                               {if $rowid!=0 && !empty($dataUmowa[0].rabatdoabonamentu)}value="{$dataUmowa[0].rabatdoabonamentu|number_format:2:",":" "|escape:'htmlall'}"{/if}>
                    </td>
                    <th class='tdOpis'>
                        rabat do wydruków[%]
                    </th>
                    <td class='tdWartosc'>
                        <input type="text" id='txtrabatdowydrukow'
                               class="form-control form-control-md" maxlength="10"
                               {if $rowid!=0 && !empty($dataUmowa[0].rabatdowydrukow)}value="{$dataUmowa[0].rabatdowydrukow|number_format:2:",":" "|escape:'htmlall'}"{/if}>
                    </td>
                </tr>
                <tr id="trtxtcenazastrone_kolor">

                    <th class='tdOpis'>
                        wartość urządz.
                    </th>
                    <td class='tdWartosc'>
                        <input type="text" id='txtwartoscurzadzenia'
                               class="form-control form-control-md" maxlength="10"
                               {if $rowid!=0 && !empty($dataUmowa[0].wartoscurzadzenia)}value="{$dataUmowa[0].wartoscurzadzenia|number_format:2:",":" "|escape:'htmlall'}"{/if}>
                    </td>

                    <th class='tdOpis'>
                        SLA [ h ]
                    </th>
                    <td class='tdWartosc'>
                        <input type="text" id='txtsla'
                               class="form-control form-control-md" maxlength="10"
                               {if $rowid!=0 && !empty($dataUmowa[0].sla)}value="{$dataUmowa[0].sla|number_format:0:",":" "|escape:'htmlall'}"{/if}
                                {if $rowid==0}value="48"{/if}
                        >
                    </td>

                </tr>
                <tr>
                    <th class='tdOpis' style='height:50px;min-height: 50px;max-height: 50px;'>
                        krótki opis
                    </th>
                    <td class='tdWartosc' colspan="3">
                                   <textarea id="txtopis" class="form-control form-control-md"
                                             maxlength="500">{if $rowid!=0}{$dataUmowa[0].opis|escape:'htmlall'}{/if}</textarea>
                    </td>
                </tr>
                <tr id="trtxtstatusumowy">
                    <th class='tdOpis'>
                        Status umowy
                    </th>
                    <td class='tdWartosc' colspan="3">
                        {if $editMode}
                            {if $dataUmowa[0].activity == 1 && !$canEditActive}
                                <select id='txtstatusumowy' class="form-control form-control-md" disabled>
                                    <option value="1" selected>aktywna</option>
                                </select>
                            {else}
                                <select id='txtstatusumowy' class="form-control form-control-md">
                                    {if $canEditActive}
                                        <option value="1" {if $dataUmowa[0].activity == 1}selected{/if}>aktywna</option>
                                    {/if}
                                    {if $canEditClosed}
                                        <option value="0" {if $dataUmowa[0].activity == 0}selected{/if}>zamknięta</option>
                                    {/if}
                                    {if $canEditDraft}
                                        <option value="-1" {if $dataUmowa[0].activity == -1}selected{/if}>wersja robocza</option>
                                    {/if}
                                </select>
                            {/if}
                        {else}
                            <select id='txtstatusumowy' class="form-control form-control-md">
                                {if $canAddActive}
                                    <option value="1">aktywna</option>
                                {/if}
                                {if $canAddClosed}
                                    <option value="0">zamknięta</option>
                                {/if}
                                {if $canAddDraft}
                                    <option value="-1" selected>wersja robocza</option>
                                {/if}
                            </select>
                        {/if}
                    </td>
                </tr>
            </table>
        </div>
    </div>
{*    canSaveAgreementAsFinal*}
    <div class="row container">
        <div class="col">
            <table class='table table-sm bok-two-column-layout'>

                <tr>
                    <th class="text-center" colspan="8">stan początkowy licznika</th>
                </tr>
                <tr>
                    <td class="align-middle text-muted"><small>c/b:</small></td>
                    <td class="tdWartosc">
                        <input type="text" id='counterstart' class="form-control form-control-md" maxlength="10"
                               {if $prtcntrowid!=0 && !empty($dataCounters[0].ilosc_start)}value="{$dataCounters[0].ilosc_start|number_format:0:",":" "|escape:'htmlall'}"{/if}
                    </td>
                    <td class="align-middle text-muted"><small>kol:</small></td>
                    <td class="tdWartosc">
                        <input type="text" id='countercolorstart' class="form-control form-control-md" maxlength="10"
                               {if $prtcntrowid!=0 && !empty($dataCounters[0].ilosckolor_start)}value="{$dataCounters[0].ilosckolor_start|number_format:0:",":" "|escape:'htmlall'}"{/if}>
                    </td>
                    <td class="align-middle text-muted"><small>skan:</small></td>
                    <td class="tdWartosc">
                        <input type="text" id='counterscansstart' class="form-control form-control-md" maxlength="10"
                               {if $prtcntrowid!=0 && !empty($dataCounters[0].iloscskans_start)}value="{$dataCounters[0].iloscskans_start|number_format:0:",":" "|escape:'htmlall'}"{/if}>
                    </td>
                    <td class="align-middle text-muted"><small>data:</small></td>
                    <td class="tdWartosc">
                        <input type="text" class="form-control form-control-md" id='datacounterstart'
                               {if $prtcntrowid!=0}value="{$dataCounters[0].date_start|escape:'htmlall'}"{/if}>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col">
            <table class='table table-sm bok-two-column-layout'>
                <tr>
                    <th class="text-center" colspan="8">stan końcowy licznika</th>
                </tr>
                <tr>
                    <td class="align-middle text-muted"><small>c/b:</small></td>
                    <td class="tdWartosc">
                        <input type="text" id='counterend' class="form-control form-control-md" maxlength="10"
                               {if $prtcntrowid!=0 && !empty($dataCounters[0].ilosc_koniec)}value="{$dataCounters[0].ilosc_koniec|number_format:0:",":" "|escape:'htmlall'}"{/if}>
                    </td>
                    <td class="align-middle text-muted"><small>kol:</small></td>
                    <td class="tdWartosc">
                        <input type="text" id='countercolorend' class="form-control form-control-md" maxlength="10"
                               {if $prtcntrowid!=0 && !empty($dataCounters[0].ilosckolor_koniec)}value="{$dataCounters[0].ilosckolor_koniec|number_format:0:",":" "|escape:'htmlall'}"{/if}>
                    </td>
                    <td class="align-middle text-muted"><small>skan:</small></td>
                    <td class="tdWartosc">
                        <input type="text" id='counterscansend' class="form-control form-control-md" maxlength="10"
                               {if $prtcntrowid!=0 && !empty($dataCounters[0].iloscskans_koniec)}value="{$dataCounters[0].iloscskans_koniec|number_format:0:",":" "|escape:'htmlall'}"{/if}>
                    </td>
                    <td class="align-middle text-muted"><small>data:</small></td>
                    <td class="tdWartosc">
                        <input type="text" class="form-control form-control-md" id='datacounterend'
                               {if $prtcntrowid!=0}value="{$dataCounters[0].date_koniec|escape:'htmlall'}"{/if}>
                        <input type="hidden" id="prtcntrowid" value="{$prtcntrowid}">
                    </td>
                </tr>
            </table>

        </div>
    </div>
    <div class="row container">
        <div class="col">
            {if isset($rowid) && $rowid!=0}
                <div class="dropzone" id="divdropzone3">

                </div>
                <script type="text/javascript">
                    createDropZone('div#divdropzone3', '{$rowid}', 'agreements', '{$smarty.const.ADRESHTTPS}/public_html', '{$smarty.const.SCIEZKA}');
                </script>
            {/if}
        </div>
    </div>

</div>

<div class="container text-right mt-4 mb-2" wymaganylevel='r' wymaganyzrobiony='1'>
    {if $editMode && $canSaveClosed && !($dataUmowa[0].activity == 1 && !$canEditActive)}
        <a href="#" class="btn btn-danger mr-5" role="button" onclick='usunUmowe("{$rowid}");return false;'>
            <i class="fas fa-trash"></i>&nbsp;&nbsp;Zamknij Umowę
        </a>
    {/if}

    <a href="#" class="btn btn-outline-secondary" role="button" onclick="$.colorbox.close();">Anuluj</a>

    <a href="#" id="saveAgreementBtn"
       class="btn btn-outline-success active"
       role="button"
       aria-pressed="true"
       data-can-save-active="{$canSaveActive|default:false}"
       data-can-save-draft="{$canSaveDraft|default:false}"
       data-can-save-closed="{$canSaveClosed|default:false}"
       onmousedown='zapiszUmowe("{$rowid}");return false;'>
        <i class="fas fa-save"></i>&nbsp;Zapisz
    </a>
</div>


<script type="text/javascript">
    $("#txtdataod").datepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd", changeMonth: true,
        changeYear: true,
    });
    $("#txtdatado").datepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd", changeMonth: true,
        changeYear: true,
    });


    $("#datacounterstart").datetimepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd", changeMonth: true, timeFormat: 'HH:mm', stepMinute: 10,
        changeYear: true
    });

    $("#datacounterend").datetimepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd", changeMonth: true, timeFormat: 'HH:mm', stepMinute: 10,
        changeYear: true
    });

    $('.selectpicker').selectpicker();


</script>

<script>

        const statusSelect = document.getElementById('txtstatusumowy');
        const saveButton = document.getElementById('saveAgreementBtn');

        function updateSaveButtonVisibility() {
            const selectedValue = parseInt(statusSelect.value);
            const canSaveActive = saveButton.dataset.canSaveActive === "1" || saveButton.dataset.canSaveActive === "true";
            const canSaveDraft = saveButton.dataset.canSaveDraft === "1" || saveButton.dataset.canSaveDraft === "true";
            const canSaveClosed = saveButton.dataset.canSaveClosed === "1" || saveButton.dataset.canSaveClosed === "true";

            let show = false;
            if (selectedValue === 1 && canSaveActive) show = true;
            if (selectedValue === 0 && canSaveClosed) show = true;
            if (selectedValue === -1 && canSaveDraft) show = true;

            saveButton.style.display = show ? 'inline-block' : 'none';
        }

        updateSaveButtonVisibility();

        statusSelect.addEventListener('change', updateSaveButtonVisibility);

</script>

