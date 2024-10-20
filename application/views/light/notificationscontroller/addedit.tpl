<script type="text/javascript">
    {if isset($uprawnienia)}
    val2 = '{$uprawnienia}';
    {/if}
</script>

<div class="container mt-3" id="notificationsAddEdit">

    {*    {include file="$templates/notification/manageConsumables.tpl"}*}

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
                <table class="table bok-two-column-layout">
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
                                    {if $item.type=='number'}
                                        <input class="form-control form-control-md" type="number" min="0" max="20"
                                               step="1" onkeydown="return false" id='{$key}'
                                               baza='{$item.baza}' name='editobj'
                                               {if isset($item.focus) && $item.focus=='1'}autofocus="true"{/if}
                                                {if isset($item.wymagane) && $item.wymagane=='1'}wymagane="{$item.wymagane}"{/if}
                                                {if isset($item.readonly) && $item.readonly=='1'}disabled='true'{/if}
                                                {if isset($item.iskey) && $item.iskey=='1'}iskey='1'{/if}
                                                {if isset($item.idzewnetrznespan) && $item.idzewnetrznespan!=''}zewnetrznyspan='{$item.idzewnetrznespan}'{/if}
                                                {if isset($item.wymaganylevel) && $item.wymaganylevel!=''}wymaganylevel='{$item.wymaganylevel}' wymaganyzrobiony='0' {/if}
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
                                         >{strip}{if isset($item.value)  && $item.value!=''}
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
                                            {/if}{/strip}</textarea>
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
                <table class='table bok-two-column-layout'>
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
                                    {if $item.type=='number'}
                                        <input class="form-control form-control-md" type="number" min="0" max="20"
                                               step="1" onkeydown="return false" id='{$key}'
                                               baza='{$item.baza}' name='editobj'
                                               {if isset($item.focus) && $item.focus=='1'}autofocus="true"{/if}
                                                {if isset($item.wymagane) && $item.wymagane=='1'}wymagane="{$item.wymagane}"{/if}
                                                {if isset($item.readonly) && $item.readonly=='1'}disabled='true'{/if}
                                                {if isset($item.iskey) && $item.iskey=='1'}iskey='1'{/if}
                                                {if isset($item.idzewnetrznespan) && $item.idzewnetrznespan!=''}zewnetrznyspan='{$item.idzewnetrznespan}'{/if}
                                                {if isset($item.wymaganylevel) && $item.wymaganylevel!=''}wymaganylevel='{$item.wymaganylevel}' wymaganyzrobiony='0' {/if}
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
                                         >{strip}{if isset($item.value)  && $item.value!=''}
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
                                    {/strip}</textarea>
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
            <a href="#" id="saveNotification" class="btn btn-outline-success active" role="button"
               aria-pressed="true"
               onclick="zapiszNoti('0', '{$smarty.const.SCIEZKA}/notifications/save/notemplate');return false;"><i
                        class="fas fa-save"></i>&nbsp; Zapisz</a>
            <a href='{$smarty.const.SCIEZKA}/notifications/show' class="btn btn-outline-secondary"
               role="button">Anuluj</a>
        </div>
    {/if}

    <hr/>

    <div id="warehouseDocuments" data-form>

        <div class="container">
            <div id='actionok' class="actionok alert alert-success" role="alert">
                <strong>Dane zapisane poprawnie</strong>
            </div>
            <div id='actionerror' class="actionerror alert alert-danger" role="alert">
                <strong>Błąd zapisu danych.</strong>
            </div>
        </div>

        Magazyn:
        <select id="warehouse_id" data-ref
                onchange="onChangeWarehouse(this.value)">
            {foreach from=$allWarehouses item=warehouse key=key}
                <option value="{$warehouse.id}" {if $warehouse.name === 'FF'}selected{/if}>{$warehouse.name}</option>
            {/foreach}
        </select>

        Produkt:
        <select id="product_id" data-ref
                onchange="onSelectProduct(event)"
                class="form-control form-control-md selectpicker"
                data-size="10"
                data-width="340px"
                data-none-selected-text="Nie wybrano żadnego produktu"
                data-none-results-text="Nie znaleziono wyników dla podanego filtra"
                data-live-search-placeholder="Wpisz filtr aby zawęzić listę produktów"
                data-live-search="true">
            <option value="" selected></option>

            {foreach from=$allProducts item=product key=key}
                <option data-quantity="{$product.warehouse_quantity|number_format:0}" value="{$product.id}">{$product.name} - ({$product.warehouse_quantity|number_format:0})</option>
            {/foreach}
        </select>
        Ilość: <input id="quantity" data-ref
                     type="number" min="1" max="0"/>

        <input id="notification_id" data-ref value="{$keyVal}" type="hidden">

        <a id="addRW" href="#" class="btn btn-outline-success active"
           role="button"
           aria-pressed="true"
           onclick="addEditWarehouseDocument({$keyVal})">
            <i class="fas fa-save"></i>&nbsp; Dodaj Pozycję</a>

        <div class="container">
            {if empty($documents)}
                Aktualnie nie ma żadnych dokumentów RW dla tego zlecenia.
            {else}
                <div class="row font-weight-bold">
                    <div class="col-2">Magazyn</div>
                    <div class="col-2">Numer</div>
                    <div class="col-2">Data Ost. Zapisu</div>
                    <div class="col-2">Ilość</div>
                    <div class="col-2">Netto</div>
                    <div class="col-2"></div>
                </div>
                {foreach from=$documents item=document key=key}
                    <div class="row align-items-start">
                        <div class="col">
                            {$warehouseMap[$document.warehouse_id]}
                        </div>
                        <div class="col">
                            <a target="_blank"
                               href="https://faktury.otus.pl/warehouse_documents/{$document.id}">{$document.number}</a>
                        </div>
                        <div class="col">
                            {$document.updated_at|date_format:"%Y-%m-%d %H:%M"}
                        </div>
                        <div class="col">
                            {if isset($document.additional_fields.quantity)}{$document.additional_fields.quantity}{else}-{/if}
                        </div>
                        <div class="col">
                            {$document.purchase_price_net}
                        </div>
                        <div class="col d-flex">
{*                            <a href="#" class="btn btn-outline-danger d-inline-block" role="button"><i class="fas fa-save"></i>&nbsp; Generuj Przesyłkę</a>&nbsp;*}
                            <a href="#"
                               class="btn btn-outline-danger d-inline-block"
                               role="button"
                               aria-pressed="true" onclick="removeWarehouseDocument('{$document.id}', '{$document.number}', {$keyVal})">
                                <i class="fas fa-times"></i>&nbsp; Usuń</a>
                        </div>
                    </div>
                {/foreach}
            {/if}
        </div>
        {* TODO: Przerobić mechanizm raportowania ilości wysłanych i odebranych tonerów od klienta *}
    </div>

    <hr/>
    <div id="accordion" class="mt-5 mb-3 container">
        {if isset($dane) }
            <div class="card" id="replacePrinterContainer" data-form>

                <input type="hidden" id="serial" value="{$dane[0]['serial']}" data-ref/>
                <input type="hidden" id="newSerial" value="{$agreementSerial}" data-ref/>
                <input type="hidden" id="rowid_agreement" value="{$dane[0]['rowid_agreements']}" data-ref/>
                <input type="hidden" id="umowadane" value="{$dane[0]['umowadane']}"/>

                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn collapsed" data-toggle="collapse" data-target="#collapseOne"
                                aria-expanded="false" aria-controls="collapseOne"
                                onclick="gotoBottom('headingOne')">
                            <i class="fa"
                               aria-hidden="true"></i>&nbsp;Wymiana {if $dane[0]['serial'] != $agreementSerial}Drukarki{else}Formatera{/if}
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="container">
                                <div class="alert alert-success collapse font-weight-bold" role="alert"></div>
                                <div class="alert alert-danger collapse font-weight-bold" role="alert"></div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col">
                                <table class="table bok-two-column-layout">
                                    <tr>
                                        <th class='tdOpis thead-dark' scope="row"><span>C/B Koniec:</span></th>
                                        <td class='tdWartosc'><input class="form-control" id="counterEnd"
                                                                     type="text"
                                                                     data-ref/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class='tdOpis thead-dark'><span>Kolor Koniec:</span></th>
                                        <td class='tdWartosc'><input class="form-control" id="counterColorEnd"
                                                                     type="text" data-ref/></td>
                                    </tr>
                                    <tr>
                                        <th class='tdOpis thead-dark'><span>Skany Koniec:</span></th>
                                        <td class='tdWartosc'><input class="form-control" id="scansEnd"
                                                                     type="text" data-ref/></td>
                                    </tr>
                                    <tr>
                                        <th class='tdOpis thead-dark'><span>Serial (stara)</span></th>
                                        <td class='tdWartosc'><input class="form-control" type="text" disabled
                                                                     value="{$dane[0]['serial']}"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class='tdOpis thead-dark'><span>Data:</span></th>
                                        <td class='tdWartosc'><input class="form-control" id="replacementDate"
                                                                     type="text" data-ref/></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col">
                                <table class="table bok-two-column-layout">
                                    <tr>
                                        <th class='tdOpis'><span>C/B Start:</span></th>
                                        <td class='tdWartosc'>
                                            <input class="form-control" id="counterStart" type="text" data-ref/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class='tdOpis'><span>Kolor Start:</span></th>
                                        <td class='tdWartosc'><input class="form-control" id="counterColorStart"
                                                                     type="text" data-ref/></td>
                                    </tr>
                                    <tr>
                                        <th class='tdOpis'><span>Skany Start:</span></th>
                                        <td class='tdWartosc'><input class="form-control" id="scansStart"
                                                                     type="text" data-ref/></td>
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
                                            <a id="replacePrinter" href="#" class="btn btn-outline-success active"
                                               role="button"
                                               aria-pressed="true"
                                               onclick="callServiceAction('/printers/replacePrinter/notemplate', 'replacePrinterContainer')">
                                                <i class="fas fa-save"></i>&nbsp; Zapisz</a>
                                            <a id="showPrinterService" href="#" class="btn btn-outline-warning"
                                               role="button"
                                               aria-pressed="true" onclick="showPrinterService()">
                                                <i class="fas fa-history"></i>&nbsp;Historia</a>
                                        </td>
                                    </tr>

                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        {/if}
    </div>


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

        $("#replacementDate").focus(function () {
            window.scrollTo(0, 0);
        });

        $("#replacementDate").datetimepicker($.datepicker.regional['pl'], {
            dateFormat: "yy-mm-dd", changeMonth: true, timeFormat: 'HH:mm', stepMinute: 10,
            changeYear: true
        });
        $("#data_planowana").datetimepicker($.datepicker.regional['pl'], {
            dateFormat: "yy-mm-dd", changeMonth: true, timeFormat: 'HH:mm', stepMinute: 10,
            changeYear: true
        });

        const toners = ["black", "cyan", "yellow", "magenta"].map(color => '#trtoner_' + color).join(',');

        const updateTonersVisibility = () => {
            const selectedType = $("#rowid_type").find(":selected").text();
            if (selectedType === "Materiały eksploatacyjne" || selectedType === "Zwrot Materiałów") {
                $(toners).show();
            } else {
                $(toners).hide();
            }
        };

        $("#rowid_type").change(updateTonersVisibility);

        updateTonersVisibility();
    </script>

    <script>

        // const dataContainerId = 'replacePrinterContainer';

        // $("#saveNotification").on('click', () => {
        //        zapiszNoti('0', '$smarty.const.SCIEZKA/notifications/save/notemplate');
        //        return false;
        // });

        // $("#replacePrinter").on('click', () => callServiceAction("/printers/replacePrinter/notemplate", dataContainerId));


        // $("#showPrinterService").on('click', () => {
        //     const dataContainer = getContainerById(dataContainerId);
        //     const agreement = dataContainer.querySelector('#umowadane')?.value;
        //     const rowid_agreement = dataContainer.querySelector('#rowid_agreement')?.value;
        //
        //     $.colorbox
        //     ({
        //         height: 650 + 'px',
        //         width: 1000 + 'px',
        //         title: "Historia serwisu drukarek dla umowy : " + agreement,
        //         data: {
        //             rowid_agreement: rowid_agreement
        //         },
        //         href: sciezka + "/printers/service/todiv",
        //         onClosed: function () {
        //         },
        //         onComplete: function () {
        //             uprawnienia();
        //         }
        //     });
        // });

        $('.selectpicker').selectpicker();

    </script>

