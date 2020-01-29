<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>{if !isset($title) || $title==''}{$smarty.const.TITLE}{else}{$title}{/if}</title>
    <meta name="keywords" content="{if !isset($keywords) || $keywords==''}{$smarty.const.KEYWORDS}{else}{$keywords}{/if}">
    <meta name='description' content="{if !isset($description) || $description==''}{$smarty.const.DESCRIPTION}{else}{$description}{/if}"/>
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
        {*<link rel="stylesheet" href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/font-awesome.min.css">*}
        <link rel="stylesheet" type="text/css" href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/style.css?{$smarty.now}" title="default" />
        <link rel="stylesheet" type="text/css" href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/menu.css" title="default" />
        <link rel="stylesheet" type="text/css" href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/profitability.css?{$smarty.now}" title="default" />
         <link rel="stylesheet" type="text/css" href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/acl.css" title="default" />
        <link rel="stylesheet" type="text/css" href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/colorbox.css" title="default" />
        <link rel="stylesheet" type="text/css" href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/jquery-ui-1.10.4.custom.min.css" title="default" />
        <link rel="stylesheet" type="text/css" href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/jquery-ui-timepicker-addon.css" title="default" />
        <link rel="stylesheet" type="text/css" href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/sort.css" title="default" />
        <link rel="stylesheet" type="text/css" href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/dropzone.css" title="default" />


        <!-- bootstrap -->
        <link rel="stylesheet" type="text/css" href="{$smarty.const.SCIEZKA}/css/bootstrap.min.css" title="default"/>
        <link rel="stylesheet" type="text/css" href="{$smarty.const.SCIEZKA}/css/bok.css" title="default"/>

        <!-- modules -->
        <link rel="stylesheet" type="text/css" href="{$smarty.const.SCIEZKA}/css/service.css" />

    <script type="text/javascript">
        function loadScript(src, callback) 
            {
                    var head = document.getElementsByTagName('head')[0],
                        script = document.createElement('script');
                    done = false;
                    script.setAttribute('src', src);
                    script.setAttribute('type', 'text/javascript');
                    script.setAttribute('charset', 'utf-8');
                    script.onload = script.onreadstatechange = function() {
                        if (!done && (!this.readyState || this.readyState === 'loaded' || this.readyState === 'complete')) {
                            done = true;
                            script.onload = script.onreadystatechange = null;
                                if (callback) {
                                    callback();
                                }
                            }
                    };
                    head.insertBefore(script, head.firstChild);
            }
            
     </script>
     <script type="text/javascript">
        var sciezka = "{$smarty.const.SCIEZKA}";
        {if isset($uprawnienia)}
            var val2 = '{$uprawnienia}';
         {/if}
     </script>
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/js.js?{$smarty.now}"></script>
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/acl.js"></script>
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/jquery.tablesorter.min.js"></script>
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/dropzone.js"></script>
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/invoices.js?{$smarty.now}"></script>
        <!-- angular libs -->
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/lib/angular.min.js"></script>
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/lib/angular-locale_pl.min.js"></script>

        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/angular/app.js"></script>
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/angular/app.config.js"></script>
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/angular/service/rest.js"></script>
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/angular/ctrl/profitabilityCtrl.js?{$smarty.now}"></script>
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/angular/ctrl/clientInvoicesCtrl.js?{$smarty.now}"></script>
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/angular/ctrl/userSharesCtrl.js?{$smarty.now}"></script>
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/angular/ctrl/serviceCtrl.js?{$smarty.now}"></script>


        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/angular/common/dropdownCtrl.js?{$smarty.now}"></script>

        <!-- Angular UI bootstrap  -->
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/lib/ui-bootstrap-2.5.0.min.js"></script>
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/lib/ui-bootstrap-tpls-2.5.0.min.js"></script>
</head>
 <?php flush(); ?>
<body>
<div id='divContainer' class="container-fluid row">
     
    {if isset($smarty.session.login) && $smarty.session.login==1}
        <img src='http://www.otus.pl/templates/otus/images/obraz/logo.png' alt='Otus' title='Otus' border='0' height='82' width='150'
       style='position:absolute;left:40px;'
       ></img>
    <div id='divHeader' >
         {if isset($smarty.session.przypisanemenu['but_addclient'])}
                <a id='but_addclient' href="#" onclick='showNewClientAdd("0");return false;' class="butaddclient" >Nowy klient</a>
        {/if}
        {if isset($smarty.session.przypisanemenu['but_addprinter'])}
        <a id='but_addprinter' href="#" onclick='showNewPrinterAdd("");return false;'  class="butaddprinter">Nowa drukarka</a>
        {/if}
        {if isset($smarty.session.przypisanemenu['but_addagreement'])}
        <a id='but_addagreement' href="#" onclick='showNewAgreementAdd("0");return false;' class="butaddumowa">Nowa umowa</a>
        {/if}
        {if isset($smarty.session.przypisanemenu['but_addtoner'])}
        <a id='but_addtoner' href="#" onclick='showNewTonerAdd("0","");return false;' class="butaddtoner">Nowy toner</a>
        {/if}
         {if isset($smarty.session.przypisanemenu['but_addcase'])}
        <a id='but_addcase' href="javascript:void(0);" onclick='showNewNotiAdd("0");return false;' class="butaddcase">Nowe zgłoszenie</a>
        {/if}
        {if isset($smarty.session.przypisanemenu['but_addcase'])}
            <a id='but_addservice' href="{$smarty.const.SCIEZKA}/service/show#addNewRequest" class="butaddservice">Nowy serwis</a>
        {/if}
    </div>
    <div class='liniaRozdzielajaca'></div>
    <div id='leftMenu' class="col-xs-3">
        
        <div id='cssmenu'>
                <ul>
                   <li><a href='{$smarty.const.SCIEZKA}/acls/logout/notemplate'><span>Wyloguj</span></a></li>
                     {if isset($smarty.session.przypisanemenu['li_printersshow'])}
                   <li id='li_printersshow'><a href='{$smarty.const.SCIEZKA}/printers/show'><span>Drukarki</span></a></li>
                   {/if}
                   {if isset($smarty.session.przypisanemenu['li_clientsshow'])}
                   <li id='li_clientsshow'><a href='{$smarty.const.SCIEZKA}/clients/show' ><span>Klienci</span></a></li>
                   {/if}
                   {if isset($smarty.session.przypisanemenu['li_agreementsshow'])}
                   <li id='li_agreementsshow'><a href='{$smarty.const.SCIEZKA}/agreements/show'><span>Umowy</span></a></li>
                   {/if}
                   {if isset($smarty.session.przypisanemenu['li_tonersshow'])}
                   <li id='li_tonersshow'><a href='{$smarty.const.SCIEZKA}/toners/show'><span>Tonery</span></a></li>
                   {/if}
                   {if isset($smarty.session.przypisanemenu['li_reportsshow'])}
                   <li id='li_reportsshow'><a href='{$smarty.const.SCIEZKA}/reports/show' ><span>Raporty</span></a></li>
                   {/if}
                   
                   {if isset($smarty.session.przypisanemenu['li_passwordshow'])}
                   <li id='li_passwordshow'><a href='{$smarty.const.SCIEZKA}/acls/passshow' ><span>Hasło</span></a></li>
                   {/if}
                  
                     {if isset($smarty.session.przypisanemenu['li_casesshow'])}
                        <li id='li_caseshow'><a href='{$smarty.const.SCIEZKA}/notifications/show' ><span>Zgłoszenia</span></a></li>
                   {/if}

                    {if isset($smarty.session.przypisanemenu['li_countersshow'])}
                        <li id='li_caseshow'><a href='{$smarty.const.SCIEZKA}/custom/show' ><span>Liczniki Drukarek</span></a></li>
                    {/if}

                    {if isset($smarty.session.przypisanemenu['li_profitabilityshow'])}
                        <li id='li_caseshow'><a href='{$smarty.const.SCIEZKA}/profitability/show' ><span>Rentowność Umów</span></a></li>
                    {/if}

                    {if isset($smarty.session.przypisanemenu['li_sharesshow'])}
                        <li id='li_caseshow'><a href='{$smarty.const.SCIEZKA}/shares/show' ><span>Uprawnienia</span></a></li>
                    {/if}

                    {if isset($smarty.session.przypisanemenu['li_serviceshow'])}
                        <li id='li_serviceshow' class='last'><a href='{$smarty.const.SCIEZKA}/service/show'><span>Serwis</span></a></li>
                    {/if}

                    {if isset($smarty.session.przypisanemenu['li_serviceoperating'])}
                        <li id='li_serviceoperating' class='last'><a href='{$smarty.const.SCIEZKA}/service/operating'><span>Serwis Drukarek</span></a></li>
                    {/if}
                    {if isset($smarty.session.przypisanemenu['li_alertsshow'])}
                        <li id='li_alertshow' class='last'><a href='{$smarty.const.SCIEZKA}/alerts/show'><span>Alerty</span></a></li>
                    {/if}
                    {if isset($smarty.session.przypisanemenu['li_messagesshow'])}
                        <li id='li_alertshow' class='last'><a href='{$smarty.const.SCIEZKA}/messages/show'><span>Tablica</span></a></li>
                    {/if}
                    {if isset($smarty.session.przypisanemenu['li_messagesinvoicesshow'])}
                        <li id='li_alertshow' class='last'><a href='{$smarty.const.SCIEZKA}/messagesinvoices/show'><span>Tablica Płatności</span></a></li>
                    {/if}
                    {if isset($smarty.session.przypisanemenu['li_clientinvoicesshow'])}
                        <li id='li_clientinvoicesshow' class='last'><a href='{$smarty.const.SCIEZKA}/clientinvoices/show'><span>Płatności</span></a></li>
                    {/if}
                </ul>
         </div>
   
        
    </div>{/if} 
    <div id='rightCenter' class="col-xs-9">
   