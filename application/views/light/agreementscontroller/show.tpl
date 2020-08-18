<div class="container-fluid">
    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-auto">
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
                    <small id="agreementNbHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj numer umowy.</small>
                </div>

                <div class="form-group">
                    <label for="txtfilterserial{$czycolorbox}">Serial</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilterserial{$czycolorbox}' class="form-control"
                           aria-describedby="serialHelp" {if isset($serial)} value='{$serial}'{/if}>
                    <small id="serialHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj numer seryjny urządzenia.</small>
                </div>

                <div class="form-group">
                    <label for="txtfilternazwaklienta{$czycolorbox}">Klient</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilternazwaklienta{$czycolorbox}' class='form-control' aria-describedby="clientHelp"
                            {if isset($clientnazwakrotka)} value='{$clientnazwakrotka}' {/if}>
                    <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj nazwę klienta.</small>
                </div>

                <div class="form-group mt-4">
                    <input type="checkbox" id='checkPokazZakonczone{$czycolorbox}' aria-describedby="closedAgreements" />
                    <label for="checkPokazZakonczone{$czycolorbox}">Zakończone</label>
                    <small id="closedAgreementsHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Pokaż zakończone umowy.</small>
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

        <main id='divRightCenter{$czycolorbox}' class="col-12 col-md-12 col-xl">

        </main>
    </div>
</div>

<script type="text/javascript">
    $('#txtfilternrumowy{$czycolorbox}').unbind("keypress");
    $('#txtfilternrumowy{$czycolorbox}').keypress(function (event) {
        if (event.keyCode == 13) {
            showAgreements('{$czycolorbox}');
            return false;
        }
    });
    $('#txtfilterserial{$czycolorbox}').unbind("keypress");
    $('#txtfilterserial{$czycolorbox}').keypress(function (event) {
        if (event.keyCode == 13) {
            showAgreements('{$czycolorbox}');
            return false;
        }
    });
    $('#txtfilternazwaklienta{$czycolorbox}').unbind("keypress");
    $('#txtfilternazwaklienta{$czycolorbox}').keypress(function (event) {
        if (event.keyCode == 13) {
            showAgreements('{$czycolorbox}');
            return false;
        }
    });
    showAgreements('{$czycolorbox}');
</script>