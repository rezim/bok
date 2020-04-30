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
                <th wymaganylevel='w' wymaganyzrobiony='0'>
                    stron <br/> abonam.
                </th>
                <th wymaganylevel='w' wymaganyzrobiony='0'>
                    cena <br/> strona
                </th>
                <th wymaganylevel='w' wymaganyzrobiony='0'>
                    rozliczenie
                </th>
                <th wymaganylevel='w' wymaganyzrobiony='0'>
                    abonament
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
            <tr
                    {if $czycolorbox=='1'}
                        onClick="
                                $('#idumowaspan').html('{$item.rowid}');
                                $('#rowid_agreements').val('{$item.nrumowy}');
                                $('#sla').val('{$item.sla}');
                                $.colorbox.close();
                                "
                    {/if}
            >
                <th scope="row">{$smarty.foreach.loopek.index+1}</th>
                <td>{$item.nrumowy|escape:'htmlall'}</td>

                <td
                        onClick='showNewClientAdd("{$item.rowidclient}")'>{$item.nazwakrotka|escape:'htmlall'}</td>
                <td
                        onClick='showNewPrinterAdd("{$item.serial}")'>{$item.serial|escape:'htmlall'}</td>
                {if !$czycolorbox}
                    <td wymaganylevel='w' wymaganyzrobiony='0'>{$item.dataod|escape:'htmlall'}</td>
                    <td wymaganylevel='w' wymaganyzrobiony='0'
                            {if ($item.datado|date_format:"%Y-%m")==($smarty.now|date_format:"%Y-%m")}{/if}
                    >
                        {$item.datado|escape:'htmlall'}
                    </td>
                    <td wymaganylevel='w'
                        wymaganyzrobiony='0'>{$item.stronwabonamencie|number_format:2:",":" "|replace:',00':''}
                    </td>
                    <td wymaganylevel='w'
                        wymaganyzrobiony='0'>{$item.cenazastrone|number_format:3:",":" "|replace:',00':''|escape:'htmlall'}
                    </td>
                    <td wymaganylevel='w' wymaganyzrobiony='0'>{$item.rozliczenie|escape:'htmlall'}</td>
                    <td wymaganylevel='w'
                        wymaganyzrobiony='0'>{if !empty($item.abonament)}{$item.abonament|number_format:2:",":" "|replace:',00':''|escape:'htmlall'}{/if}
                    </td>
                {/if}
                <td>{$item.activity}</td>
                {if $czycolorbox==''}
                    <td>
                        <div class="dropdown show">
                            <button class="btn border border-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <i class="fa fa-gear"></i>
                                {if !empty($item.blad)}
                                    <span class="badge badge-pill badge-danger" title="Logi Błąd">!</span>
                                {/if}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                <a wymaganylevel='r' wymaganyzrobiony='0' class="dropdown-item" href="#"
                                   onClick='showNewAgreementAdd("{$item.rowid}")'><i class="fa fa-edit"></i>&nbsp;&nbsp;Edycja</a>
                                {if !empty($item.serial)}
                                    <div class="border-top my-1"></div>
                                    <a class="dropdown-item" href="#" onClick='pokazLogi("{$item.serial}")'><i
                                                class="fa fa-history"></i>&nbsp;&nbsp;Logi</a>
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
       