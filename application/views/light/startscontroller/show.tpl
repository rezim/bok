<div class="container-xl">
    <div class="row align-items-center">
        {if isset($smarty.session.przypisanemenu['but_addclient'])}
            <div class="col-12 col-lg-2">
                <button type="button" class="btn btn-block btn-outline-primary mt-3 mb-3 otus-action-btn"
                        onclick='showNewClientAdd("0");return false;'><i class="fa fa-plus"></i>&nbsp;Klient
                </button>
            </div>
        {/if}
        {if isset($smarty.session.przypisanemenu['but_addprinter'])}
            <div class="col-12 col-lg-2">
                <button type="button" class="btn btn-block btn-outline-secondary mt-3 mb-3 otus-action-btn"
                        onclick='showNewPrinterAdd("");return false;'><i class="fa fa-plus"></i>&nbsp;Drukarka
                </button>
            </div>
        {/if}
        {if isset($smarty.session.przypisanemenu['but_addagreement'])}
            <div class="col-12 col-lg-2">
                <button type="button" class="btn btn-block btn-outline-success mt-3 mb-3 otus-action-btn"
                        onclick='showNewAgreementAdd("0");return false;'><i class="fa fa-plus"></i>&nbsp;Umowa
                </button>
            </div>
        {/if}
        {if isset($smarty.session.przypisanemenu['but_addtoner'])}
            <div class="col-12 col-lg-2">
                <button type="button" class="btn btn-block btn-outline-danger mt-3 mb-3 otus-action-btn"
                        onclick='showNewTonerAdd("0","");return false;'><i class="fa fa-plus"></i>&nbsp;Toner
                </button>
            </div>
        {/if}
        {if isset($smarty.session.przypisanemenu['but_addcase'])}
            <div class="col-12 col-lg-2">
                <button type="button" class="btn btn-block btn-outline-warning mt-3 mb-3 otus-action-btn"
                        onclick='showNewNotiAdd("0");return false;'><i class="fa fa-plus"></i>&nbsp;Zgłoszenie
                </button>
            </div>
        {/if}
        {if isset($smarty.session.przypisanemenu['but_addcase'])}
            <div class="col-12 col-lg-2"><a class="btn btn-block btn-outline-info mt-3 mb-3 otus-action-btn"
                                href="{$smarty.const.SCIEZKA}/service/show#addNewRequest" role="button"><i
                            class="fa fa-plus"></i>&nbsp;Serwis</a></div>
        {/if}
    </div>
</div>

{*<div class="embed-responsive embed-responsive-16by9">*}
{*    <iframe class="embed-responsive-item" src="https://saldeo.brainshare.pl/login.jsf" allowfullscreen></iframe>*}
{*</div>*}