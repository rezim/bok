<div class="container-fluid">

    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-auto">
            <form>
                <div class="form-group otus-addnew otus-section">
                    <button type="button" class="btn btn-block btn-outline-danger otus-action-btn"
                            onclick='showNewTonerAdd("0","");return false;'><i class="fas fa-plus"></i>&nbsp;Nowy Toner
                    </button>
                </div>
                <div class="border-top mt-4 mb-2 otus-separator"></div>

                <div class="form-group">
                    <label for="txtfilterserial">Serial Drukarki</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilterdrukarka' class="form-control"
                           aria-describedby="serialHelp">
                    <small id="serialHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj numer seryjny drukarki.</small>
                </div>

                <div class="form-group">
                    <label for="txtfilterserial">Serial Tonera</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilterserial' class="form-control"
                           aria-describedby="serialHelp">
                    <small id="serialHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj numer seryjny tonera.</small>
                </div>

                <div class="form-group mt-4">
                    <input name='txttonerzakonczone' type="checkbox" id='txttonerzakonczone' aria-describedby="txttonerHelp">
                    <label for='txttonerHelp'>
                        zakończone
                    </label>
                    <small id="txttonerHelp" class="form-text text-muted"><i class="fa fa-info-circle"></i> Pokaż zakończone </small>
                </div>

                <div class="border-top my-4 otus-separator"></div>

                <div class="form-group">
                    <button class="btn btn-info btn-block" type="submit"
                            onClick='pokazTonery();return false;'>
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
            pokazTonery();return false;
        }
    });

    pokazTonery();
</script>