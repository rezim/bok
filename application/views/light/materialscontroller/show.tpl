<div class="container-fluid">

    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-auto">
            <form>
                <div class="border-top mt-4 mb-2 otus-separator"></div>


                <div class="form-group">
                    <label for="txtdataod">data od</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilterdataod' class="form-control" value="2021-01-14"
                           aria-describedby="dateFromHelp" ng-model="date_from" datepicker required>
                    <small id="dateFromHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę
                        początkową.</small>
                </div>

                <div class="form-group">
                    <label for="txtdatado">data do</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilterdatado' class="form-control" value="2022-01-14"
                           aria-describedby="dateToHelp" ng-model="date_to" datepicker required>
                    <small id="dateToHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę
                        końcową.</small>
                </div>

                <div class="border-top my-4 otus-separator"></div>

                <div class="w-100"></div>

                <div class="form-group">
                    <label for="txtklient">klient</label>
                </div>

                <div class="form-group">
                    <input type="text" id="txtklient" class="form-control"
                           aria-describedby="clientHelp" ng-model="search.name">
                    <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj nazwę
                        klienta</small>
                </div>

                <div class="form-group">
                    <label for="txtfilternrumowy">Nr umowy</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilternrumowy' class="form-control"
                           aria-describedby="agreementNbHelp">
                    <small id="agreementNbHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj numer umowy.</small>
                </div>

                <div class="form-group mt-4">
                    <input id="chkReturns" type="checkbox" aria-describedby="returnsHelp">
                    <label for='returnsHelp'>
                        tylko zwroty
                    </label>
                    <small id="returnsHelp" class="form-text text-muted"><i class="fa fa-info-circle"></i> pokaż tylko zwroty materiału</small>
                </div>

                <div class="form-group mt-4">
                    <input id="chkSend" type="checkbox" aria-describedby="sendHelp">
                    <label for='sendHelp'>
                        tylko wysłane
                    </label>
                    <small id="sendHelp" class="form-text text-muted"><i class="fa fa-info-circle"></i> pokaż tylko wysłane</small>
                </div>

                <div class="border-top my-4 otus-separator"></div>

                <div class="form-group">
                    <button class="btn btn-info btn-block" type="submit"
                            onClick="showMaterials();return false;"
                    ">
                    Filtruj
                    </button>
                </div>
            </form>
        </div>

        <main id='divRightCenter' class="col-12 col-md-12 col-xl">

        </main>
    </div>
</div>

<!-- this should be replaced by angular based solution -->
<script type="text/javascript">
    $("#txtfilterdataod").datepicker
    ($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true
    });
    $("#txtfilterdatado").datepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true
    });

    showMaterials();
</script>