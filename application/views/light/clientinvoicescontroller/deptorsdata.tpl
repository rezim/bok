<div class="table-responsive-sm">
    <table class="table table-sm table-hover table-sm tablesorter" id="tableDeptors">
        <thead class="thead-light">
        <tr>
            <th>Klient</th>
            <th>Kontakt</th>
            <th class="text-center">Faktury</th>
            <th class="text-right">Kwota</th>
            <th>Najstarsza</th>
            <th></th>
        </tr>
        </thead>

        <tbody>
        {foreach $clients as $c}
            {* ROW: client summary *}
            <tr class="js-acc-header align-middle" data-client-id="{$c.client_id|escape}">
                <td>
                    <div class="font-weight-bold">
                        {$c.client_name|escape}
                    </div>
                </td>

                <td>
                    {if $c.client_phone}
                        <div class="text-muted small">
                            <i class="fas fa-phone-alt mr-1"></i>{$c.client_phone|escape}
                        </div>
                    {else}
                        <span class="text-muted">–</span>
                    {/if}
                </td>

                <td class="text-center font-weight-bold">
                    {$c.unpaid_count}
                </td>

                <td class="text-right font-weight-bold"  data-value="{$c.unpaid_sum}">
                    {$c.unpaid_sum|number_format:2:".":" "} {$c.currency|escape}
                </td>

                <td>
        <span class="badge badge-outline-secondary">
            {$c.oldest_due_date|default:"-"|escape}
        </span>
                </td>

                <td class="text-right">
                    <a href="#" class="js-acc-toggle text-decoration-none"
                       data-client-id="{$c.client_id|escape}"
                       title="Pokaż faktury">
                        <i class="fas fa-chevron-down"></i>
                    </a>
                </td>
            </tr>
            {* ROW: details (hidden by default) *}
            <tr class="js-acc-body bg-light" data-client-id="{$c.client_id|escape}" style="display:none;">
                <td colspan="6" class="p-3">

                    <div class="card shadow-sm">
                        <div class="card-body p-2">

                            <table class="table table-sm mb-0">
                                <thead>
                                <tr class="text-muted small">
                                    <th>Nr</th>
                                    <th>Wystawiona</th>
                                    <th>Termin</th>
                                    <th>Status</th>
                                    <th class="text-right">Kwota</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                {foreach $c.invoices as $inv}
                                    <tr>
                                        <td>{$inv.number|default:"-"|escape}</td>
                                        <td>{$inv.issue_date|default:"-"|escape}</td>
                                        <td>{$inv.due_date|default:"-"|escape}</td>

                                        <td>
                                            <span class="invoice-status-line">
                                                <span class="invoice-status-dot invoice-status-dot--{$inv.payment_status_type|escape}"></span>
                                                {$inv.payment_status|escape}
                                            </span>
                                        </td>

                                        <td class="text-right font-weight-bold">
                                            {assign var=amount value=$inv.amount_due|default:$inv.remaining|default:0}
                                            {$amount|number_format:2:",":" "} {$inv.currency|default:$c.currency|escape}
                                        </td>

                                        <td class="text-right">
                                            {if $inv.id}
                                                {* Wezwanie do zapłaty (PDF) *}
                                                <a href="{$FAKTUROWNIA_ENDPOINT|escape}/invoices/{$inv.id|escape}/demand_for_payment?api_token={$FAKTUROWNIA_APITOKEN|escape}"
                                                   target="_blank"
                                                   class="text-warning mr-2 cursor-pointer demand-for-payment"
                                                   title="Drukuj wezwanie do zapłaty">
                                                    <i class="far fa-flag"></i>
                                                </a>

                                                {* Duplikat faktury (PDF) *}
                                                <a data-url="{$FAKTUROWNIA_ENDPOINT|escape}/invoices/{$inv.id|escape}.pdf?print_option=duplicate&api_token={$FAKTUROWNIA_APITOKEN|escape}"
                                                   target="_blank"
                                                   class="text-secondary mr-2 cursor-pointer duplicate-invoice"
                                                   title="Pobierz duplikat faktury (PDF)">
                                                    <i class="far fa-copy"></i>
                                                </a>

                                                {* Podgląd faktury *}
                                                {if $inv.view_url}
                                                    <a href="{$inv.view_url|escape}"
                                                       target="_blank"
                                                       class="text-success"
                                                       title="Podgląd faktury">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
                                                {/if}

                                            {/if}
                                        </td>
                                    </tr>
                                {/foreach}
                                </tbody>
                            </table>

                        </div>
                    </div>

                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>

</div>
