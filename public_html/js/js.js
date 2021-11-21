/* Polish initialisation for the jQuery UI date picker plugin. */
/* Written by Jacek Wysocki (jacek.wysocki@gmail.com). */
jQuery(function ($) {
    $.datepicker.regional['pl'] = {
        closeText: 'Zamknij',
        prevText: '&#x3c;Poprzedni',
        nextText: 'Następny&#x3e;',
        currentText: 'Dziś',
        monthNames: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec',
            'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
        monthNamesShort: ['Sty', 'Lu', 'Mar', 'Kw', 'Maj', 'Cze',
            'Lip', 'Sie', 'Wrz', 'Pa', 'Lis', 'Gru'],
        dayNames: ['Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'],
        dayNamesShort: ['Nie', 'Pn', 'Wt', 'Śr', 'Czw', 'Pt', 'So'],
        dayNamesMin: ['N', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'So'],
        weekHeader: 'Tydz',
        dateFormat: 'yy-mm-dd',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        timeText: 'Czas',
        hourText: 'Godzina',
        minuteText: 'Minuty',
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['pl']);
});

function showSzczegolyRaportRozwin(tr) {
    var obj = document.getElementById(tr);


    if ($(obj).attr('stan') == '0') {
        $(obj).attr('stan', '1');
        $(obj).show();
    } else {
        $(obj).attr('stan', '0');
        $(obj).hide()
    }
}

function saveConfiguration() {
    var
        doc = document,
        objOk = doc.getElementById('actionok'),
        objError = doc.getElementById('actionerror');

    const data = {
        stawkakilometrowa: doc.getElementById('txtStawkaKilometrowa').value,
        stawkagodzinowa: doc.getElementById('txtStawkaGodzinowa').value
    };

    $.ajax({
        type: 'POST',
        url: sciezka + "/config/saveconfiguration/notemplate",
        async: true,
        data,
        success: function (dane) {
            checkReplay(objError, null, null, null, dane, objOk, 1, 3000, null);
            return false;
        },
        error: function () {

            showError(objError, null, null, null, 10000);
            return false;
        }
    });
}

function clearPaymentMonitoring() {
    if (confirm("Czy na pewno chcesz wyczyścić monitoring płatności swoich klientów?")) {

        var
            doc = document,
            objLoad = doc.getElementById('actionloader'),
            objOk = doc.getElementById('actionok'),
            objError = doc.getElementById('actionerror'),
            objClick = doc.getElementById('actionbuttonclick');

        $.ajax({
            type: 'POST',
            url: sciezka + "/config/clearpaymentsmonitoring/notemplate",
            async: true,
            data: {},
            success: function (dane) {
                checkReplay(objError, objLoad, null, objClick, dane, objOk, 1, 3000, null);
                return false;
            },
            error: function () {

                showError(objError, objLoad, null, objClick, 10000);
                return false;
            }
        });
    }
}

function showConfiguration() {
    $.colorbox
    ({
        height: 250 + 'px',
        width: 500 + 'px',
        title: "Konfiguracja",
        data:
            {},

        href: sciezka + "/config/show/todiv",
        onClosed: function () {

        },
        onComplete: function () {

            $("txtStawkaKilometrowa").focus();
            uprawnienia();
        }
    });
}

function showNewClientAdd(rowid) {

    $.colorbox
    ({
        height: 945 + 'px',
        width: 985 + 'px',
        title: rowid ? "Karta Klienta" : "",
        data:
            {
                rowid: rowid
            },

        href: sciezka + "/clients/addedit/todiv",
        onClosed: function () {

        },
        onComplete: function () {

            $("#txtNazwaKrotka").focus();
            uprawnienia();
        }
    });
}

function showNewTonerAdd(rowid, typ) {

    $.colorbox
    ({
        height: 650 + 'px',
        width: 600 + 'px',
        title: "Dodawanie/Edycja tonera",
        data:
            {
                rowid: rowid,
                typ: typ
            },

        href: sciezka + "/toners/addedit/todiv",
        onClosed: function () {

        },
        onComplete: function () {
            uprawnienia();
        }
    });
}

function showNewConsumablesAdd(rowid) {

    $.colorbox
    ({
        height: 640 + 'px',
        width: 600 + 'px',
        title: "Dodawanie/Edycja materiału eksploatacyjnego",
        data: { rowid },
        href: sciezka + "/consumables/addedit/todiv",
        onClosed: function () {

        },
        onComplete: function () {
            uprawnienia();
        }
    });
}

function pokazLogi(serial) {

    $.colorbox
    ({
        height: 650 + 'px',
        width: 800 + 'px',
        title: "Logi drukarki : " + serial,
        data:
            {
                serial: serial
            },

        href: sciezka + "/printers/logi/todiv",
        onClosed: function () {


        },
        onComplete: function () {

            uprawnienia();

        }
    });
}


function updateAgreementWithPrinter(rowid, serial) {
    $.ajax({
        type: 'POST',
        url: sciezka + "/agreements/getAgreementPrinterCounters/notemplate",
        async: true,
        data: {
            rowid: rowid,
            serial: serial
        },
        success: function (result) {
            result = (result) ? $.parseJSON(result) : {};
            document.getElementById("counterstart").value = result['ilosc_start'] || '';
            document.getElementById("countercolorstart").value = result['ilosckolor_start'] || '';
            document.getElementById("datacounterstart").value = result['date_start'] || '';
            document.getElementById("counterend").value = result['ilosc_koniec'] || '';
            document.getElementById("countercolorend").value = result['ilosckolor_koniec'] || '';
            document.getElementById("datacounterend").value = result['date_koniec'] || '';
            document.getElementById("prtcntrowid").value = result['rowid'] || 0;

            console.log(result);
            return false;
        },
        error: function () {
            return false;
        }
    });
}

function showNewAgreementAdd(rowid) {

    $.colorbox
    ({
        height: 750 + 'px',
        width: 700 + 'px',
        title: "Dodawanie/Edycja umowy",
        data:
            {
                rowid: rowid
            },

        href: sciezka + "/agreements/addedit/todiv",
        onClosed: function () {

        },
        onComplete: function () {

            $("#txtnrumowy").focus();
            uprawnienia();
        }
    });
}

function showNewPrinterAdd(serial) {

    $.colorbox
    ({
        height: 850 + 'px',
        width: 600 + 'px',
        title: "Dodawanie/Edycja drukarki",
        data:
            {
                serial: serial
            },

        href: sciezka + "/printers/addedit/todiv",
        onClosed: function () {

        },
        onComplete: function () {

            $("#txtserial").focus();
            uprawnienia();
        }
    });
}

function checkReplay(objError, objLoad, info, objClick, dane, objOk, czyreload, showtime, adtrestoredirect) {

    try {
        dane = $.parseJSON(dane);
    } catch (e) {

        showError(objError, objLoad, dane, objClick, showtime);
        return false;
    }
    if (dane.status === 0) {
        showError(objError, objLoad, dane.info, objClick, showtime);
        return false;
    } else {
        showOk(objOk, objLoad, dane.info, objClick, czyreload, showtime, adtrestoredirect);
        return false;
    }
}

function showError(objError, objLoad, info, objClick, showtime) {

    if (info !== null) {
        let errorMessageSection = $(objError);
        if (errorMessageSection.children('span').length) {
            errorMessageSection = errorMessageSection.children('span');
        } else {
            if (errorMessageSection.children('strong').length) {
                errorMessageSection = errorMessageSection.children('strong');
            }
        }
        errorMessageSection.html(info);
    }

    if (objLoad !== null)
        $(objLoad).hide();
    $(objError).fadeIn();

    if (showtime >= 0) {
        setTimeout(
            function () {
                $(objError).hide();
                if (objClick !== null)
                    $(objClick).show();
                return false;
            }, showtime);
    }
}

