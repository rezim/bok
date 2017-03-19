/* Polish initialisation for the jQuery UI date picker plugin. */
/* Written by Jacek Wysocki (jacek.wysocki@gmail.com). */
jQuery(function($){
        $.datepicker.regional['pl'] = {
                closeText: 'Zamknij',
                prevText: '&#x3c;Poprzedni',
                nextText: 'Następny&#x3e;',
                currentText: 'Dziś',
                monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec',
                'Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'],
                monthNamesShort: ['Sty','Lu','Mar','Kw','Maj','Cze',
                'Lip','Sie','Wrz','Pa','Lis','Gru'],
                dayNames: ['Niedziela','Poniedziałek','Wtorek','Środa','Czwartek','Piątek','Sobota'],
                dayNamesShort: ['Nie','Pn','Wt','Śr','Czw','Pt','So'],
                dayNamesMin: ['N','Pn','Wt','Śr','Cz','Pt','So'],
                weekHeader: 'Tydz',
                dateFormat: 'yy-mm-dd',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                timeText: 'Czas',
                hourText: 'Godzina',
                minuteText: 'Minuty',
                yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['pl']);
});


function menuPodsumowanieClick()
{
    
}
function menuKlienciClick()
{
    
}
function showSzczegolyRaportRozwin(tr)
{
    var obj = document.getElementById(tr);
    
    
    if($(obj).attr('stan')=='0')
    {
        $(obj).attr('stan','1');
        $(obj).show();
    }
    else
    {
        $(obj).attr('stan','0');
        $(obj).hide()
    }
}
function showNewClientAdd(rowid)
{
    
        $.colorbox
        ({
            height:800+'px',
            width: 600+'px',
            title:"Dodawanie/Edycja klienta",
            data:
            {
                rowid:rowid
            },
            
            href:sciezka+"/clients/addedit/todiv",
                onClosed:function()
                {
                    
                },
                onComplete:function()
                {
                    
                    $("#txtnazwakrotka").focus();
                    uprawnienia();
                }
        });
}

