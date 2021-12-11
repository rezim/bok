<div class="container-fluid">

    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-auto">
            <form>
                <div class="form-group">
                <label for="txtfilterdataod">Data od</label>
                </div>
                <div class="form-group">
                <input type="text" id='txtfilterdataod' class="form-control" aria-describedby="modelHelp">
                    <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę początkową.</small>
                </div>
                <div class="form-group">
                <label for="txtfilterdatado">Data do</label>
                </div>
                <div class="form-group">
                <input type="text" id='txtfilterdatado' class="form-control" aria-describedby="modelHelp">
                    <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę końcową.</small>
                </div>

                <div class="border-top my-4 otus-separator"></div>


                <div class="form-group mt-4">
                    <input name='checkStatus' type="checkbox" id='checkStatus' checked aria-describedby="checkStatusHelp">
                    <label for='checkStatus'>
                        pokaż w trakcie
                    </label>
                    <small id="checkStatusHelp" class="form-text text-muted"><i class="fa fa-info-circle"></i> Pokaż zlecenie w trakcie realizacji </small>
                </div>

                <div class="border-top my-4 otus-separator"></div>

                <div class="form-group">
                    <button class="btn btn-info btn-block" type="submit"
                            onClick="showStatistics();return false;">
                        Filtruj
                    </button>
                </div>

            </form>
        </div>

        <main id='divRightCenter' class="col-12 col-md-12 col-xl">

        </main>

    </div>
    <script type="text/javascript">
        $('#txtfilterdataod').unbind("keypress");
        $('#txtfilterdataod').keypress(function (event) {
            if (event.keyCode == 13) {
                showStatistics();
                return false;
            }
        });
        $('#txtfilterdatado').unbind("keypress");
        $('#txtfilterdatado').keypress(function (event) {
            if (event.keyCode == 13) {
                showStatistics();
                return false;
            }
        });
        $("#txtfilterdataod").datepicker($.datepicker.regional['pl'], {
            dateFormat: "yy-mm-dd", changeMonth: true,
            changeYear: true,
        });
        $("#txtfilterdatado").datepicker($.datepicker.regional['pl'], {
            dateFormat: "yy-mm-dd", changeMonth: true,
            changeYear: true,
        });

        showStatistics();
    </script>