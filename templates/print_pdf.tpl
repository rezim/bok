{* ==========================================================
   umowa_dzierzawy_1_3.tpl
   Strony 1–3, HTML pod mPDF + Smarty
   - inicjalizacja danych demo (bez PHP notices)
   - wspólny header + wspólna stopka na każdej stronie
   ========================================================== *}

{* ================== 1) SAFE INIT (żeby nie było NOTICE) ================== *}
{if !isset($contract)}{assign var=contract value=[]}{/if}
{if !isset($lessor)}{assign var=lessor value=[]}{/if}
{if !isset($tenant)}{assign var=tenant value=[]}{/if}
{if !isset($device)}{assign var=device value=[]}{/if}
{if !isset($pricing)}{assign var=pricing value=[]}{/if}
{if !isset($company)}{assign var=company value=[]}{/if}
{if !isset($logoPath)}{assign var=logoPath value=''}{/if}

{* ================== 2) DEFAULT DEMO DATA (nadpisuje tylko brakujące) ================== *}
{assign var=contract value=[
'number' => 'UM/01/2024',
'date' => '2024-01-15',
'city' => 'Wrocław',
'term_months' => 36
]|@array_merge:$contract}

{assign var=lessor value=[
'name' => 'Otus Sp. z o.o.',
'address' => 'ul. Wrocławska 23, 55-010 Radwanice',
'krs' => '0000327722',
'nip' => '8982156132',
'representative' => 'Marek Stańko – Prezes Zarządu'
]|@array_merge:$lessor}

{assign var=tenant value=[
'name' => 'ACME Sp. z o.o.',
'representative' => 'Jan Kowalski',
'address' => 'ul. Przykładowa 1, 00-001 Warszawa',
'nip' => '5251234567',
'krs_pesel' => '0000123456',
'invoice_email' => 'faktury@acme.pl',
'install_address' => 'ul. Przykładowa 1, 00-001 Warszawa',
'contact_person' => 'Anna Nowak'
]|@array_merge:$tenant}

{assign var=device value=[
'model' => 'Lexmark MX611de',
'value_net' => '12 500,00'
]|@array_merge:$device}

{assign var=pricing value=[
'rent_net' => '199,00',
'limit_mono' => 3000,
'price_mono_over' => '0,05',
'limit_color' => 500,
'price_color_over' => '0,30',
'limit_scan' => 1000,
'price_scan_over' => '0,02',
'delivery_install_net' => '0,00'
]|@array_merge:$pricing}

