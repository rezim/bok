<div class="container mt-3">

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
                test
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
</div>