function showOk(objOk, objLoad, info, objClick, czyreload, showtime, adtrestoredirect) {

    if (info !== null) {
        let successMessageSection = $(objOk);
        if (successMessageSection.children('span').length) {
            successMessageSection = successMessageSection.children('span');
        } else {
            if (successMessageSection.children('strong').length) {
                successMessageSection = successMessageSection.children('strong');
            }
        }
        successMessageSection.html(info)
    }

    if (objLoad !== null)
        $(objLoad).hide();
    $(objOk).fadeIn();

    if (showtime >= 0) {
        setTimeout(
            function () {

                if (czyreload === 1) {
                    $.colorbox.close();
                    if (document.getElementById("tableClient") !== null) {
                        showClients();
                    }
                    if (document.getElementById("tablePrinter") !== null) {
                        showPrinters();
                    }
                    if (document.getElementById("tableUmowy") !== null) {
                        showAgreements();
                    }
                    if (document.getElementById("tableToner") !== null) {
                        pokazTonery();
                    }
                    if (document.getElementById("tableAlert") !== null) {
                        showAlerts('divRightCenter', 'divLoader');
                    }
                    if (document.getElementById("tableCounters") !== null) {
                        showPrintersCounters();
                    }
                    if (document.getElementById("tableMessages") !== null) {
                        showMessages();
                    }
                    if (document.getElementById("tableConsumables") !== null) {
                        showConsumables();
                    }
                } else {
                    $(objOk).hide();
                    if (objClick !== null)
                        $(objClick).show();
                }

                return false;
            }, showtime);
    }
    // we dont want to wait for table report to be reloaded, it takes some time, so start operation ASAP
    if (document.getElementById("tableReport") !== null) {
        generujRaport(function (data, params) {
            invMgr.refreshInvoices(params);
            invMgr.showAgreementWarnings(params);
        });
    }
}

function zapiszKlienta(rowid) {
    var
        doc = document,
        objLoad = doc.getElementById('actionloader'),
        objOk = doc.getElementById('actionok'),
        objError = doc.getElementById('actionerror'),
        objClick = doc.getElementById('actionbuttonclick');


    $(objClick).hide();
    $(objLoad).show();

    let data = {
        rowid: rowid,
        nazwakrotka: doc.getElementById('txtNazwaKrotka').value,
        nazwapelna: doc.getElementById('txtNazwaPelna').value,
        ulica: doc.getElementById('txtUlica').value,
        miasto: doc.getElementById('txtMiasto').value,
        kodpocztowy: doc.getElementById('txtKodPocztowy').value,
        opis: doc.getElementById('txtDodatkowyOpis').value,
        opiekunklienta: doc.getElementById('txtOpiekunKlienta').value,
        branza: doc.getElementById('txtBranza').value,
        telefon: doc.getElementById('txtKontaktTelefon').value,
        mail: doc.getElementById('txtKontaktEmail').value,
        stanowisko: doc.getElementById('txtKontaktStanowisko').value,
        zamowieniatelefon: doc.getElementById('txtZamowieniaTelefon').value,
        zamowieniaemail: doc.getElementById('txtZamowieniaEmail').value,
        zamowieniastanowisko: doc.getElementById('txtZamowieniaStanowisko').value,
        fakturyimienazwisko: doc.getElementById('txtFakturyImieNazwisko').value,
        fakturyemail: doc.getElementById('txtFakturyEmail').value,
        fakturykomorka: doc.getElementById('txtFakturyKomorka').value,
        fakturytelefon: doc.getElementById('txtFakturyTelefon').value,
        fakturystanowisko: doc.getElementById('txtFakturyStanowisko').value,
        fakturyuwagi: doc.getElementById('txtFakturyUwagi').value,
        imienazwisko: doc.getElementById('txtKontaktImieNazwisko').value,
        zamowieniaimienazwisko: doc.getElementById('txtZamowieniaImieNazwisko').value,
        mailfaktury: doc.getElementById('txtMailFaktury').value
    };

    if (doc.getElementById("checkPokazNumerSeryjny")) {
        data['pokaznumerseryjny'] = doc.getElementById("checkPokazNumerSeryjny").checked ? 1 : 0
    }
    if (doc.getElementById("checkPokazStanLicznika")) {
        data['pokazstanlicznika'] = doc.getElementById("checkPokazStanLicznika").checked ? 1 : 0
    }
    if (doc.getElementById("checkFakturaDlaKazdejUmowy")) {
        data['fakturadlakazdejumowy'] = doc.getElementById("checkFakturaDlaKazdejUmowy").checked ? 1 : 0
    }
    if (doc.getElementById("checkUmowaZbiorcza")) {
        data['umowazbiorcza'] = doc.getElementById("checkUmowaZbiorcza").checked ? 1 : 0
    }
    if (doc.getElementById("checkMonitoringPlatnosci")) {
        data['monitoringplatnosci'] = doc.getElementById("checkMonitoringPlatnosci").checked ? 1 : 0
    }
    if (doc.getElementById("checkNaliczacOdsetki")) {
        data['naliczacodsetki'] = doc.getElementById("checkNaliczacOdsetki").checked ? 1 : 0
    }

    const protectDisabledValues = true;

    if (!doc.getElementById('txtNip').disabled || !protectDisabledValues) {
        data['nip'] = doc.getElementById('txtNip').value;
    }

    if (!doc.getElementById('txtTerminPlatnosci').disabled || !protectDisabledValues) {
        data['terminplatnosci'] = doc.getElementById('txtTerminPlatnosci').value;
    }

    if (!doc.getElementById('txtBank').disabled || !protectDisabledValues) {
        data['bank'] = doc.getElementById('txtBank').value;
    }

    if (!doc.getElementById('txtNumerRachunku').disabled || !protectDisabledValues) {
        data['numerrachunku'] = doc.getElementById('txtNumerRachunku').value;
    }

    $.ajax({
        type: 'POST',
        url: sciezka + "/clients/saveupdate/notemplate",
        async: true,
        data,
        success: function (dane) {
            checkReplay(objError, objLoad, null, objClick, dane, objOk, 1, 3000, null);
            return false;
        },
        error: function () {

            showError(objError, objLoad, null, objClick, 10000);
            return false;
        }
    });
}

function zapiszToner(rowid) {
    var
        doc = document,
        objLoad = doc.getElementById('actionloader'),
        objOk = doc.getElementById('actionok'),
        objError = doc.getElementById('actionerror'),
        objClick = doc.getElementById('actionbuttonclick');


    $(objClick).hide();
    $(objLoad).show();

    $.ajax({
        type: 'POST',
        url: sciezka + "/toners/saveupdate/notemplate",
        async: true,
        data:
            {
                rowid: rowid,
                serialdrukarka: doc.getElementById('txtdrukarka').value,
                serial: doc.getElementById('txtserial').value,
                typ: doc.getElementById('txttyp').value,
                number: doc.getElementById('txtnumber').value,
                description: doc.getElementById('txtopis').value,
                datainstalacji: doc.getElementById('txtdatainstalacji').value,
                stronmax: doc.getElementById('txtstronmax').value,
                stronpozostalo: doc.getElementById('txtstronpozostalo').value,
                ostatnieuzycie: doc.getElementById('txtostatnieuzycie').value,
                licznikstart: doc.getElementById('txtlicznikstart').value,
                licznikkoniec: doc.getElementById('txtlicznikkoniec').value
            },
        success: function (dane) {
            checkReplay(objError, objLoad, null, objClick, dane, objOk, 1, 3000, null);
            return false;
        },
        error: function () {

            showError(objError, objLoad, null, objClick, 3000);
            return false;
        }
    });
}