function showNewTonerAdd(rowid,typ)
{
    
        $.colorbox
        ({
            height:650+'px',
            width: 600+'px',
            title:"Dodawanie/Edycja tonera",
            data:
            {
                rowid:rowid,
                typ:typ
            },
            
            href:sciezka+"/toners/addedit/todiv",
                onClosed:function()
                {
                    
                },
                onComplete:function()
                {
                         uprawnienia();
                }
        });
}
function pokazLogi(serial)
{
    
        $.colorbox
        ({
            height:650+'px',
            width: 800+'px',
            title:"Logi drukarki : "+serial,
            data:
            {
                serial:serial
            },
            
            href:sciezka+"/printers/logi/todiv",
                onClosed:function()
                {
                    
                   
                },
                onComplete:function()
                {
                    
                         uprawnienia();
                    
                }
        });
}
function showNewAgreementAdd(rowid)
{
    
        $.colorbox
        ({
            height:750+'px',
            width: 700+'px',
            title:"Dodawanie/Edycja umowy",
            data:
            {
                rowid:rowid
            },
            
            href:sciezka+"/agreements/addedit/todiv",
                onClosed:function()
                {
                    
                },
                onComplete:function()
                {
                    
                    $("#txtnrumowy").focus();
                         uprawnienia();
                }
        });
}
function showNewPrinterAdd(serial)
{
    
        $.colorbox
        ({
            height:850+'px',
            width: 600+'px',
            title:"Dodawanie/Edycja drukarki",
            data:
            {
                serial:serial
            },
            
            href:sciezka+"/printers/addedit/todiv",
                onClosed:function()
                {
                    
                },
                onComplete:function()
                {
                    
                    $("#txtserial").focus();
                         uprawnienia();
                }
        });
}
function checkReplay(objError,objLoad,info,objClick,dane,objOk,czyreload,showtime,adtrestoredirect)
{
    
                  try
                  {
                    dane = $.parseJSON(dane);
                  }
                  catch(e)
                  {
                      
                   showError(objError,objLoad,dane,objClick,showtime);
                   return false;     
                  }
                if(dane.status===0)
                {
                    showError(objError,objLoad,dane.info,objClick,showtime);
                    return false;
                }
                else
                {
                    showOk(objOk,objLoad,info,objClick,czyreload,showtime,adtrestoredirect);
                   return false;
                }   
}
function showError(objError,objLoad,info,objClick,showtime)
{

    if(info!==null)    
        $(objError).children('span').html(info);
        
    if(objLoad!==null)
        $(objLoad).hide();
    $(objError).fadeIn();

                        setTimeout(
                        function() 
                        {
                            $(objError).hide();
                            if(objClick!==null)
                                $(objClick).show();
                            return false;
                        },showtime);
}
function showOk(objOk,objLoad,info,objClick,czyreload,showtime,adtrestoredirect)
{
    
    if(info!==null)
        $(objOk).children('span').html(info)
    if(objLoad!==null)
        $(objLoad).hide();
    $(objOk).fadeIn();
 
                        setTimeout(
                        function() 
                        {
                                        
                                            if(czyreload===1)
                                                {
                                                    $.colorbox.close();
                                                       if(document.getElementById("tableClient")!==null)
                                                        {
                                                          pokazKlientow();
                                                        }
                                                        if(document.getElementById("tablePrinter")!==null)
                                                        {
                                                          pokazDrukarki('divRightCenter','divLoader');
                                                        }
                                                        if(document.getElementById("tableUmowy")!==null)
                                                        {
                                                          pokazUmowy('divRightCenter','divLoader');
                                                        }
                                                        if(document.getElementById("tableToner")!==null)
                                                        {
                                                          pokazTonery();
                                                        }
                                                        if(document.getElementById("tableCounters")!==null)
                                                        {
                                                          generujCustom();
                                                        }
                                                }
                                            else
                                            {
                                                $(objOk).hide();
                                                if(objClick!==null)
                                                    $(objClick).show();
                                            }
                                    
                            return false;
                        },showtime);
    // we dont want to wait for table report to be reloaded, it takes some time, so start operation ASAP
    if(document.getElementById("tableReport")!==null)
    {
        generujRaport(function(data, params){invMgr.refreshInvoices(params);invMgr.showAgreementWarnings(params);});
    }
}
function zapiszKlienta(rowid)
{
      var 
    doc=document,
    objLoad=doc.getElementById('actionloader'),
    objOk = doc.getElementById('actionok'),
    objError = doc.getElementById('actionerror'),
    objClick = doc.getElementById('actionbuttonclick');
    
  
    
    $(objClick).hide();
    $(objLoad).show();
    
           $.ajax({
            type:'POST',
            url:sciezka+"/clients/saveupdate/notemplate",
            async:true,
            data: 
            {
                rowid:rowid,
                nazwakrotka:doc.getElementById('txtnazwakrotka').value,
                nazwapelna:doc.getElementById('txtnazwapelna').value,
                ulica:doc.getElementById('txtulica').value,
                miasto:doc.getElementById('txtmiasto').value,
                kodpocztowy:doc.getElementById('txtkodpocztowy').value,
                nip:doc.getElementById('txtknip').value,
                regon:doc.getElementById('txtregon').value,
                telefon:doc.getElementById('txttelefon').value,
                mail:doc.getElementById('txtmail').value,
                mailfaktury:doc.getElementById('txtmailfaktury').value,
                terminplatnosci:doc.getElementById('txtterminplatnosci').value,
                opis:doc.getElementById('txtopis').value,
                pokaznumerseryjny:doc.getElementById("checkPokazNumerSeryjny").checked?1:0,
                pokazstanlicznika:doc.getElementById("checkPokazStanLicznika").checked?1:0,
                fakturadlakazdejumowy:doc.getElementById("checkFakturaDlaKazdejUmowy").checked?1:0
            },
            success: function(dane) 
            {
               checkReplay(objError,objLoad,null,objClick,dane,objOk,1,3000,null); 
               return false;
            },
            error: function()
            {
                
                showError(objError,objLoad,null,objClick,3000);
                return false;
            }
            });
}
function zapiszToner(rowid)
{
      var 
    doc=document,
    objLoad=doc.getElementById('actionloader'),
    objOk = doc.getElementById('actionok'),
    objError = doc.getElementById('actionerror'),
    objClick = doc.getElementById('actionbuttonclick');
    
  
    
    $(objClick).hide();
    $(objLoad).show();
    
           $.ajax({
            type:'POST',
            url:sciezka+"/toners/saveupdate/notemplate",
            async:true,
            data: 
            {
                rowid:rowid,
                serialdrukarka:doc.getElementById('txtdrukarka').value,
                serial:doc.getElementById('txtserial').value,
                typ:doc.getElementById('txttyp').value,
                number:doc.getElementById('txtnumber').value,
                description:doc.getElementById('txtopis').value,
                datainstalacji:doc.getElementById('txtdatainstalacji').value,
                stronmax:doc.getElementById('txtstronmax').value,
                stronpozostalo:doc.getElementById('txtstronpozostalo').value,
                ostatnieuzycie:doc.getElementById('txtostatnieuzycie').value,
                licznikstart:doc.getElementById('txtlicznikstart').value,
                licznikkoniec:doc.getElementById('txtlicznikkoniec').value
            },
            success: function(dane) 
            {
               checkReplay(objError,objLoad,null,objClick,dane,objOk,1,3000,null); 
               return false;
            },
            error: function()
            {
                
                showError(objError,objLoad,null,objClick,3000);
                return false; 
            }
            });
}
function zapiszUmowe(rowid)
{
      var 
    doc=document,
    objLoad=doc.getElementById('actionloader'),
    objOk = doc.getElementById('actionok'),
    objError = doc.getElementById('actionerror'),
    objClick = doc.getElementById('actionbuttonclick');
    
  
    
    $(objClick).hide();
    $(objLoad).show();
    
           $.ajax({
            type:'POST',
            url:sciezka+"/agreements/saveupdate/notemplate",
            async:true,
            data: 
            {
                rowid:rowid,
                nrumowy:doc.getElementById('txtnrumowy').value,
                dataod:doc.getElementById('txtdataod').value,
                datado:doc.getElementById('txtdatado').value,
                stronwabonamencie:doc.getElementById('txtiloscstron').value,
                cenazastrone:doc.getElementById('txtcenazastrone').value,
                abonament:doc.getElementById('txtabonament').value,
                serial:doc.getElementById('txtdrukarka').value,
                rozliczenie:doc.getElementById('txtrozliczenie').value,
                rowidclient:doc.getElementById('txtklient').value,
                opis:doc.getElementById('txtopis').value,
                iloscstron_kolor:doc.getElementById('txtiloscstron_kolor').value,
                cenazastrone_kolor:doc.getElementById('txtcenazastrone_kolor').value,
                cenainstalacji:doc.getElementById('txtcenainstalacji').value,
                rabatdoabonamentu:doc.getElementById('txtrabatdoabonamentu').value,
                rabatdowydrukow:doc.getElementById('txtrabatdowydrukow').value,
                prowizjapartnerska:doc.getElementById('txtprowizjapartnerska').value,
                sla:doc.getElementById('txtsla').value,
                wartoscurzadzenia:doc.getElementById('txtwartoscurzadzenia').value,
                jakczarne:doc.getElementById("checkJakCzarne").checked?1:0
            },
            success: function(dane) 
            {
               checkReplay(objError,objLoad,null,objClick,dane,objOk,1,3000,null); 
               return false;
            },
            error: function()
            {
                
                showError(objError,objLoad,null,objClick,3000);
                return false;
            }
            });
}
function zapiszDrukarke(serial)
{
      var 
    doc=document,
    objLoad=doc.getElementById('actionloader'),
    objOk = doc.getElementById('actionok'),
    objError = doc.getElementById('actionerror'),
    objClick = doc.getElementById('actionbuttonclick');
    
  
    
    $(objClick).hide();
    $(objLoad).show();
    
           $.ajax({
            type:'POST',
            url:sciezka+"/printers/saveupdate/notemplate",
            async:true,
            data: 
            {
                serial:doc.getElementById('txtserial').value,
                model:doc.getElementById('txtmodel').value,
                product_number:doc.getElementById('txtproduct_number').value,
                nr_firmware:doc.getElementById('txtnr_firmware').value,
                date_firmware:doc.getElementById('txtdate_firmware').value,
                ip:doc.getElementById('txtip').value,
                stan_fuser:doc.getElementById('txtstan_fuser').value,
                stan_adf:doc.getElementById('txtstan_adf').value,
                black_toner:doc.getElementById('txtblack_toner').value,
                iloscstron:doc.getElementById('txtiloscstron').value,
                iloscstron_kolor:doc.getElementById('txtiloscstronkolor').value,
                iloscstron_total:doc.getElementById('txtiloscstrontotal').value,
                type_color:doc.getElementById('checkKolorowa').checked?1:0,
                opis:doc.getElementById('txtopis').value,
                lokalizacja:doc.getElementById('txtlokalizacja').value,
                ulica:doc.getElementById('txtulica').value,
                miasto:doc.getElementById('txtmiasto').value,
                kodpocztowy:doc.getElementById('txtkodpocztowy').value,
                telefon:doc.getElementById('txttelefon').value,
                mail:doc.getElementById('txtmail').value,
                nazwa:doc.getElementById('txtnazwa').value,
                osobakontaktowa:doc.getElementById('txtosobakontaktowa').value
            },
            success: function(dane) 
            {
               checkReplay(objError,objLoad,null,objClick,dane,objOk,1,3000,null); 
               return false;
            },
            error: function()
            {
                
                showError(objError,objLoad,null,objClick,3000);
                return false;
            }
            });
}
function zapiszStanNa(serial)
{
      var 
    doc=document,
    objLoad=doc.getElementById('actionloader'),
    objOk = doc.getElementById('actionok'),
    objError = doc.getElementById('actionerror'),
    objClick = doc.getElementById('actionbuttonclick');
    
  
    
    $(objClick).hide();
    $(objLoad).show();
    
           $.ajax({
            type:'POST',
            url:sciezka+"/printers/savestanna/notemplate",
            async:true,
            data: 
            {
                serial:doc.getElementById('txtserial').value,
                iloscstron:doc.getElementById('txtiloscstron').value,
                iloscstron_kolor:doc.getElementById('txtiloscstronkolor').value,
                stanna:doc.getElementById('txtstanna').value,
            },
            success: function(dane) 
            {
               checkReplay(objError,objLoad,null,objClick,dane,objOk,0,3000,null); 
               return false;
            },
            error: function()
            {
                
                showError(objError,objLoad,null,objClick,3000);
                return false;
            }
            });
}
function pokazKlientow(objtoshow,objtoload,czycolorbox)
{
   
    var doc=document,objCenter = doc.getElementById(objtoshow),objLoad = doc.getElementById(objtoload);
    objCenter.innerHTML='';
    objLoad.innerHTML = '<p><img src="light/img/loader.gif" alt="Loading" /></p>';
                 
                      $.ajax({
                          url:sciezka+"/clients/showdane/todiv",
                          type: 'POST',
                          data: {
                                  filternazwa:doc.getElementById('txtfilternazwa').value,
                                  filternip:doc.getElementById('txtfilternip').value,
                                  filtermiasto:doc.getElementById('txtfiltermiasto').value,
                                  filterserial:doc.getElementById('txtfilterserial').value,
                                  czycolorbox:czycolorbox
                                },
                          success: function(data) {
                          
                                    objCenter.innerHTML = data;
                                    $(objCenter).animate({opacity: 1}, 1500 );
                          },
                          error: function(){
                                    objCenter.innerHTML = 'Problem z pobraniem klientów';
                                }
                           }).done(function () 
                                {
                                    objLoad.innerHTML = '';
                                    $("#tableClient").tablesorter();     uprawnienia();
                                });
               delete objCenter;delete objLoad;
               return false;
}
function usunKlienta(rowid)
{
    if(confirm("Czy na pewno chcesz usunąć tego klienta ? "))
        {
             
           $.ajax({
            type:'POST',
            url:sciezka+"/clients/delete/notemplate",
            async:true,
            data: 
            {
                rowid:rowid
            },
            success: function(dane) 
            {
                 try
                  {
                    dane = $.parseJSON(dane);
                  }
                  catch(e)
                  {
                      
                   alert('Błąd usunięcia klienta -'+dane);
                   return false;     
                  }
                if(dane.status===0)
                {
                   alert('Błąd usunięcia klienta -'+dane.info);
                    return false;
                }
                else
                {
                    alert('Klienta usunięty poprawnie');
                    $.colorbox.close();
                    pokazKlientow();
                   return false;
                }   
               return false;
            },
            error: function()
            {
                
                alert('Problem z usunięciem tego klienta');
                return false;
            }
            });
        }
     
    
}
function usunUmowe(rowid)
{
    if(confirm("Czy na pewno chcesz usunąć tą umowę ? "))
        {
             
           $.ajax({
            type:'POST',
            url:sciezka+"/agreements/delete/notemplate",
            async:true,
            data: 
            {
                rowid:rowid
            },
            success: function(dane) 
            {
                 try
                  {
                    dane = $.parseJSON(dane);
                  }
                  catch(e)
                  {
                      
                   alert('Błąd usunięcia umowy -'+dane);
                   return false;     
                  }
                if(dane.status===0)
                {
                   alert('Błąd usunięcia umowy -'+dane.info);
                    return false;
                }
                else
                {
                    alert('Umowa usunięta poprawnie');
                    $.colorbox.close();
                    pokazUmowy('divRightCenter','divLoader');
                   return false;
                }   
               return false;
            },
            error: function()
            {
                
                alert('Problem z usunięciem tej umowy');
                return false;
            }
            });
        }
     
    
}
function usunDrukarke(serial)
{
    if(confirm("Czy na pewno chcesz usunąć tą drukarkę ? "))
        {
             
           $.ajax({
            type:'POST',
            url:sciezka+"/printers/delete/notemplate",
            async:true,
            data: 
            {
                serial:serial
            },
            success: function(dane) 
            {
                 try
                  {
                    dane = $.parseJSON(dane);
                  }
                  catch(e)
                  {
                      
                   alert('Błąd usunięcia druakrki -'+dane);
                   return false;     
                  }
                if(dane.status===0)
                {
                   alert('Błąd usunięcia drukarki -'+dane.info);
                    return false;
                }
                else
                {
                    alert('Drukarka usunięty poprawnie');
                    $.colorbox.close();
                    pokazDrukarki();
                   return false;
                }   
               return false;
            },
            error: function()
            {
                
                alert('Problem z usunięciem tej drukarki');
                return false;
            }
            });
        }
     
}
function pokazDrukarki(objtoshow,objtoload,czycolorbox)
{
    czycolorbox = (czycolorbox!== undefined) ? czycolorbox : '';
    var doc=document,objCenter = doc.getElementById(objtoshow),objLoad = doc.getElementById(objtoload);
     
    objCenter.innerHTML='';
    objLoad.innerHTML = '<p><img src="light/img/loader.gif" alt="Loading" /></p>';
                 
                      $.ajax({
                          url:sciezka+"/printers/showdane/todiv",
                          type: 'POST',
                          data: {
                                  filterserial:doc.getElementById('txtfilterserial'+czycolorbox).value,
                                  filtermodel:doc.getElementById('txtfiltermodel'+czycolorbox).value,
                                  filterklient:doc.getElementById('txtfilterklient'+czycolorbox).value,
                                  czycolorbox:czycolorbox
                                },
                          success: function(data) {
                          
                                    objCenter.innerHTML = data;
                                    $(objCenter).animate({opacity: 1}, 1500 );
                          },
                          error: function(){
                                    objCenter.innerHTML = 'Problem z pobraniem drukarek';
                                }
                           }).done(function () 
                                {
                                    objLoad.innerHTML = '';
                                    $("#tablePrinter").tablesorter();
                                    uprawnienia();
                                });
               delete objCenter;delete objLoad;
               return false;
}
function pokazTonery()
{
    var doc=document,objCenter = doc.getElementById('divRightCenter'),objLoad = doc.getElementById('divLoader');
    objCenter.innerHTML='';
    objLoad.innerHTML = '<p><img src="light/img/loader.gif" alt="Loading" /></p>';
                 
                      $.ajax({
                          url:sciezka+"/toners/showdane/todiv",
                          type: 'POST',
                          data: {
                                  filterserial:doc.getElementById('txtfilterserial').value,
                                  filterdrukarka:doc.getElementById('txtfilterdrukarka').value,
                                  czyhistoria:doc.getElementById("txttonerzakonczone").checked?1:0,
                                },
                          success: function(data) {
                          
                                    objCenter.innerHTML = data;
                                    $(objCenter).animate({opacity: 1}, 1500 );
                          },
                          error: function(){
                                    objCenter.innerHTML = 'Problem z pobraniem tonerów';
                                }
                           }).done(function () 
                                {
                                    objLoad.innerHTML = '';
                                    $("#tableToner").tablesorter();
                                    uprawnienia();
                                });
               delete objCenter;delete objLoad;
               return false;
}


