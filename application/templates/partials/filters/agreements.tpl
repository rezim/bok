{include file="../filters-button.tpl"}

<div class="otus-filters-panel p-4">
    {include file="../close-button.tpl"}
    <form>
        {if
        !$czycolorbox &&
        isset($smarty.session.przypisanemenu['but_addagreement']['permission']) &&
        $smarty.session.przypisanemenu['but_addagreement']['permission'] === 'rw'
        }
            <div class="form-group otus-addnew otus-section">
                <button type="button" class="btn btn-block btn-outline-success otus-action-btn"
                        onclick="showNewAgreementAdd('0');return false;"><i class="fas fa-plus"></i>&nbsp;Nowa
                    Umowa
                </button>
            </div>
            <div class="border-top mt-4 mb-2 otus-separator"></div>
        {/if}
        <div class="form-group">
            <label for="txtfilternrumowy{$czycolorbox}">Nr umowy</label>
        </div>
        <div class="form-group">
            <input type="text" id='txtfilternrumowy{$czycolorbox}' class="form-control"
                   aria-describedby="agreementNbHelp">
            <small id="agreementNbHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj numer
                umowy.</small>
        </div>

        <div class="form-group">
            <label for="txtfilterserial{$czycolorbox}">Serial</label>
        </div>
        <div class="form-group">
            <input type="text" id='txtfilterserial{$czycolorbox}' class="form-control"
                   aria-describedby="serialHelp" {if isset($serial)} value='{$serial}'{/if}>
            <small id="serialHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj numer seryjny
                urządzenia.</small>
        </div>

        <div class="form-group">
            <label for="txtfilternazwaklienta{$czycolorbox}">Klient</label>
        </div>
        <div class="form-group">
            <input type="text" id='txtfilternazwaklienta{$czycolorbox}' class='form-control'
                   aria-describedby="clientHelp"
                    {if isset($clientnazwakrotka)} value='{$clientnazwakrotka}' {/if}>
            <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj nazwę klienta.</small>
        </div>

        {assign var="defaultStatus" value=""}
        {if $canListActive}
            {assign var="defaultStatus" value=1}
        {elseif $canListDraft}
            {assign var="defaultStatus" value=-1}
        {elseif $canListClosed}
            {assign var="defaultStatus" value=0}
        {/if}

        <div class="mb-3">
            <div class="form-group">
                <label for="status-filters">Typ umowy</label>
            </div>
            <div id="status-filters">
                {if $canListActive}
                    <span class="badge badge-status badge-aktywna {if $defaultStatus == 1}selected{/if}" data-value="1">aktywna</span>
                {/if}
                {if $canListDraft}
                    <span class="badge badge-status badge-robocza {if $defaultStatus == -1}selected{/if}"
                          data-value="-1">robocza</span>
                {/if}
                {if $canListClosed}
                    <span class="badge badge-status badge-zamknieta {if $defaultStatus == 0}selected{/if}"
                          data-value="0">zamknięta</span>
                {/if}
            </div>
            <small id="closedAgreementsHelp" class="form-text text-muted">
                <i class="fas fa-info-circle"></i> Wybierz typ umowy.
            </small>
            <input type="hidden" name="statusy" id="selectedStatuses" value="{$defaultStatus}">
        </div>

        <div class="border-top my-4 otus-separator"></div>

        <div class="form-group">
            <button class="btn btn-info btn-block" type="submit"
                    onClick="showAgreements('{$czycolorbox}');return false;">
                Filtruj
            </button>
        </div>
    </form>
</div>