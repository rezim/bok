<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>{if !isset($title) || $title==''}{$smarty.const.TITLE}{else}{$title}{/if}</title>
    <meta name="keywords" content="{if !isset($keywords) || $keywords==''}{$smarty.const.KEYWORDS}{else}{$keywords}{/if}">
    <meta name='description' content="{if !isset($description) || $description==''}{$smarty.const.DESCRIPTION}{else}{$description}{/if}"/>
        {*<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">*}
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/angular/ctrl/userSharesCtrl.js?{$smarty.now}"></script>
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/angular/ctrl/serviceCtrl.js?{$smarty.now}"></script>


        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/angular/common/dropdownCtrl.js?{$smarty.now}"></script>

        <!-- Angular UI bootstrap  -->
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/lib/ui-bootstrap-2.5.0.min.js"></script>
        <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/lib/ui-bootstrap-tpls-2.5.0.min.js"></script>
</head>
 <?php flush(); ?>

{assign var=rentMenuOpened value=($currentPage == 'clients' || $currentPage == 'printers' || $currentPage == 'agreements' || $currentPage == 'reports')}
{assign var=serviceMenuOpened value=($currentPage == 'service')}

<body class="{if $currentPage != 'starts'}menu-open{/if} {$currentPage}">
{if isset($smarty.session.login) && $smarty.session.login==1}
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <img src='http://www.otus.pl/templates/otus/images/obraz/logo.png' alt='Otus' title='Otus' border='0' height='41' width='75'></img>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown {if $rentMenuOpened}open{/if}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Wynajem <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        {if isset($smarty.session.przypisanemenu['li_clientsshow'])}
                            <li {if $currentPage==='clients'}class="active"{/if} id='li_clientsshow'>
                                <a href='{$smarty.const.SCIEZKA}/clients/show' ><i class="fa fa-user-o" aria-hidden="true"></i> Klienci</a>
                            </li>
                        {/if}

                        {if isset($smarty.session.przypisanemenu['li_printersshow'])}
                            <li {if $currentPage==='printers'}class="active"{/if} id='li_printersshow'>
                                <a href='{$smarty.const.SCIEZKA}/printers/show'><i class="fa fa-print" aria-hidden="true"></i> Drukarki</a>
                            </li>
                        {/if}

                        {if isset($smarty.session.przypisanemenu['li_agreementsshow'])}
                            <li {if $currentPage==='agreements'}class="active"{/if} id='li_agreementsshow'>
                                <a href='{$smarty.const.SCIEZKA}/agreements/show'><i class="fa fa-handshake-o" aria-hidden="true"></i> Umowy</a>
                            </li>
                        {/if}
                        <li><a href="javascript:void();"><i class="fa fa-file-text-o" aria-hidden="true"></i> Faktury</a></li>

                        {if isset($smarty.session.przypisanemenu['li_reportsshow'])}
                            <li {if $currentPage==='reports'}class="active"{/if} id='li_reportsshow'>
                                <a href='{$smarty.const.SCIEZKA}/reports/show' ><i class="fa fa-bar-chart" aria-hidden="true"></i> Raporty</a>
                            </li>
                        {/if}
                        <li><a href="javascript:void()"><i class="fa fa-cog" aria-hidden="true"></i> Ustawienia</a></li>
                    </ul>
                </li>
                <li class="dropdown {if $serviceMenuOpened}open{/if}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Serwis <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        {if isset($smarty.session.przypisanemenu['li_serviceshow'])}
                            <li {if $currentPage==='service'}class="active"{/if} id='li_serviceshow'>
                                <a href='{$smarty.const.SCIEZKA}/service/show'><i class="fa fa-print" aria-hidden="true"></i> Drukarki</a>
                            </li>
                        {/if}
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Zadania <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="fa fa-tasks" aria-hidden="true"></i> Dodaj Zadanie</a></li>
                        <li><a href="#"><i class="fa fa-envelope" aria-hidden="true"></i> Wyślij Email</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href='{$smarty.const.SCIEZKA}/acls/logout/notemplate'>Wyloguj</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
{/if}
<div id='divContainer' class="container-fluid row">
     
    {if isset($smarty.session.login) && $smarty.session.login==1}

    <div id='divHeader' style="display: none">


        {if isset($smarty.session.przypisanemenu['but_addagreement']) && $currentPage==='agreements'}
        <a id='but_addagreement' href="#" onclick='showNewAgreementAdd("0");return false;' class="butaddumowa">Nowa umowa</a>
        {/if}
        {*{if isset($smarty.session.przypisanemenu['but_addtoner'])}*}
        {*<a id='but_addtoner' href="#" onclick='showNewTonerAdd("0","");return false;' class="butaddtoner">Nowy toner</a>*}
        {*{/if}*}
         {*{if isset($smarty.session.przypisanemenu['but_addcase'])}*}
        {*<a id='but_addcase' href="javascript:void(0);" onclick='showNewNotiAdd("0");return false;' class="butaddcase">Nowe zgłoszenie</a>*}
        {*{/if}*}
        {*{if isset($smarty.session.przypisanemenu['but_addcase'])}*}
            {*<a id='but_addservice' href="{$smarty.const.SCIEZKA}/service/show#addNewRequest" class="butaddservice">Nowy serwis</a>*}
        {*{/if}*}
    </div>

    <div id='leftMenu' class="col-xs-3" style="display: none">
        
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
                 {*  <li class='active'><a href='/logs/show' ><span>Historia</span></a></li>*}
                </ul>
         </div>
   
        
    </div>{/if}

    <div id='rightCenter' class="col-xs-12">
   