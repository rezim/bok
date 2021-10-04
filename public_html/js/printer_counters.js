const resolveClassNames = (classNames) => classNames?.length ? classNames?.join(' ') || '' : classNames;
const renderTableCells = (values, colspan, classNames) => values.map(value => `<td colspan="${colspan || 1}" class="${resolveClassNames(classNames)}">${value}</td>`).join('');
const renderTableRows = values => {
    return values.map(value => `<tr>${value}</tr>`).join('');
};
const renderTableHeader = (value) => `<thead>${value}</thead>`;
const renderTableBody = (value) => `<tbody>${value}</tbody>`;
const renderTable = (value, classNames) => `<table class="${resolveClassNames(classNames)}">${value}</table>`;

const renderAgreementRows = (agreement, withCheckbox) => {


    console.log(agreement);
    // filter unique values
    const serials = agreement['serials'].filter((item, pos, self) => self.indexOf(item) === pos);
    const pageStats = [
        {
            pagesStart: agreement['strony_black_start'],
            pagesEnd: agreement['strony_black_koniec'],
            dateStart: agreement['data_wiadomosci_black_start'],
            dateEnd: agreement['data_wiadomosci_black_koniec']
        },
        {
            pagesStart: agreement['strony_kolor_start'],
            pagesEnd: agreement['strony_kolor_koniec'],
            dateStart: agreement['data_wiadomosci_kolor_start'],
            dateEnd: agreement['data_wiadomosci_kolor_koniec']
        }
    ];

    const agreementCells = !withCheckbox ?
        renderTableCells([`umowa: ${agreement['nrumowy']}, klient: ${agreement['nazwakrotka']}`], 6, ['bg-dark text-white'])
        :
        renderTableCells([`umowa: ${agreement['nrumowy']}, klient: ${agreement['nazwakrotka']}`], 5, ['bg-secondary text-white']) +
        renderTableCells([`<input type="checkbox" value="${agreement?.fix?.serial}" checked />`], 1, ['bg-secondary text-white text-right']);


    const agreementRow = renderTableRows([agreementCells]);

    const arrPageTables = ['Czarne', 'Kolorowe'].map((pageType, pageTypeIdx) => {

        const headerCells =
            [
                renderTableCells([pageType], 6, ['text-center', 'font-weight-bold']),
                renderTableCells(['data od', 'data do', 'strony od', 'strony do', 'suma', 'serial'])
            ];

        const arrStatsCells = serials.map(
            (serial, i) => renderTableCells(
                [
                    pageStats[pageTypeIdx].dateStart[i],
                    pageStats[pageTypeIdx].dateEnd[i],
                    pageStats[pageTypeIdx].pagesStart[i],
                    pageStats[pageTypeIdx].pagesEnd[i],
                    pageStats[pageTypeIdx].pagesEnd[i] - pageStats[pageTypeIdx].pagesStart[i],
                    serial
                ]
            )
        );

        const sumOfPageStats = serials.map((_, i) => pageStats[pageTypeIdx].pagesEnd[i] - pageStats[pageTypeIdx].pagesStart[i]).reduce((a, b) => a + b);

        const statsSum = renderTableCells(['razem:'], 4, ['text-right', 'font-weight-bold']) +
            renderTableCells([sumOfPageStats], 2, ['text-left', 'font-weight-bold']);

        return renderTableRows([...headerCells, ...arrStatsCells, statsSum]);
    });

    return [agreementRow, ...arrPageTables].join('');
};


function showPrinterCounters(agreement) {
    const agreements = agreement?.lista_umow ? Object.values(agreement.lista_umow) : [agreement];

    const html = renderTable(agreements.map(agreement => renderAgreementRows(agreement)).join(''), ['printerCounters']);

    $.colorbox({html: html});
}

let fixes = [];

function fixDeviceCounters(data) {

    if (!data) {
        return;
    }

    const clients = Object.values(data);

    const agreements = clients.reduce(
        (agreements, client) => {
            if (!client.umowy) {
                return agreements;
            }
            return agreements.concat(Object.values(client.umowy))
        }, []);

    const agreementsToFix = agreements.reduce(
        (agreements, agreement) => {
            const arrAgreements = agreement.lista_umow ? Object.values(agreement.lista_umow) : [agreement];

            return agreements.concat(arrAgreements.filter(agreement => !!agreement.fix));
        }, []
    );

    fixes = agreementsToFix.map(agreement => agreement.fix);

    let html = renderTable(agreementsToFix.map(agreement => renderAgreementRows(agreement, true)).join(''), ['printerCounters']);


    html += `<div class="container mt-3 mb-3"><div class="container text-right">
                <a href="#" class="btn btn-outline-danger active" role="button" aria-pressed="true" onclick="confirmFixCounters()">
                    <i class="fas fa-save"></i>&nbsp; Popraw</a>
                <a href="#" class="btn btn-outline-secondary" role="button" onclick="$.colorbox.close();">Anuluj</a>
            </div></div>`;

    $.colorbox({html: html, scrolling: true});
}

function confirmFixCounters() {

    const arrSelectedSerials = [];

    $('.printerCounters input[type=checkbox]:checked').each(
        (_, check) =>
            arrSelectedSerials.push($(check).val())
    );


    const arrSelectedFixes = fixes.filter(fix => arrSelectedSerials.some(serial => serial === fix.serial));

    const promisses = arrSelectedFixes.map(fix =>
        $.ajax({
            type: 'POST',
            url: sciezka + "/printers/savestanna/notemplate",
            async: true,
            data: {
                serial: fix.serial,
                stanna: fix.dateTo,
                iloscstron: fix.black,
                iloscstron_kolor: fix.color
            }
        })
    );

    $.colorbox.close();

    Promise.all(promisses).then(() => startReportGeneration());
}

//
// <a href="#" class="btn btn-outline-warning" role="button" aria-pressed="true"
// onclick='showPrinterService("{$dane[0]['umowadane']}", "{$dane[0]['rowid_agreements']}")'><i class="fas fa-history"></i>&nbsp;Historia</a>