function zapiszUmowe(rowid) {
    var
        doc = document,
        objLoad = doc.getElementById('actionloader'),
        objOk = doc.getElementById('actionok'),
        objError = doc.getElementById('actionerror'),
        objClick = doc.getElementById('actionbuttonclick');


    $(objClick).hide();
    $(objLoad).show();

    $.ajax({
        type: 'POST',
        url: sciezka + "/agreements/saveupdate/notemplate",
        async: true,
        data:
            {
                rowid: rowid,
                nrumowy: doc.getElementById('txtnrumowy').value,
                dataod: doc.getElementById('txtdataod').value,
                datado: doc.getElementById('txtdatado').value,
                stronwabonamencie: doc.getElementById('txtiloscstron').value,
                cenazastrone: doc.getElementById('txtcenazastrone').value,
                abonament: doc.getElementById('txtabonament').value,
                kwotawabonamencie: doc.getElementById('txtkwotawabonamencie').value || 0,
                serial: doc.getElementById('txtdrukarka').value,
                odbiorca_id: doc.getElementById('txtodbiorca_id').value,
                rozliczenie: doc.getElementById('txtrozliczenie').value,
                rowidclient: doc.getElementById('txtklient').value,
                opis: doc.getElementById('txtopis').value,
                iloscstron_kolor: doc.getElementById('txtiloscstron_kolor').value,
                cenazastrone_kolor: doc.getElementById('txtcenazastrone_kolor').value,
                cenainstalacji: doc.getElementById('txtcenainstalacji').value,
                rabatdoabonamentu: doc.getElementById('txtrabatdoabonamentu').value,
                rabatdowydrukow: doc.getElementById('txtrabatdowydrukow').value,
                prowizjapartnerska: doc.getElementById('txtprowizjapartnerska').value,
                sla: doc.getElementById('txtsla').value,
                wartoscurzadzenia: doc.getElementById('txtwartoscurzadzenia').value,
                jakczarne: doc.getElementById("checkJakCzarne").checked ? 1 : 0,
                counterstart: doc.getElementById("counterstart").value,
                countercolorstart: doc.getElementById("countercolorstart").value,
                datacounterstart: doc.getElementById("datacounterstart").value,
                counterend: doc.getElementById("counterend").value,
                countercolorend: doc.getElementById("countercolorend").value,
                datacounterend: doc.getElementById("datacounterend").value,
                prtcntrowid: doc.getElementById("prtcntrowid").value,
                rowid_type: doc.getElementById("txttypumowy").value
            },
        success: function (dane) {
            checkReplay(objError, objLoad, null, objClick, dane, objOk, 1, 3000, null);
            return false;
        },
        error: function () {

            showError(objError, objLoad, null, objClick, 3000);
            return false;
        }
    });
}

function zapiszDrukarke(serial) {
    var
        doc = document,
        objLoad = doc.getElementById('actionloader'),
        objOk = doc.getElementById('actionok'),
        objError = doc.getElementById('actionerror'),
        objClick = doc.getElementById('actionbuttonclick');


    $(objClick).hide();
    $(objLoad).show();

    $.ajax({
        type: 'POST',
        url: sciezka + "/printers/saveupdate/notemplate",
        async: true,
        data:
            {
                serial: doc.getElementById('txtserial').value,
                model: doc.getElementById('txtmodel').value,
                product_number: doc.getElementById('txtproduct_number').value,
                nr_firmware: doc.getElementById('txtnr_firmware').value,
                date_firmware: doc.getElementById('txtdate_firmware').value,
                ip: doc.getElementById('txtip').value,
                stan_fuser: doc.getElementById('txtstan_fuser').value,
                stan_adf: doc.getElementById('txtstan_adf').value,
                black_toner: doc.getElementById('txtblack_toner').value,
                iloscstron: doc.getElementById('txtiloscstron').value,
                iloscstron_kolor: doc.getElementById('txtiloscstronkolor').value,
                iloscstron_total: doc.getElementById('txtiloscstrontotal').value,
                type_color: doc.getElementById('checkKolorowa').checked ? 1 : 0,
                opis: doc.getElementById('txtopis').value,
                lokalizacja: doc.getElementById('txtlokalizacja').value,
                ulica: doc.getElementById('txtulica').value,
                miasto: doc.getElementById('txtmiasto').value,
                kodpocztowy: doc.getElementById('txtkodpocztowy').value,
                telefon: doc.getElementById('txttelefon').value,
                mail: doc.getElementById('txtmail').value,
                nazwa: doc.getElementById('txtnazwa').value,
                osobakontaktowa: doc.getElementById('txtosobakontaktowa').value
            },
        success: function (dane) {
            checkReplay(objError, objLoad, null, objClick, dane, objOk, 1, 3000, null);
            return false;
        },
        error: function () {

            showError(objError, objLoad, null, objClick, 3000);
            return false;
        }
    });
}

function zapiszStanNa(serial) {
    var
        doc = document,
        objLoad = doc.getElementById('actionloader'),
        objOk = doc.getElementById('actionok'),
        objError = doc.getElementById('actionerror'),
        objClick = doc.getElementById('actionbuttonclick');


    $(objClick).hide();
    $(objLoad).show();

    $.ajax({
        type: 'POST',
        url: sciezka + "/printers/savestanna/notemplate",
        async: true,
        data:
            {
                serial: doc.getElementById('txtserial').value,
                iloscstron: doc.getElementById('txtiloscstron').value,
                iloscstron_kolor: doc.getElementById('txtiloscstronkolor').value,
                stanna: doc.getElementById('txtstanna').value,
            },
        success: function (dane) {
            checkReplay(objError, objLoad, null, objClick, dane, objOk, 0, 3000, null);
            return false;
        },
        error: function () {

            showError(objError, objLoad, null, objClick, 3000);
            return false;
        }
    });
}

function usunKlienta(rowid) {
    if (confirm("Czy na pewno chcesz usunąć tego klienta ? ")) {

        $.ajax({
            type: 'POST',
            url: sciezka + "/clients/delete/notemplate",
            async: true,
            data:
                {
                    rowid: rowid
                },
            success: function (dane) {
                try {
                    dane = $.parseJSON(dane);
                } catch (e) {

                    alert('Błąd usunięcia klienta -' + dane);
                    return false;
                }
                if (dane.status === 0) {
                    alert('Błąd usunięcia klienta -' + dane.info);
                    return false;
                } else {
                    alert('Klienta usunięty poprawnie');
                    $.colorbox.close();
                    showClients();
                    return false;
                }
                return false;
            },
            error: function () {

                alert('Problem z usunięciem tego klienta');
                return false;
            }
        });
    }


}

