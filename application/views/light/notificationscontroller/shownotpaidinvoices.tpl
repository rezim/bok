{if $invoices|@count gt 0}
    <div class="notpaid-invoices-alert">
        <div><i class="fa fa-exclamation-triangle" style="color: red"></i> Klient ma niezapłacone faktury</div>
        {foreach from=$invoices item=item key=key}
            <div class="invoice-row">
                <span>FV numer:</span><span>&nbsp;<b>{$item.number}</b>&nbsp;</span>
                <span>data płatności:</span>&nbsp;<span><b>{$item.payment_to}</b>&nbsp;</span>
                <span>opóźnienie (dni):</span><span>&nbsp;<b>{$item.late_days}</b>&nbsp;</span>
            </div>
        {/foreach}
    </div>
{/if}
