<div class="table-responsive-sm">
    <table class='table table-hover table-sm' id='tableUmowy'>
        <thead class="thead-dark">
        <tr>
            <th>
                #
            </th>
            <th>
                nr umowy
            </th>
            <th>
                typ
            </th>
            <th>
                umowa zbiorcza
            </th>
            <th>
                klient
            </th>
            <th>
                drukarka
            </th>
            {if !$czycolorbox}
                <th wymaganylevel='w' wymaganyzrobiony='0'>
                    data od
                </th>
                <th wymaganylevel='w' wymaganyzrobiony='0'>
                    data do
                </th>
                <th wymaganylevel='w' wymaganyzrobiony='0' class="text-right pr-3">
                    stron <br/> abonam.
                </th>
                <th wymaganylevel='w' wymaganyzrobiony='0' class="text-right pr-3">
                    cena <br/> strona
                </th>
                <th wymaganylevel='w' wymaganyzrobiony='0' class="text-right pr-3">
                    rozliczenie
                </th>
                <th wymaganylevel='w' wymaganyzrobiony='0' class="text-right pr-3">
                    kwota w abon.
                </th>
                <th wymaganylevel='w' wymaganyzrobiony='0' class="text-right pr-3">
                    abon.
                </th>
            {/if}
            <th>
                aktywna
            </th>
            {if !$czycolorbox}
                <th>
                </th>
            {/if}
        </tr>
        </thead>
        <tbody>

        {foreach from=$dataAgreements item=item key=key name=loopek}
            <tr {if $czycolorbox}
                class="selectable-row"
                data-source="agreements"
                data-modalselector="{$czycolorbox}"
                data-agreementid="{$item.rowid}"
                data-agreementnb="{$item.nrumowy}"
                data-sla="{{$item.sla}}"
                onclick="dataRowSelectedHandler(this);return false"
                {/if}>
                <th scope="row">{$smarty.foreach.loopek.index+1}</th>
                <td>{$item.nrumowy|escape:'htmlall'}</td>
                <td>{$item.type|escape:'htmlall'}</td>
                <td>{$item.umowazbiorcza|escape:'htmlall'}</td>
                <td
                        {if !$czycolorbox}onClick='showNewClientAdd("{$item.rowidclient}")'{/if}>{$item.nazwakrotka|escape:'htmlall'}</td>
                <td
                        {if !$czycolorbox}onClick='showNewPrinterAdd("{$item.serial}")'{/if}>{$item.serial|escape:'htmlall'}</td>
                {if !$czycolorbox}
                    <td wymaganylevel='w' wymaganyzrobiony='0'>{$item.dataod|escape:'htmlall'}</td>
                    <td wymaganylevel='w' wymaganyzrobiony='0'
                            {if ($item.datado|date_format:"%Y-%m")==($smarty.now|date_format:"%Y-%m")}{/if}
                    >
                        {$item.datado|escape:'htmlall'}
                    </td>
                    <td wymaganylevel='w'
                        wymaganyzrobiony='0' class="text-right pr-3">{$item.stronwabonamencie|number_format:2:",":" "|replace:',00':''}
                    </td>
                    <td wymaganylevel='w'
                        wymaganyzrobiony='0' class="text-right pr-3">{$item.cenazastrone|number_format:3:",":" "|escape:'htmlall'}
                    </td>
                    <td wymaganylevel='w' wymaganyzrobiony='0' class="text-right pr-3">{$item.rozliczenie|escape:'htmlall'}</td>
                    <td wymaganylevel='w'
                        wymaganyzrobiony='0' class="text-right pr-3">{if !empty($item.kwotawabonamencie)}{$item.kwotawabonamencie|number_format:2:",":" "|escape:'htmlall'}{/if}
                    </td>
                    <td wymaganylevel='w'
                        wymaganyzrobiony='0' class="text-right pr-3">{if !empty($item.abonament)}{$item.abonament|number_format:2:",":" "|escape:'htmlall'}{/if}
                    </td>
                {/if}
                <td class="text-center">{if $item.activity === 1}tak{else}nie{/if}</td>
                {if $czycolorbox==''}
                    <td>
                        <div class="dropdown show">
                            <button class="btn border border-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <i class="fas fa-cog"></i>
                                {if !empty($item.blad)}
                                    <span class="badge badge-pill badge-danger" title="Logi Błąd"><i class="fas fa-exclamation-circle"></i></span>
                                {/if}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                <a wymaganylevel='r' wymaganyzrobiony='0' class="dropdown-item" href="#"
                                   onClick='showNewAgreementAdd("{$item.rowid}")'><i class="fas fa-edit"></i>&nbsp;&nbsp;Edycja</a>
                                {if !empty($item.serial)}
                                    <div class="border-top my-1"></div>
                                    <a class="dropdown-item" href="#" onClick='pokazLogi("{$item.serial}")'><i
                                                class="fas fa-history"></i>&nbsp;&nbsp;Logi</a>
                                {/if}
                            </div>
                        </div>
                    </td>
                {/if}
            </tr>
        {/foreach}
        </tbody>
    </table>
</div>
       