function usunUmowe(rowid) {
    if (confirm("Czy na pewno chcesz usunąć tą umowę ? ")) {

        $.ajax({
            type: 'POST',
            url: sciezka + "/agreements/delete/notemplate",
            async: true,
            data:
                {
                    rowid: rowid,
                    serial: document.getElementById('txtdrukarka').value,
                    counterstart: document.getElementById("counterstart").value,
                    countercolorstart: document.getElementById("countercolorstart").value,
                    datacounterstart: document.getElementById("datacounterstart").value,
                    counterend: document.getElementById("counterend").value,
                    countercolorend: document.getElementById("countercolorend").value,
                    datacounterend: document.getElementById("datacounterend").value,
                    prtcntrowid: document.getElementById("prtcntrowid").value
                },
            success: function (dane) {
                try {
                    dane = $.parseJSON(dane);
                } catch (e) {

                    alert('Błąd usunięcia umowy -' + dane);
                    return false;
                }
                if (dane.status === 0) {
                    alert('Błąd usunięcia umowy -' + dane.info);
                    return false;
                } else {
                    alert('Umowa usunięta poprawnie');
                    $.colorbox.close();
                    showAgreements();
                    return false;
                }
                return false;
            },
            error: function () {

                alert('Problem z usunięciem tej umowy');
                return false;
            }
        });
    }


}

function usunDrukarke(serial) {
    if (confirm("Czy na pewno chcesz usunąć tą drukarkę ? ")) {

        $.ajax({
            type: 'POST',
            url: sciezka + "/printers/delete/notemplate",
            async: true,
            data:
                {
                    serial: serial
                },
            success: function (dane) {
                try {
                    dane = $.parseJSON(dane);
                } catch (e) {

                    alert('Błąd usunięcia druakrki -' + dane);
                    return false;
                }
                if (dane.status === 0) {
                    alert('Błąd usunięcia drukarki -' + dane.info);
                    return false;
                } else {
                    alert('Drukarka usunięta poprawnie');
                    $.colorbox.close();
                    showPrinters();
                    return false;
                }
                return false;
            },
            error: function () {

                alert('Problem z usunięciem tej drukarki');
                return false;
            }
        });
    }

}

function generujRaport(successCallback, errorCallback) {
    var doc = document, objCenter = doc.getElementById('divRightCenter');

    var params = {
        dateFrom: doc.getElementById('txtdataod').value,
        dateTo: doc.getElementById('txtdatado').value
    };
    $.ajax({
        url: sciezka + "/reports/showdaneklient/todiv",
        type: 'POST',
        data: {
            dataod: params.dateFrom,
            datado: params.dateTo,
            filterklient: doc.getElementById('txtklient')?.value,
            filterdrukarka: doc.getElementById('txtdrukarka')?.value
        },
        success: function (data) {
            objCenter.innerHTML = '';
            objCenter.innerHTML = data;
            $(objCenter).animate({opacity: 1}, 1500);

            evalScript(objCenter);

            //if (successCallback) {
            successCallback(data, params);
            //}
        },
        error: function (err) {
            objCenter.innerHTML = 'Problem z wygenerowaniem raportu';
            //if (errorCallback) {
            errorCallback(err);
            //}
        }
    }).done(function () {
        $("#tableReport").tablesorter();
        uprawnienia();
    });
    delete objLoad;
    return false;
}

function showColorTonerInfo(id) {
    var obj = document.getElementById(id);

    if ($(obj).attr('vis') === '0') {
        $(obj).show();
        $(obj).attr('vis', "1");
    } else {
        $(obj).hide();
        $(obj).attr('vis', "0");
    }
}

function pokazUmowy2(objtoshow, objtoload, czycolorbox) {

    var doc = document, objCenter = doc.getElementById(objtoshow), objLoad = doc.getElementById(objtoload);
    objCenter.innerHTML = '';
    objLoad.innerHTML = '<p><img src="light/img/loader.gif" alt="Loading" /></p>';

    $.ajax({
        url: sciezka + "/agreements/showdane2/todiv",
        type: 'POST',
        data: {
            filternrumowy: doc.getElementById('txtfilternrumowy' + czycolorbox).value,
            filterserial: doc.getElementById('txtfilterserial' + czycolorbox).value,
            filternazwaklienta: doc.getElementById('txtfilternazwaklient' + czycolorbox).value,
            pokazzakonczone: doc.getElementById("checkPokazZakonczone" + czycolorbox).checked ? 1 : 0,
            czycolorbox: czycolorbox
        },
        success: function (data) {

            objCenter.innerHTML = data;
            $(objCenter).animate({opacity: 1}, 1500);
        },
        error: function (data) {
            objCenter.innerHTML = data;
        }
    }).done(function () {
        objLoad.innerHTML = '';
        $("#tableUmowy").tablesorter();
        uprawnienia();
    });
    delete objCenter;
    delete objLoad;
    return false;
}

function showUmowyDoKlienta(clientrowid) {
    $.colorbox
    ({
        height: 650 + 'px',
        width: 1200 + 'px',
        title: "Umowy do klienta : ",
        data:
            {
                clientrowid: clientrowid,
                czycolorbox: 1
            },

        href: sciezka + "/agreements/showdane/todiv",
        onClosed: function () {


        },
        onComplete: function () {
            uprawnienia();


        }
    });
}

function showDrukarkiDoKlienta(clientrowid) {
    $.colorbox
    ({
        height: 650 + 'px',
        width: 1200 + 'px',
        title: "Drukarki do klienta : ",
        data:
            {
                clientrowid: clientrowid,
                czycolorbox: 1
            },

        href: sciezka + "/printers/showdane/todiv",
        onClosed: function () {


        },
        onComplete: function () {

            uprawnienia();

        }
    });
}

function setDateDefault() {
    var date = new Date();
    date.setDate(1, 1);

    $('#txtdataod').val($.datepicker.formatDate('yy-mm-dd', date));
    var data = new Date(date);
    data.setMonth(date.getMonth() + 1, 1);
    data.setDate(1, 1);
    $('#txtdatado').val($.datepicker.formatDate('yy-mm-dd', data));
}

function changeMiesiac(obj) {
    var data = $(obj).val();

    if (data == '') {
        var date = new Date();
        date.setDate(1, 1);
        $('#txtdataod').val($.datepicker.formatDate('yy-mm-dd', date));
        var data = new Date(date);
        data.setMonth(date.getMonth() + 1, 1);
        data.setDate(1, 1);
        $('#txtdatado').val($.datepicker.formatDate('yy-mm-dd', data));
    } else {
        var date = new Date(data);
        date.setDate(date.getDate(), 1);
        $('#txtdataod').val($.datepicker.formatDate('yy-mm-dd', date));

        var data = new Date(date);
        data.setMonth(date.getMonth() + 1, 1);
        data.setDate(1, 1);
        $('#txtdatado').val($.datepicker.formatDate('yy-mm-dd', data));
    }
}

function showTonersInfo(printerserial) {

    var doc = document, objCenter = doc.getElementById('tonertd' + printerserial),
        objTR = doc.getElementById('tonertr' + printerserial);

    if ($(objTR).attr('vis') === '0') {

        objCenter.innerHTML = '';
        $.ajax({
            url: sciezka + "/toners/showdane/todiv",
            type: 'POST',
            data: {
                printerserial: printerserial
            },
            success: function (data) {

                objCenter.innerHTML = data;
                $(objTR).show();

            },
            error: function () {
                objCenter.innerHTML = 'Problem z pobraniem tonerów';
                $(objTR).show();
            }
        }).done(function () {
            uprawnienia();
        });
        delete objCenter;

        $(objTR).attr('vis', "1");
    } else {
        $(objTR).hide();
        $(objTR).attr('vis', "0");
    }


    return false;
}

function historiaTonerow(printerserial) {
    $.colorbox
    ({
        height: 650 + 'px',
        width: 1200 + 'px',
        title: "Historia tonerów na drukarce",
        data:
            {
                printerserial: printerserial,
                czyhistoria: 1
            },

        href: sciezka + "/toners/showdane/todiv",
        onClosed: function () {


        },
        onComplete: function () {


        }
    });
}

