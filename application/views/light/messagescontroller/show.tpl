<div class="container-fluid modal-body">
    <div class='divSave'>
        <div id='actionerror' class='actionerror'><span>Błąd zapisu danych.</span></div>
        <div id='actionok' class='actionok'><span style='margin-top:6px;'>Dane zapisane poprawnie</span></div>
    </div>


    <form class="form-horizontal" role="form" id="messageDataContainer">
        <div class="container mt-3">
            <div class="row">
                <div class="form-group col-sm-3">
                    <label for="date" class="control-label">Data</label>
                    <div>
                        <input type="text" class="form-control" id="date" name="date"
                               placeholder="data wiadomości"
                               required data-ref>
                    </div>
                </div>
                <div class="form-group col-sm-9">
                    <label for="description" class="control-label">Treść:</label>
                    <div>
                    <textarea rows=4 type="text" class="form-control" id="message" name="message"
                              placeholder="treść wiadomości" data-ref data-clear-ref></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-right">
                    <button class="btn btn-info" type="button" onclick="saveUpdateMessage('messageDataContainer', 'divRightCenter', 0)">zapisz</button>
                </div>
            </div>
            <input type="hidden" id="type" value="0" data-ref>
        </div>
    </form>
    <form id='divRightCenter' class="form-horizontal divRightCenter container" role="form">
        {* Message Data Here *}
    </form>
{*    <div class='divRightCenter container' >*}
{*    </div>*}
</div>
<script type="text/javascript">
    showMessages('divRightCenter', 0);
    $( "#date" ).datepicker({ dateFormat: "yy-mm-dd" });
    $( "#date" ).datepicker('setDate', 'today');
</script>