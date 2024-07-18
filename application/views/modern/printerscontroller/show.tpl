<div class="container-fluid">
    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-auto">
            <form id="dataFilter" data-form>
                {if
                !$czycolorbox &&
                isset($smarty.session.przypisanemenu['but_addprinter']) &&
                $smarty.session.przypisanemenu['but_addprinter']['permission'] === 'rw'
                }
                    <div class="form-group otus-addnew otus-section mt-2 w-100">
                        <button type="button" class="btn btn-success w-100 d-flex align-items-center otus-action-btn"
                                onclick="onAddEditAction(&quot;&quot;);return false;">
                            <i class="fas fa-plus"></i>&nbsp;Nowe Urządzenie
                        </button>
                    </div>
                    <div class="border-top mt-4 mb-2 otus-separator"></div>
                {/if}

                <div class="form-group">
                    <label for="filterserial" class="form-label">Serial</label>
                    <input type="text" id='filterserial' data-ref class="form-control w-100"
                           aria-describedby="serialHelp">
                    <small id="emailHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Numer seryjny
                        urządzenia.</small>
                </div>

                <div class="form-group">
                    <label for="filtermodel" class="form-label">Model</label>
                    <input type="text" id='filtermodel' data-ref class="form-control w-100"
                           aria-describedby="modelHelp">
                    <small id="modelHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj model
                        urządzenia.</small>
                </div>

                <div class="form-group">
                    <label for="filterklient" class="form-label">Klient</label>
                    <input type="text" id='filterklient' data-ref class="form-control w-100"
                           aria-describedby="clientHelp"
                            {if isset($clientnazwakrotka)}
                                value='{$clientnazwakrotka}'
                            {/if}
                    >
                    <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj nazwę
                        klienta.</small>
                </div>

                <div class="form-group">
                    <label for="filterlokalizacja" class="form-label">Lokalizacja</label>
                    <input type="text" id='filterlokalizacja' data-ref class="form-control w-100"
                           aria-describedby="lokalizacjaHelp"
                            {if isset($miasto)}
                                value='{$miasto}'
                            {/if}
                    >
                    <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj
                        lokalizację urządzenia.</small>
                </div>

                <div class="border-top my-4 otus-separator"></div>

                <div class="form-group otus-addnew otus-section mt-2 w-100">
                    <button id="applyFilter" class="btn btn-primary w-100 d-flex align-items-center" type="button">
                        Filtruj
                    </button>
                </div>
            </form>
        </div>

        <main class="col-12 col-md-12 col-xl">
            <div id="listSkeletonLoader">
                {assign var="numbers" value=[1,2,3,4,5,6,7,8,9,10]}
                <p class="placeholder-glow">
                    {foreach from=$numbers item=number}
                        <span class="placeholder bg-quaternary col-12 placeholder-lg placeholder-wave bg-secondary"></span>
                        <span class="placeholder bg-quaternary col-12 placeholder-lg bg-body-highlight"></span>
                        <span class="placeholder bg-quaternary col-12 placeholder-lg placeholder-wave bg-secondary"></span>
                        <span class="placeholder bg-quaternary col-12 placeholder-lg bg-body-highlight"></span>
                    {/foreach}
                </p>
            </div>
            <div id='divRightCenter'></div>
        </main>

    </div>
</div>

<script>
    const dataContainerId = 'dataFilter';
    const templateId = 'divRightCenter';
    const skeletonLoader = 'listSkeletonLoader';

    const renderTemplate = () => renderTemplateAction("/printers/showdane/todiv", dataContainerId, templateId, skeletonLoader);

    $("#applyFilter").on('click', renderTemplate);

    renderTemplate();
    const onAddEditAction = (serial) => {
        const data = {literal}{serial: {/literal}serial{literal}}{/literal}
        renderTemplateWithDataAction("/printers/addedit/todiv", data, templateId, skeletonLoader);
    }

    $("")
</script>