function usunToner(rowid, typ) {
    if (confirm("Czy na pewno chcesz usunąć ten toner ? ")) {

        var stronkoniec = prompt("Podaj stan wydrukowanych stron w drukarce");

        if (stronkoniec !== null && stronkoniec !== 'undefined' && stronkoniec !== '') {
            $.ajax({
                type: 'POST',
                url: sciezka + "/toners/delete/notemplate",
                async: true,
                data:
                    {
                        rowid: rowid,
                        typ: typ,
                        stronkoniec: stronkoniec
                    },
                success: function (dane) {
                    try {
                        dane = $.parseJSON(dane);
                    } catch (e) {

                        alert('Błąd usunięcia tonera -' + dane);
                        return false;
                    }
                    if (dane.status === 0) {
                        alert('Błąd usunięcia tonera -' + dane.info);
                        return false;
                    } else {
                        alert('Toner usunięty poprawnie');
                        pokazTonery();
                        return false;
                    }
                    return false;
                },
                error: function () {

                    alert('Problem z usunięciem tego tonera');
                    return false;
                }
            });
        } else {
            alert("Musisz podać wartość");
        }
    }
}


function saveConsumable(rowid) {
    let
        doc = document,
        objLoad = doc.getElementById('actionloader'),
        objOk = doc.getElementById('actionok'),
        objError = doc.getElementById('actionerror'),
        objClick = doc.getElementById('actionbuttonclick');

    $.ajax({
        type: 'POST',
        url: sciezka + "/consumables/saveupdate/notemplate",
        async: true,
        data:
            {
                rowid,
                code: $('#txtcode').val(),
                name: $('#txtname').val(),
                model: $('#txtmodel').val().filter(val => val !== ''),
                yield: $('#txtyield').val(),
                price: $('#txtprice').val().replace(',', '.'),
            },
        success: function (dane) {
            checkReplay(objError, objLoad, null, objClick, dane, objOk, 1, 1000, null);
            return false;
        },
        error: function () {
            showError(objError, objLoad, null, objClick, 3000);
            return false;
        }
    });
}

function deleteConsumable(rowid) {
    if (confirm("Czy na pewno chcesz usunąć ten materiał eksploatacyjny ? ")) {
        $.ajax({
            type: 'POST',
            url: sciezka + "/consumables/delete/notemplate",
            async: true,
            data:
                {
                    rowid: rowid
                },
            success: function (dane) {
                try {
                    dane = $.parseJSON(dane);
                } catch (e) {

                    alert('Błąd usunięcia materiału ekspoatacyjnego -' + dane);
                    return false;
                }
                if (dane.status === 0) {
                    alert('Błąd usunięcia materiału ekspoatacyjnego -' + dane.info);
                    return false;
                } else {
                    alert('Materiał eksploatacyjny usunięty poprawnie');
                    showConsumables();
                    return false;
                }
            },
            error: function () {
                alert('Problem z usunięciem tego materiału ekspoatacyjnego');
                return false;
            }
        });
    }
}

function hideshowReportRow(nazwakrotka) {

    var doc = document, objTR = doc.getElementById('tr' + nazwakrotka);

    if ($(objTR).attr('vis') === '0') {

        $(objTR).show();
        $(objTR).attr('vis', "1");
    } else {
        $(objTR).hide();
        $(objTR).attr('vis', "0");
    }


    return false;
}

function showSzczegolyRaport(nazwakrotka) {
    var doc = document;
    $.colorbox
    ({
        height: 650 + 'px',
        width: 1200 + 'px',
        title: "Szczegóły raportu",
        data:
            {
                dataod: doc.getElementById('txtdataod').value,
                datado: doc.getElementById('txtdatado').value,
                filterklient: doc.getElementById('txtklient').value,
                filterdrukarka: doc.getElementById('txtdrukarka').value,
                nazwakrotka: nazwakrotka
            },

        href: sciezka + "/reports/showdane/todiv",
        onClosed: function () {


        },
        onComplete: function () {


        }
    });
}

function wsteczNoti() {
    $("#divFilterNoti").show();
    showListOfNotifications();
}

function zapiszNoti(czydelete, savelink) {
    if (czydelete === "1") {
        if (!confirm("Czy chcesz usunąć ten rekord ?")) {
            return;
        }
    }
    var doc = document,
        objLoad = doc.getElementById('actionloader'),
        objOk = doc.getElementById('actionok'),
        objError = doc.getElementById('actionerror'),
        objClick = doc.getElementById('actionbuttonclick');

    $(objClick).hide();
    $(objLoad).show();
    var objKey = null;

    var dataOfFileds = {};


    $("[name='editobj']").each(function () {
        var attr = $(this).attr('zewnetrznyspan');
        if (typeof attr !== typeof undefined && attr !== false) {
            dataOfFileds[$(this).attr('id')] = $("#" + $(this).attr('zewnetrznyspan')).html();
        } else
            dataOfFileds[$(this).attr('id')] = $(this).val().trim();

        var iskey = $(this).attr('iskey');
        if (typeof iskey !== typeof undefined && iskey !== false && iskey === '1') {
            objKey = this;
        }

    });

    $.ajax({
        type: 'POST',
        url: savelink,
        async: false,
        data:
            {
                _filedsToEdit: unescape(JSON.stringify(dataOfFileds).replace(/\\u/g, '%u')),
                czydelete: czydelete,
            },
        success: function (dane) {

            if (czydelete === '1') {
                checkReplay(objError, objLoad, null, objClick, dane, objOk, -1, 1000, null, 1);
            } else {

                checkReplay(objError, objLoad, null, objClick, dane, objOk, 0, -1, null, 1);
                try {
                    dane = $.parseJSON(dane);
                    // przypisaneni rowid do tetboca

                    setTimeout(
                        function () {
                            showListOfNotifications();
                        }, 2000);


                } catch (e) {


                }

            }
            return false;
        },
        error: function () {
            showErrorMessgae(objError);
            showError(objError, objLoad, null, objClick, 3000);
            return false;
        }
    });


}

function showNotPaidInvoices(clientId, uiContainerSelector) {
    // no client no invoices
    if (clientId === '') {
        return;
    }

    $.ajax({
        url: sciezka + "/notifications/shownotpaidinvoices/todiv",
        type: 'POST',
        data: {
            client_id: clientId
        },
        success: function (data) {
            $(uiContainerSelector).html(data);
        },
        error: function () {
            objCenter.innerHTML = 'Problem z pobraniem faktur';
        }
    }).done(function () {

    });
    return false;
}


function showMaile() {

    if ($("#keyval").html() == '' || $("#keyval").html() == '0')
        return;


    var doc = document, objCenter = doc.getElementById('divMailePowiazane');
    objCenter.innerHTML = '';


    $.ajax({
        url: sciezka + "/notimails/show/todiv",
        type: 'POST',
        data: {
            noti_rowid: $("#keyval").html()
        },
        success: function (data) {

            objCenter.innerHTML = data;
            $(objCenter).animate({opacity: 1}, 1500);
        },
        error: function () {

            objCenter.innerHTML = 'Problem z pobraniem klientów';
        }
    }).done(function () {

        $("#tableNotiMail").tablesorter();
    });
    delete objCenter;
    delete objLoad;
    return false;
}

