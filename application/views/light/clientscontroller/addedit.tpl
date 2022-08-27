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
                        Nazwa krótka&nbsp;<span style="color: red">*</span>
                    </th>
                    <td>
                        <input class="form-control form-control-md" type="text" id='txtNazwaKrotka' autofocus
                               {if $rowid!=0}value="{$dataClient[0].nazwakrotka|escape:'htmlall'}"{/if}>
                    </td>
                </tr>
                <tr>
                    <th>
                        Nazwa pełna&nbsp;<span style="color: red">*</span>
                    </th>
                    <td>
                        <textarea id="txtNazwaPelna"
                                  class="form-control form-control-md">{if $rowid!=0}{$dataClient[0].nazwapelna}{/if}</textarea>
                    </td>
                </tr>
                <tr>
                    <th>
                        Ulica
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtUlica'
                               {if $rowid!=0}value="{$dataClient[0].ulica|escape:'htmlall'}"{/if}>
                    </td>
                </tr>
                <tr>
                    <th>
                        Miasto
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtMiasto'
                               {if $rowid!=0}value="{$dataClient[0].miasto|escape:'htmlall'}"{/if}>
                    </td>
                </tr>
                <tr>
                    <th>
                        Kod pocztowy
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtKodPocztowy'
                               {if $rowid!=0}value="{$dataClient[0].kodpocztowy|escape:'htmlall'}"{/if}>
                    </td>
                </tr>

                <tr>
                    <th>
                        NIP&nbsp;<span style="color: red">*</span>
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtNip' {if !$show_payment_options && $rowid!=0}disabled{/if}
                               {if $rowid!=0}value="{$dataClient[0].nip|escape:'htmlall'}"{/if}>
                    </td>
                </tr>
                <tr>
                    <th>
                        Termin płatności (dni)
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtTerminPlatnosci' {if !$show_payment_options && $rowid!=0}disabled{/if}
                               {if $rowid!=0 && !empty($dataClient[0].terminplatnosci)}value="{$dataClient[0].terminplatnosci|number_format:0:",":" "|escape:'htmlall'}"{/if}>
                    </td>
                </tr>
                <tr>
                    <th>
                        Email faktury
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtMailFaktury'
                               {if $rowid!=0}value="{$dataClient[0].mailfaktury|escape:'htmlall'}"{/if}
                        />
                    </td>
                </tr>
                <tr>
                    <th>
                        Bank
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtBank' {if !$show_payment_options && $rowid!=0}disabled{/if}
                               {if $rowid!=0}value="{$dataClient[0].bank|escape:'htmlall'}"{/if}
                        />
                    </td>
                </tr>
                <tr>
                    <th>
                        Numer rachunku bankowego
                    </th>
                    <td>
                        <input class="form-control form-control-sm" id='txtNumerRachunku' {if !$show_payment_options && $rowid!=0}disabled{/if}
                               {if $rowid!=0}value="{$dataClient[0].numerrachunku|escape:'htmlall'}"{/if}
                        />
                    </td>
                </tr>
                <tr>
                    <th>
                        Dodatkowy opis
                    </th>
                    <td>
                        <textarea id="txtDodatkowyOpis" rows="5"
                                  class="form-control form-control-xl">{if $rowid!=0}{$dataClient[0].opis|escape:'htmlall'}{/if}</textarea>
                    </td>
                </tr>
                <tr>
                    <th>
                        Opiekun klienta
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtOpiekunKlienta'
                               {if $rowid!=0}value="{$dataClient[0].opiekunklienta|escape:'htmlall'}"{/if}
                        />
                    </td>
                </tr>
                <tr>
                    <th>
                        Branża
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtBranza'
                               {if $rowid!=0}value="{$dataClient[0].branza|escape:'htmlall'}"{/if}
                        />
                    </td>
                </tr>
                {if $show_payment_options}
                <!-- invoice options -->
                <tr>
                    <td colspan="2" class="font-weight-bold">
                        Opcje Faktury
                    </td>
                </tr>

                <!-- show serial number -->
                <tr>
                    <th>
                        pokaż numer seryjny
                    </th>
                    <td>
                        <input type="checkbox" id='checkPokazNumerSeryjny' class="form-control form-control-sm"
                               {if $rowid!=0 && !empty($dataClient[0].pokaznumerseryjny) &&  $dataClient[0].pokaznumerseryjny==1}checked{/if}
                        />
                    </td>
                </tr>
                <!-- show device counter state -->
                <tr>
                    <th>
                        Pokaż stan licznika
                    </th>
                    <td>
                        <input type="checkbox" id='checkPokazStanLicznika' class="form-control form-control-sm"
                               {if $rowid!=0 && !empty($dataClient[0].pokazstanlicznika) &&  $dataClient[0].pokazstanlicznika==1}checked{/if}
                        />
                    </td>
                </tr>
                <!-- separate invoice for each agreement -->
                <tr>
                    <th>
                        Faktura dla każdej umowy
                    </th>
                    <td>
                        <input type="checkbox" id='checkFakturaDlaKazdejUmowy' class="form-control form-control-sm"
                               {if $rowid!=0 && !empty($dataClient[0].fakturadlakazdejumowy) && $dataClient[0].fakturadlakazdejumowy==1}checked{/if}
                        />
                    </td>
                </tr>
                <tr>
                    <th>
                        Umowa zbiorcza
                    </th>
                    <td>
                        <input type="checkbox" id='checkUmowaZbiorcza' class="form-control form-control-sm"
                               {if $rowid!=0 && !empty($dataClient[0].umowazbiorcza) && $dataClient[0].umowazbiorcza==1}checked{/if}
                        />
                    </td>
                </tr>
                {/if}
                <!-- end -->
            </table>
        </div>
        <div class="col">
            <table class='table table-sm bok-two-column-layout'>
                <tr>
                    <td colspan="2" class="font-weight-bold">Osoba kontaktowa</td>
                </tr>
                <tr>
                    <th>
                       Imię i nazwisko
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtKontaktImieNazwisko'
                               {if $rowid!=0}value="{$dataClient[0].imienazwisko|escape:'htmlall'}"{/if}
                        />
                    </td>
                </tr>
                <tr>
                    <th>
                        Adres email
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtKontaktEmail'
                               {if $rowid!=0}value="{$dataClient[0].mail|escape:'htmlall'}"{/if}
                    </td>
                </tr>
                <tr>
                    <th>
                        Numer telefonu
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtKontaktTelefon'
                               {if $rowid!=0}value="{$dataClient[0].telefon|escape:'htmlall'}"{/if}
                        />
                    </td>
                </tr>
                <tr>
                    <th>
                        Stanowisko
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtKontaktStanowisko'
                               {if $rowid!=0}value="{$dataClient[0].stanowisko|escape:'htmlall'}"{/if}
                        />
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="font-weight-bold">Osoba odpowiedzialna za zamówienia</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right small">kopiuj dane osoby kontaktowej <input type="checkbox"
                                                                                                  onclick="copyToValuesForPerson('Kontakt', 'Zamowienia', this.checked)"/>
                    </td>
                </tr>
                <tr>
                    <th>
                        Imię i nazwisko
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtZamowieniaImieNazwisko'
                               {if $rowid!=0}value="{$dataClient[0].zamowieniaimienazwisko|escape:'htmlall'}"{/if}
                        />
                    </td>
                </tr>
                <tr>
                    <th>
                        Adres email
                    </th>
                    <td>
                        <input class="form-control form-control-md" id="txtZamowieniaEmail"
                               {if $rowid!=0}value="{$dataClient[0].zamowieniaemail|escape:'htmlall'}"{/if}
                        />
                    </td>
                </tr>
                <tr>
                    <th>
                        Numer telefonu
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtZamowieniaTelefon'
                               {if $rowid!=0}value="{$dataClient[0].zamowieniatelefon|escape:'htmlall'}"{/if}
                        />
                    </td>
                </tr>
                <tr>
                    <th>
                        Stanowisko
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtZamowieniaStanowisko'
                               {if $rowid!=0}value="{$dataClient[0].zamowieniastanowisko|escape:'htmlall'}"{/if}
                        />
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="font-weight-bold">Osoba odpowiedzialna za płatności</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right small">kopiuj dane osoby kontaktowej <input type="checkbox"
                                                                                                  onclick="copyToValuesForPerson('Kontakt', 'Faktury', this.checked)"/>
                    </td>
                </tr>
                <tr>
                    <th>
                        Imię i nazwisko
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtFakturyImieNazwisko'
                               {if $rowid!=0}value="{$dataClient[0].fakturyimienazwisko|escape:'htmlall'}"{/if}
                        />
                    </td>
                </tr>
                <tr>
                    <th>
                        Adres email
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtFakturyEmail'
                               {if $rowid!=0}value="{$dataClient[0].fakturyemail|escape:'htmlall'}"{/if}
                        />
                    </td>
                </tr>
                <tr>
                    <th>
                        Telefon komórkowy
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtFakturyKomorka'
                               {if $rowid!=0}value="{$dataClient[0].fakturykomorka|escape:'htmlall'}"{/if}
                        />
                    </td>
                </tr>
                <tr>
                    <th>
                        Telefon stacjonarny
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtFakturyTelefon'
                               {if $rowid!=0}value="{$dataClient[0].fakturytelefon|escape:'htmlall'}"{/if}
                        />
                    </td>
                </tr>
                <tr>
                    <th>
                        Stanowisko
                    </th>
                    <td>
                        <input class="form-control form-control-md" id='txtFakturyStanowisko'
                               {if $rowid!=0}value="{$dataClient[0].fakturystanowisko|escape:'htmlall'}"{/if}
                        />
                    </td>
                </tr>
                <tr>
                    <th>
                        Uwagi / notatki
                    </th>
                    <td>
                        <textarea id="txtFakturyUwagi" rows="2" class="form-control form-control-xl">
                            {if $rowid!=0}{$dataClient[0].fakturyuwagi|escape:'htmlall'}{/if}
                        </textarea>
                    </td>
                </tr>
                {if $show_payment_options}
                <tr>
                    <th>
                        Monitoring płatności
                    </th>
                    <td>
                        <input type="checkbox" id='checkMonitoringPlatnosci' class="form-control form-control-sm"
                               {if $rowid!=0 && !empty($dataClient[0].monitoringplatnosci) && $dataClient[0].monitoringplatnosci==1}checked{/if}
                        />
                    </td>
                </tr>
                <tr>
                    <th>
                        Naliczać odsetki
                    </th>
                    <td class="text-left">
                        <input type="checkbox" id='checkNaliczacOdsetki' class="form-control form-control-sm" class="text-left"
                               {if $rowid!=0 && !empty($dataClient[0].naliczacodsetki) && $dataClient[0].naliczacodsetki==1}checked{/if}
                        />
                    </td>
                </tr>
                {/if}
            </table>
        </div>
    </div>
    {if !$show_payment_options}
        <div class="h-50">&nbsp;{*placeholder*}</div>
    {/if}

    {* [TR] - as we show these options to both Admin and sytem Operator, we can remove it as optional below *}
    <div class="container text-right" wymaganylevel='r' wymaganyzrobiony='1'>
        <a href="#" class="btn btn-outline-success active" role="button" aria-pressed="true"
           onmousedown='zapiszKlienta("{$rowid}");return false;'><i class="fas fa-save"></i>&nbsp; Zapisz</a>
        <a href="#" class="btn btn-outline-secondary" role="button" onclick="$.colorbox.close();">Anuluj</a>
    </div>
</div>

<script type="text/javascript">
    copyToValuesForPerson = function (fromPerson, toPerson, checked) {
        const fields = ["ImieNazwisko", "Telefon", "Email", "Stanowisko"];
        fields.forEach((field) => {
            const newValue = checked ? $("#txt" + fromPerson + field).val() : '';
            $("#txt" + toPerson + field).val(newValue);
        });
    };
</script>