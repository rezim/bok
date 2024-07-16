<div class="table-responsive-sm">
    <table class="table table-striped table-sm fs-9 mb-0" id="tableUmowy">
        <thead>
        <tr class="fs-9">
            <th>#</th>
            <th class="sort ps-3">nr umowy</th>
            <th class="sort">typ</th>
            <th class="sort">umowa zbiorcza</th>
            <th class="sort">klient</th>
            <th class="sort">drukarka</th>
            {if !$czycolorbox}
                <th class="sort" wymaganylevel="w" wymaganyzrobiony="0">data od</th>
                <th class="sort" wymaganylevel="w" wymaganyzrobiony="0">data do</th>
                <th class="sort text-right pr-3" wymaganylevel="w" wymaganyzrobiony="0">stron <br/> abonam.</th>
                <th class="sort text-right pr-3" wymaganylevel="w" wymaganyzrobiony="0">cena <br/> strona</th>
                <th class="sort text-right pr-3" wymaganylevel="w" wymaganyzrobiony="0">abon.</th>
            {/if}
            {if !$czycolorbox}
                <th class="text-end align-middle pe-0">ACTION</th>
            {/if}
        </tr>
        </thead>
        <tbody class="list">
        {foreach from=$dataAgreements item=item key=key name=loopek}
            <tr class="fs-9" {if $czycolorbox}
                class="selectable-row"
                data-source="agreements"
                data-modalselector="{$czycolorbox}"
                data-agreementid="{$item.rowid}"
                data-agreementnb="{$item.nrumowy}"
                data-sla="{{$item.sla}}"
                onclick="dataRowSelectedHandler(this); return false"
                    {/if}>
                <th scope="row">{$smarty.foreach.loopek.index+1}</th>
                <td>{$item.nrumowy|escape:'htmlall'}</td>
                <td>{$item.type|escape:'htmlall'}</td>
                <td>{$item.umowazbiorcza|escape:'htmlall'}</td>
                <td {if !$czycolorbox}onClick='showNewClientAdd("{$item.rowidclient}")'{/if}>{$item.nazwakrotka|escape:'htmlall'}</td>
                <td {if !$czycolorbox}onClick='showNewPrinterAdd("{$item.serial}")'{/if}>{$item.serial|escape:'htmlall'}</td>
                {if !$czycolorbox}
                    <td wymaganylevel="w" wymaganyzrobiony="0">{$item.dataod|escape:'htmlall'}</td>
                    <td wymaganylevel="w" wymaganyzrobiony="0" {if ($item.datado|date_format:"%Y-%m")==($smarty.now|date_format:"%Y-%m")}{/if}>{$item.datado|escape:'htmlall'}</td>
                    <td class="text-right pr-3">{$item.stronwabonamencie|number_format:2:",":" "|replace:',00':''}</td>
                    <td class="text-right pr-3">{$item.cenazastrone|number_format:3:",":" "|escape:'htmlall'}</td>
                    <td class="text-right pr-3">{if !empty($item.abonament)}{$item.abonament|number_format:2:",":" "|escape:'htmlall'}{/if}</td>
                {/if}
                {if !$czycolorbox}
                    <td class="text-end pe-0">
                        <div class="btn-reveal-trigger position-static">
                            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                <i class="fas fa-ellipsis"></i>
                                {if !empty($item.blad)}
                                    <span class="badge badge-pill badge-danger" title="Logi Błąd"><i class="fas fa-exclamation-circle"></i></span>
                                {/if}
                            </button>
                            <div class="dropdown-menu dropdown-menu-end py-2">
                                <a wymaganylevel="r" wymaganyzrobiony="0" class="dropdown-item" href="#" onClick='showNewAgreementAdd("{$item.rowid}")'><i class="fas fa-edit"></i>&nbsp;&nbsp;Edycja</a>
                                <a href="javascript:void(0)" class="dropdown-item" onClick="showAgreementMessages('{$item.nrumowy}', '{$item.type}', '{$item.nazwakrotka}')"><i class="fas fa-comment-dots"></i>&nbsp;&nbsp;Notatki</a>
                                {if !empty($item.serial)}
                                    <div class="border-top my-1"></div>
                                    <a class="dropdown-item" href="#" onClick='pokazLogi("{$item.serial}")'><i class="fas fa-history"></i>&nbsp;&nbsp;Logi</a>
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
