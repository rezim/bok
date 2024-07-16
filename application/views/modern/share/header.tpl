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

    <link rel="shortcut icon" href="https://www.otus.pl/favicon.ico"/>


    <!-- ===============================================-->
    <!-- Phoenix Stylesheets-->
    <!-- ===============================================-->

    <script src="{$smarty.const.SCIEZKA}/vendors/simplebar/simplebar.min.js"></script>
    <script src="{$smarty.const.SCIEZKA}/assets/js/config.js"></script>
    <link href="{$smarty.const.SCIEZKA}/vendors/prism/prism-okaidia.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap"
          rel="stylesheet">
    <link href="{$smarty.const.SCIEZKA}/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="{$smarty.const.SCIEZKA}/assets/css/theme-rtl.min.css" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="{$smarty.const.SCIEZKA}/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="{$smarty.const.SCIEZKA}/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet"
          id="user-style-rtl">
    <link href="{$smarty.const.SCIEZKA}/assets/css/user.min.css" type="text/css" rel="stylesheet"
          id="user-style-default">
    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap"
          rel="stylesheet">
    <link href="{$smarty.const.SCIEZKA}/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="{$smarty.const.SCIEZKA}/assets/css/theme-rtl.min.css" type="text/css" rel="stylesheet" id="style-rtl"
          disabled="true">
    <link href="{$smarty.const.SCIEZKA}/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="{$smarty.const.SCIEZKA}/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet"
          id="user-style-rtl" disabled="true">
    <link href="{$smarty.const.SCIEZKA}/assets/css/user.min.css" type="text/css" rel="stylesheet"
          id="user-style-default">
    <script>
        var phoenixIsRTL = window.config.config.phoenixIsRTL;
        if (phoenixIsRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
    <link href="{$smarty.const.SCIEZKA}/vendors/leaflet/leaflet.css" rel="stylesheet">
    <link href="{$smarty.const.SCIEZKA}/vendors/leaflet.markercluster/MarkerCluster.css" rel="stylesheet">
    <link href="{$smarty.const.SCIEZKA}/vendors/leaflet.markercluster/MarkerCluster.Default.css" rel="stylesheet">

    <!-- end phoenix -->


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
    <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/service.js?{$smarty.const.APPVERSION}"></script>
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
    <script type="text/javascript"
            src="{$smarty.const.SCIEZKA}/js/angular/ctrl/serviceCtrl.js?{$smarty.const.APPVERSION}"></script>

    <script type="text/javascript"
            src="{$smarty.const.SCIEZKA}/js/angular/common/dropdownCtrl.js?{$smarty.const.APPVERSION}"></script>

    <!-- Angular UI bootstrap  -->
    <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/lib/ui-bootstrap-2.5.0.min.js"></script>
    <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/lib/ui-bootstrap-tpls-2.5.0.min.js"></script>

    <script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/test/e2e.js?{$smarty.const.APPVERSION}"></script>

    {if isset($smarty.session.login) && $smarty.session.login==1}
        <script type="text/javascript"
                src="{$smarty.const.SCIEZKA}/js/auto-logout.js?{$smarty.const.APPVERSION}"></script>
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

<header id="appNavBar" class="navbar-horizontal">
    <main>
        <nav class="navbar navbar-top navbar-expand-lg">
            <div class="navbar-logo">
                <a class="navbar-brand" href="/bok/">
                    </i>
                    <img src="https://www.otus.pl/wp-content/uploads/2021/06/logo_ot1.png" alt="Logo Otus">
                </a>
            </div>
            <div class="collapse navbar-collapse navbar-top-collapse order-1 order-lg-0 justify-content-center"
                 id="navbarTopCollapse">
                <ul class="navbar-nav navbar-nav-top" data-dropdown-on-hover="data-dropdown-on-hover">
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle lh-1" href="#!"
                                                     role="button" data-bs-toggle="dropdown"
                                                     data-bs-auto-close="outside" aria-haspopup="true"
                                                     aria-expanded="false"><span
                                    class="uil fs-0 me-2 uil-chart-pie"></span>Kartoteki</a>
                        <ul class="dropdown-menu navbar-dropdown-caret">
                                    <div class="dropdown-item-wrapper">
                                        {/if}
                                        {if isset($smarty.session.przypisanemenu['li_printersshow'])}
                                        <a href='{$smarty.const.SCIEZKA}/printers/show' class="dropdown-item">Urządzenia</a>
                                    </div>

                                </a></li>
                                    <div class="dropdown-item-wrapper">
                                            {/if}
                                            {if isset($smarty.session.przypisanemenu['li_clientsshow'])}
                                            <a href='{$smarty.const.SCIEZKA}/clients/show' class="dropdown-item">Klienci</a>
                                    </div>
                                </a></li>
                            <li>
                                        {/if}
                                        {if isset($smarty.session.przypisanemenu['li_agreementsshow'])}
                                            <a href='{$smarty.const.SCIEZKA}/agreements/show' class="dropdown-item">Umowy</a>

                             </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle lh-1" href="#!"
                                                     role="button" data-bs-toggle="dropdown"
                                                     data-bs-auto-close="outside" aria-haspopup="true"
                                                     aria-expanded="false"><span
                                    class="uil fs-0 me-2 uil-cube"></span>Serwis</a>


                        <ul class="dropdown-menu navbar-dropdown-caret">
                            <li class="dropdown"><a class="dropdown-item dropdown-toggle" id="email" href="#"
                                                    data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                    <div class="dropdown-item-wrapper"></span><span>Raporty</span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a>
                                            <div> {if
                                                isset($smarty.session.przypisanemenu['li_scansreport']) &&
                                                $smarty.session.przypisanemenu['li_scansreport']['permission'] === 'rw'
                                                }
                                                <a href='{$smarty.const.SCIEZKA}/reports/scansreport' class="dropdown-item">Raport Skanów</a>{/if}
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../apps/email/email-detail.html">
                                            <div></span>Raport wydruków
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../apps/email/compose.html">
                                            <div></span>Poczta
                                            </div>
                                        </a></li>
                                </ul>
                            </li>




                            <li class="dropdown"><a class="dropdown-item dropdown-toggle" id="e-commerce"
                                                    href="#" data-bs-toggle="dropdown"
                                                    data-bs-auto-close="outside">
                                    <div class="dropdown-item-wrapper"><span
                                                class="uil fs-0 uil-angle-right lh-1 dropdown-indicator-icon"></span>
                                        <span><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16px"
                                                    height="16px" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-shopping-cart me-2 uil">
                                                <circle
                                                        cx="9" cy="21" r="1"></circle><circle cx="20" cy="21"
                                                                                              r="1"></circle>
                                                <path
                                                        d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>Raporty</span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown"><a class="dropdown-item dropdown-toggle" id="admin"
                                                            href="#" data-bs-toggle="dropdown"
                                                            data-bs-auto-close="outside">
                                            <div class="dropdown-item-wrapper"><span
                                                        class="uil fs-0 uil-angle-right lh-1 dropdown-indicator-icon"></span><span><span
                                                            class="me-2 uil"></span>Rapoty</span></div>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item"
                                                   href="../apps/e-commerce/admin/add-product.html">
                                                    <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Raport skanów

                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../apps/e-commerce/admin/products.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Products
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../apps/e-commerce/admin/customers.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Customers
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../apps/e-commerce/admin/customer-details.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Customer details
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../apps/e-commerce/admin/orders.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Orders
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../apps/e-commerce/admin/order-details.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Order details
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../apps/e-commerce/admin/refund.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Refund
                                                    </div>
                                                </a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown"><a class="dropdown-item dropdown-toggle" id="customer"
                                                            href="#" data-bs-toggle="dropdown"
                                                            data-bs-auto-close="outside">
                                            <div class="dropdown-item-wrapper"><span
                                                        class="uil fs-0 uil-angle-right lh-1 dropdown-indicator-icon"></span><span><span
                                                            class="me-2 uil"></span>Customer</span></div>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item"
                                                   href="../apps/e-commerce/landing/homepage.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Homepage
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../apps/e-commerce/landing/product-details.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Product details
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../apps/e-commerce/landing/products-filter.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Products filter
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../apps/e-commerce/landing/cart.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Cart
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../apps/e-commerce/landing/checkout.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Checkout
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../apps/e-commerce/landing/shipping-info.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Shipping info
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../apps/e-commerce/landing/profile.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Profile
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../apps/e-commerce/landing/favourite-stores.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Favourite stores
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../apps/e-commerce/landing/wishlist.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Wishlist
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../apps/e-commerce/landing/order-tracking.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Order tracking
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../apps/e-commerce/landing/invoice.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Invoice
                                                    </div>
                                                </a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown"><a class="dropdown-item dropdown-toggle" id="CRM" href="#"
                                                    data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                    <div class="dropdown-item-wrapper"><span
                                                class="uil fs-0 uil-angle-right lh-1 dropdown-indicator-icon"></span><span><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16px"
                                                    height="16px" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-phone me-2 uil"><path
                                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>CRM</span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../apps/crm/analytics.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Analytics
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../apps/crm/deals.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Deals
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../apps/crm/deal-details.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Deal
                                                details
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../apps/crm/leads.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Leads
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../apps/crm/lead-details.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Lead
                                                details
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../apps/crm/reports.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Reports
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../apps/crm/reports-details.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Reports
                                                details
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../apps/crm/add-contact.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Add
                                                contact
                                            </div>
                                        </a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a class="dropdown-item dropdown-toggle"
                                                    id="project-management" href="#" data-bs-toggle="dropdown"
                                                    data-bs-auto-close="outside">
                                    <div class="dropdown-item-wrapper"><span
                                                class="uil fs-0 uil-angle-right lh-1 dropdown-indicator-icon"></span><span><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16px"
                                                    height="16px" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-clipboard me-2 uil"><path
                                                        d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect
                                                        x="8" y="2" width="8" height="4" rx="1"
                                                        ry="1"></rect></svg>Project management</span></div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                           href="../apps/project-management/create-new.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Create
                                                new
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item"
                                           href="../apps/project-management/project-list-view.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Project
                                                list view
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item"
                                           href="../apps/project-management/project-card-view.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Project
                                                card view
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item"
                                           href="../apps/project-management/project-board-view.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Project
                                                board view
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item"
                                           href="../apps/project-management/todo-list.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Todo
                                                list
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item"
                                           href="../apps/project-management/project-details.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Project
                                                details
                                            </div>
                                        </a></li>
                                </ul>
                            </li>
                            <li><a class="dropdown-item" href="../apps/chat.html">
                                    <div class="dropdown-item-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-message-square me-2 uil">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                        </svg>
                                        Chat
                                    </div>
                                </a></li>
                            <li class="dropdown"><a class="dropdown-item dropdown-toggle" id="events" href="#"
                                                    data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                    <div class="dropdown-item-wrapper"><span
                                                class="uil fs-0 uil-angle-right lh-1 dropdown-indicator-icon"></span><span><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16px"
                                                    height="16px" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-bookmark me-2 uil"><path
                                                        d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>Events</span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../apps/events/create-an-event.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Create
                                                an event
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../apps/events/event-detail.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Event
                                                detail
                                            </div>
                                        </a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a class="dropdown-item dropdown-toggle" id="kanban" href="#"
                                                    data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                    <div class="dropdown-item-wrapper"><span
                                                class="uil fs-0 uil-angle-right lh-1 dropdown-indicator-icon"></span><span><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16px"
                                                    height="16px" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-trello me-2 uil"><rect x="3" y="3"
                                                                                                  width="18"
                                                                                                  height="18"
                                                                                                  rx="2"
                                                                                                  ry="2"></rect><rect
                                                        x="7" y="7" width="3" height="9"></rect><rect x="14"
                                                                                                      y="7"
                                                                                                      width="3"
                                                                                                      height="5"></rect></svg>Kanban</span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../apps/kanban/kanban.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Kanban
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../apps/kanban/boards.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Boards
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../apps/kanban/create-kanban-board.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Create
                                                board
                                            </div>
                                        </a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a class="dropdown-item dropdown-toggle" id="social" href="#"
                                                    data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                    <div class="dropdown-item-wrapper"><span
                                                class="uil fs-0 uil-angle-right lh-1 dropdown-indicator-icon"></span><span><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16px"
                                                    height="16px" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-share-2 me-2 uil"><circle cx="18"
                                                                                                     cy="5"
                                                                                                     r="3"></circle><circle
                                                        cx="6" cy="12" r="3"></circle><circle cx="18" cy="19"
                                                                                              r="3"></circle><line
                                                        x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line
                                                        x1="15.41" y1="6.51" x2="8.59"
                                                        y2="10.49"></line></svg>Social</span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../apps/social/profile.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Profile
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../apps/social/settings.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Settings
                                            </div>
                                        </a></li>
                                </ul>
                            </li>
                            <li><a class="dropdown-item" href="../apps/calendar.html">
                                    <div class="dropdown-item-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-calendar me-2 uil">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        Calendar
                                    </div>
                                </a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle lh-1" href="#!"
                                                     role="button" data-bs-toggle="dropdown"
                                                     data-bs-auto-close="outside" aria-haspopup="true"
                                                     aria-expanded="false"><span
                                    class="uil fs-0 me-2 uil-files-landscapes-alt"></span>CRM</a>
                        <ul class="dropdown-menu navbar-dropdown-caret">
                            <li><a class="dropdown-item" href="../pages/starter.html">
                                    <div class="dropdown-item-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-compass me-2 uil">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polygon
                                                    points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon>
                                        </svg>
                                        Starter
                                    </div>
                                </a></li>
                            <li><a class="dropdown-item" href="../pages/faq.html">
                                    <div class="dropdown-item-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-help-circle me-2 uil">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                        </svg>
                                        Faq
                                    </div>
                                </a></li>
                            <li class="dropdown"><a class="dropdown-item dropdown-toggle" id="landing" href="#"
                                                    data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                    <div class="dropdown-item-wrapper"><span
                                                class="uil fs-0 uil-angle-right lh-1 dropdown-indicator-icon"></span><span><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16px"
                                                    height="16px" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-globe me-2 uil"><circle cx="12"
                                                                                                   cy="12"
                                                                                                   r="10"></circle><line
                                                        x1="2" y1="12" x2="22" y2="12"></line><path
                                                        d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>Landing</span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../pages/landing/default.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Default
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../pages/landing/alternate.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Alternate
                                            </div>
                                        </a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a class="dropdown-item dropdown-toggle" id="pricing" href="#"
                                                    data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                    <div class="dropdown-item-wrapper"><span
                                                class="uil fs-0 uil-angle-right lh-1 dropdown-indicator-icon"></span><span><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16px"
                                                    height="16px" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-tag me-2 uil"><path
                                                        d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line
                                                        x1="7" y1="7" x2="7.01"
                                                        y2="7"></line></svg>Pricing</span></div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../pages/pricing/pricing-column.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Pricing
                                                column
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../pages/pricing/pricing-grid.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Pricing
                                                grid
                                            </div>
                                        </a></li>
                                </ul>
                            </li>
                            <li><a class="dropdown-item" href="../pages/notifications.html">
                                    <div class="dropdown-item-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-bell me-2 uil">
                                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                        </svg>
                                        Notifications
                                    </div>
                                </a></li>
                            <li><a class="dropdown-item" href="../pages/members.html">
                                    <div class="dropdown-item-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-users me-2 uil">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                        Members
                                    </div>
                                </a></li>
                            <li><a class="dropdown-item" href="../pages/timeline.html">
                                    <div class="dropdown-item-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-clock me-2 uil">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                        Timeline
                                    </div>
                                </a></li>
                            <li class="dropdown"><a class="dropdown-item dropdown-toggle" id="errors" href="#"
                                                    data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                    <div class="dropdown-item-wrapper"><span
                                                class="uil fs-0 uil-angle-right lh-1 dropdown-indicator-icon"></span><span><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16px"
                                                    height="16px" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-alert-triangle me-2 uil"><path
                                                        d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line
                                                        x1="12" y1="9" x2="12" y2="13"></line><line x1="12"
                                                                                                    y1="17"
                                                                                                    x2="12.01"
                                                                                                    y2="17"></line></svg>Errors</span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../pages/errors/404.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>404
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../pages/errors/500.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>500
                                            </div>
                                        </a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a class="dropdown-item dropdown-toggle" id="authentication"
                                                    href="#" data-bs-toggle="dropdown"
                                                    data-bs-auto-close="outside">
                                    <div class="dropdown-item-wrapper"><span
                                                class="uil fs-0 uil-angle-right lh-1 dropdown-indicator-icon"></span><span><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16px"
                                                    height="16px" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-lock me-2 uil"><rect x="3" y="11"
                                                                                                width="18"
                                                                                                height="11"
                                                                                                rx="2"
                                                                                                ry="2"></rect><path
                                                        d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>Authentication</span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown"><a class="dropdown-item dropdown-toggle" id="simple"
                                                            href="#" data-bs-toggle="dropdown"
                                                            data-bs-auto-close="outside">
                                            <div class="dropdown-item-wrapper"><span
                                                        class="uil fs-0 uil-angle-right lh-1 dropdown-indicator-icon"></span><span><span
                                                            class="me-2 uil"></span>Simple</span></div>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item"
                                                   href="../pages/authentication/simple/sign-in.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Sign in
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../pages/authentication/simple/sign-up.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Sign up
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../pages/authentication/simple/sign-out.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Sign out
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../pages/authentication/simple/forgot-password.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Forgot password
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../pages/authentication/simple/reset-password.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Reset password
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../pages/authentication/simple/lock-screen.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Lock screen
                                                    </div>
                                                </a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown"><a class="dropdown-item dropdown-toggle" id="split"
                                                            href="#" data-bs-toggle="dropdown"
                                                            data-bs-auto-close="outside">
                                            <div class="dropdown-item-wrapper"><span
                                                        class="uil fs-0 uil-angle-right lh-1 dropdown-indicator-icon"></span><span><span
                                                            class="me-2 uil"></span>Split</span></div>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item"
                                                   href="../pages/authentication/split/sign-in.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Sign in
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../pages/authentication/split/sign-up.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Sign up
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../pages/authentication/split/sign-out.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Sign out
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../pages/authentication/split/forgot-password.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Forgot password
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../pages/authentication/split/reset-password.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Reset password
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../pages/authentication/split/lock-screen.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Lock screen
                                                    </div>
                                                </a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown"><a class="dropdown-item dropdown-toggle" id="Card"
                                                            href="#" data-bs-toggle="dropdown"
                                                            data-bs-auto-close="outside">
                                            <div class="dropdown-item-wrapper"><span
                                                        class="uil fs-0 uil-angle-right lh-1 dropdown-indicator-icon"></span><span><span
                                                            class="me-2 uil"></span>Card</span></div>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item"
                                                   href="../pages/authentication/card/sign-in.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Sign in
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../pages/authentication/card/sign-up.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Sign up
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../pages/authentication/card/sign-out.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Sign out
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../pages/authentication/card/forgot-password.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Forgot password
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../pages/authentication/card/reset-password.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Reset password
                                                    </div>
                                                </a></li>
                                            <li><a class="dropdown-item"
                                                   href="../pages/authentication/card/lock-screen.html">
                                                    <div class="dropdown-item-wrapper"><span
                                                                class="me-2 uil"></span>Lock screen
                                                    </div>
                                                </a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown"><a class="dropdown-item dropdown-toggle" id="layouts" href="#"
                                                    data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                    <div class="dropdown-item-wrapper"><span
                                                class="uil fs-0 uil-angle-right lh-1 dropdown-indicator-icon"></span><span><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16px"
                                                    height="16px" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-layout me-2 uil"><rect x="3" y="3"
                                                                                                  width="18"
                                                                                                  height="18"
                                                                                                  rx="2"
                                                                                                  ry="2"></rect><line
                                                        x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21"
                                                                                                  x2="9"
                                                                                                  y2="9"></line></svg>Layouts</span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../demo/vertical-sidenav.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Vertical
                                                sidenav
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../demo/dark-mode.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Dark
                                                mode
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../demo/sidenav-collapse.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Sidenav
                                                collapse
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../demo/darknav.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Darknav
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../demo/topnav-slim.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Topnav
                                                slim
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../demo/navbar-top-slim.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Navbar
                                                top slim
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item active" href="../demo/navbar-top.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Navbar
                                                top
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../demo/horizontal-slim.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Horizontal
                                                slim
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../demo/combo-nav.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Combo
                                                nav
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../demo/combo-nav-slim.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Combo
                                                nav slim
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../demo/dual-nav.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Dual
                                                nav
                                            </div>
                                        </a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle lh-1" href="#!"
                                                     role="button" data-bs-toggle="dropdown"
                                                     data-bs-auto-close="outside" aria-haspopup="true"
                                                     aria-expanded="false"><span
                                    class="uil fs-0 me-2 uil-document-layout-right"></span>Administracja</a>
                        <ul class="dropdown-menu navbar-dropdown-caret">
                            <li><a class="dropdown-item" href="../documentation/getting-started.html">
                                    <div class="dropdown-item-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-life-buoy me-2 uil">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <circle cx="12" cy="12" r="4"></circle>
                                            <line x1="4.93" y1="4.93" x2="9.17" y2="9.17"></line>
                                            <line x1="14.83" y1="14.83" x2="19.07" y2="19.07"></line>
                                            <line x1="14.83" y1="9.17" x2="19.07" y2="4.93"></line>
                                            <line x1="14.83" y1="9.17" x2="18.36" y2="5.64"></line>
                                            <line x1="4.93" y1="19.07" x2="9.17" y2="14.83"></line>
                                        </svg>
                                        Getting started
                                    </div>
                                </a></li>
                            <li class="dropdown dropdown-inside"><a class="dropdown-item dropdown-toggle"
                                                                    id="customization" href="#"
                                                                    data-bs-toggle="dropdown"
                                                                    data-bs-auto-close="outside">
                                    <div class="dropdown-item-wrapper"><span
                                                class="uil fs-0 uil-angle-right lh-1 dropdown-indicator-icon"></span><span><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16px"
                                                    height="16px" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-settings me-2 uil"><circle cx="12"
                                                                                                      cy="12"
                                                                                                      r="3"></circle><path
                                                        d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>Customization</span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                           href="../documentation/customization/configuration.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Configuration
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item"
                                           href="../documentation/customization/styling.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Styling
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item"
                                           href="../documentation/customization/dark-mode.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Dark
                                                mode
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item"
                                           href="../documentation/customization/plugin.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Plugin
                                            </div>
                                        </a></li>
                                </ul>
                            </li>
                            <li class="dropdown dropdown-inside"><a class="dropdown-item dropdown-toggle"
                                                                    id="layouts-doc" href="#"
                                                                    data-bs-toggle="dropdown"
                                                                    data-bs-auto-close="outside">
                                    <div class="dropdown-item-wrapper"><span
                                                class="uil fs-0 uil-angle-right lh-1 dropdown-indicator-icon"></span><span><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16px"
                                                    height="16px" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-table me-2 uil"><path
                                                        d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"></path></svg>Layouts doc</span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                           href="../documentation/layouts/vertical-navbar.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Vertical
                                                navbar
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item"
                                           href="../documentation/layouts/horizontal-navbar.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Horizontal
                                                navbar
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item"
                                           href="../documentation/layouts/combo-navbar.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Combo
                                                navbar
                                            </div>
                                        </a></li>
                                    <li><a class="dropdown-item" href="../documentation/layouts/dual-nav.html">
                                            <div class="dropdown-item-wrapper"><span class="me-2 uil"></span>Dual
                                                nav
                                            </div>
                                        </a></li>
                                </ul>
                            </li>
                            <li><a class="dropdown-item" href="../documentation/gulp.html">
                                    <div class="dropdown-item-wrapper">
                                        <svg class="svg-inline--fa fa-gulp me-2 ms-1 me-1 fa-lg"
                                             aria-hidden="true" focusable="false" data-prefix="fab"
                                             data-icon="gulp" role="img" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 256 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                  d="M209.8 391.1l-14.1 24.6-4.6 80.2c0 8.9-28.3 16.1-63.1 16.1s-63.1-7.2-63.1-16.1l-5.8-79.4-14.9-25.4c41.2 17.3 126 16.7 165.6 0zm-196-253.3l13.6 125.5c5.9-20 20.8-47 40-55.2 6.3-2.7 12.7-2.7 18.7 .9 5.2 3 9.6 9.3 10.1 11.8 1.2 6.5-2 9.1-4.5 9.1-3 0-5.3-4.6-6.8-7.3-4.1-7.3-10.3-7.6-16.9-2.8-6.9 5-12.9 13.4-17.1 20.7-5.1 8.8-9.4 18.5-12 28.2-1.5 5.6-2.9 14.6-.6 19.9 1 2.2 2.5 3.6 4.9 3.6 5 0 12.3-6.6 15.8-10.1 4.5-4.5 10.3-11.5 12.5-16l5.2-15.5c2.6-6.8 9.9-5.6 9.9 0 0 10.2-3.7 13.6-10 34.7-5.8 19.5-7.6 25.8-7.6 25.8-.7 2.8-3.4 7.5-6.3 7.5-1.2 0-2.1-.4-2.6-1.2-1-1.4-.9-5.3-.8-6.3 .2-3.2 6.3-22.2 7.3-25.2-2 2.2-4.1 4.4-6.4 6.6-5.4 5.1-14.1 11.8-21.5 11.8-3.4 0-5.6-.9-7.7-2.4l7.6 79.6c2 5 39.2 17.1 88.2 17.1 49.1 0 86.3-12.2 88.2-17.1l10.9-94.6c-5.7 5.2-12.3 11.6-19.6 14.8-5.4 2.3-17.4 3.8-17.4-5.7 0-5.2 9.1-14.8 14.4-21.5 1.4-1.7 4.7-5.9 4.7-8.1 0-2.9-6-2.2-11.7 2.5-3.2 2.7-6.2 6.3-8.7 9.7-4.3 6-6.6 11.2-8.5 15.5-6.2 14.2-4.1 8.6-9.1 22-5 13.3-4.2 11.8-5.2 14-.9 1.9-2.2 3.5-4 4.5-1.9 1-4.5 .9-6.1-.3-.9-.6-1.3-1.9-1.3-3.7 0-.9 .1-1.8 .3-2.7 1.5-6.1 7.8-18.1 15-34.3 1.6-3.7 1-2.6 .8-2.3-6.2 6-10.9 8.9-14.4 10.5-5.8 2.6-13 2.6-14.5-4.1-.1-.4-.1-.8-.2-1.2-11.8 9.2-24.3 11.7-20-8.1-4.6 8.2-12.6 14.9-22.4 14.9-4.1 0-7.1-1.4-8.6-5.1-2.3-5.5 1.3-14.9 4.6-23.8 1.7-4.5 4-9.9 7.1-16.2 1.6-3.4 4.2-5.4 7.6-4.5 .6 .2 1.1 .4 1.6 .7 2.6 1.8 1.6 4.5 .3 7.2-3.8 7.5-7.1 13-9.3 20.8-.9 3.3-2 9 1.5 9 2.4 0 4.7-.8 6.9-2.4 4.6-3.4 8.3-8.5 11.1-13.5 2-3.6 4.4-8.3 5.6-12.3 .5-1.7 1.1-3.3 1.8-4.8 1.1-2.5 2.6-5.1 5.2-5.1 1.3 0 2.4 .5 3.2 1.5 1.7 2.2 1.3 4.5 .4 6.9-2 5.6-4.7 10.6-6.9 16.7-1.3 3.5-2.7 8-2.7 11.7 0 3.4 3.7 2.6 6.8 1.2 2.4-1.1 4.8-2.8 6.8-4.5 1.2-4.9 .9-3.8 26.4-68.2 1.3-3.3 3.7-4.7 6.1-4.7 1.2 0 2.2 .4 3.2 1.1 1.7 1.3 1.7 4.1 1 6.2-.7 1.9-.6 1.3-4.5 10.5-5.2 12.1-8.6 20.8-13.2 31.9-1.9 4.6-7.7 18.9-8.7 22.3-.6 2.2-1.3 5.8 1 5.8 5.4 0 19.3-13.1 23.1-17 .2-.3 .5-.4 .9-.6 .6-1.9 1.2-3.7 1.7-5.5 1.4-3.8 2.7-8.2 5.3-11.3 .8-1 1.7-1.6 2.7-1.6 2.8 0 4.2 1.2 4.2 4 0 1.1-.7 5.1-1.1 6.2 1.4-1.5 2.9-3 4.5-4.5 15-13.9 25.7-6.8 25.7 .2 0 7.4-8.9 17.7-13.8 23.4-1.6 1.9-4.9 5.4-5 6.4 0 1.3 .9 1.8 2.2 1.8 2 0 6.4-3.5 8-4.7 5-3.9 11.8-9.9 16.6-14.1l14.8-136.8c-30.5 17.1-197.6 17.2-228.3 .2zm229.7-8.5c0 21-231.2 21-231.2 0 0-8.8 51.8-15.9 115.6-15.9 9 0 17.8 .1 26.3 .4l12.6-48.7L228.1 .6c1.4-1.4 5.8-.2 9.9 3.5s6.6 7.9 5.3 9.3l-.1 .1L185.9 74l-10 40.7c39.9 2.6 67.6 8.1 67.6 14.6zm-69.4 4.6c0-.8-.9-1.5-2.5-2.1l-.2 .8c0 1.3-5 2.4-11.1 2.4s-11.1-1.1-11.1-2.4c0-.1 0-.2 .1-.3l.2-.7c-1.8 .6-3 1.4-3 2.3 0 2.1 6.2 3.7 13.7 3.7 7.7 .1 13.9-1.6 13.9-3.7z"></path>
                                        </svg>
                                        <!-- <span class="me-2 fa-brands fa-gulp ms-1 me-1 fa-lg"></span> Font Awesome fontawesome.com -->
                                        Gulp
                                    </div>
                                </a></li>
                            <li><a class="dropdown-item" href="../documentation/design-file.html">
                                    <div class="dropdown-item-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-figma me-2 uil">
                                            <path d="M5 5.5A3.5 3.5 0 0 1 8.5 2H12v7H8.5A3.5 3.5 0 0 1 5 5.5z"></path>
                                            <path d="M12 2h3.5a3.5 3.5 0 1 1 0 7H12V2z"></path>
                                            <path d="M12 12.5a3.5 3.5 0 1 1 7 0 3.5 3.5 0 1 1-7 0z"></path>
                                            <path d="M5 19.5A3.5 3.5 0 0 1 8.5 16H12v3.5a3.5 3.5 0 1 1-7 0z"></path>
                                            <path d="M5 12.5A3.5 3.5 0 0 1 8.5 9H12v7H8.5A3.5 3.5 0 0 1 5 12.5z"></path>
                                        </svg>
                                        Design file
                                    </div>
                                </a></li>
                            <li><a class="dropdown-item" href="../changelog.html">
                                    <div class="dropdown-item-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-git-merge me-2 uil">
                                            <circle cx="18" cy="18" r="3"></circle>
                                            <circle cx="6" cy="6" r="3"></circle>
                                            <path d="M6 21V9a9 9 0 0 0 9 9"></path>
                                        </svg>
                                        Changelog
                                    </div>
                                </a></li>
                            <li><a class="dropdown-item" href="../showcase.html">
                                    <div class="dropdown-item-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-monitor me-2 uil">
                                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                            <line x1="8" y1="21" x2="16" y2="21"></line>
                                            <line x1="12" y1="17" x2="12" y2="21"></line>
                                        </svg>
                                        Showcase
                                    </div>
                                </a></li>
                        </ul>
                    </li>
                </ul>
            </div>


            <div class="avatar avatar-xl ">
                <img class="rounded-circle " src="https://media.licdn.com/dms/image/D5603AQGfCXD5aIriZw/profile-displayphoto-shrink_400_400/0/1686568108038?e=1726099200&v=beta&t=nxHbW_A7P0GRY1xQ7Wyi6YzCgawLOMkR0wSRi0P8Orc" alt="">

            </div>

        </nav>
    </main>
</header>

{if isset($smarty.session.przypisanemenu['li_configuration'])}
    <script>
        $("#showConfigurationAction").on('click', () => openModal("/config/show/todiv"));
    </script>
{/if}
<div id='divContainer'>
    {else}
    <div id='divContainer'>
        {/if}
