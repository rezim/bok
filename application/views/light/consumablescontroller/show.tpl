<div class="container-fluid">

    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-auto">
            <form>
                <div class="form-group otus-addnew otus-section">
                    <button type="button" class="btn btn-block btn-outline-danger otus-action-btn"
                            onclick='showNewConsumablesAdd("0","");return false;'><i class="fas fa-plus"></i>&nbsp;Nowy Materiał Eksploatacyjny
                    </button>
                </div>
                <div class="border-top mt-4 mb-2 otus-separator"></div>

                <div class="form-group">
                    <label for="txtfiltername">Nazwa Materiału</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfiltername' class="form-control"
                           aria-describedby="serialHelp">
                    <small id="serialHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj nazwę materiału.</small>
                </div>

                <div class="form-group">
                    <label for="txtfiltermodel">Model Drukarki</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfiltermodel' class="form-control"
                           aria-describedby="serialHelp">
                    <small id="serialHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj model drukarki.</small>
                </div>

                <div class="border-top my-4 otus-separator"></div>

                <div class="form-group">
                    <button class="btn btn-info btn-block" type="submit"
                            onClick='showConsumables();return false;'>
                        Filtruj
                    </button>
                </div>
            </form>
        </div>

        <main id='divRightCenter' class="col-12 col-md-12 col-xl">

        </main>
    </div>
</div>

<script type="text/javascript">
    $('#txtfilterserial').unbind("keypress");
    $('#txtfilterserial').keypress(function(event) {
        if (event.keyCode == 13) {
            showConsumables();return false;
        }
    });

    showConsumables();
</script>