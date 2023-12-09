<div class="container-fluid reports">
    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-auto">
            <form id="dataFilter" data-form>
                <div class="form-group">
                    <label for="startDate">data od</label>
                </div>
                <div class="form-group">
                    <input data-ref type="text" id='startDate' class="form-control"
                           aria-describedby="dateFromHelp">
                    <small id="dateFromHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę
                        początkową.</small>
                </div>

                <div class="form-group">
                    <label for="endDate">data do</label>
                </div>
                <div class="form-group">
                    <input data-ref type="text" id='endDate' class="form-control"
                           aria-describedby="dateToHelp">
                    <small id="dateToHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę
                        końcową.</small>
                </div>

                <div class="form-group">
                    <label for="endDate">miesiąc</label>
                </div>
                <div class="form-group">
                    <select data-ref id='month' class="form-control" aria-describedby="monthHelp">
                        <option value="" selected></option>
                        {foreach from=$months item=item key=key}
                            <option value="{$rok}-{$key}-01">{$item}</option>
                        {/foreach}
                    </select>
                    <small id="monthHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Wybierz
                        miesiąc.</small>
                </div>

                <div class="border-top my-4 otus-separator"></div>

                <div class="w-100"></div>

                <div class="form-group">
                    <label for="clientName">klient</label>
                </div>
                <div class="form-group">
                    <input data-ref type="text" id='clientName' class="form-control"
                           aria-describedby="clientHelp">
                    <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj nazwę
                        klienta</small>
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
    const startAndEndDate = getStartAndEndDate();

    $("#startDate").datepicker
    ($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true
    }).val($.datepicker.formatDate('yy-mm-dd', startAndEndDate.startDate));
    $("#endDate").datepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true
    }).val($.datepicker.formatDate('yy-mm-dd', startAndEndDate.endDate));

    $("#month").on('change', (event) => {
        const selectedDate = $(event.target).val();
        const startAndEndDate = getStartAndEndDate(selectedDate);
        $("#startDate").val($.datepicker.formatDate('yy-mm-dd', startAndEndDate.startDate));
        $("#endDate").val($.datepicker.formatDate('yy-mm-dd', startAndEndDate.endDate));
    });
</script>

<script>
    const dataContainerId = 'dataFilter';
    const templateId = 'divRightCenter';

    $("#applyFilter").on('click', () => renderTemplateAction("/reports/scansreportdata/todiv", dataContainerId, templateId));
</script>