app.constant('appConf', {
    ENDPOINT: 'https://otus.fakturownia.pl',
    API_TOKEN: 'kVWaYhlLHXhWQNKDTSk/OTUS',
    EMAIL: {
        SERWIS: {
            POTWIERDZENIE_KOSZTORYSU: {
                TEMAT: '[ZlecenieSerwisowe#[[numer_rewersu]]] - Prośba o akceptację wyceny.',
                TRESC: 'Szacunkowy koszt naprawy wynosi: [[koszt_naprawy]] zł. ' +
                '<br /><br /> Proszę o akceptację kosztu naprawy.' +
                '<br/><br/>' +
                'Pozdrawiamy,<br/>' +
                'Otus Sp. z o.o.<br/>' +
                '+48 71 321 19 06<br/>' +
                '<a href="http://www.otus.pl">www.otus.pl</a><br/>' +
                '<img src="http://www.otus.pl/templates/otus/images/obraz/logo.png" alt="Otus" title="Otus" border="0" height="82" width="150"></img>'
            },
            GOTOWA_DO_ODBIORU: {
                TEMAT: '[ZlecenieSerwisowe#[[numer_rewersu]]] - Urządzenie jest gotowe do odbioru.',
                TRESC: 'Szanowni Państwo, <br /> <br /> urządzenie [[model]] o numerze seryjnym \'[[numer_seryjny]]\' jest gotowe do odbioru. <br /><br /> ' +
                'Informujemy, że mogą Państwo zamówić usługę dostarczenia urządzenia pod wskazany adres. <br /><br />Koszt takiej usługi na terenie Wrocławia wynosi 20 zł netto dla urządzeń do 30 kg.' +
                '<br/><br/>' +
                'Pozdrawiamy,<br/>' +
                'Otus Sp. z o.o.<br/>' +
                '+48 71 321 19 06<br/>' +
                '<a href="http://www.otus.pl">www.otus.pl</a><br/>' +
                '<img src="http://www.otus.pl/templates/otus/images/obraz/logo.png" alt="Otus" title="Otus" border="0" height="82" width="150"></img>'
            }
        }
    }
});