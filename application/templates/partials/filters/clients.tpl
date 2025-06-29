{include file="../filters-button.tpl"}
<div class="otus-filters-panel p-4">
    {include file="../close-button.tpl"}
    <form>
        {if
        !$czycolorbox &&
        isset($smarty.session.przypisanemenu['but_addclient']['permission']) &&
        $smarty.session.przypisanemenu['but_addclient']['permission'] === 'rw'
        }
            <div class="form-group otus-addnew otus-section">
                <button type="button" class="btn btn-block btn-outline-primary otus-action-btn"
                        onclick="showNewClientAdd('0');return false;"><i class="fas fa-plus"></i>&nbsp;Nowy
                    Klient
                </button>
            </div>
            <div class="border-top mt-4 mb-2 otus-separator"></div>
        {/if}
        <div class="form-group">
            <label for="txtfilternazwa">Nazwa</label>
        </div>
        <div class="form-group">
            <input type="text" id='txtfilternazwa' class="form-control"
                   aria-describedby="nameHelp">
            <small id="nameHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj nazwę klienta.</small>
        </div>

        <div class="form-group">
            <label for="txtfiltermiasto">Miasto</label>
        </div>
        <div class="form-group">
            <input type="text" id='txtfiltermiasto' class="form-control"
                   aria-describedby="miastoHelp">
            <small id="miastoHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj miasto siedziby klienta.</small>
        </div>

        <div class="form-group">
            <label for="txtfilternip">Nip</label>
        </div>
        <div class="form-group">
            <input type="text" id='txtfilternip' class='form-control'
                   aria-describedby="nipHelp">
            <small id="nipHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj NIP klienta.</small>
        </div>

        <div class="form-group">
            <label for="txtfilterserial">Serial</label>
        </div>
        <div class="form-group">
            <input type="text" id='txtfilterserial' class='form-control'
                   aria-describedby="serialHelp"
                    {if isset($serial)}
                value='{$serial}'
                    {/if}>
            <small id="serialHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj serial urządzenia klienta.</small>
        </div>

        <div class="border-top my-4 otus-separator"></div>

        <div class="form-group">
            <button class="btn btn-info btn-block" type="submit"
                    onClick="showClients('{$czycolorbox}');return false;"">
            Filtruj
            </button>
        </div>

        <div class="form-group">
            <button class="btn btn-success btn-block" type="submit"
                    onClick="showListOfClientInvoiceEmails();return false;"">
            Pokaż Listę Adresów Email
            </button>
        </div>

    </form>
</div>