function generujCustom(successCallback, errorCallback)
{
    var doc=document,objCenter = doc.getElementById('divRightCenter'),objLoad = doc.getElementById('divLoader');
    objCenter.innerHTML='';
    objLoad.innerHTML = '<p><img src="light/img/loader.gif" alt="Loading" /></p>';

    var dateFrom = new Date();
    dateFrom.setDate(1);
    dateFrom.setMonth(dateFrom.getMonth()-1);

    var dateTo = new Date(dateFrom);
    dateTo.setMonth(dateFrom.getMonth()+1, 1);
    dateTo.setDate(1, 1);

    var params = {
        dateFrom: $.datepicker.formatDate('yy-mm-dd', dateFrom),
        dateTo: $.datepicker.formatDate('yy-mm-dd', dateTo)
    };
    $.ajax({
        url:sciezka+"/custom/showdaneklient/todiv",
        type: 'POST',
        data: {
            dataod:params.dateFrom,
            datado:params.dateTo
        },
        success: function(data) {

            objCenter.innerHTML = data;
            $(objCenter).animate({opacity: 1}, 1500 );

            $('.printerCounterDateTo').datepicker($.datepicker.regional['pl'],{ dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                showOtherMonths: true,
                selectOtherMonths: true });

            $('.printerCounterDateTo').val($.datepicker.formatDate('yy-mm-dd', new Date(params.dateTo)));

            if (successCallback) {
                successCallback(data, params);
            }

        },
        error: function(err){
            objCenter.innerHTML = 'Problem z wygenerowaniem raportu';

            if (errorCallback) {
                errorCallback(err);
            }
        }
    }).done(function ()
    {
        objLoad.innerHTML = '';
        $("#tableReport").tablesorter();     uprawnienia();
    });
    delete objCenter;delete objLoad;
    return false;
}
function generujRaport(successCallback, errorCallback)
{
     var doc=document,objCenter = doc.getElementById('divRightCenter'),objLoad = doc.getElementById('divLoader');
     objCenter.innerHTML='';
     objLoad.innerHTML = '<p><img src="light/img/loader.gif" alt="Loading" /></p>';

    var params = {
        dateFrom: doc.getElementById('txtdataod').value,
                          dateTo: doc.getElementById('txtdatado').value
                      };
                      $.ajax({
                          url:sciezka+"/reports/showdaneklient/todiv",
                          type: 'POST',
                          data: {
                                  dataod:params.dateFrom,
                                  datado:params.dateTo,
                                  filterklient:doc.getElementById('txtklient').value,
                                  filterdrukarka:doc.getElementById('txtdrukarka').value
                                },
                          success: function(data) {
                          
                                    objCenter.innerHTML = data;
                                    $(objCenter).animate({opacity: 1}, 1500 );
                                
                                successCallback(data, params);
                          },
                          error: function(err){
                                    objCenter.innerHTML = 'Problem z wygenerowaniem raportu';

                                    errorCallback(err);
                                }
                           }).done(function () 
                                {
                                    objLoad.innerHTML = '';
                                    $("#tableReport").tablesorter();     uprawnienia();
                                });
               delete objCenter;delete objLoad;
               return false;
}
function showColorTonerInfo(id)
{
    var obj = document.getElementById(id);
    
    if($(obj).attr('vis')==='0')
        {
            $(obj).show();$(obj).attr('vis',"1");
        }
        else
            {
                $(obj).hide();$(obj).attr('vis',"0");
            }
}
function pokazUmowy(objtoshow,objtoload,czycolorbox)
{
    czycolorbox = (czycolorbox!== undefined) ? czycolorbox : '';
    var doc=document,objCenter = doc.getElementById(objtoshow),objLoad = doc.getElementById(objtoload);
    objCenter.innerHTML='';
    objLoad.innerHTML = '<p><img src="light/img/loader.gif" alt="Loading" /></p>';
                 
                      $.ajax({
                          url:sciezka+"/agreements/showdane/todiv",
                          type: 'POST',
                          data: {
                                  filternrumowy:doc.getElementById('txtfilternrumowy'+czycolorbox).value,
                                  filterserial:doc.getElementById('txtfilterserial'+czycolorbox).value,
                                  filternazwaklienta:doc.getElementById('txtfilternazwaklient'+czycolorbox).value,
                                  pokazzakonczone:doc.getElementById("checkPokazZakonczone"+czycolorbox).checked?1:0,
                                  czycolorbox:czycolorbox
                                },
                          success: function(data) {
                                    objCenter.innerHTML = data;
                                    $(objCenter).animate({opacity: 1}, 1500 );
                          },
                          error: function(data){
                                    objCenter.innerHTML = data;
                                }
                           }).done(function () 
                                {
                                    objLoad.innerHTML = '';
                                    $("#tableUmowy").tablesorter();     
                                    uprawnienia();
                                });
               delete objCenter;delete objLoad;
               return false;
}
function pokazUmowy2(objtoshow,objtoload,czycolorbox)
{
   
     var doc=document,objCenter = doc.getElementById(objtoshow),objLoad = doc.getElementById(objtoload);
    objCenter.innerHTML='';
    objLoad.innerHTML = '<p><img src="light/img/loader.gif" alt="Loading" /></p>';
                 
                      $.ajax({
                          url:sciezka+"/agreements/showdane2/todiv",
                          type: 'POST',
                          data: {
                                  filternrumowy:doc.getElementById('txtfilternrumowy'+czycolorbox).value,
                                  filterserial:doc.getElementById('txtfilterserial'+czycolorbox).value,
                                  filternazwaklienta:doc.getElementById('txtfilternazwaklient'+czycolorbox).value,
                                  pokazzakonczone:doc.getElementById("checkPokazZakonczone"+czycolorbox).checked?1:0,
                                  czycolorbox:czycolorbox
                                },
                          success: function(data) {
                          
                                    objCenter.innerHTML = data;
                                    $(objCenter).animate({opacity: 1}, 1500 );
                          },
                          error: function(data){
                                    objCenter.innerHTML = data;
                                }
                           }).done(function () 
                                {
                                    objLoad.innerHTML = '';
                                    $("#tableUmowy").tablesorter();     
                                    uprawnienia();
                                });
               delete objCenter;delete objLoad;
               return false;
}
function showUmowyDoKlienta(clientrowid)
{
       $.colorbox
        ({
            height:650+'px',
            width: 1200+'px',
            title:"Umowy do klienta : ",
            data:
            {
                clientrowid:clientrowid,
                czycolorbox:1
            },
            
            href:sciezka+"/agreements/showdane/todiv",
                onClosed:function()
                {
                    
                   
                },
                onComplete:function()
                {
                         uprawnienia();
                    
                    
                }
        });
}
function showDrukarkiDoKlienta(clientrowid)
{
       $.colorbox
        ({
            height:650+'px',
            width: 1200+'px',
            title:"Drukarki do klienta : ",
            data:
            {
                clientrowid:clientrowid,
                czycolorbox:1
            },
            
            href:sciezka+"/printers/showdane/todiv",
                onClosed:function()
                {
                    
                   
                },
                onComplete:function()
                {
                    
                         uprawnienia();
                    
                }
        });
}
function setDateDefault()
{
     var date = new Date();
            date.setDate(1, 1);
            
            $('#txtdataod').val($.datepicker.formatDate('yy-mm-dd', date));
            var data = new Date(date);
            data.setMonth(date.getMonth()+1, 1);
            data.setDate(1, 1);
            $('#txtdatado').val($.datepicker.formatDate('yy-mm-dd', data));
}
function changeMiesiac(obj)
{
    var data = $(obj).val();
    
    if(data=='')
    {
            var date = new Date();
            date.setDate(1, 1);
            $('#txtdataod').val($.datepicker.formatDate('yy-mm-dd', date));
            var data = new Date(date);
            data.setMonth(date.getMonth()+1, 1);
            data.setDate(1, 1);
            $('#txtdatado').val($.datepicker.formatDate('yy-mm-dd', data));
    }
    else
    {
            var date = new Date(data);
            date.setDate(date.getDate(), 1);
            $('#txtdataod').val($.datepicker.formatDate('yy-mm-dd', date));
            
            var data = new Date(date);
            data.setMonth(date.getMonth()+1, 1);
            data.setDate(1, 1);
            $('#txtdatado').val($.datepicker.formatDate('yy-mm-dd', data));
    }
}
function showTonersInfo(printerserial)
{
   
       var doc=document,objCenter = doc.getElementById('tonertd'+printerserial),objTR = doc.getElementById('tonertr'+printerserial);
       
       if($(objTR).attr('vis')==='0')
        {
            
                    objCenter.innerHTML='';
                            $.ajax({
                          url:sciezka+"/toners/showdane/todiv",
                          type: 'POST',
                          data: {
                                  printerserial:printerserial
                                },
                          success: function(data) {
                          
                                    objCenter.innerHTML = data;
                                    $(objTR).show();
                                    
                          },
                          error: function(){
                                    objCenter.innerHTML = 'Problem z pobraniem tonerów';
                                    $(objTR).show();
                                }
                           }).done(function () 
                                {
                                         uprawnienia();
                                });
               delete objCenter;
        
                $(objTR).attr('vis',"1");
        }
        else
            {
                $(objTR).hide();$(objTR).attr('vis',"0");
            }
       
       
       
               return false;
}
function historiaTonerow(printerserial)
{
        $.colorbox
        ({
            height:650+'px',
            width: 1200+'px',
            title:"Historia tonerów na drukarce",
            data:
            {
                printerserial:printerserial,
                czyhistoria:1
            },
            
            href:sciezka+"/toners/showdane/todiv",
                onClosed:function()
                {
                    
                   
                },
                onComplete:function()
                {
                    
                    
                    
                }
        });
}
function usunToner(rowid,typ)
{
    if(confirm("Czy na pewno chcesz usunąć ten toner ? "))
    {
             
        var stronkoniec = prompt("Podaj stan wydrukowanych stron w drukarce");     
           
           if(stronkoniec!==null && stronkoniec!=='undefined' && stronkoniec!=='')
           {
                        $.ajax({
                         type:'POST',
                         url:sciezka+"/toners/delete/notemplate",
                         async:true,
                         data: 
                         {
                             rowid:rowid,
                             typ:typ,
                             stronkoniec: stronkoniec
                         },
                         success: function(dane) 
                         {
                              try
                               {
                                 dane = $.parseJSON(dane);
                               }
                               catch(e)
                               {

                                alert('Błąd usunięcia tonera -'+dane);
                                return false;     
                               }
                             if(dane.status===0)
                             {
                                alert('Błąd usunięcia tonera -'+dane.info);
                                 return false;
                             }
                             else
                             {
                                 alert('Toner usunięty poprawnie');
                                 pokazTonery();
                                return false;
                             }   
                            return false;
                         },
                         error: function()
                         {

                             alert('Problem z usunięciem tego tonera');
                             return false;
                         }
                         });
           }
           else
               {
                   alert("Musisz podać wartość");
               }
        }
     
    
}
function hideshowReportRow(nazwakrotka)
{
   
       var doc=document,objTR = doc.getElementById('tr'+nazwakrotka);
       
       if($(objTR).attr('vis')==='0')
        {
            
                                    $(objTR).show();
                $(objTR).attr('vis',"1");
        }
        else
            {
                $(objTR).hide();$(objTR).attr('vis',"0");
            }
       
       
       
               return false;
}
function showSzczegolyRaport(nazwakrotka)
{
    var doc=document;
      $.colorbox
        ({
            height:650+'px',
            width: 1200+'px',
            title:"Szczegóły raportu",
            data:
            {
                 dataod:doc.getElementById('txtdataod').value,
                 datado:doc.getElementById('txtdatado').value,
                 filterklient:doc.getElementById('txtklient').value,
                 filterdrukarka:doc.getElementById('txtdrukarka').value,
                 nazwakrotka:nazwakrotka
            },
            
            href:sciezka+"/reports/showdane/todiv",
                onClosed:function()
                {
                    
                   
                },
                onComplete:function()
                {
                    
                    
                }
        });
}
function pokazNotiFi()
{
    
    var doc=document,objCenter = doc.getElementById('divRightCenter'),objLoad = doc.getElementById('divLoader');
    objCenter.innerHTML='';
    objLoad.innerHTML = '<p><img src="light/img/loader.gif" alt="Loading" /></p>';
                 
    var statusy={};             
                 
    $("input[type=checkbox][name='txtstatus']")  // for all checkboxes
            .each(function() {  // first pass, create name mapping
        
                if(this.checked)
                {
                    statusy[$(this).attr('id')] = '1';
                }
            });              
                 
                 
                 
                      $.ajax({
                          url:sciezka+"/notifications/showdane/todiv",
                          type: 'POST',
                          data: {
                                  filterklient:doc.getElementById('txtfilterklient').value,
                                  filternrseryjny:doc.getElementById('txtfilternrseryjny').value,
                                  filternrzlecenia:doc.getElementById('txtfilternrzlecenia').value,  
                                  filterdataod:doc.getElementById('txtfilterdataod').value,
                                  filterdatado:doc.getElementById('txtfilterdatado').value,
                                  filterstatusy:statusy,
                                },
                          success: function(data) {
                          
                                    objCenter.innerHTML = data;
                                    $(objCenter).animate({opacity: 1}, 1500 );
                          },
                          error: function(){
                              
                                    objCenter.innerHTML = 'Problem z pobraniem klientów';
                                }
                           }).done(function () 
                                {
                                    objLoad.innerHTML = '';
                                    $("#tableNoti").tablesorter();     uprawnienia();
                                });
               delete objCenter;delete objLoad;
               return false;
}


