<div class="container-fluid">

    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-2">
            <form>
                <div class="form-group otus-addnew otus-section">
                    <button type="button" class="btn btn-block btn-outline-primary otus-action-btn"
                            onclick="showNewClientAdd("0");return false;"><i class="fa fa-plus"></i>&nbsp;Nowy
                        Klient
                    </button>
                </div>
                <div class="border-top my-4 otus-separator"></div>
                <div class="form-group">
                    <label for="txtfilternazwa">Nazwa</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilternazwa' class="form-control"
                           aria-describedby="nameHelp">
                    <small id="nameHelp" class="form-text text-muted">Podaj nazwę klienta.</small>
                </div>

                <div class="form-group">
                    <label for="txtfiltermiasto">Miasto</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfiltermiasto' class="form-control"
                           aria-describedby="miastoHelp">
                    <small id="miastoHelp" class="form-text text-muted">Podaj miasto siedziby klienta.</small>
                </div>

                <div class="form-group">
                    <label for="txtfilternip">Nip</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilternip' class='form-control'
                           aria-describedby="nipHelp">
                    <small id="nipHelp" class="form-text text-muted">Podaj NIP klienta.</small>
                </div>

                <div class="form-group">
                    <label for="txtfilterserial">Serial</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtfilterserial' class='form-control'
                           aria-describedby="serialHelp"
                            {if isset($serial)}
                                value='{$serial}'
                            {/if}>
                    <small id="serialHelp" class="form-text text-muted">Podaj serial urządzenia klienta.</small>
                </div>

                <div class="border-top my-4 otus-separator"></div>

                <div class="form-group">
                    <button class="btn btn-info btn-block" type="submit"
                            onClick="showClients('{$czycolorbox}');return false;"">
                        Filtruj
                    </button>
                </div>
            </form>
        </div>

        <main id='divRightCenter{$czycolorbox}' class="col-12 col-md-12 col-xl-10">

        </main>
    </div>
</div>

<script type="text/javascript">
                       $('#txtfilternazwa').unbind("keypress");
                       $('#txtfilternazwa').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                     showClients('{$czycolorbox}');return false;
                                                 }
                                             });  
                       $('#txtfilternip').unbind("keypress");
                       $('#txtfilternip').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    showClients('{$czycolorbox}');return false;
                                                 }
                                             });  
                       $('#txtfiltermiasto').unbind("keypress");
                       $('#txtfiltermiasto').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                     showClients('{$czycolorbox}');return false;
                                                 }
                                             });  
    showClients('{$czycolorbox}');
</script>