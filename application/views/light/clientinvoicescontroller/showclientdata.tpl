<div>

    <p>Rozliczenie szczegółowe dla: <b>{$client['nazwakrotka']}</b>, NIP: <b>{$client['nip']}</b></p>
    <p>
        <a class="btn btn-sm btn-outline-primary"
           href="javascript:void(0)"
           onclick="showClientMessages('{$client.nip|escape:'javascript'}', '{$client.nazwakrotka|escape:'javascript'}'); return false;">
            Notatki klienta
        </a>
        <a class="btn btn-sm btn-outline-secondary" data-toggle="collapse" href="#clientDetails" role="button" aria-expanded="false" aria-controls="clientDetails">
            Pokaż dane klienta
        </a>
    </p>
    <div class="collapse" id="clientDetails">
        <table class='table table-sm table-bordered mb-3'>
            <tbody>
            <tr>
                <th style="width: 280px;">Pełny adres klienta</th>
                <td>
                    {if !empty($client['ulica']) || !empty($client['kodpocztowy']) || !empty($client['miasto'])}
                        {$client['ulica']|escape:'html'}{if !empty($client['ulica']) && (!empty($client['kodpocztowy']) || !empty($client['miasto']))}, {/if}{$client['kodpocztowy']|escape:'html'}{if !empty($client['kodpocztowy']) && !empty($client['miasto'])} {/if}{$client['miasto']|escape:'html'}
                    {else}
                        -
                    {/if}
                </td>
            </tr>
            <tr>
                <th>Email faktury</th>
                <td>{if !empty($client['mailfaktury'])}{$client['mailfaktury']|escape:'html'}{else}-{/if}</td>
            </tr>
            <tr>
                <th>Termin płatności</th>
                <td>{if !empty($client['terminplatnosci'])}{$client['terminplatnosci']|escape:'html'} dni{else}-{/if}</td>
            </tr>
            <tr class="table-active">
                <th colspan="2">Osoba odpowiedzialna za płatności</th>
            </tr>
            <tr>
                <th>Imię i nazwisko</th>
                <td>{if !empty($client['fakturyimienazwisko'])}{$client['fakturyimienazwisko']|escape:'html'}{else}-{/if}</td>
            </tr>
            <tr>
                <th>Adres email</th>
                <td>{if !empty($client['fakturyemail'])}{$client['fakturyemail']|escape:'html'}{else}-{/if}</td>
            </tr>
            <tr>
                <th>Telefon komórkowy</th>
                <td>{if !empty($client['fakturykomorka'])}{$client['fakturykomorka']|escape:'html'}{else}-{/if}</td>
            </tr>
            <tr>
                <th>Telefon stacjonarny</th>
                <td>{if !empty($client['fakturytelefon'])}{$client['fakturytelefon']|escape:'html'}{else}-{/if}</td>
            </tr>
            <tr>
                <th>Stanowisko</th>
                <td>{if !empty($client['fakturystanowisko'])}{$client['fakturystanowisko']|escape:'html'}{else}-{/if}</td>
            </tr>
            <tr>
                <th>Uwagi / notatki</th>
                <td>{if !empty($client['fakturyuwagi'])}{$client['fakturyuwagi']|escape:'html'}{else}-{/if}</td>
            </tr>
            </tbody>
        </table>
    </div>
    {if isset($isEmptyMessage)}{$isEmptyMessage}{else}
    <table class='table table-hover table-sm tablesorter'>
        <thead class="thead-dark">
        <tr>
            {foreach $columnNames as $columnName}
                <th>{$columnName}</th>
            {/foreach}
        </tr>
        </thead>
        <tbody>
        <tr class="table-dark text-dark text-b">
            {foreach $columnSummaries as $columnSummary}
                <th><h5><strong>{if $columnSummary != 0}{$columnSummary}{else}-{/if}</strong></h5></th>
            {/foreach}
        </tr>
        {foreach $accountingSettlements as $rowScan}
            <tr{if isset($rowScan[$rowClassName])} class="{$rowScan[$rowClassName]}"{/if}>
                {foreach $columnNames as $key}
                    <td>
                        {if isset($isGroupedView) && $isGroupedView && ($key === 'treść' || $key === 'data płatności' || $key === 'saldo' || $key === 'uwagi')}
                            {$rowScan[$key] nofilter}
                        {else}
                            {$rowScan[$key]}
                        {/if}
                    </td>
                {/foreach}
            </tr>
        {/foreach}
        </tbody>
    </table>
    {/if}
</div>