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
            {if $czycolorbox==''}
                <th>
                    klient
                </th>
                <th>
                    drukarka
                </th>
            {/if}
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
            <th titla="1-tak; 0-nie">
                aktywna
            </th>
            {if $czycolorbox==''}
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
                <td>{$smarty.foreach.loopek.index+1}</td>
                <td>{$item.nrumowy|escape:'htmlall'}</td>
                {if $czycolorbox==''}
                    <td
                        onClick='showNewClientAdd("{$item.rowidclient}")'>{$item.nazwakrotka|escape:'htmlall'}</td>
                    <td
                        onClick='showNewPrinterAdd("{$item.serial}")'>{$item.serial|escape:'htmlall'}</td>
                {/if}
                <td wymaganylevel='w' wymaganyzrobiony='0'>{$item.dataod|escape:'htmlall'}</td>
                <td wymaganylevel='w' wymaganyzrobiony='0'
                    {if ($item.datado|date_format:"%Y-%m")==($smarty.now|date_format:"%Y-%m")}{/if}
                >
                    {$item.datado|escape:'htmlall'}
                </td>
                <td wymaganylevel='w' wymaganyzrobiony='0'>{$item.stronwabonamencie|number_format:2:",":" "|replace:',00':''}
                </td>
                <td wymaganylevel='w' wymaganyzrobiony='0'>{$item.cenazastrone|number_format:3:",":" "|replace:',00':''|escape:'htmlall'}
                </td>
                <td wymaganylevel='w' wymaganyzrobiony='0'>{$item.rozliczenie|escape:'htmlall'}</td>
                <td wymaganylevel='w' wymaganyzrobiony='0'>{if !empty($item.abonament)}{$item.abonament|number_format:2:",":" "|replace:',00':''|escape:'htmlall'}{/if}
                </td>
                <td>{$item.activity}</td>
                {if $czycolorbox==''}
                    <td>
                        <div class="dropdown show">
                            <button class="btn border border-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                {if !empty($item.blad)}
                                <span class="badge badge-pill badge-danger" title="Logi Błąd">!</span>
                                {/if}
                                <i class="fa fa-gear"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                <a wymaganylevel='r' wymaganyzrobiony='0' class="dropdown-item" href="#" onClick='showNewAgreementAdd("{$item.rowid}")'>Edycja</a>
                                {if !empty($item.serial)}
                                <a class="dropdown-item" href="#" onClick='pokazLogi("{$item.serial}")'>Logi</a>
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
       