function newEditMail(replyrowid, czyedit) {


    $.colorbox
    ({
        height: 800 + 'px',
        width: 1200 + 'px',
        title: "Nowy email",
        data:
            {
                replyrowid: replyrowid,
                czyedit: czyedit,
                noti_rowid: $("#keyval").html()
            },

        href: sciezka + "/notimails/neweditmail/todiv",
        onClosed: function () {


        },
        onComplete: function () {


        }
    });

}

function showChangePrinterDialog() {
    $.colorbox
    ({
        height: 800 + 'px',
        width: 1200 + 'px',
        title: "Wymiana Drukarki",
        data:
            {},

        href: sciezka + "/notifications/service/todiv",
        onClosed: function () {


        },
        onComplete: function () {


        }
    });
}

function sendMail(noti_rowid, replyrowid, uniqueid) {


    var doc = document,
        objLoad = doc.getElementById('actionloader2'),
        objOk = doc.getElementById('actionok2'),
        objError = doc.getElementById('actionerror2'),
        objClick = doc.getElementById('actionbuttonclick2');

    // $(objClick).hide();
    $(objLoad).show();


    var data2 = {};


    $("[name='rowid_file_aggrametns']")  // for all checkboxes
        .each(function () {  // first pass, create name mapping

            if ($(this).html() !== '') {
                data2[$(this).html()] = {};
                data2[$(this).html()]['filename'] = $(this).attr('atrfilename');
                data2[$(this).html()]['path'] = $(this).attr('atrpath');
            }
        });


    $.ajax({
        type: 'POST',
        url: sciezka + "/notimails/wyslijmail/notemplate",
        async: false,
        data:
            {
                noti_rowid: noti_rowid,
                replyrowid: replyrowid,
                tresc: $("#txttresc").val(),
                temat: $("#txttemat").val(),
                mail: $("#txtmail").val(),
                uniqueid: uniqueid,
                zalaczniki: data2
            },
        success: function (dane) {

            checkReplay(objError, objLoad, null, objClick, dane, objOk, 0, 3000, null, 1);
            // TR: commented to only check if send email is working fine
            // $.colorbox.close();
            showMaile();

            return false;
        },
        error: function (dane) {

            showError(objError, objLoad, null, objClick, 3000);
            return false;
        }
    });

}

function uprawnienia() {
    if (val2 !== null) {

        $('[wymaganylevel]').each(function () {

            var value = $(this).attr('wymaganylevel');


            if (value == 'r' && $(this).attr('wymaganyzrobiony') == '0') {
                if (val2.indexOf(value) === -1) {
                    $(this).css('display', 'none');
                }
            }
            if (value == 'w' && $(this).attr('wymaganyzrobiony') == '0') {

                if (val2.indexOf(value) === -1) {

                    if ($(this).is("a")) {

                        $(this).css('display', 'none');

                    } else if ($(this).is("img")) {
                        $(this).css('display', 'none');

                    } else if ($(this).is("div")) {
                        $(this).css('display', 'none');

                    } else if ($(this).is("th")) {
                        $(this).css('display', 'none');

                    } else if ($(this).is("td")) {
                        $(this).css('display', 'none');

                    } else {
                        $(this).prop('disabled', true);
                    }

                }
            }
            $(this).attr('wymaganyzrobiony', '1');


        });
    }
}

function savePrinterCounters(previousBlack, previousColor, serial) {
    var
        doc = document,
        objLoad = doc.getElementById('actionloader'),
        objOk = doc.getElementById('actionok'),
        objError = doc.getElementById('actionerror'),
        objErrorWrongValue = doc.getElementById('actionerrorwrongvalue'),
        objClick = doc.getElementById('actionbuttonclick');


    $(objClick).hide();
    $(objErrorWrongValue).hide();
    $(objLoad).show();


    // check if value is not smaller then the original one
    var blackCount = doc.getElementById('blackCount_' + serial) ? parseInt(doc.getElementById('blackCount_' + serial).value.replace(/\s+/g, '')) : 0;
    var colorCount = doc.getElementById('colorCount_' + serial) ? parseInt(doc.getElementById('colorCount_' + serial).value.replace(/\s+/g, '')) : 0;
    previousBlack = parseInt(previousBlack.replace(/\s+/g, ''));
    previousColor = parseInt(previousColor.replace(/\s+/g, ''));

    if (blackCount < previousBlack || colorCount < previousColor) {
        $(objErrorWrongValue).show();
        $(objLoad).hide();
    } else {

        var message = 'Czarne: ' + blackCount;
        if (doc.getElementById('colorCount_' + serial)) {
            message += ', Kolor: ' + colorCount + '.';
        }
        message += '. Potwierdzasz ?';

        if (confirm(message)) {

            var d = {
                serial: serial,
                iloscstron: doc.getElementById('blackCount_' + serial).value,
                stanna: doc.getElementById('dateToSave_' + serial).value
            };
            if (doc.getElementById('colorCount_' + serial)) {
                d['iloscstron_kolor'] = doc.getElementById('colorCount_' + serial).value;
            }

            $.ajax({
                type: 'POST',
                url: sciezka + "/printers/savestanna/notemplate",
                async: true,
                data: d,
                success: function (dane) {
                    checkReplay(objError, objLoad, null, objClick, dane, objOk, 1, 3000, null);
                    return false;
                },
                error: function () {

                    showError(objError, objLoad, null, objClick, 3000);
                    return false;
                }
            });
        }
    }
}


function replacePrinter(serial, newSerial, rowid_agreement) {
    var data = {
        serial: serial,
        newSerial: newSerial,
        rowid_agreement: rowid_agreement,
        counterEnd: document.getElementById('counterEnd').value,
        counterStart: document.getElementById('counterStart').value,
        counterColorEnd: document.getElementById('counterColorEnd').value,
        counterColorStart: document.getElementById('counterColorStart').value,
        replacementDate: document.getElementById('replacementDate').value
    };
    $.ajax({
        type: 'POST',
        url: sciezka + "/printers/replacePrinter/notemplate",
        async: true,
        data: data,
        success: function (dane) {
            alert('Dane zapisane poprawnie');
            return false;
        },
        error: function () {

            // showError(objError, objLoad, null, objClick, 3000);
            return false;
        }
    });
}

function showPrinterService(agreement, rowid_agreement) {
    $.colorbox
    ({
        height: 650 + 'px',
        width: 950 + 'px',
        title: "Historia serwisu drukarek dla umowy : " + agreement,
        data:
            {
                rowid_agreement: rowid_agreement
            },

        href: sciezka + "/printers/service/todiv",
        onClosed: function () {


        },
        onComplete: function () {

            uprawnienia();

        }
    });
}

function removePrinterService(rowid, serial) {
    if (confirm("Czy na pewno chcesz usunąć ? ")) {

        $.ajax({
            type: 'POST',
            url: sciezka + "/printers/removeService/notemplate",
            async: true,
            data:
                {
                    rowid: rowid
                },
            success: function (dane) {
                try {
                    dane = $.parseJSON(dane);
                } catch (e) {

                    alert('Błąd usunięcia -' + dane);
                    return false;
                }
                if (dane.status === 0) {
                    alert('Błąd usunięcia -' + dane.info);
                    return false;
                } else {
                    alert('Usunięty.');
                    $.colorbox.close();
                    showPrinterService(serial);
                    return false;
                }
                return false;
            },
            error: function () {

                alert('Problem z usunięciem');
                return false;
            }
        });
    }
}

