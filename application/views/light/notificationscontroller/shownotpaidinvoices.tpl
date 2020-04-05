{if $invoices|@count gt 0}
    <div class="notpaid-invoices-alert">
        <div><i class="fa fa-exclamation-triangle" style="color: red"></i> Klient ma niezapłacone faktury</div>
        {foreach from=$invoices item=item key=key}
            <div class="invoice-row">
                <span>FV numer:</span><span><b>{$item.number}</b></span>
                <span>opóźnienie (dni):</span><span><b>{$item.late_days}</b></span>
            </div>
        {/foreach}
    </div>
{/if}