{assign var=company value=[
'footer_line1' => 'Otus Sp. z o.o., ul. Wrocławska 23, 55-010 Radwanice tel: +48 71 321 19 06 www.otus.pl',
'footer_line2' => 'NIP : 8982156132  REGON: 020952647  KRS : 0000327722  Sąd Rejonowy dla Wrocławia-Fabrycznej',
'footer_line3' => 'we Wrocławiu VI Wydział gospodarczy KRS  Kapitał zakładowy 50 tys.'
]|@array_merge:$company}

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: dejavusans, sans-serif;
            font-size: 10pt;
            color: #111;
            line-height: 1.3;
        }

        /* ===== HEADER ===== */
        .header-table { width: 100%; border-collapse: collapse; }
        .header-left { width: 70%; vertical-align: top; }
        .header-right { width: 30%; vertical-align: top; text-align: right; }
        .logo { height: 28px; }
        .top-line { border-bottom: 1px solid #666; margin-top: 6px; }

        /* ===== FOOTER ===== */
        .footer {
            font-size: 8.5pt;
            color: #333;
            border-top: 1px solid #666;
            padding-top: 6px;
            line-height: 1.25;
        }

        /* ===== TYPO ===== */
        h1.title {
            font-size: 14pt;
            text-align: center;
            margin: 0 0 8px 0;
            font-weight: bold;
        }
        .intro { margin: 0 0 12px 0; text-align: justify; }
        .para { margin: 0 0 8px 0; text-align: justify; }
        .bold { font-weight: bold; }
        .section-title {
            text-align: center;
            font-weight: bold;
            margin: 10px 0 6px 0;
            font-size: 12pt;
        }
        ol { margin: 0 0 10px 18px; }
        ol li { margin: 0 0 4px 0; }

        /* ===== TABLES ===== */
        .box-table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0 14px 0;
        }
        .box-table td, .box-table th {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: top;
        }
        .box-table .label {
            width: 28%;
            font-weight: bold;
        }

        .params-table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0 14px 0;
        }
        .params-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: top;
        }
        .col-no { width: 7%; text-align: center; }
        .col-name { width: 46%; }
        .col-val { width: 22%; text-align: center; font-weight: bold; }
        .col-note { width: 25%; text-align: left; }

        /* ===== SIGNATURES ===== */
        .sign-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        .sign-table td {
            width: 50%;
            vertical-align: top;
            text-align: center;
        }
        .sign-line {
            border-top: 1px solid #000;
            width: 80%;
            margin: 40px auto 6px auto;
        }
        .sign-label { font-weight: bold; }
        .sign-note { font-size: 10pt; color: #333; }

        /* ===== PAGE BREAK ===== */
        .page-break { page-break-after: always; }
    </style>
</head>

<body>

{* ================== HEADER/FOOTER (mPDF) ================== *}
<htmlpageheader name="docHeader">
    <table class="header-table">
        <tr>
            <td class="header-left">
                {if !empty($logoPath)}
                    <img class="logo" src="{$logoPath|escape}" alt="OTUS" />
                {else}
                    <span style="font-weight:bold;">OTUS</span>
                {/if}
            </td>
            <td class="header-right">
                strona {ldelim}PAGENO{rdelim}/{ldelim}nbpg{rdelim}
            </td>
        </tr>
    </table>
    <div class="top-line"></div>
</htmlpageheader>

<htmlpagefooter name="docFooter">
    <div class="footer">
        {$company.footer_line1|escape}<br/>
        {$company.footer_line2|escape}<br/>
        {$company.footer_line3|escape}
    </div>
</htmlpagefooter>

<sethtmlpageheader name="docHeader" value="on" show-this-page="1" />
<sethtmlpagefooter name="docFooter" value="on" />

{* ==========================================================
   STRONA 1
   ========================================================== *}

<h1 class="title">
    Umowa dzierżawy nr: {$contract.number|escape}
</h1>

<p class="intro">
    zawarta we {$contract.city|escape} dnia {$contract.date|escape}, pomiędzy:
    <span class="bold">{$lessor.name|escape}</span>,
    z siedzibą {$lessor.address|escape},
    wpisaną do rejestru przedsiębiorców pod numerem KRS: {$lessor.krs|escape},
    NIP {$lessor.nip|escape},
    reprezentowaną przez {$lessor.representative|escape},
    zwaną dalej <span class="bold">Wydzierżawiającym</span>
    a zwanym dalej <span class="bold">Dzierżawcą</span>
</p>

<table class="box-table">
    <tr>
        <td colspan="2" class="bold">
            {$tenant.name|escape}
        </td>
    </tr>
    <tr>
        <td class="label">Reprezentowaną przez:</td>
        <td>{$tenant.representative|escape}</td>
    </tr>
    <tr>
        <td class="label">Z siedzibą:</td>
        <td>{$tenant.address|escape}</td>
    </tr>
    <tr>
        <td class="label">NIP:</td>
        <td>
            {$tenant.nip|escape}
            <span style="padding-left:18px;">KRS/PESEL:</span>
            {$tenant.krs_pesel|escape}
        </td>
    </tr>
</table>

<div class="section-title">§ 1</div>
<p class="para">
    Przedmiotem niniejszej umowy jest dzierżawa urządzenia drukującego którego numer fabryczny
    i wyposażenie wyszczególnione są w <span class="bold">Protokole przekazania</span>.
</p>

<table class="params-table">
    <tr>
        <td class="col-no">1</td>
        <td class="col-name">Umowa zostaje zawarta na okres:</td>
        <td class="col-val">{$contract.term_months|escape}</td>
        <td class="col-note">miesiące/cy</td>
    </tr>
    <tr>
        <td class="col-no">2</td>
        <td class="col-name">Model urządzenia:</td>
        <td class="col-val">
            {$device.model|escape}
        </td>
        <td class="col-note">
            wartość: <span class="bold">{$device.value_net|escape}</span> zł netto
        </td>
    </tr>
    <tr>
        <td class="col-no">3</td>
        <td class="col-name">Miesięczny czynsz dzierżawy:</td>
        <td class="col-val">{$pricing.rent_net|escape}</td>
        <td class="col-note">zł netto</td>
    </tr>
    <tr>
        <td class="col-no">4</td>
        <td class="col-name">Stron czarnych A4 w abonamencie:</td>
        <td class="col-val">{$pricing.limit_mono|escape}</td>
        <td class="col-note">
            <span class="bold">{$pricing.price_mono_over|escape}</span> zł netto strona A4 powyżej
        </td>
    </tr>
    <tr>
        <td class="col-no">5</td>
        <td class="col-name">Stron kolorowych A4 w abonamencie:</td>
        <td class="col-val">{$pricing.limit_color|escape}</td>
        <td class="col-note">
            <span class="bold">{$pricing.price_color_over|escape}</span> zł netto strona A4 powyżej
        </td>
    </tr>
    <tr>
        <td class="col-no">6</td>
        <td class="col-name">Skanów A4 w abonamencie:</td>
        <td class="col-val">{$pricing.limit_scan|escape}</td>
        <td class="col-note">
            <span class="bold">{$pricing.price_scan_over|escape}</span> zł netto strona A4 powyżej
        </td>
    </tr>
    <tr>
        <td class="col-no">7</td>
        <td class="col-name">Koszt dostawy i instalacji:</td>
        <td class="col-val">{$pricing.delivery_install_net|escape}</td>
        <td class="col-note">zł netto</td>
    </tr>
    <tr>
        <td class="col-no">8</td>
        <td class="col-name">Adres email do wysyłki faktur:</td>
        <td class="col-val" colspan="2">{$tenant.invoice_email|escape}</td>
    </tr>
    <tr>
        <td class="col-no">9</td>
        <td class="col-name">Adres instalacji urządzenia:</td>
        <td class="col-val" colspan="2">{$tenant.install_address|escape}</td>
    </tr>
    <tr>
        <td class="col-no"></td>
        <td class="col-name">Osoba odpowiedzialna u klienta:</td>
        <td class="col-val" colspan="2">{$tenant.contact_person|escape}</td>
    </tr>
</table>

<div class="section-title">§ 2</div>
<p class="para">
    Wydzierżawiający oddaje w dzierżawę Dzierżawcy urządzenie drukujące, nr fabryczny zgodnie z protokołem
    przekazania oraz zobowiązuje się do dostarczenia i świadczenia kompleksowej obsługi serwisowej dzierżawionego
    urządzenia, a Dzierżawca przedmiot dzierżawy przyjmuje i zobowiązuje się płacić Wydzierżawiającemu umówiony
    czynsz miesięczny opisany w § 1 punkt 3.
</p>

<div class="section-title">§ 3</div>
<ol>
    <li class="para">
        Prawo własności przez cały okres dzierżawy pozostaje przy Wydzierżawiającym.
    </li>
    <li class="para">
        Dzierżawiony sprzęt będzie znajdował się w miejscu wskazanym przez Dzierżawcę i bez zgody
        Wydzierżawiającego nie może zmienić miejsca pobytu. Dzierżawca ma obowiązek poinformować pisemnie
        Wydzierżawiającego o zmianach pobytu urządzenia.
    </li>
</ol>
<div class="page-break"></div>
<ol start="3">
    <li class="para">
        Dzierżawca ponosi pełną odpowiedzialność za uszkodzenie, utratę lub zmniejszenie wartości przedmiotu
        dzierżawy, które powstały w czasie trwania niniejszej umowy chyba, że będą one następstwem normalnego
        użytkowania.
    </li>
    <li class="para">
        Dzierżawca jest zobowiązany udostępnić Wydzierżawiającemu przedmiot dzierżawy na każde jego żądanie.
    </li>
    <li class="para">
        Dzierżawca oświadcza, że zapoznał się z instrukcją obsługi urządzenia i oświadcza, że będzie użytkował
        je zgodnie z jego przeznaczeniem i instrukcją obsługi.
    </li>
</ol>

<div class="section-title">§ 4</div>
<ol>
    <li class="para">
        Wydzierżawiający zapewni sprawne działanie urządzenia przez cały okres dzierżawy oraz usunięcie ewentualnych
        usterek urządzenia w dni robocze w ciągu 48h od zgłoszenia. Zgłoszenia usterek można dokonywać w dni robocze
        w godzinach od 8:00 do 14:00. Usterka zgłoszona po godzinie 14:00 będzie traktowana jako usterka zgłoszona
        następnego dnia o godz. 8:00. W przypadku zgłoszenia usterki w piątek po godz. 14:00 termin na dokonanie
        naprawy biegnie od poniedziałku od godz. 8:00. Na użytek niniejszej umowy sobota nie jest dniem roboczym.
        Zgłaszania usterek należy dokonywać na adres e-mail:
        <a href="../public_html/index.php">serwis@otus.pl</a>
        lub na stronie internetowej www.otus.pl.
    </li>
    <li class="para">
        W przypadku awarii dłuższej niż 48h Wydzierżawiający zobowiązuje się podstawić bezpłatnie urządzenie zastępcze
        na czas naprawy lub wymienić je na inne.
    </li>
    <li class="para">
        Wydatki związane z wymianą części zamiennych, napraw i materiałów eksploatacyjnych wynikające z prawidłowego
        użytkowania urządzenia ponosi Wydzierżawiający.
    </li>
    <li class="para">
        W przypadku, gdy na skutek uszkodzeń mechanicznych, nieprzestrzegania instrukcji obsługi lub zaleceń
        Wydzierżawiającego nastąpi uszkodzenie urządzenia, koszty jego usunięcia, tj. części zamiennych i robocizny,
        ponosi Dzierżawca.
    </li>
    <li class="para">
        Usterki związane z działaniem komputerów, nieprawidłowym działaniem sieci komputerowej, konfiguracją nowych
        i dodatkowych komputerów, dodawanie użytkowników, rekonfigurację urządzenia drukującego spowodowane zmianami
        w systemach IT Dzierżawcy oraz wszelkie dodatkowe niewyszczególnione usługi informatyczne nie są objęte
        niniejszą umową i mogą być wykonywane przez Wydzierżawiającego za dodatkową opłatą. Konfiguracja dodatkowych
        komputerów lub rekonfiguracja w trakcie trwania umowy jest dodatkowo płatna.
    </li>
    <li class="para">
        Wydzierżawiający będzie dostarczał do celów eksploatacyjnych tonery. Za dostarczone tonery Dzierżawca nie ponosi
        dodatkowych opłat ponad koszt miesięcznej dzierżawy.
    </li>
</ol>

<div class="section-title">§ 5</div>
<ol>
    <li class="para">
        Dzierżawca będzie wypłacał Wydzierżawiającemu wynagrodzenie ustalone w § 1 pkt 3 przez cały okres trwania umowy
        a w przypadku opóźnienia w zapłacie zobowiązuje się zapłacić odsetki ustawowe za każdy dzień zwłoki. Wynagrodzenie
        podlegać będzie waloryzacji o średnioroczny wskaźnik wzrostu cen towarów i usług konsumpcyjnych ogółem w okresach
        rocznych ze skutkiem od pierwszego dnia miesiąca następującego po miesiącu, w którym został ogłoszony komunikat
        Prezesa GUS w sprawie średniorocznego wskaźnika cen towarów i usług konsumpcyjnych ogółem w roku poprzednim.
        Waloryzacja czynszu nie wymaga aneksu.
    </li>
    <li class="para">
        W cenie abonamentu dzierżawcy przysługuje wydrukowanie ilości stron ustalonych w § 1 punkt 4 oraz punkt 5.
    </li>
    <li class="para">
        Każda wydrukowana strona powyżej limitu o którym mowa w § 1 pkt 4 oraz 5 jest płatna w wysokości ustalonej
        w § 1 pkt 4 oraz 5. Ilość kopii ustala się na podstawie wskazań fabrycznego licznika kopii zamontowanego
        w urządzeniu. Każda strona rozumiana jest jako strona A4. Strony A3 rozliczane są jako dwie strony A4.
    </li>
    <li class="para">
        Skanowanie na urządzeniu jest rozliczane zgodnie z § 1 punkt 6. Każda strona rozumiana jest jako strona A4.
        Strony A3 rozliczane są jako dwie strony A4.
    </li>
    <li class="para">
        Dzierżawcy nie przysługuje upust za wydrukowanie mniejszej ilości stron niż ustalony w § 1 punkt 4 , punkt 5
        oraz punkt 6.
    </li>
    <li class="para">
        Dzierżawca jest zobowiązany do przekazania w formie pisemnej (e-mailem na adres bok@otus.pl) stanu licznika
        na każde żądanie Wydzierżawiającego.
    </li>
    <li class="para">
        Czynsz dzierżawny płatny będzie przelewem na rachunek Wydzierżawiającego na podstawie faktury VAT,
        wystawionej przez Wydzierżawiającego i przesłanej na adres e-mailowy ustalony w § 1 punkt 8 w terminie do
        czternastu dni od jej wystawienia.
    </li>
</ol>
<div class="section-title">§ 6</div>
<ol>
    <li class="para">
        Dzierżawca nie może bez zgody Wypożyczającego oddawać przedmiotu dzierżawy ani jego części osobom trzecim
        w podnajem lub do bezpłatnego używania bez uprzedniej pisemnej zgody Wydzierżawiającego.
    </li>
    <li class="para">
        Dzierżawca nie może ustanawiać zastawu ani obciążeń przedmiotu dzierżawy w jakikolwiek sposób.
        Dzierżawca nie ma prawa przekazać swoich praw i obowiązków wynikających z niniejszej umowy na osoby trzecie.
    </li>
    <li class="para">
        Wydzierżawiający jest uprawniony do bieżącej kontroli liczników, a Dzierżawca jest zobowiązany do udostępnienia
        urządzenia celem wykonania czynności kontrolnych.
    </li>
</ol>

<div class="section-title">§ 7</div>
<ol>
    <li class="para">
        Okres dzierżawy podawany jest w pełnych miesiącach kalendarzowych i wlicza się do niego miesiąc protokolarnego
        przekazania przedmiotu dzierżawy.
    </li>
    <li class="para">
        Po okresie dzierżawy o którym mowa w § 1 pkt 1 umowa przechodzi na czas nieokreślony, w którym może być
        wypowiedziana przez każdą ze stron z jednomiesięcznym okresem wypowiedzenia ze skutkiem na koniec miesiąca,
        chyba że jedna ze stron w ostatnim miesiącu obowiązywania umowy złoży oświadczenie o braku jej kontynuowania.
    </li>
</ol>

<div class="section-title">§ 8</div>
<ol>
    <li class="para">
        Dzierżawca ma prawo wypowiedzieć umowę w okresie o którym mowa w § 1 punkt 1 z jednomiesięcznym okresem
        wypowiedzenia ze skutkiem na koniec miesiąca. Wypowiedzenie takie upoważnia Wydzierżawiającego do naliczenia
        kary umownej w wysokości 50% wartości opłaty miesięcznej, za każdy rozpoczęty miesiąc liczony od dnia
        wypowiedzenia umowy do dnia jej zakończenia. Wypowiedzenie umowy ze strony Dzierżawcy może nastąpić tylko po
        uregulowaniu należności.
    </li>
    <li class="para">
        Dzierżawca może wypowiedzieć umowę bez zachowania terminów wypowiedzenia w przypadku awarii urządzenia powyżej
        7 dni roboczych, licząc od dnia zgłoszenia. Wypowiedzenie takie nie pociąga za sobą obowiązku uiszczenia kary
        umownej z § 8 pkt 1.
    </li>
</ol>

<div class="section-title">§ 9</div>
<ol>
    <li class="para">
        Wydzierżawiający zastrzega sobie prawo do natychmiastowego odstąpienia od umowy, gdy Dzierżawca zalega z
        płaceniem czynszu dłużej niż 14 dni lub gdy Dzierżawca naruszy istotne warunki niniejszej umowy.
        Oświadczenie o odstąpieniu może zostać złożone w ciągu 60 dni od zaistnienia przesłanki od odstąpienia.
    </li>
    <li class="para">
        Wydzierżawiający może odmówić naprawy i konserwacji urządzenia lub dostawy materiałów eksploatacyjnych w
        przypadku posiadania przeterminowanych płatności przez Dzierżawcę.
    </li>
    <li class="para">
        Wypowiedzenie umowy może być złożone jedynie w formie pisemnej i skutecznie dostarczone do siedziby
        Wydzierżawiającego.
    </li>
</ol>
<div class="page-break"></div>
<div class="section-title">§ 10</div>
<p class="para">
    Po zakończeniu umowy dzierżawy Dzierżawca jest zobowiązany zwrócić przedmiot dzierżawy w stanie nie gorszym niż
    wskazuje na to zużycie spowodowane jego normalną eksploatacją. W przypadku zakończenia umowy Wydzierżawca jest
    zobowiązany do niezwłocznego zwrotu Wydzierżawiającemu przedmiotu dzierżawy. Dzierżawca upoważnia Wydzierżawiającego
    do wejścia na teren zakładu Dzierżawcy i odbioru przedmiotu dzierżawy.
</p>

<div class="section-title">§ 11</div>
<ol>
    <li class="para">
        Umowa wchodzi w życie w dniu protokolarnego przekazania przedmiotu dzierżawy. Protokół przekazania stanowi
        integralną część niniejszej umowy.
    </li>
    <li class="para">
        W sprawach nie uregulowanych niniejszą umową obowiązują przepisy Kodeksu Cywilnego. Ewentualne spory mogące
        powstać w związku z wykonywaniem umowy rozstrzygać będzie Sąd Rejonowy we Wrocławiu. Umowę sporządzono w dwóch
        jednobrzmiących egzemplarzach, po jednym dla każdej ze stron.
    </li>
    <li class="para">
        Zmiany Umowy wymagają zachowania formy pisemnej lub <b>elektronicznej (w tym podpisu osobistego z e-dowodu)</b>
        pod rygorem nieważności.
    </li>
</ol>

<table class="sign-table">
    <tr>
        <td>
            <div class="sign-line"></div>
            <div class="sign-label">podpis Wydzierżawiającego</div>
            <div class="sign-note">(otus)</div>
        </td>
        <td>
            <div class="sign-line"></div>
            <div class="sign-label">podpis Dzierżawcy</div>
            <div class="sign-note">(klient)</div>
        </td>
    </tr>
</table>

</body>
</html>
