<div id="print-template">
    <table class="printTable">
        <tr>
            <td align="left">
                <div>
                    <img src="http://www.otus.pl/templates/otus/images/obraz/logo.png" alt="Otus" title="Otus" border="0" height="82" width="150">
                </div>
                <div>
                    {$smarty.const.BOK_OTUS_ADRES}, {$smarty.const.BOK_OTUS_ADRES2}
                </div>
                <div>
                    tel.: {$smarty.const.BOK_OTUS_TELEFON}, {$smarty.const.BOK_OTUS_WWW}
                </div>
                <div>
                    {$smarty.const.BOK_OTUS_KONTO_BANKOWE}
                </div>
            </td>
            <td width="50%" class="positionRight">
                <div align="center" class="printSubHeader">Rewers przyjęcia do serwisu </div>
                <div align="right" class="text-uppercase">[[toPrint.revers_number]]</div>
                <div align="center" class="printSubHeader">Data sporządzenia wydruku</div>
                <div align="right">[[toPrint.date | date:'dd.MM.yyyy']]</div>
            </td>
        </tr>
        <tr>
            <td width="50%" class="positionLeft">
                <div class="printSubHeader" style="margin-top: 20px">Sprzedawca:</div>
                <div>{$smarty.const.BOK_OTUS}</div>
                <div>{$smarty.const.BOK_OTUS_ADRES}</div>
                <div>{$smarty.const.BOK_OTUS_ADRES2}</div>
                <div>NIP: {$smarty.const.BOK_OTUS_NIP}</div>
            </td>
            <td width="50%" align="center" class="positionRight">
                <div class="printSubHeader">Klient:</div>
                <div>[[toPrint.nazwa]]</div>
                <div>[[toPrint.ulica]]</div>
                <div>[[toPrint.kodpocztowy]] [[toPrint.miasto]]</div>
                <div>Tel. [[toPrint.telefon]]</div>
                <div>NIP: [[toPrint.nip]]</div>
                <div>E-mail: [[toPrint.mail]]</div>
            </td>
        </tr>
        <tr>
            <td width="50%">
            </td>
            <td width="50%" align="center" class="positionRight">
                <div class="printSubHeader">Adres dostawy:</div>
                <div>[[toPrint.imieinazwisko]]</div>
                <div>[[toPrint.dostawa_ulica]]</div>
                <div>[[toPrint.dostawa_kodpocztowy]] [[toPrint.miasto]]</div>
                <div>Tel. [[toPrint.kontakt_telefon]]</div>
                <div>E-mail: [[toPrint.kontakt_mail]]</div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="requestDescription">
                    <div><span><strong>Model Drukarki:</strong></span><span>[[toPrint.modeldrukarki]]</span></div>
                    <div><span><strong>Numer Seryjny:</strong></span><span>[[toPrint.numerseryjny]]</span></div>
                    <div><div><strong>Opis Usterki:</strong></div><div>[[toPrint.opisusterki]]</div></div>
                    <div><div><strong>Uwagi Klienta:</strong></div><div>[[toPrint.uwagiklienta]]</div></div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <ol>
                    <li>Sprzęt przyjęty do serwisu jest diagnozowany tylko pod kątem usterki zgłoszonej przez klienta. Koszt diagnozy wynosi 35 zł  netto + 23 % VAT. Kwota ta nie jest pobierana w przypadku naprawy sprzętu w naszym serwisie.</li>
                    <li>Maksymalny czas naprawy wynosi 14 dni roboczych od daty dostarczenia sprzętu. W przypadku naprawy o szczególnym stopniu trudności lub wymagającej sprowadzenia części, termin naprawy może się przedłużyć po uzgodnieniu z klientem.</li>
                    <li>Serwis nie ponosi odpowiedzialności za dane pozostawione na nośnikach w urządzeniu (np. dyskach twardych) oraz dokumenty pozostawione w urządzeniu.</li>
                    <li>W przypadku gdy koszt naprawy nie przekracza kwoty 100 zł netto , klient zgadza się na naprawę urządzenia bez konsultacji kosztów z klientem.</li>
                    <li>Za sprzęt nieodebrany po 21 dniach od daty zakończenia naprawy serwis nalicza koszty magazynowania w wysokości 5 zł netto za każdy dzień. </li>
                    <li>Sprzęt nieodebrany w ciągu 90 dni od daty pozostawienia go do naprawy zostaje przekazany przez serwis do utylizacji na co klient wyraża zgodę.</li>
                    <li>Niniejszy dokument stanowi jedyną podstawę do odbioru sprzętu z serwisu.</li>
                    <li>Serwis zastrzega sobie prawo do odmowy naprawy. W takim przypadku serwis nie pobiera opłat.</li>
                    <li>Rewers jest jedyną podstawą do odbioru sprzętu z serwisu.</li>
                </ol>
            </td></tr>
        <tr>
            <td width="50%" align="center">Zapoznałem się i akceptuje warunki naprawy:</td>
            <td width="50%" align="center">Potwierdzenie odbioru drukarki z serwisu:</td>
        </tr>
        <tr>
            <td width="50%" align="center" class="printSign"><div>czytelny podpis klienta</div></td>
            <td width="50%" align="center" class="printSign"><div>data i czytelny podpis klienta</div></td>
        </tr>
    </table>
</div>