function showNotification(rowid)
{

    $.colorbox
    ({
        height:650+'px',
        width: 600+'px',
        title:"Zgłoszenie",
        data:
        {
            rowid:rowid
        },

        href:sciezka+"/notifications/addedit/todiv",
        onClosed:function()
        {

        },
        onComplete:function()
        {
            uprawnienia();
        }
    });
}

function showNewNotiAdd(rowid)
{
    
    if(document.getElementById("divFilterNoti")===null || document.getElementById("divFilterNoti")===undefined)
    {
        
        window.location=sciezka+'/notifications/show/addeditnoti/'+rowid;
    }
   $("#divFilterNoti").hide();
    var doc=document,objCenter = doc.getElementById('divRightCenter'),objLoad = doc.getElementById('divLoader');
    objCenter.innerHTML='';
    objLoad.innerHTML = '<p><img src="light/img/loader.gif" alt="Loading" /></p>';
     $.ajax({
                          url:sciezka+"/notifications/addedit/todiv",
                          type: 'POST',
                          data: {
                                  keyVal:rowid,
                                  keyname:'rowid'
                                },
                          success: function(data) {
                          
                                    $(objCenter).html(data);
                                    $(objCenter).animate({opacity: 1}, 1500 );
                          },
                          error: function(){
                              
                                    objCenter.innerHTML = 'Problem z pobraniem klientów';
                                }
                           }).done(function () 
                                {
                                    objLoad.innerHTML = '';
                                    $("#tableNoti").tablesorter();
                                    $('#date_email').datepicker($.datepicker.regional['pl'],{ dateFormat: 'yy-mm-dd' , changeMonth: true,changeYear: true,});     uprawnienia();
                                });
               delete objCenter;delete objLoad;
               return false;
    
}
function wsteczNoti()
{
     $("#divFilterNoti").show();
     pokazNotiFi();
}
function openDataShow(link,idzewnetrznespan)
{
       $.colorbox
        ({
            height:650+'px',
            width: 1000+'px',
            data:
            {
                czycolorbox:'1',
                clientnazwakrotka:$("#rowid_client").val(),
                serial:$("#serial").val(),
            },
            href:link,
                onClosed:function()
                {
                    
                },
                onComplete:function()
                {
                    uprawnienia();
                    
                    
                }
        });
}
function zapiszNoti(czydelete,savelink)
{
     if(czydelete==="1")
    {
        if(!confirm("Czy chcesz usunąć ten rekord ?"))
        {
            return;
        }
    }
     var doc = document,
    objLoad=doc.getElementById('actionloader'),
    objOk = doc.getElementById('actionok'),
    objError = doc.getElementById('actionerror'),
    objClick = doc.getElementById('actionbuttonclick');
    
    $(objClick).hide(); 
    $(objLoad).show();
    var objKey=null;
    
       var dataOfFileds = {};
               

               $("[name='editobj']").each(function()
               {
                   var attr = $(this).attr('zewnetrznyspan');
                   if (typeof attr !== typeof undefined && attr !== false) {
                    dataOfFileds[$(this).attr('id')] = $("#"+$(this).attr('zewnetrznyspan')).html();    
                   }
                   else
                    dataOfFileds[$(this).attr('id')] = $(this).val().trim();
                
                  var iskey = $(this).attr('iskey');
                   if (typeof iskey !== typeof undefined && iskey !== false && iskey==='1') 
                   {
                       objKey=this;
                   }
                
               });
        
            $.ajax({ 
            type:'POST',	
            url:savelink,
            async:false,
            data: 
            {
                _filedsToEdit: unescape(JSON.stringify(dataOfFileds).replace(/\\u/g, '%u')),
                czydelete:czydelete,
            },
            success: function(dane) 
            {
             
                if(czydelete==='1')
                {
                   checkReplay(objError,objLoad,null,objClick,dane,objOk,-1,1000,null,1); 
                }
                else
                {
                   
                   checkReplay(objError,objLoad,null,objClick,dane,objOk,0,3000,null,1); 
                        try
                        {
                          dane = $.parseJSON(dane);
                          // przypisaneni rowid do tetboca
                          
                             setTimeout(
                        function() 
                        {
                           pokazNotiFi();
                        },2000);
                               
                         
                        }
                        catch(e)
                        {


                        }
                 
                }
                   return false;
            },
            error: function()
            {
                
                showError(objError,objLoad,null,objClick,3000);
                return false;
            }
            });
    
    
    
}
function showMaile()
{
    
    if($("#keyval").html()=='' || $("#keyval").html()=='0')
        return;
    
    
     var doc=document,objCenter = doc.getElementById('divMailePowiazane');
    objCenter.innerHTML='';
    
                 
    
                      $.ajax({
                          url:sciezka+"/notimails/show/todiv",
                          type: 'POST',
                          data: {
                                  noti_rowid:$("#keyval").html()
                                },
                          success: function(data) {
                          
                                    objCenter.innerHTML = data;
                                    $(objCenter).animate({opacity: 1}, 1500 );
                          },
                          error: function(){
                              
                                    objCenter.innerHTML = 'Problem z pobraniem klientów';
                                }
                           }).done(function () 
                                {
    
                                    $("#tableNotiMail").tablesorter();
                                });
               delete objCenter;delete objLoad;
               return false;
}
function newEditMail(replyrowid,czyedit)
{
    
  
      $.colorbox
        ({
            height:800+'px',
            width: 1200+'px',
            title:"Nowy email",
            data:
            {
                 replyrowid:replyrowid,
                 czyedit:czyedit,
                 noti_rowid:$("#keyval").html()
            },
            
            href:sciezka+"/notimails/neweditmail/todiv",
                onClosed:function()
                {
                    
                   
                },
                onComplete:function()
                {
                    
                    
                }
        });
    
}
function sendMail(noti_rowid,replyrowid,uniqueid)
{
    
    
     var doc = document,
    objLoad=doc.getElementById('actionloader2'),
    objOk = doc.getElementById('actionok2'),
    objError = doc.getElementById('actionerror2'),
    objClick = doc.getElementById('actionbuttonclick2');
    
   // $(objClick).hide(); 
    $(objLoad).show();
    
    
    
      var data2={};
        
        
        $("[name='rowid_file_aggrametns']")  // for all checkboxes
            .each(function() {  // first pass, create name mapping
        
                if($(this).html()!=='')
                {
                    data2[$(this).html()]={};
                    data2[$(this).html()]['filename'] = $(this).attr('atrfilename');
                    data2[$(this).html()]['path'] = $(this).attr('atrpath');
                }
            }); 
    
    
    
                
            
            $.ajax({
            type:'POST',	
            url:sciezka+"/notimails/wyslijmail/notemplate",
            async:false,
            data: 
            {
                noti_rowid:noti_rowid,
                replyrowid:replyrowid,
                tresc:$("#txttresc").val(),
                temat:$("#txttemat").val(),
                mail:$("#txtmail").val(),
                uniqueid:uniqueid,
                zalaczniki:data2
            },
            success: function(dane) 
            {
            
                   checkReplay(objError,objLoad,null,objClick,dane,objOk,0,3000,null,1);
                   // TR: commented to only check if send email is working fine
                   // $.colorbox.close();
                   showMaile();
                   
                   return false;
            },
            error: function(dane)
            {
                 
                showError(objError,objLoad,null,objClick,3000);
                return false;
            }
            });
    
}
function uprawnienia()
{
    if(val2!==null)
    {
      
        $('[wymaganylevel]').each(function() 
            {   

                var value = $(this).attr('wymaganylevel');
                

                if(value=='r' && $(this).attr('wymaganyzrobiony')=='0')
                {
                    if (val2.indexOf(value) === -1) {
                        $(this).css('display','none');
                    }
                }
                if(value=='w' && $(this).attr('wymaganyzrobiony')=='0')
                { 

                    if (val2.indexOf(value) === -1) {

                        if ( $(this).is( "a" ) )
                        {

                              $(this).css('display','none');

                        }
                        else if ( $(this).is( "img" ) )
                        {
                             $(this).css('display','none');

                        }
                         else if ( $(this).is( "div" ) )
                        {
                             $(this).css('display','none');

                        }
                         else if ( $(this).is( "th" ) )
                        {
                             $(this).css('display','none');

                        }
                         else if ( $(this).is( "td" ) )
                        {
                             $(this).css('display','none');

                        }
                        else
                        {
                            $(this).prop('disabled', true);
                        }

                    }
                }
                $(this).attr('wymaganyzrobiony','1');


            });       
    }
}

