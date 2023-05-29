<div id="configModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Konfiguracja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container mt-3">
                    <div class="container">
                        <div class="alert alert-success collapse font-weight-bold" role="alert"></div>
                        <div class="alert alert-danger collapse font-weight-bold" role="alert"></div>
                    </div>
                    <div class="container">

                        <div class="row align-items-start">
                            <div class="col">
                                Czas trwania sesji w minutach
                            </div>
                            <div class="col">
                                <input class="form-control form-control-md" data-ref type="text" id='czassesjiminut'
                                       value="{$configuration[0].czas_sesji_minut|escape:'htmlall'}" autofocus/>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col">
                                <small  class="form-text text-muted"><i class="fas fa-info-circle"></i> Czas
                                    po którym nastąpi automatyczne wylogowanie</small>
                            </div>
                        </div>
                        <div class="border-top my-4 otus-separator"></div>
                        <div class="row align-items-start">
                            <div class="col">
                                Stawka kilometrowa
                            </div>
                            <div class="col">
                                <input class="form-control form-control-md" data-ref type="text" id='stawkakilometrowa'
                                       value="{$configuration[0].stawka_kilometrowa|escape:'htmlall'}" autofocus/>
                            </div>
                        </div>
                        <div class="row align-items-start">
                            <div class="col">
                                Stawka godzinowa
                            </div>
                            <div class="col">
                                <input id="stawkagodzinowa"
                                       class="form-control form-control-md" data-ref type="text"
                                       value="{$configuration[0].stawka_godzinowa|escape:'htmlall'}"
                                />
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col">
                                <small  class="form-text text-muted"><i class="fas fa-info-circle"></i> Wartości używane w kalkulacji kosztów obsługi klienta.</small>
                            </div>
                        </div>
                        <div class="border-top my-4 otus-separator"></div>
                        <div class="row align-items-start">
                            <div class="col">
                                Wyczyść monitoring płatności
                            </div>
                            <div class="col">
                                <a href="#" class="btn btn-outline-light active" role="button" aria-pressed="true"
                                   onmousedown='clearPaymentMonitoring();return false;'><i
                                            class="fas fa-user-slash"></i>&nbsp; wyczyść</a>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col">
                                <small  class="form-text text-muted"><i class="fas fa-info-circle"></i> Wyczyść monitoring płatności w kartach klientów dla operatora.</small>
                            </div>
                        </div>
                        <div class="border-top my-4 otus-separator"></div>
                        <div class="row align-items-start">
                            <div class="col">
                                Mail raportu płatności.
                            </div>
                            <div class="col">
                                <input class="form-control form-control-md" data-ref type="text" id='emailraportuplatnosci'
                                       value="{$configuration[0].email_raportu_platnosci|escape:'htmlall'}" />
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col">
                                <small  class="form-text text-muted"><i class="fas fa-info-circle"></i> Mail na który zostanie wysłany raport płatności za poprzedni miesiąc
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" onclick="callServiceAction('/config/saveconfiguration/notemplate', 'configModal')"
                        class="btn btn-outline-success active"><i class="fas fa-save"></i> Zapisz
                </button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Anuluj</button>
                <small  class="form-text text-muted"><i class="fas fa-exclamation-triangle text-warning"></i> UWAGA: wyloguj się aby zmiany w konfiguracji zostały ponownie zaczytane.</small>
            </div>
        </div>
    </div>
</div>