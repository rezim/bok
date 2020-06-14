<div class="container mt-3">
    <span id="keyval" style='display:none;'>{$keyVal}</span>

    <div id="invoicesContainer" class="container">
    </div>

    <div class="container">
        <div id='actionok' class="actionok alert alert-success" role="alert">
            <strong>Dane zapisane poprawnie</strong>
        </div>
        <div id='actionerror' class="actionerror alert alert-danger" role="alert">
            <strong>Błąd zapisu danych.</strong>
        </div>
    </div>

    <div class="row container">
        <div class="col">
            <div id="divNotiGlowne">
                <table class="table bok-edit-notification">
                    <tbody>
                    {foreach from=$filedsToEdit item=item key=key}
                        {if $item.activity=='1' && $item.divek=='divNotiGlowne'}
                            <tr id='tr{$key}'>
                                <th {if isset($item.ishide) && $item.ishide=='1'}style="display:none;"{/if}>
                                    {$item.label}</th>
                                <td class='tdWartosc'
                                    {if isset($item.ishide) && $item.ishide=='1'}style="display:none;"{/if}>
                                    {if $item.type=='link' || $item.type=='text'}
                                        <div class="input-group mb-1">
                                            <input class="form-control form-control-md" type="text" id='{$key}'
                                                   baza='{$item.baza}'
                                                   name='editobj'
                                                   {if isset($item.focus) && $item.focus=='1'}autofocus="true"{/if}
                                                    {if isset($item.wymagane) && $item.wymagane=='1'}wymagane="{$item.wymagane}"{/if}
                                                    {if isset($item.readonly) && $item.readonly=='1'}disabled='true'{/if}
                                                    {if isset($item.iskey) && $item.iskey=='1'}iskey='1'{/if}
                                                    {if isset($item.idzewnetrznespan) && $item.idzewnetrznespan!=''}zewnetrznyspan='{$item.idzewnetrznespan}'{/if}
                                                    {if isset($item.wymaganylevel) && $item.wymaganylevel!=''}wymaganylevel='{$item.wymaganylevel}' wymaganyzrobiony='0' {/if}
                                                    {if $item.type=='link'}
                                                        disabled='true'
                                                    {/if}
                                                    {if isset($item.value) && (string)$item.value!=''}
                                                        {if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
                                                            value='{$item.value|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}'
                                                        {else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
                                                            value='{$item.value|date_format:"%Y-%m-%d"|escape:'htmlall'}'
                                                        {else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
                                                            value='{$item.value|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}'
                                                        {else}
                                                            value='{$item.value|escape:'htmlall'}'
                                                        {/if}
                                                    {else if isset($item.sqldanebaza) && isset($dane[0][$item.sqldanebaza]) && (string)$dane[0][$item.sqldanebaza]!=''}
                                                        {if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
                                                            value='{$dane[0][$item.sqldanebaza]|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}'
                                                        {else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
                                                            value='{$dane[0][$item.sqldanebaza]|date_format:"%Y-%m-%d"|escape:'htmlall'}'
                                                        {else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
                                                            value='{$dane[0][$item.sqldanebaza]|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}'
                                                        {else}
                                                            value='{$dane[0][$item.sqldanebaza]|escape:'htmlall'}'
                                                        {/if}
                                                    {else if isset($item.baza) && isset($dane[0][$item.baza]) && (string)$dane[0][$item.baza]!=''}
                                                        {if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
                                                            value='{$dane[0][$item.baza]|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}'
                                                        {else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
                                                            value='{$dane[0][$item.baza]|date_format:"%Y-%m-%d"|escape:'htmlall'}'
                                                        {else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
                                                            value='{$dane[0][$item.baza]|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}'
                                                        {else}
                                                            value='{$dane[0][$item.baza]|escape:'htmlall'}'
                                                        {/if}

                                                    {/if}
                                            />

                                            {if $item.type=='link' && $item.readonly=='0'}
                                                <div class="input-group-append">
                                                    <button
                                                            {if isset($item.wymaganylevel) && $item.wymaganylevel!=''}wymaganylevel='{$item.wymaganylevel}'
                                                            wymaganyzrobiony='0' {/if}
                                                            class="btn btn-info btn-sm" type="button"
                                                            onclick="openDataShow('{$item.link}','{$item.idzewnetrznespan}')">
                                                        <i class="fa fa-search" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            {/if}
                                        </div>
                                    {if isset($item.js)}
                                        <script type="text/javascript">


                                        </script>
                                    {/if}
                                    {/if}
                                    {if $item.type=='combobox'}
                                        <select name='editobj' id='{$key}' baza='{$item.baza}'
                                                class="form-control form-control-md"
                                                {if isset($item.wymagane) && $item.wymagane=='1'}wymagane="{$item.wymagane}"{/if}
                                                {if isset($item.readonly) && $item.readonly=='1'}disabled='true'{/if}
                                                {if isset($item.iskey) && $item.iskey=='1'}iskey='1'{/if}
                                                {if isset($item.wymaganylevel) && $item.wymaganylevel!=''}wymaganylevel='{$item.wymaganylevel}' wymaganyzrobiony='0' {/if}
                                                {if isset($item.idzewnetrznespan) && $item.idzewnetrznespan!=''}zewnetrznyspan='{$item.idzewnetrznespan}'{/if}
                                        >
                                            <option value="" selected></option>
                                            {if isset($item.arr) && $item.arr!=''}
                                                {foreach from=${$item.arr} item=item2 key=key2}
                                                    <option value="{$key2}"
                                                    {if isset($item.value)  && $item.value!=''}
                                                        {if $key2==  $item.value}selected{/if}>{$item.value}</option>
                                                    {elseif !isset($dane)}
                                                        {if isset($item.wart_domyslna) && $item.wart_domyslna==$key2}selected{/if}>{$item2.dane}</option>
                                                    {else}
                                                        {if isset($dane) && $key2==  $dane[0][$item.baza]}selected{/if}>{$item2.dane}</option>
                                                    {/if}
                                                {/foreach}
                                            {/if}
                                        </select>
                                    {/if}
                                    {if $item.type=='textarea'}
                                        <textarea id='{$key}' baza='{$item.baza}' name='editobj'
                                                  class="form-control form-control-md"
                                                  {if isset($item.focus) && $item.focus=='1'}autofocus="true"{/if}
                                                {if isset($item.wymagane) && $item.wymagane=='1'}wymagane="{$item.wymagane}"{/if}
                                                {if isset($item.readonly) && $item.readonly=='1'}disabled='true'{/if}
                                                {if isset($item.iskey) && $item.iskey=='1'}iskey='1'{/if}
                                                {if isset($item.wymaganylevel) && $item.wymaganylevel!=''}wymaganylevel='{$item.wymaganylevel}' wymaganyzrobiony='0' {/if}
                                                {if isset($item.idzewnetrznespan) && $item.idzewnetrznespan !=''}zewnetrznyspan='{$item.idzewnetrznespan}'{/if}
                                         >{if isset($item.value)  && $item.value!=''}
                                                {if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
                                                    {$item.value|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}
                                                {else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
                                                    {$item.value|date_format:"%Y-%m-%d"|escape:'htmlall'}
                                                {else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
                                                    {$item.value|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}
                                                {else}
                                                    {$item.value|escape:'htmlall'}
                                                {/if}
                                            {else if isset($item.sqldanebaza) && isset($dane[0][$item.sqldanebaza]) && (string)$dane[0][$item.sqldanebaza]!=''}
                                                {if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
                                                    {$dane[0][$item.sqldanebaza]|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}
                                                {else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
                                                    {$dane[0][$item.sqldanebaza]|date_format:"%Y-%m-%d"|escape:'htmlall'}
                                                {else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
                                                    {$dane[0][$item.sqldanebaza]|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}
                                                {else}
                                                    {$dane[0][$item.sqldanebaza]|escape:'htmlall'}
                                                {/if}
                                            {else if isset($item.baza) && isset($dane[0][$item.baza]) && (string)$dane[0][$item.baza]!=''}
                                                {if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
                                                    {$dane[0][$item.baza]|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}
                                                {else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
                                                    {$dane[0][$item.baza]|date_format:"%Y-%m-%d"|escape:'htmlall'}
                                                {else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
                                                    {$dane[0][$item.baza]|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}
                                                {else}
                                                    {$dane[0][$item.baza]|escape:'htmlall'}
                                                {/if}
                                            {/if}
</textarea>
                                    {/if}
                                    {if $item.type=='link' && $item.readonly=='0'}
                                        <span id='{$item.idzewnetrznespan}'
                                              style="display:none;">{if isset($dane[0][$item.baza]) && (string)$dane[0][$item.baza]!=''}{$dane[0][$item.baza]}{/if}</span>
                                    {/if}
                                    {if isset($item.opis) && $item.opis!=''}
                                        <span>{$item.opis}</span>
                                    {/if}
                                </td>
                            </tr>
                        {/if}
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col">
            <div id="divNotiWykonanie">
                <table class='table bok-edit-notification'>
                    <tbody>

                    {foreach from=$filedsToEdit item=item key=key}
                        {if $item.activity=='1' && $item.divek=='divNotiWykonanie'}
                            <tr id='tr{$key}'>
                                <th class="thead-dark"
                                    {if isset($item.ishide) && $item.ishide=='1'}style="display:none;"{/if}>
                                    {$item.label}</th>
                                <td
                                        {if isset($item.ishide) && $item.ishide=='1'}style="display:none;"{/if}>
                                    {if $item.type=='link' || $item.type=='text'}
                                        <input class="form-control form-control-md" type="text" id='{$key}'
                                               baza='{$item.baza}' name='editobj'
                                               {if isset($item.focus) && $item.focus=='1'}autofocus="true"{/if}
                                                {if isset($item.wymagane) && $item.wymagane=='1'}wymagane="{$item.wymagane}"{/if}
                                                {if isset($item.readonly) && $item.readonly=='1'}disabled='true'{/if}
                                                {if isset($item.iskey) && $item.iskey=='1'}iskey='1'{/if}
                                                {if isset($item.idzewnetrznespan) && $item.idzewnetrznespan!=''}zewnetrznyspan='{$item.idzewnetrznespan}'{/if}
                                                {if isset($item.wymaganylevel) && $item.wymaganylevel!=''}wymaganylevel='{$item.wymaganylevel}' wymaganyzrobiony='0' {/if}
                                                {if $item.type=='link'}
                                                    disabled='true'
                                                {/if}
                                                {if isset($item.value) && $item.value!=''}
                                                    {if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
                                                        value='{$item.value|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}'
                                                    {else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
                                                        value='{$item.value|date_format:"%Y-%m-%d"|escape:'htmlall'}'
                                                    {else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
                                                        value='{$item.value|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}'
                                                    {else}
                                                        value='{$item.value|escape:'htmlall'}'
                                                    {/if}
                                                {else if isset($item.sqldanebaza) && isset($dane[0][$item.sqldanebaza]) && (string)$dane[0][$item.sqldanebaza]!=''}
                                                    {if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
                                                        value='{$dane[0][$item.sqldanebaza]|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}'
                                                    {else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
                                                        value='{$dane[0][$item.sqldanebaza]|date_format:"%Y-%m-%d"|escape:'htmlall'}'
                                                    {else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
                                                        value='{$dane[0][$item.sqldanebaza]|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}'
                                                    {else}
                                                        value='{$dane[0][$item.sqldanebaza]|escape:'htmlall'}'
                                                    {/if}
                                                {else if isset($item.baza) && isset($dane[0][$item.baza]) && (string)$dane[0][$item.baza]!=''}
                                                    {if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
                                                        value='{$dane[0][$item.baza]|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}'
                                                    {else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
                                                        value='{$dane[0][$item.baza]|date_format:"%Y-%m-%d"|escape:'htmlall'}'
                                                    {else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
                                                        value='{$dane[0][$item.baza]|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}'
                                                    {else}
                                                        value='{$dane[0][$item.baza]|escape:'htmlall'}'
                                                    {/if}

                                                {/if}
                                        />
                                    {if isset($item.js)}
                                        <script type="text/javascript">
                                            alert('s');

                                        </script>
                                    {/if}
                                    {/if}
                                    {if $item.type=='combobox'}
                                        <select class="custom-select form-control-md" name='editobj' id='{$key}'
                                                baza='{$item.baza}'
                                                {if isset($item.wymagane) && $item.wymagane=='1'}wymagane="{$item.wymagane}"{/if}
                                                {if isset($item.readonly) && $item.readonly=='1'}disabled='true'{/if}
                                                {if isset($item.iskey) && $item.iskey=='1'}iskey='1'{/if}
                                                {if isset($item.wymaganylevel) && $item.wymaganylevel!=''}wymaganylevel='{$item.wymaganylevel}' wymaganyzrobiony='0' {/if}
                                                {if isset($item.idzewnetrznespan) && $item.idzewnetrznespan!=''}zewnetrznyspan='{$item.idzewnetrznespan}'{/if}
                                        >
                                            <option value=""></option>
                                            {if isset($item.arr) && $item.arr!=''}
                                                {foreach from=${$item.arr} item=item2 key=key2}
                                                    <option value="{$key2}"
                                                    {if isset($item.value)  && $item.value!=''}
                                                        {if $key2==  $item.value}selected{/if}>{$item.value}</option>
                                                    {elseif !isset($dane)}
                                                        {if isset($item.wart_domyslna) && $item.wart_domyslna==$key2}selected{/if}>{$item2.dane}</option>
                                                    {elseif $dane[0][$item.baza]}
                                                        {if isset($dane) && $key2==$dane[0][$item.baza]}selected{/if}>{$item2.dane}</option>
                                                    {else}
                                                        {if isset($item.wart_domyslna) && $item.wart_domyslna==$key2}selected{/if}>{$item2.dane}</option>
                                                    {/if}
                                                {/foreach}
                                            {/if}
                                        </select>
                                    {/if}
                                    {if $item.type=='textarea'}
                                        <textarea id='{$key}' baza='{$item.baza}' name='editobj' class="form-control"

                                                  {if isset($item.focus) && $item.focus=='1'}autofocus="true"{/if}
                                                {if isset($item.wymagane) && $item.wymagane=='1'}wymagane="{$item.wymagane}"{/if}
                                                {if isset($item.readonly) && $item.readonly=='1'}disabled='true'{/if}
                                                {if isset($item.iskey) && $item.iskey=='1'}iskey='1'{/if}
                                                {if isset($item.wymaganylevel) && $item.wymaganylevel!=''}wymaganylevel='{$item.wymaganylevel}' wymaganyzrobiony='0' {/if}
                                                {if isset($item.idzewnetrznespan) && $item.idzewnetrznespan !=''}zewnetrznyspan='{$item.idzewnetrznespan}'{/if}
                                         >{if isset($item.value)  && $item.value!=''}
                                                {if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
                                                    {$item.value|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}
                                                {else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
                                                    {$item.value|date_format:"%Y-%m-%d"|escape:'htmlall'}
                                                {else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
                                                    {$item.value|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}
                                                {else}
                                                    {$item.value|escape:'htmlall'}
                                                {/if}
                                            {else if isset($item.sqldanebaza) && isset($dane[0][$item.sqldanebaza]) && (string)$dane[0][$item.sqldanebaza]!=''}
                                                {if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
                                                    {$dane[0][$item.sqldanebaza]|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}
                                                {else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
                                                    {$dane[0][$item.sqldanebaza]|date_format:"%Y-%m-%d"|escape:'htmlall'}
                                                {else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
                                                    {$dane[0][$item.sqldanebaza]|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}
                                                {else}
                                                    {$dane[0][$item.sqldanebaza]|escape:'htmlall'}
                                                {/if}
                                            {else if isset($item.baza) && isset($dane[0][$item.baza]) && (string)$dane[0][$item.baza]!=''}
                                                {if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
                                                    {$dane[0][$item.baza]|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}
                                                {else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
                                                    {$dane[0][$item.baza]|date_format:"%Y-%m-%d"|escape:'htmlall'}
                                                {else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
                                                    {$dane[0][$item.baza]|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}
                                                {else}
                                                    {$dane[0][$item.baza]|escape:'htmlall'}
                                                {/if}
                                            {/if}
                                    </textarea>
                                    {/if}
                                    {if $item.type=='link' && $item.readonly=='0'}
                                        <span id='{$item.idzewnetrznespan}'
                                              style="display:none;">{if isset($dane[0][$item.baza]) && (string)$dane[0][$item.baza]!=''}{$dane[0][$item.baza]}{/if}</span>
                                        <img {if isset($item.wymaganylevel) && $item.wymaganylevel!=''}wymaganylevel='{$item.wymaganylevel}'
                                             wymaganyzrobiony='0' {/if}
                                             src="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/find.png"
                                             style='display:inline;margin-left: 5px;cursor:hand;cursor:pointer;'
                                             title='Wybierz'
                                             onclick="openDataShow('{$smarty.const.SCIEZKA}/{$item.link}','{$item.idzewnetrznespan}')"


                                        />
                                    {/if}
                                </td>
                            </tr>
                        {/if}
                    {/foreach}

                    </tbody>
                </table>

            </div>
        </div>
    </div>

    {if isset($dane) && $dane[0]['status']=='3'}

    {else}
        <div class="container text-right" wymaganylevel='w' wymaganyzrobiony='0'>
            <a href="#" class="btn btn-outline-success active" role="button" aria-pressed="true" onclick="zapiszNoti('0','{$smarty.const.SCIEZKA}/notifications/save/notemplate');return false;"><i class="fas fa-save"></i>&nbsp; Zapisz</a>
            <a href="#" class="btn btn-outline-secondary" role="button" onclick="$.colorbox.close();">Anuluj</a>
        </div>
    {/if}

    <div id="accordion" class="mt-5 mb-3 container">
        {if isset($dane) }
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" onclick="gotoBottom('headingOne')">
                        <i class="fa" aria-hidden="true"></i>&nbsp;Wymiana {if $dane[0]['serial'] != $agreementSerial}Drukarki{else}Formatera{/if}
                    </button>
                </h5>
            </div>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <table class="table bok-edit-notification">
                                <tr>
                                    <th class='tdOpis thead-dark' scope="row"><span>C/B Koniec:</span></th>
                                    <td class='tdWartosc'><input class="form-control" id="counterEnd" type="text"/></td>
                                </tr>
                                <tr>
                                    <th class='tdOpis thead-dark'><span>Kolor Koniec:</span></th>
                                    <td class='tdWartosc'><input class="form-control" id="counterColorEnd" type="text"/></td>
                                </tr>
                                <tr>
                                    <th class='tdOpis thead-dark'><span>Serial (stara)</span></th>
                                    <td class='tdWartosc'><input class="form-control" type="text" disabled
                                                                 value="{$dane[0]['serial']}"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th class='tdOpis thead-dark'><span>Data:</span></th>
                                    <td class='tdWartosc'><input class="form-control" id="replacementDate" type="text"/></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col">
                            <table class="table bok-edit-notification">
                                <tr>
                                    <th class='tdOpis'><span>C/B Start:</span></th>
                                    <td class='tdWartosc'><input class="form-control" id="counterStart" type="text"/></td>
                                </tr>
                                <tr>
                                    <th class='tdOpis'><span>Kolor Start:</span></th>
                                    <td class='tdWartosc'><input class="form-control" id="counterColorStart" type="text"/></td>
                                </tr>
                                {if $dane[0]['serial'] != $agreementSerial}
                                    <tr>
                                        <th class='tdOpis'>Serial (nowa)</th>
                                        <td class='tdWartosc'><input class="form-control" type="text" disabled
                                                                     value="{$agreementSerial}"/>
                                        </td>
                                    </tr>
                                {else}
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>
                                {/if}
                                <tr>
                                    <td colspan="2" style="text-align: right">
                                        <a href="#" class="btn btn-outline-success active" role="button" aria-pressed="true"
                                           onclick='replacePrinter("{$dane[0]['serial']}", "{$agreementSerial}", {$dane[0]['rowid_agreements']})'>
                                            <i class="fas fa-save"></i>&nbsp; Zapisz</a>
                                        <a href="#" class="btn btn-outline-warning" role="button" aria-pressed="true"
                                           onclick='showPrinterService("{$dane[0]['umowadane']}", "{$dane[0]['rowid_agreements']}")'><i class="fas fa-history"></i>&nbsp;Historia</a>
                                    </td>
                                </tr>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {/if}
        {if isset($keyVal) && $keyVal!=0}
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h5 class="mb-0">
                    <button class="btn collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <i class="fa" aria-hidden="true"></i>&nbsp;Dodaj pliki
                    </button>
                </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                    <div class="dropzone" id="divdropzone">

                    </div>
                    <script type="text/javascript">
                        createDropZone('div#divdropzone', '{$keyVal}', 'notifications', '{$smarty.const.ADRESHTTPS}/public_html', '{$smarty.const.SCIEZKA}');
                    </script>
                </div>
            </div>
        </div>
        {/if}
        <div class="card">
            <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <i class="fa" aria-hidden="true"></i>&nbsp;Maile powiązane
                    </button>
                </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                <div class="card-body">
                    <div id="divMailePowiazane">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="selectNotificationData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Wybierz opcję z listy</h5>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    const clientIdSelector = "#idclientspan";
    const clientIdHolder = $(clientIdSelector);
    if (clientIdHolder.text() !== '') {
        showNotPaidInvoices(clientIdHolder.text(), '#invoicesContainer');
    }

    showMaile();

    $("#replacementDate").datetimepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd", changeMonth: true, timeFormat: 'HH:mm', stepMinute: 10,
        changeYear: true
    });
    $("#data_planowana").datetimepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd", changeMonth: true, timeFormat: 'HH:mm', stepMinute: 10,
        changeYear: true
    });
</script>

