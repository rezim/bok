<div class="container-fluid reports">
    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-auto">
            <form id="dataFilter" data-form>
                <div class="form-group">
                    <label for="upperDateLimit">Data do (domyślnie dzisiaj - 3 dni)</label>
                </div>
                <div class="form-group">
                    <input data-ref type="text" id='upperDateLimit' class="form-control"
                           aria-describedby="dateFromHelp">
                    <small id="dateFromHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę
                        graniczną dla liczników.</small>
                </div>

                <div class="form-group">
                    <label for="serial">drukarka</label>
                </div>
                <div class="form-group">
                    <input data-ref type="text" id='serial' class="form-control"
                           aria-describedby="deviceHelp">
                    <small id="deviceHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj serial
                        urządzenia</small>
                </div>

                <div class="border-top my-4 otus-separator"></div>

                <div class="form-group">
                    <button id="applyFilter" class="btn btn-info btn-block" type="button">
                    Filtruj
                    </button>
                </div>
            </form>
        </div>

        <main id='divRightCenter' class="col-12 col-md-12 col-xl">

        </main>
    </div>
</div>
<script>
    const today = new Date();
    today.setDate(today.getDate() - 3);

    $("#upperDateLimit").datepicker
    ($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true
    }).val($.datepicker.formatDate('yy-mm-dd', today));
</script>
<script>
    const dataContainerId = 'dataFilter';
    const templateId = 'divRightCenter';
    const applyFilters = () => renderTemplateAction("/reports/countersreportdata/todiv", dataContainerId, templateId);
    const sendEmail = (email, serial) => {
        callServiceWithDataAction("/reports/sendmail/notemplate", { email, serial }, null, applyFilters, (err) => alert(err) );
    }


    $("#applyFilter").on('click', applyFilters);

    applyFilters();
</script>