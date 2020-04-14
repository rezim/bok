<div class="container">
    <div class="row align-items-center">
        {if isset($smarty.session.przypisanemenu['but_addclient'])}
            <div class="col">
                <button type="button" class="btn btn-block btn-outline-primary"
                        onclick='showNewClientAdd("0");return false;'><i class="fa fa-plus"></i>&nbsp;Klient
                </button>
            </div>
        {/if}
        {if isset($smarty.session.przypisanemenu['but_addprinter'])}
            <div class="col">
                <button type="button" class="btn btn-block btn-outline-secondary"
                        onclick='showNewPrinterAdd("");return false;'><i class="fa fa-plus"></i>&nbsp;Drukarka
                </button>
            </div>
        {/if}
        {if isset($smarty.session.przypisanemenu['but_addagreement'])}
            <div class="col">
                <button type="button" class="btn btn-block btn-outline-success"
                        onclick='showNewAgreementAdd("0");return false;'><i class="fa fa-plus"></i>&nbsp;Umowa
                </button>
            </div>
        {/if}
        {if isset($smarty.session.przypisanemenu['but_addtoner'])}
            <div class="col">
                <button type="button" class="btn btn-block btn-outline-danger"
                        onclick='showNewTonerAdd("0","");return false;'><i class="fa fa-plus"></i>&nbsp;Toner
                </button>
            </div>
        {/if}
        {if isset($smarty.session.przypisanemenu['but_addcase'])}
            <div class="col">
                <button type="button" class="btn btn-block btn-outline-warning"
                        onclick='showNewNotiAdd("0");return false;'><i class="fa fa-plus"></i>&nbsp;Zgłoszenie
                </button>
            </div>
        {/if}
        {if isset($smarty.session.przypisanemenu['but_addcase'])}
            <div class="col"><a class="btn btn-block btn-outline-info"
                                href="{$smarty.const.SCIEZKA}/service/show#addNewRequest" role="button"><i
                            class="fa fa-plus"></i>&nbsp;Serwis</a></div>
        {/if}
    </div>
</div>

{*<div class="embed-responsive embed-responsive-16by9">*}
{*    <iframe class="embed-responsive-item" src="https://saldeo.brainshare.pl/login.jsf" allowfullscreen></iframe>*}
{*</div>*}