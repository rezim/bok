<div class="container-fluid">
    <div class='divSave'>
        <div id='actionerror' class='actionerror'><span>Błąd zapisu danych.</span></div>
        <div id='actionok' class='actionok'><span style='margin-top:6px;'>Dane zapisane poprawnie</span></div>
    </div>

    <div class="addNew container mt-3 text-right">
        <textarea id="messageArea" class="form-control" cols="160" rows="4" placeholder="Wpisz nową wiadomość"></textarea>
        <br/>
        <button id='actionbuttonclick' class="btn btn-success" onclick="saveUpdateMessage()">Zapisz</button>
    </div>
    <div class='divRightCenter container' id='divRightCenter'>
    </div>
</div>
<script type="text/javascript">
    showMessages();
</script>