<div class="table-responsive-sm">


    <div id="tableExample3" data-list="{{'{"valueNames":["name","email","age"],"page":5,"pagination":true}'}}">
        <div class="search-box mb-3 mx-auto">
            <form class="position-relative">
                <input class="form-control search-input search form-control-sm" type="search" placeholder="Search"
                       aria-label="Search">
{*                <svg class="svg-inline--fa fa-magnifying-glass search-box-icon" aria-hidden="true" focusable="false"*}
{*                     data-prefix="fas" data-icon="magnifying-glass" role="img" xmlns="http://www.w3.org/2000/svg"*}
{*                     viewBox="0 0 512 512" data-fa-i2svg="">*}
{*                    <path fill="currentColor"*}
{*                          d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path>*}
{*                </svg><!-- <span class="fas fa-search search-box-icon"></span> Font Awesome fontawesome.com -->*}

            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm fs-9 mb-0">
                <thead>
                <tr>
                    <th class="sort border-top border-translucent ps-3" data-sort="name">Name</th>
                    <th class="sort border-top" data-sort="email">Email</th>
                    <th class="sort border-top" data-sort="age">Age</th>
                    <th class="sort text-end align-middle pe-0 border-top" scope="col">ACTION</th>
                </tr>
                </thead>
                <tbody class="list">
                <tr>
                    <td class="align-middle ps-3 name">Anna</td>
                    <td class="align-middle email">anna@example.com</td>
                    <td class="align-middle age">18</td>
                    <td class="align-middle white-space-nowrap text-end pe-0">
                        <div class="btn-reveal-trigger position-static">
                            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                    aria-expanded="false" data-bs-reference="parent">
                                <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false"
                                     data-prefix="fas" data-icon="ellipsis" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                          d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                </svg>
                                <!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com -->
                            </button>
                            <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item"
                                                                                 href="#!">View</a><a
                                        class="dropdown-item" href="#!">Export</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#!">Remove</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle ps-3 name">Homer</td>
                    <td class="align-middle email">homer@example.com</td>
                    <td class="align-middle age">35</td>
                    <td class="align-middle white-space-nowrap text-end pe-0">
                        <div class="btn-reveal-trigger position-static">
                            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                    aria-expanded="false" data-bs-reference="parent">
                                <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false"
                                     data-prefix="fas" data-icon="ellipsis" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                          d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                </svg>
                                <!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com -->
                            </button>
                            <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item"
                                                                                 href="#!">View</a><a
                                        class="dropdown-item" href="#!">Export</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#!">Remove</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle ps-3 name">Oscar</td>
                    <td class="align-middle email">oscar@example.com</td>
                    <td class="align-middle age">52</td>
                    <td class="align-middle white-space-nowrap text-end pe-0">
                        <div class="btn-reveal-trigger position-static">
                            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                    aria-expanded="false" data-bs-reference="parent">
                                <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false"
                                     data-prefix="fas" data-icon="ellipsis" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                          d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                </svg>
                                <!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com -->
                            </button>
                            <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item"
                                                                                 href="#!">View</a><a
                                        class="dropdown-item" href="#!">Export</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#!">Remove</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle ps-3 name">Emily</td>
                    <td class="align-middle email">emily@example.com</td>
                    <td class="align-middle age">30</td>
                    <td class="align-middle white-space-nowrap text-end pe-0">
                        <div class="btn-reveal-trigger position-static">
                            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                    aria-expanded="false" data-bs-reference="parent">
                                <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false"
                                     data-prefix="fas" data-icon="ellipsis" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                          d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                </svg>
                                <!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com -->
                            </button>
                            <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item"
                                                                                 href="#!">View</a><a
                                        class="dropdown-item" href="#!">Export</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#!">Remove</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle ps-3 name">Jara</td>
                    <td class="align-middle email">jara@example.com</td>
                    <td class="align-middle age">25</td>
                    <td class="align-middle white-space-nowrap text-end pe-0">
                        <div class="btn-reveal-trigger position-static">
                            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                    aria-expanded="false" data-bs-reference="parent">
                                <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false"
                                     data-prefix="fas" data-icon="ellipsis" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                          d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                </svg>
                                <!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com -->
                            </button>
                            <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item"
                                                                                 href="#!">View</a><a
                                        class="dropdown-item" href="#!">Export</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#!">Remove</a>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between mt-3"><span class="d-none d-sm-inline-block"
                                                               data-list-info="data-list-info">1 to 5 <span
                        class="text-body-tertiary"> Items of </span>43</span>
            <div class="d-flex">
                <button class="page-link disabled" data-list-pagination="prev" disabled="">
                    <svg class="svg-inline--fa fa-chevron-left" aria-hidden="true" focusable="false" data-prefix="fas"
                         data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                         data-fa-i2svg="">
                        <path fill="currentColor"
                              d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"></path>
                    </svg><!-- <span class="fas fa-chevron-left"></span> Font Awesome fontawesome.com --></button>
                <ul class="mb-0 pagination">
                    <li class="active">
                        <button class="page" type="button" data-i="1" data-page="5">1</button>
                    </li>
                    <li>
                        <button class="page" type="button" data-i="2" data-page="5">2</button>
                    </li>
                    <li>
                        <button class="page" type="button" data-i="3" data-page="5">3</button>
                    </li>
                    <li class="disabled">
                        <button class="page" type="button">...</button>
                    </li>
                </ul>
                <button class="page-link pe-0" data-list-pagination="next">
                    <svg class="svg-inline--fa fa-chevron-right" aria-hidden="true" focusable="false" data-prefix="fas"
                         data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                         data-fa-i2svg="">
                        <path fill="currentColor"
                              d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                    </svg><!-- <span class="fas fa-chevron-right"></span> Font Awesome fontawesome.com --></button>
            </div>
        </div>
    </div>


    <div class="table-responsive">
        <table class='table table-striped table-sm fs-9 mb-0' id='tablePrinter'>
            <thead class="thead-dark">
            <tr>
                <th>
                    #
                </th>
                <th class="sort border-top border-translucent ps-3">
                    serial
                </th>
                <th>
                    model
                </th>
                <th class="text-right">
                    black
                </th>
                <th class="text-center">
                    color
                </th>
                {if !$czycolorbox}
                    <th>
                        nr umowy
                    </th>
                    <th>
                        klient
                    </th>
                {/if}
                <th>
                    data mail
                </th>
                <th>
                    test
                </th>
                {if !$czycolorbox}
                    <th>
                    </th>
                {/if}
            </tr>
            </thead>
            <tbody>
            {foreach from=$dataPrinters item=item key=key name=loopek}
                <tr {if $czycolorbox}
                    class="selectable-row"
                    data-source="devices"
                    data-modalselector="{$czycolorbox}"
                    data-serial="{$item.serial}"
                    data-clientname="{$item.nazwaklient}"
                    data-clientid="{$item.rowidclient}"
                    data-agreementnb="{$item.nrumowy}"
                    data-agreementid="{$item.rowidumowa}"
                    data-sla="{{$item.sla}}"
                    onclick="dataRowSelectedHandler(this); return false;"
                        {/if}>
                    <th scope="row">{$smarty.foreach.loopek.index+1}</th>
                    <td>{$item.serial|escape:'htmlall'}</td>
                    <td>{$item.model|escape:'htmlall'} </td>
                    <td class="text-right">
                        {if !isset($item.cnt_iloscstron) || $item.cnt_iloscstron==0}0{else}{$item.cnt_iloscstron|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}{/if}
                    </td>
                    <td class="text-right">
                        {if !isset($item.cnt_iloscstron_kolor) || $item.cnt_iloscstron_kolor==''}{else}{$item.cnt_iloscstron_kolor|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}{/if}</td>
                    {if $czycolorbox==''}
                        <td onClick='showNewAgreementAdd("{$item.rowidumowa}")'>{$item.nrumowy|escape:'htmlall'}</td>
                        <td {if !empty($item.nazwaklient)}onClick='showNewClientAdd("{$item.rowidclient}")'{/if}>{$item.nazwaklient|escape:'htmlall'}</td>
                    {/if}
                    <td
                            {if (!empty($item.cnt_datawiadomosci) && ($item.cnt_datawiadomosci|date_format:"%Y-%m-%d")<($smarty.now|date_format:"%Y-%m-%d"))}class="bg-warning text-light" {/if}
                    >
                        {if (!empty($item.cnt_datawiadomosci))}
                            {assign var="dateTime" value=" "|explode:$item.cnt_datawiadomosci}
                            {$dateTime[0]|escape:'htmlall'}
                            <br/>
                            <small>{$dateTime[1]|escape:'htmlall'}</small>
                        {/if}
                    </td>
                    {if $czycolorbox==''}
                        <td>
                            <div class="dropdown show">
                                <button class="btn border border-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    <i class="fas fa-cog"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="#" onClick='showNewPrinterAdd("{$item.serial}")'><i
                                                class="fas fa-edit"></i>&nbsp;&nbsp;Edycja</a>
                                    <div class="border-top my-1"></div>

                                    <a href="javascript:void(0)" class="dropdown-item"
                                       onClick="showPrinterMessages('{$item.serial}', '{$item.model}')"><i
                                                class="fas fa-comment-dots"></i>&nbsp;&nbsp;notatki</a>

                                    <a class="dropdown-item" href="#" onClick='pokazLogi("{$item.serial}")'><i
                                                class="fas fa-history"></i>&nbsp;&nbsp;Logi</a>
                                    <a class="dropdown-item" href="#" onClick='historiaTonerow("{$item.serial}")'>Historia
                                        Tonerów</a>
                                    <a class="dropdown-item" href="#" onClick='historiaTonerow("{$item.serial}")'>Historia
                                        Serwisu</a>
                                    <a wymaganylevel='w' wymaganyzrobiony='0' class="dropdown-item text-danger" href="#"
                                       onClick='usunDrukarke("{$item.serial}")'>
                                        <i class="fas fa-print"></i><span class="font-weight-bold f">x</span>&nbsp;Usuń
                                        Urządzenie</a>
                                </div>
                            </div>
                        </td>
                    {/if}
                </tr>
            {/foreach}
            </tbody>

        </table>
    </div>
</div>