function generateProfitsReport(successCallback, errorCallback) {
    var doc = document, objCenter = doc.getElementById('divRightCenter'), objLoad = doc.getElementById('divLoader');
    objCenter.innerHTML = '';
    objLoad.innerHTML = '<p><img src="light/img/loader.gif" alt="Loading" /></p>';

    var params = {
        dateFrom: doc.getElementById('txtdataod').value,
        dateTo: doc.getElementById('txtdatado').value
    };
    $.ajax({
        url: sciezka + "/profitability/showdaneklient/todiv",
        type: 'POST',
        data: {
            dataod: params.dateFrom,
            datado: params.dateTo,
            filterklient: doc.getElementById('txtklient').value,
            filterdrukarka: doc.getElementById('txtdrukarka').value
        },
        success: function (data) {

            objCenter.innerHTML = data;
            $(objCenter).animate({opacity: 1}, 1500);

            successCallback(data, params);
        },
        error: function (err) {
            objCenter.innerHTML = 'Problem z wygenerowaniem raportu';

            errorCallback(err);
        }
    }).done(function () {
        objLoad.innerHTML = '';
        $("#tableReport").tablesorter();
        uprawnienia();
    });
    delete objCenter;
    delete objLoad;
    return false;
}

function show(path) {
    window.location = sciezka + path;
}

function closeColorbox(callback) {
    $.colorbox.close();
    if (callback) {
        callback();
    }
}

function saveUpdateMessage(type) {
    var
        doc = document,
        objLoad = doc.getElementById('actionloader'),
        objOk = doc.getElementById('actionok'),
        objError = doc.getElementById('actionerror'),
        objClick = doc.getElementById('actionbuttonclick');

    $.ajax({
        type: 'POST',
        url: sciezka + ((!type) ? "/messages/saveupdate/notemplate" : "/messagesinvoices/saveupdate/notemplate"),
        async: true,
        data:
            {
                message: doc.getElementById('messageArea').value
            },
        success: function (dane) {
            // checkReplay(objError,objLoad,null,objClick,dane,objOk,1,3000,null);
            showMessages(type);
            doc.getElementById('messageArea').value = '';
            return false;
        },
        error: function () {
            showError(objError, objLoad, null, objClick, 3000);
            return false;
        }
    });
}

function showMessages(type) {
    const objCenter = getElementById('divRightCenter');

    $.ajax({
        url: sciezka + ((!type) ? "/messages/showdane/todiv" : "/messagesinvoices/showdane/todiv"),
        type: 'POST',
        data: {},
        success: function (data) {
            objCenter.innerHTML = data;
            $(objCenter).animate({opacity: 1}, 1500);
        },
        error: function () {
            objCenter.innerHTML = 'Problem z pobraniem wiadomości';
        }
    }).done(function () {
        uprawnienia();
    });
    return false;
}

function removeMessage(rowid, type) {

    if (confirm('Czy na pewno chcesz usunąć wiadomość ?')) {
        const objCenter = getElementById('divRightCenter');

        $.ajax({
            url: sciezka + ((!type) ? "/messages/remove/todiv" : "/messagesinvoices/remove/todiv"),
            type: 'POST',
            data: {
                rowid: rowid
            },
            success: function (data) {
                showMessages(type);
            },
            error: function () {
                objCenter.innerHTML = 'Problem z usunięciem wiadomości';
            }
        }).done(function () {
            uprawnienia();
        });
    }
    return false;
}

function showPrinters(isPopup) {
    const objCenter = getElementById('divRightCenter', isPopup);

    $.ajax({
        url: sciezka + "/printers/showdane/todiv",
        type: 'POST',
        data: {
            filterserial: getElementById('txtfilterserial', isPopup).value,
            filtermodel: getElementById('txtfiltermodel', isPopup).value,
            filterklient: getElementById('txtfilterklient', isPopup).value,
            czycolorbox: isPopup
        },
        success: function (data) {
            objCenter.innerHTML = '';
            objCenter.innerHTML = data;
            $(objCenter).animate({opacity: 1}, 1500);
        },
        error: function () {
            objCenter.innerHTML = 'Problem z pobraniem drukarek';
        }
    }).done(function () {
        $("#tablePrinter").tablesorter();
        uprawnienia();
    });
    return false;
}

function showPrintersCounters(successCallback, errorCallback) {

    var doc = document, objCenter = doc.getElementById('divRightCenter');

    var dateFrom = new Date();
    dateFrom.setDate(1);
    dateFrom.setMonth(dateFrom.getMonth() - 1);

    var dateTo = new Date(dateFrom);
    dateTo.setMonth(dateFrom.getMonth() + 1, 1);
    dateTo.setDate(1, 1);

    var params = {
        dateFrom: $.datepicker.formatDate('yy-mm-dd', dateFrom),
        dateTo: $.datepicker.formatDate('yy-mm-dd', dateTo)
    };
    $.ajax({
        url: sciezka + "/custom/showdaneklient/todiv",
        type: 'POST',
        data: {
            dataod: params.dateFrom,
            datado: params.dateTo
        },
        success: function (data) {
            objCenter.innerHTML = '';
            objCenter.innerHTML = data;
            $(objCenter).animate({opacity: 1}, 1500);

            $('.printerCounterDateTo').datepicker($.datepicker.regional['pl'], {
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                showOtherMonths: true,
                selectOtherMonths: true
            });

            $('.printerCounterDateTo').val($.datepicker.formatDate('yy-mm-dd', new Date(params.dateTo)));

            if (successCallback) {
                successCallback(data, params);
            }

        },
        error: function (err) {
            objCenter.innerHTML = 'Problem z wygenerowaniem raportu';

            if (errorCallback) {
                errorCallback(err);
            }
        }
    }).done(function () {
        $("#tableReport").tablesorter();
        uprawnienia();
    });
    delete objCenter;

    return false;
}

function showAlerts(objtoshow, objtoload, czycolorbox) {
    const doc = document;
    const objCenterId = czycolorbox ? 'divRightCenter' + czycolorbox : 'divRightCenter';
    const objCenter = doc.getElementById(objCenterId);

    $.ajax({
        url: sciezka + "/alerts/showdane/todiv",
        type: 'POST',
        data: {
            czycolorbox: czycolorbox
        },
        success: function (data) {
            objCenter.innerHTML = data;
            $(objCenter).animate({opacity: 1}, 1500);
        },
        error: function () {
            objCenter.innerHTML = 'Problem z pobraniem drukarek';
        }
    }).done(function () {
        $("#tablePrinter").tablesorter();
        uprawnienia();
    });
    return false;
}

function pokazTonery() {
    const doc = document;
    const objCenterId = 'divRightCenter';
    const objCenter = doc.getElementById(objCenterId);

    $.ajax({
        url: sciezka + "/toners/showdane/todiv",
        type: 'POST',
        data: {
            filterserial: doc.getElementById('txtfilterserial').value,
            filterdrukarka: doc.getElementById('txtfilterdrukarka').value,
            czyhistoria: doc.getElementById("txttonerzakonczone").checked ? 1 : 0,
        },
        success: function (data) {
            objCenter.innerHTML = data;
            $(objCenter).animate({opacity: 1}, 1500);
        },
        error: function () {
            objCenter.innerHTML = 'Problem z pobraniem tonerów';
        }
    }).done(function () {
        $("#tableToner").tablesorter();
        uprawnienia();
    });
    return false;
}


