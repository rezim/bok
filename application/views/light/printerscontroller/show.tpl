<div class="container-fluid">

    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-2">
            <form>
                <div class="form-group otus-addnew otus-section">
                    <button type="button" class="btn btn-block btn-outline-secondary otus-action-btn"
                            onclick="showNewPrinterAdd(&quot;&quot;);return false;"><i class="fa fa-plus"></i>&nbsp;Nowe
                        Urządzenie
                    </button>
                </div>
                <div class="border-top my-4 otus-separator"></div>
                <div class="form-group">
                    <label for="txtfilterserial{$czycolorbox}">Serial</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilterserial{$czycolorbox}' class="form-control"
                           aria-describedby="serialHelp">
                    <small id="emailHelp" class="form-text text-muted">Podaj numer seryjny urządzenia.</small>
                </div>

                <div class="form-group">
                    <label for="txtfiltermodel{$czycolorbox}">Model</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfiltermodel{$czycolorbox}' class="form-control"
                           aria-describedby="modelHelp">
                    <small id="modelHelp" class="form-text text-muted">Podaj model urządzenia.</small>
                </div>

                <div class="form-group">
                    <label for="txtfilterklient{$czycolorbox}">Klient</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilterklient{$czycolorbox}' class='form-control'
                           aria-describedby="clientHelp"
                            {if isset($clientnazwakrotka)}
                                value='{$clientnazwakrotka}'
                            {/if}
                    >
                    <small id="clientHelp" class="form-text text-muted">Podaj model urządzenia.</small>
                </div>

                <div class="border-top my-4 otus-separator"></div>

                <div class="form-group">
                    <button class="btn btn-info btn-block" type="submit"
                            onClick="showPrinters('divRightCenter{$czycolorbox},'{$czycolorbox}');return false;">
                        Filtruj
                    </button>
                </div>
            </form>
        </div>

        <main id='divRightCenter{$czycolorbox}' class="col-12 col-md-12 col-xl-10">

        </main>
    </div>
</div>
<script type="text/javascript">
    $('#txtfilterserial{$czycolorbox}').unbind("keypress");
    $('#txtfilterserial{$czycolorbox}').keypress(function (event) {
        if (event.keyCode == 13) {
            showPrinters('divRightCenter{$czycolorbox}', '{$czycolorbox}');
            return false;
        }
    });
    $('#txtfiltermodel{$czycolorbox}').unbind("keypress");
    $('#txtfiltermodel{$czycolorbox}').keypress(function (event) {
        if (event.keyCode == 13) {
            showPrinters('divRightCenter{$czycolorbox}', '{$czycolorbox}');
            return false;
        }
    });
    $('#txtfilterklient{$czycolorbox}').unbind("keypress");
    $('#txtfilterklient{$czycolorbox}').keypress(function (event) {
        if (event.keyCode == 13) {
            showPrinters('divRightCenter{$czycolorbox}', '{$czycolorbox}');
            return false;
        }
    });

    showPrinters('divRightCenter{$czycolorbox}', '{$czycolorbox}');
</script>