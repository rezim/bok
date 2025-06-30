{include file="../filters-button.tpl"}

<div class="otus-filters-panel p-4">
    {include file="../close-button.tpl"}
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