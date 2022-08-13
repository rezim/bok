<!doctype html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="utf-8"/>
    <title>{if !isset($title) || $title==''}{$smarty.const.TITLE}{else}{$title}{/if}</title>
    <meta name="keywords"
          content="{if !isset($keywords) || $keywords==''}{$smarty.const.KEYWORDS}{else}{$keywords}{/if}">
    <meta name='description'
          content="{if !isset($description) || $description==''}{$smarty.const.DESCRIPTION}{else}{$description}{/if}"/>
    {*    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css?{$smarty.const.APPVERSION}">*}
    {*<link rel="stylesheet" href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/font-awesome.min.css">*}

    <link rel="shortcut icon" href="https://www.otus.pl/favicon.ico" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<link rel="stylesheet" type="text/css"
      href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/style.css?{$smarty.const.APPVERSION}"
      title="default"/>
<link rel="stylesheet" type="text/css"
      href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/menu.css?{$smarty.const.APPVERSION}"
      title="default"/>
<link rel="stylesheet" type="text/css"
      href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/profitability.css?{$smarty.const.APPVERSION}"
      title="default"/>
<link rel="stylesheet" type="text/css"
      href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/acl.css?{$smarty.const.APPVERSION}"
      title="default"/>
<link rel="stylesheet" type="text/css"
      href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/colorbox.css?{$smarty.const.APPVERSION}"
      title="default"/>
<link rel="stylesheet" type="text/css"
      href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/jquery-ui-1.10.4.custom.min.css?{$smarty.const.APPVERSION}"
      title="default"/>
<link rel="stylesheet" type="text/css"
      href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/jquery-ui-timepicker-addon.css?{$smarty.const.APPVERSION}"
      title="default"/>
<link rel="stylesheet" type="text/css"
      href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/sort.css?{$smarty.const.APPVERSION}"
      title="default"/>
<link rel="stylesheet" type="text/css"
      href="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/css/dropzone.css?{$smarty.const.APPVERSION}"
      title="default"/>

<!-- bootstrap -->
<link rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css?{$smarty.const.APPVERSION}"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"/>

<link rel="stylesheet" type="text/css" href="{$smarty.const.SCIEZKA}/css/bok.css?{$smarty.const.APPVERSION}"
      title="default"/>

<!-- modules -->
<link rel="stylesheet" type="text/css" href="{$smarty.const.SCIEZKA}/css/service.css?{$smarty.const.APPVERSION}"/>


<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css">

<script type="text/javascript">
    function loadScript(src, callback) {
        var head = document.getElementsByTagName('head')[0],
            script = document.createElement('script');
        done = false;
        script.setAttribute('src', src);
        script.setAttribute('type', 'text/javascript');
        script.setAttribute('charset', 'utf-8');
        script.onload = script.onreadstatechange = function () {
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
<script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/js.js?{$smarty.const.APPVERSION}"></script>
<script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/acl.js"></script>
<script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/dropzone.js"></script>
<script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/invoices.js?{$smarty.const.APPVERSION}"></script>
<!-- angular libs -->
<script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/lib/angular.min.js"></script>
<script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/lib/angular-locale_pl.min.js"></script>

<script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/angular/app.js"></script>
<script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/angular/app.config.js"></script>
<script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/angular/service/rest.js"></script>
<script type="text/javascript"
        src="{$smarty.const.SCIEZKA}/js/angular/ctrl/profitabilityCtrl.js?{$smarty.const.APPVERSION}"></script>
<script type="text/javascript"
        src="{$smarty.const.SCIEZKA}/js/angular/ctrl/paymentsCtrl.js?{$smarty.const.APPVERSION}"></script>
<script type="text/javascript"
        src="{$smarty.const.SCIEZKA}/js/angular/ctrl/userSharesCtrl.js?{$smarty.const.APPVERSION}"></script>
<script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/angular/ctrl/serviceCtrl.js?{$smarty.const.APPVERSION}"></script>

<script type="text/javascript"
        src="{$smarty.const.SCIEZKA}/js/angular/common/dropdownCtrl.js?{$smarty.const.APPVERSION}"></script>

<!-- Angular UI bootstrap  -->
<script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/lib/ui-bootstrap-2.5.0.min.js"></script>
<script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/lib/ui-bootstrap-tpls-2.5.0.min.js"></script>

<script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/test/e2e.js?{$smarty.const.APPVERSION}"></script>

{if isset($smarty.session.login) && $smarty.session.login==1}
    <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/auto-logout.js?{$smarty.const.APPVERSION}"></script>
{/if}

</head>
<?php flush(); ?>
<body>

{if isset($smarty.session.login) && $smarty.session.login==1}

{if isset($smarty.session.appConfig['czas_sesji_minut'])}
    <script type="text/javascript">
        autoLogout({$smarty.session.appConfig['czas_sesji_minut']}, "/bok/acls/logout/notemplate");
    </script>
{/if}

<div class="progress otus-progress" id="progress">
    <div id="progressBar" class="progress-bar bg-success" role="progressbar"
         style="width: 0;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<header id="appNavBar" class="navbar navbar-expand-lg navbar-dark bg-dark otus-navbar" style="flex-wrap: wrap;">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{$smarty.const.SCIEZKA}/">
        <i class="fas fa-cogs"></i>&nbsp;OTUS
    </a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            {if
            isset($smarty.session.przypisanemenu['but_addprinter']) ||
            isset($smarty.session.przypisanemenu['li_printersshow']) ||
            isset($smarty.session.przypisanemenu['li_countersshow'])
            }
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-print"></i>&nbsp;Urządzenia
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        {if
                        isset($smarty.session.przypisanemenu['but_addprinter']) &&
                        $smarty.session.przypisanemenu['but_addprinter']['permission'] === 'rw'
                        }
                            <a href='#' onclick='showNewPrinterAdd("");return false;' class="dropdown-item"><i
                                        class="fas fa-plus-circle"></i>&nbsp;Dodaj urządzenie</a>
                        {/if}
                        {if isset($smarty.session.przypisanemenu['li_printersshow'])}
                            <a href='{$smarty.const.SCIEZKA}/printers/show' class="dropdown-item">Lista urządzeń</a>
                        {/if}
                        {if isset($smarty.session.przypisanemenu['li_countersshow'])}
                            <a href='{$smarty.const.SCIEZKA}/custom/show' class="dropdown-item">Liczniki urządzeń</a>
                        {/if}
                    </div>
                </li>
            {/if}
            {if
            (
            isset($smarty.session.przypisanemenu['but_addclient']) &&
            $smarty.session.przypisanemenu['but_addclient']['permission'] === 'rw'
            ) ||
            isset($smarty.session.przypisanemenu['li_clientsshow']) ||
            (
            isset($smarty.session.przypisanemenu['but_addagreement']) &&
            $smarty.session.przypisanemenu['but_addagreement']['permission'] === 'rw'
            ) ||
            isset($smarty.session.przypisanemenu['li_agreementsshow']) ||
            (
            isset($smarty.session.przypisanemenu['li_externallinks']) &&
            $smarty.session.przypisanemenu['li_externallinks']['permission'] === 'rw'
            )
            }
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-users"></i>&nbsp;Klienci
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        {if
                        isset($smarty.session.przypisanemenu['but_addclient']) &&
                        $smarty.session.przypisanemenu['but_addclient']['permission'] === 'rw'
                        }
                            <a href='#' onclick='showNewClientAdd("0");return false;' class="dropdown-item"><i
                                        class="fas fa-plus-circle"></i>&nbsp;Dodaj klienta</a>
                        {/if}
                        {if isset($smarty.session.przypisanemenu['li_clientsshow'])}
                            <a href='{$smarty.const.SCIEZKA}/clients/show' class="dropdown-item">Lista Klientów</a>
                            <div class="dropdown-divider"></div>
                        {/if}
                        {if
                        isset($smarty.session.przypisanemenu['but_addagreement']) &&
                        $smarty.session.przypisanemenu['but_addagreement']['permission'] === 'rw'
                        }
                            <a href='#' onclick='showNewAgreementAdd("0");return false;' class="dropdown-item"><i
                                        class="fas fa-plus-circle"></i>&nbsp;Dodaj umowę</a>
                        {/if}
                        {if isset($smarty.session.przypisanemenu['li_agreementsshow'])}
                            <a href='{$smarty.const.SCIEZKA}/agreements/show' class="dropdown-item">Lista umów</a>
                        {/if}
                        {if
                        isset($smarty.session.przypisanemenu['li_externallinks']) &&
                        $smarty.session.przypisanemenu['li_externallinks']['permission'] === 'rw'
                        }
                            <div class="dropdown-divider"></div>
                            <a target="_blank"
                               href='https://ekrs.ms.gov.pl/web/wyszukiwarka-krs/strona-glowna/index.html'
                               class="dropdown-item">KRS</a>
                            <a target="_blank" href='https://prod.ceidg.gov.pl/CEIDG/CEIDG.Public.UI/Search.aspx'
                               class="dropdown-item">CEIDG</a>
                            <a target="_blank"
                               href='https://www.podatki.gov.pl/wykaz-podatnikow-vat-wyszukiwarka?fbclid=IwAR2xqKi-wl7ImgKROSgtmHfD0--hQmfxq_wlBf7FdXQFWTYux8z0B65jBsU'
                               class="dropdown-item">VAT</a>
                        {/if}
                    </div>
                </li>
            {/if}
            {if
            (
            isset($smarty.session.przypisanemenu['but_addcase']) &&
            $smarty.session.przypisanemenu['but_addcase']['permission'] === 'rw'
            ) ||
            isset($smarty.session.przypisanemenu['li_casesshow']) ||
            isset($smarty.session.przypisanemenu['li_alertsshow']) ||
            isset($smarty.session.przypisanemenu['li_tonersshow']) ||
            isset($smarty.session.przypisanemenu['but_addcase']) ||
            isset($smarty.session.przypisanemenu['li_serviceshow'])
            }
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-wrench"></i>&nbsp;Serwis
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        {if
                        isset($smarty.session.przypisanemenu['but_addcase']) &&
                        $smarty.session.przypisanemenu['but_addcase']['permission'] === 'rw'
                        }
                            <a href='#' onclick='editNotification("0");return false;' class="dropdown-item"><i
                                        class="fas fa-plus-circle"></i>&nbsp;Dodaj zgłoszenie</a>
                        {/if}
                        {if isset($smarty.session.przypisanemenu['li_casesshow'])}
                            <a href='{$smarty.const.SCIEZKA}/notifications/show' class="dropdown-item">Lista
                                zgłoszeń</a>
                        {/if}
                        {if isset($smarty.session.przypisanemenu['li_alertsshow'])}
                            <a href='{$smarty.const.SCIEZKA}/alerts/show' class="dropdown-item">Alerty</a>
                        {/if}
                        {if isset($smarty.session.przypisanemenu['li_tonersshow'])}
                            <a href='{$smarty.const.SCIEZKA}/toners/show' class="dropdown-item">Tonery</a>
                        {/if}
                        {if isset($smarty.session.przypisanemenu['li_consumables'])}
                            <a href='{$smarty.const.SCIEZKA}/consumables/show' class="dropdown-item">Materiały
                                Eksploatacyjne</a>
                        {/if}
                        {if
                        isset($smarty.session.przypisanemenu['but_addcase']) &&
                        $smarty.session.przypisanemenu['but_addcase']['permission'] === 'rw'
                        }
                            <div class="dropdown-divider"></div>
                            <a href="{$smarty.const.SCIEZKA}/service/show#addNewRequest" class="dropdown-item"><i
                                        class="fas fa-plus-circle"></i>&nbsp;Dodaj serwis</a>
                        {/if}
                        {if isset($smarty.session.przypisanemenu['li_serviceshow'])}
                            <a href='{$smarty.const.SCIEZKA}/service/show'
                               class="dropdown-item"><span>Serwis urządzeń</span></a>
                        {/if}
                    </div>
                </li>
            {/if}
            {if
            isset($smarty.session.przypisanemenu['li_clientinvoicesshow']) ||
            isset($smarty.session.przypisanemenu['li_clientinvoicesdeptors']) ||
            isset($smarty.session.przypisanemenu['li_profitabilityshow']) ||
            isset($smarty.session.przypisanemenu['li_reportsshow']) ||
            (
            isset($smarty.session.przypisanemenu['li_externallinks']) &&
            $smarty.session.przypisanemenu['li_externallinks']['permission'] === 'rw'
            )
            }
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-area-chart"></i>&nbsp;Raporty
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        {if isset($smarty.session.przypisanemenu['li_clientinvoicesshow'])}
                            <a href='{$smarty.const.SCIEZKA}/clientinvoices/show' class="dropdown-item">Płatności</a>
                        {/if}
                        {if isset($smarty.session.przypisanemenu['li_clientinvoicesdeptors'])}
                            <a href='{$smarty.const.SCIEZKA}/clientinvoices/deptors' class="dropdown-item">Dłużnicy</a>
                        {/if}
                        {if isset($smarty.session.przypisanemenu['li_profitabilityshow'])}
                            <a href='{$smarty.const.SCIEZKA}/profitability/show' class="dropdown-item">Rentowność
                                umów</a>
                        {/if}
                        {if isset($smarty.session.przypisanemenu['li_reportsshow'])}
                            <a href='{$smarty.const.SCIEZKA}/reports/show' class="dropdown-item">Wystaw faktury</a>
                        {/if}
                        {if isset($smarty.session.przypisanemenu['li_statisticsshow'])}
                            <a href='{$smarty.const.SCIEZKA}/statistics/show' class="dropdown-item">Statystyki
                                Zgłoszeń</a>
                        {/if}
                        {if isset($smarty.session.przypisanemenu['li_materialsshow'])}
                            <a href='{$smarty.const.SCIEZKA}/materials/show' class="dropdown-item">Statystyki
                                Materiałów</a>
                        {/if}
                        {if
                        isset($smarty.session.przypisanemenu['li_externallinks']) &&
                        $smarty.session.przypisanemenu['li_externallinks']['permission'] === 'rw'
                        }
                            <div class="dropdown-divider"></div>
                            <a target="_blank" href='https://faktury.otus.pl' class="dropdown-item">Faktury</a>
                            <a target="_blank" href='https://saldeo.brainshare.pl/login.jsf'
                               class="dropdown-item">Wydatki</a>
                            <a target="_blank" href='https://rejestr-bdo.mos.gov.pl/User/ChooseCompany'
                               class="dropdown-item">BDO</a>
                        {/if}
                    </div>
                </li>
            {/if}
            {if
            isset($smarty.session.przypisanemenu['li_messagesshow']) ||
            (
            isset($smarty.session.przypisanemenu['li_externallinks']) &&
            $smarty.session.przypisanemenu['li_externallinks']['permission'] === 'rw'
            )
            }
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-file-text-o"></i>&nbsp;Notatki
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        {if isset($smarty.session.przypisanemenu['li_messagesshow'])}
                            <a href='{$smarty.const.SCIEZKA}/messages/show' class="dropdown-item">Tablica</a>
                        {/if}
                        {if
                        isset($smarty.session.przypisanemenu['li_externallinks']) &&
                        $smarty.session.przypisanemenu['li_externallinks']['permission'] === 'rw'
                        }
                            <div class="dropdown-divider"></div>
                            <a target="_blank" href='https://app.nozbe.com' class="dropdown-item">Nozbe</a>
                        {/if}
                    </div>
                </li>
            {/if}
        </ul>
        <form class="form-inline my-2 my-lg-0 d-lg-none d-xl-block">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Szukaj</button>
        </form>
        <ul class="navbar-nav my-2 my-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i>&nbsp;{$smarty.session.user.imie}&nbsp;{$smarty.session.user.nazwisko}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href='{$smarty.const.SCIEZKA}/acls/logout/notemplate'>Wyloguj się&nbsp;<i
                                class="fas fa-unlock"></i></a>
                </div>
            </li>
            {if
            isset($smarty.session.przypisanemenu['li_passwordshow']) ||
            isset($smarty.session.przypisanemenu['li_sharesshow']) ||
            isset($smarty.session.przypisanemenu['li_pullcountersshow']) ||
            isset($smarty.session.przypisanemenu['li_configuration'])
            }
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cog"></i>&nbsp;Ustawienia
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-start" aria-labelledby="navbarDropdown">
                        {if isset($smarty.session.przypisanemenu['li_passwordshow'])}
                            <a class="dropdown-item" href='{$smarty.const.SCIEZKA}/acls/passshow'>Hasło</a>
                        {/if}
                        {if isset($smarty.session.przypisanemenu['li_sharesshow'])}
                            <a class="dropdown-item" href='{$smarty.const.SCIEZKA}/shares/show'>Uprawnienia</a>
                        {/if}
                        {if isset($smarty.session.przypisanemenu['li_configuration'])}
                        <a class="dropdown-item" href='#' onclick="showConfiguration()">Konfiguracja</a>
                        {/if}
                        {if
                        isset($smarty.session.przypisanemenu['li_externallinks']) &&
                        $smarty.session.przypisanemenu['li_externallinks']['permission'] === 'rw'
                        }
                            <a target="_blank" class="dropdown-item" href='https://server.otus.pl:5001'>Serwer</a>
                        {/if}
                        {if isset($smarty.session.przypisanemenu['li_pullcountersshow'])}
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0)" onclick="callServiceAction('/emails/readdevicecounters/notemplate', null, null, null)" class="dropdown-item">Liczniki urządzeń</a>
                        {/if}
                    </div>
                </li>
            {/if}
        </ul>
    </div>
</header>
<div id='divContainer' class="content wide-content">
    {else}
    <div id='divContainer'>
{/if}