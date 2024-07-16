<div class="container-fluid">
    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-auto">
            <form>
                {if
                !$czycolorbox &&
                isset($smarty.session.przypisanemenu['but_addclient']['permission']) &&
                $smarty.session.przypisanemenu['but_addclient']['permission'] === 'rw'
                }
                    <div class="form-group otus-addnew otus-section mt-2" style="max-width: 300px;"> <!-- Ustawienie szerokości kontenera -->
                        <button type="button" class="btn btn-success w-100 d-flex align-items-center otus-action-btn"
                                onclick="showNewClientAdd('0');return false;"><i class="fas fa-plus"></i>&nbsp;Nowy
                            Klient
                        </button>
                    </div>
                    <div class="border-top mt-4 mb-2 otus-separator"></div>
                {/if}
                <div class="form-group" style="max-width: 300px;">
                    <label for="txtfilternazwa" class="form-label">Klient</label>
                    <input type="text" id='txtfilternazwa' class="form-control w-100"
                           aria-describedby="nameHelp">
                    <small id="nameHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj nazwę klienta.</small>
                </div>

                <div class="form-group" style="max-width: 300px;">
                    <label for="txtfiltermiasto" class="form-label">Lokalizacja</label>
                    <input type="text" id='txtfiltermiasto' class="form-control w-100"
                           aria-describedby="miastoHelp">
                    <small id="miastoHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj miasto siedziby klienta.</small>
                </div>

                <div class="form-group" style="max-width: 300px;">
                    <label for="txtfilternip" class="form-label">Nip</label>
                    <input type="text" id='txtfilternip' class='form-control w-100'
                           aria-describedby="nipHelp">
                    <small id="nipHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj NIP klienta.</small>
                </div>

                <div class="form-group" style="max-width: 300px;">
                    <label for="txtfilterserial" class="form-label">Serial</label>
                    <input type="text" id='txtfilterserial' class='form-control w-100'
                           aria-describedby="serialHelp"
                            {if isset($serial)}
                        value='{$serial}'
                            {/if}>
                    <small id="serialHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj serial urządzenia klienta.</small>
                </div>

                <div class="border-top my-4 otus-separator"></div>

                <div class="form-group otus-addnew otus-section mt-2" style="max-width: 300px;">
                    <button class="btn btn-primary w-100 d-flex align-items-center" type="submit"
                            onClick="showClients('{$czycolorbox}');return false;">
                        Filtruj
                    </button>
                </div>

                <div class="form-group otus-addnew otus-section mt-2" style="max-width: 300px;">
                    <button class="btn btn-success w-100 d-flex align-items-center" type="submit"
                            onClick="showListOfClientInvoiceEmails();return false;">
                        Lista Adresów Email
                    </button>
                </div>
            </form>
        </div>

        <main id='divRightCenter{$czycolorbox}' class="col-12 col-md-12 col-xl">
        </main>
    </div>
</div>

<script type="text/javascript">
    $('#txtfilternazwa').unbind("keypress");
    $('#txtfilternazwa').keypress(function(event) {
        if (event.keyCode == 13) {
            showClients('{$czycolorbox}');return false;
        }
    });
    $('#txtfilternip').unbind("keypress");
    $('#txtfilternip').keypress(function(event) {
        if (event.keyCode == 13) {
            showClients('{$czycolorbox}');return false;
        }
    });
    $('#txtfiltermiasto').unbind("keypress");
    $('#txtfiltermiasto').keypress(function(event) {
        if (event.keyCode == 13) {
            showClients('{$czycolorbox}');return false;
        }
    });

    showClients('{$czycolorbox}');
</script>