function savePrinterCounters(previousBlack, previousColor, serial)
{
    var
        doc=document,
        objLoad=doc.getElementById('actionloader'),
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

function generateProfitsReport(successCallback, errorCallback)
{
    var doc=document,objCenter = doc.getElementById('divRightCenter'),objLoad = doc.getElementById('divLoader');
    objCenter.innerHTML='';
    objLoad.innerHTML = '<p><img src="light/img/loader.gif" alt="Loading" /></p>';

    var params = {
        dateFrom: doc.getElementById('txtdataod').value,
        dateTo: doc.getElementById('txtdatado').value
    };
    $.ajax({
        url:sciezka+"/profitability/showdaneklient/todiv",
        type: 'POST',
        data: {
            dataod:params.dateFrom,
            datado:params.dateTo,
            filterklient:doc.getElementById('txtklient').value,
            filterdrukarka:doc.getElementById('txtdrukarka').value
        },
        success: function(data) {

            objCenter.innerHTML = data;
            $(objCenter).animate({opacity: 1}, 1500 );

            successCallback(data, params);
        },
        error: function(err){
            objCenter.innerHTML = 'Problem z wygenerowaniem raportu';

            errorCallback(err);
        }
    }).done(function ()
    {
        objLoad.innerHTML = '';
        $("#tableReport").tablesorter();     uprawnienia();
    });
    delete objCenter;delete objLoad;
    return false;
}

function show(path) {
    window.location=sciezka+path;
}