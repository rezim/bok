<div class="container-fluid">
    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-auto">
            <form>
                <div class="form-group otus-addnew otus-section">
                    <button type="button" class="btn btn-block btn-outline-success otus-action-btn"
                            onclick="showNewAgreementAdd(" 0
                    ");return false;"><i class="fa fa-plus"></i>&nbsp;Nowa
                    Umowa
                    </button>
                </div>
                <div class="border-top my-4 otus-separator"></div>
                <div class="form-group">
                    <label for="txtfilternrumowy">Nr umowy</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilternrumowy' class="form-control"
                           aria-describedby="agreementNbHelp">
                    <small id="agreementNbHelp" class="form-text text-muted">Podaj numer umowy.</small>
                </div>

                <div class="form-group">
                    <label for="txtfilterserial">Serial</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilterserial' class="form-control"
                           aria-describedby="serialHelp" {if isset($serial)} value='{$serial}'{/if}>
                    <small id="serialHelp" class="form-text text-muted">Podaj numer seryjny urządzenia.</small>
                </div>

                <div class="form-group">
                    <label for="txtfilternazwaklienta">Klient</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilternazwaklienta' class='form-control' aria-describedby="clientHelp"
                            {if isset($clientnazwakrotka)} value='{$clientnazwakrotka}' {/if}>
                    <small id="clientHelp" class="form-text text-muted">Podaj nazwę klienta.</small>
                </div>

                <div class="form-group mt-4">
                    <label for="checkPokazZakonczone">Zakończone</label>
                    <input type="checkbox" id='checkPokazZakonczone' aria-describedby="closedAgreements" />
                    <small id="closedAgreementsHelp" class="form-text text-muted">Pokaż zakończone umowy.</small>
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

        <main id='divRightCenter' class="col-12 col-md-12 col-xl">

        </main>
    </div>
</div>

<script type="text/javascript">
    $('#txtfilternrumowy').unbind("keypress");
    $('#txtfilternrumowy').keypress(function (event) {
        if (event.keyCode == 13) {
            showAgreements('{$czycolorbox}');
            return false;
        }
    });
    $('#txtfilterserial').unbind("keypress");
    $('#txtfilterserial').keypress(function (event) {
        if (event.keyCode == 13) {
            showAgreements('{$czycolorbox}');
            return false;
        }
    });
    $('#txtfilternazwaklienta').unbind("keypress");
    $('#txtfilternazwaklienta').keypress(function (event) {
        if (event.keyCode == 13) {
            showAgreements('{$czycolorbox}');
            return false;
        }
    });
    showAgreements('{$czycolorbox}');
</script>