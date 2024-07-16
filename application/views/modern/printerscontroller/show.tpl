<div class="container-fluid">
    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-auto">
            <form>
                {if
                !$czycolorbox &&
                isset($smarty.session.przypisanemenu['but_addprinter']) &&
                $smarty.session.przypisanemenu['but_addprinter']['permission'] === 'rw'
                }
                    <div class="form-group otus-addnew otus-section mt-2 w-100">
                        <button type="button" class="btn btn-success w-100 d-flex align-items-center otus-action-btn"
                                onclick="showNewPrinterAdd(&quot;&quot;);return false;">
                            <i class="fas fa-plus"></i>&nbsp;Nowe Urządzenie
                        </button>
                    </div>
                    <div class="border-top mt-4 mb-2 otus-separator"></div>
                {/if}

                <div class="form-group">
                    <label for="txtfilterserial" class="form-label">Serial</label>
                    <input type="text" id='txtfilterserial{$czycolorbox}' class="form-control w-100"
                           aria-describedby="serialHelp">
                    <small id="emailHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Numer seryjny urządzenia.</small>
                </div>

                <div class="form-group">
                    <label for="txtfiltermodel" class="form-label">Model</label>
                    <input type="text" id='txtfiltermodel{$czycolorbox}' class="form-control w-100"
                           aria-describedby="modelHelp">
                    <small id="modelHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj model urządzenia.</small>
                </div>

                <div class="form-group">
                    <label for="txtfilterklient" class="form-label">Klient</label>
                    <input type="text" id='txtfilterklient{$czycolorbox}' class="form-control w-100"
                           aria-describedby="clientHelp"
                            {if isset($clientnazwakrotka)}
                                value='{$clientnazwakrotka}'
                            {/if}
                    >
                    <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj nazwę klienta.</small>
                </div>

                <div class="form-group">
                    <label for="txtfilterlokalizacja" class="form-label">Lokalizacja</label>
                    <input type="text" id='txtfilterlokalizacja{$czycolorbox}' class="form-control w-100"
                           aria-describedby="lokalizacjaHelp"
                            {if isset($miasto)}
                                value='{$miasto}'
                            {/if}
                    >
                    <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj lokalizację urządzenia.</small>
                </div>

                <div class="border-top my-4 otus-separator"></div>

                <div class="form-group otus-addnew otus-section mt-2 w-100">
                    <button class="btn btn-primary w-100 d-flex align-items-center" type="submit"
                            onClick="showPrinters('{$czycolorbox}');return false;">
                        Filtruj
                    </button>
                </div>
            </form>
        </div>

        <main id='divRightCenter{$czycolorbox}' class="col-12 col-md-12 col-xl">
        </main>
    </div>
</div>
<script type="text/javascript">
    $('#txtfilterserial{$czycolorbox}').unbind("keypress");
    $('#txtfilterserial{$czycolorbox}').keypress(function (event) {
        if (event.keyCode == 13) {
            showPrinters('{$czycolorbox}');
            return false;
        }
    });
    $('#txtfiltermodel{$czycolorbox}').unbind("keypress");
    $('#txtfiltermodel{$czycolorbox}').keypress(function (event) {
        if (event.keyCode == 13) {
            showPrinters('{$czycolorbox}');
            return false;
        }
    });
    $('#txtfilterklient{$czycolorbox}').unbind("keypress");
    $('#txtfilterklient{$czycolorbox}').keypress(function (event) {
        if (event.keyCode == 13) {
            showPrinters('{$czycolorbox}');
            return false;
        }
    });

    showPrinters('{$czycolorbox}');
</script>