function showConsumables() {
    const doc = document;
    const objCenterId = 'divRightCenter';
    const objCenter = doc.getElementById(objCenterId);

    $.ajax({
        url: sciezka + "/consumables/showdane/todiv",
        type: 'POST',
        data: {
            filtername: doc.getElementById('txtfiltername').value,
            filtermodel: doc.getElementById('txtfiltermodel').value,
        },
        success: function (data) {
            objCenter.innerHTML = data;
            $(objCenter).animate({opacity: 1}, 1500);
        },
        error: function () {
            objCenter.innerHTML = 'Problem z pobraniem materiałów eksploatacyjnych';
        }
    }).done(function () {
        $("#tableConsumables").tablesorter();
        uprawnienia();
    });
    return false;
}

function showClients(czycolorbox) {
    const doc = document;
    const objCenterId = czycolorbox ? 'divRightCenter' + czycolorbox : 'divRightCenter';
    const objCenter = doc.getElementById(objCenterId);

    $.ajax({
        url: sciezka + "/clients/showdane/todiv",
        type: 'POST',
        data: {
            filternazwa: doc.getElementById('txtfilternazwa').value,
            filternip: doc.getElementById('txtfilternip').value,
            filtermiasto: doc.getElementById('txtfiltermiasto').value,
            filterserial: doc.getElementById('txtfilterserial').value,
            czycolorbox: czycolorbox
        },
        success: function (data) {
            objCenter.innerHTML = data;
            $(objCenter).animate({opacity: 1}, 1500);
        },
        error: function () {
            objCenter.innerHTML = 'Problem z pobraniem klientów';
        }
    }).done(function () {
        $("#tableClient").tablesorter();
        uprawnienia();
    });
    return false;
}

function showAgreements(isPopup) {
    const objCenter = getElementById('divRightCenter', isPopup);

    $.ajax({
        url: sciezka + "/agreements/showdane/todiv",
        type: 'POST',
        data: {
            filternrumowy: getElementById('txtfilternrumowy', isPopup).value,
            filterserial: getElementById('txtfilterserial', isPopup).value,
            filternazwaklienta: getElementById('txtfilternazwaklienta', isPopup).value,
            pokazzakonczone: getElementById('checkPokazZakonczone', isPopup).checked ? 1 : 0,
            czycolorbox: isPopup
        },
        success: function (data) {
            objCenter.innerHTML = '';
            objCenter.innerHTML = data;
            $(objCenter).animate({opacity: 1}, 1500);
        },
        error: function (data) {
            objCenter.innerHTML = data;
        }
    }).done(function () {
        $("#tableUmowy").tablesorter();
        uprawnienia();
    });
    return false;
}

function showListOfNotifications() {
    const objCenter = getElementById('divRightCenter');

    var statusy = {};

    $("input[type=checkbox][name='txtstatus']")  // for all checkboxes
        .each(function () {  // first pass, create name mapping

            if (this.checked) {
                statusy[$(this).attr('id')] = '1';
            }
        });


    $.ajax({
        url: sciezka + "/notifications/showdane/todiv",
        type: 'POST',
        data: {
            filterklient: getElementById('txtfilterklient').value,
            filternrseryjny: getElementById('txtfilternrseryjny').value,
            filternrzlecenia: getElementById('txtfilternrzlecenia').value,
            filterdataod: getElementById('txtfilterdataod').value,
            filterdatado: getElementById('txtfilterdatado').value,
            filterstatusy: statusy,
        },
        success: function (data) {
            objCenter.innerHTML = '';
            objCenter.innerHTML = data;
            $(objCenter).animate({opacity: 1}, 1500);
        },
        error: function () {

            objCenter.innerHTML = 'Problem z pobraniem klientów';
        }
    }).done(function () {
        $("#tableNoti").tablesorter();
        uprawnienia();
    });
    return false;
}

function showNewNotiAdd(rowid, serial, tonertype) {
    $.colorbox
    ({
        width: 1000 + 'px',
        data:
            {
                keyVal: rowid,
                keyname: 'rowid',
                serial: serial,
                tonertype: tonertype
            },

        href: sciezka + "/notifications/addedit/todiv",
        onClosed: function () {

        },
        onComplete: function () {
            $("#tableNoti").tablesorter();
            $('#date_email').datepicker($.datepicker.regional['pl'], {
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
            });
            uprawnienia();
        },
        escKey: false
    });
}

function editNotification(rowid) {

    $.colorbox
    ({
        width: 1000 + 'px',
        data:
            {
                keyVal: rowid,
                keyname: 'rowid'
            },

        href: sciezka + "/notifications/addedit/todiv",
        onClosed: function () {

        },
        onComplete: function () {
            uprawnienia();
        },
        escKey: false
    });
}

function openDataShow(link, idzewnetrznespan) {
    const data = {
        czycolorbox: '#selectNotificationData',
        clientnazwakrotka: $("#rowid_client").val(),
        serial: $("#serial").val(),
    };
    loadAsyncData(link, data, function (data) {
        const modal = $('#selectNotificationData');

        modal.on('show.bs.modal', function (event) {

            modal.find('.modal-body').html(data);

            modal.on('hidden.bs.modal', function (event) {
                modal.find('.modal-body').html('');
                modal.unbind();
            });
        });

        modal.modal({keyboard: true});
    });

}

function dataRowSelectedHandler(targetElement) {
    const targetObj = $(targetElement);
    const sourceName = targetObj.attr('data-source');
    const modalSelector = targetObj.attr('data-modalselector');
    switch (sourceName) {
        case "clients":
            $('#idclientspan').html(targetObj.attr('data-clientid'));
            $('#rowid_client').val(targetObj.attr('data-clientname'));
            if ($('#email').val() === '') {
                $('#email').val(targetObj.attr('data-clientemail'));
            }
            showNotPaidInvoices(targetObj.attr('data-clientid'), '#invoicesContainer');
            break;
        case "agreements":
            $('#idumowaspan').html(targetObj.attr('data-agreementid'));
            $('#rowid_agreements').val(targetObj.attr('data-agreementnb'));
            $('#sla').val(targetObj.attr('data-sla'));
            break;
        case "devices":
            $('#idserialspan').html(targetObj.attr('data-serial'));
            $('#serial').val(targetObj.attr('data-serial')).change();

            $('#rowid_client').val(targetObj.attr('data-clientname'));
            $('#idclientspan').html(targetObj.attr('data-clientid'));

            $('#rowid_agreements').val(targetObj.attr('data-agreementnb'));
            $('#idumowaspan').html(targetObj.attr('data-agreementid'));

            $('#sla').val(targetObj.attr('data-sla'));
            break;
        default:
    }

    $(modalSelector).modal('hide');

    return false;
}


// utils

function getElementById(id, isPopup) {
    return document.getElementById(isPopup ? id + isPopup : id);
}


function loadAsyncData(url, data, callback) {
    return $.ajax({
        url: url.indexOf(sciezka) !== -1 ? url : sciezka + url,
        type: 'POST',
        data: data,
        success: function (data) {
            if (callback) {
                callback(data);
            }
        },
        error: function () {
            console.log('Couldn\'t get data for url:', url, ' data:', data);
        }
    });
}

function showErrorMessgae(objError, info) {
    if (info !== null)
        $(objError).html(info);
    $(objError).fadeIn();
}

function gotoBottom(id) {
    const element = document.getElementById(id);
    element.scrollTop = 30; // element.scrollHeight - element.clientHeight;
}

function scrollToElement(id) {
    $([document.documentElement, document.body]).animate({
        scrollTop: $("#" + id).offset().top
    }, 0);
}

function evalScript(htmlElement) {
    const arr = $(htmlElement).find('script');
    for (let n = 0; n < arr.length; n++) {
        eval(arr[n].innerHTML);
    }
}