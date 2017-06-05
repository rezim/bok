app.constant('appConf', {
    EMAIL: {
        SERWIS: {
            POTWIERDZENIE_KOSZTORYSU: {
                TEMAT: '[ZlecenieSerwisowe#[[numer_rewersu]]] - Prośba o akceptację wyceny.',
                TRESC: 'Szacunkowy koszt naprawy wynosi: [[koszt_naprawy]] zł. ' +
                '<br /><br /> Proszę o akceptację kosztu naprawy.'
            },
            GOTOWA_DO_ODBIORU: {
                TEMAT: '[ZlecenieSerwisowe#[[numer_rewersu]]] - Urządzenie jest gotowe do odbioru.',
                TRESC: 'Szanowni Państwo, <br /> <br /> urządzenie [[model]] o numerze seryjnym \'[[numer_seryjny]]\' jest gotowe do odbioru. <br /><br /> ' +
                'Informujemy, że mogą Państwo zamówić usługę dostarczenia urządzenia pod wskazany adres. <br /><br />Koszt takiej usługi na terenie Wrocławia wynosi 20 zł netto dla urządzeń do 30 kg.'
            }
        }
    }
});