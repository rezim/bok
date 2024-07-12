<div id="listOfEmailsModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Lista adresów email aktywnych klientów</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="emailsContainer">

                {foreach from=$dataClient item=item key=key name=loopek}

                    {$item.mailfaktury};

                {/foreach}

            </div>
            <div class="modal-footer">
                <button type="button" onclick="copyToClipboard(document.getElementById('emailsContainer').innerText)"
                        class="btn btn-outline-success active"><i class="fas fa-save"></i> Zapisz w schowku
                </button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Anuluj</button>
            </div>
            <div class="modal-footer">
                <small  class="form-text text-muted"><i class="fas fa-exclamation-triangle text-warning"></i> kliknięcie na przycisk 'Zapisz w schowku umożliwi skopiowanie wszystkich adresów'</small>
            </div>
        </div>
    </div>
</div>