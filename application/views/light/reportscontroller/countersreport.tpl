<div class="container-fluid reports">
    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-auto">
            <form id="dataFilter" data-form>
                <div class="form-group">
                    <label for="clientName">ilość dni bez licznika</label>
                </div>
                <div class="form-group">
                    <input data-ref type="text" id='days' class="form-control"
                           aria-describedby="clientHelp" value="{$days}">
                    <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj ilość dni</small>
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
    const dataContainerId = 'dataFilter';
    const templateId = 'divRightCenter';

    $("#applyFilter").on('click', () => renderTemplateAction("/reports/countersreportdata/todiv", dataContainerId, templateId));
</script>