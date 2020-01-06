<div class='divSave'>
    <div id='actionerror' class='actionerror'><span>Błąd zapisu danych.</span></div>
    <div id='actionok' class='actionok' ><span style='margin-top:6px;'>Dane zapisane poprawnie</span></div>

    <div id='actionloader' class="actionloader">
        <img src="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/smallLoader.GIF" style='display:inline;'/>przetwarzanie
    </div>
    <div style='clear:both'></div>
</div>
<div class='divLoader' id='divLoader'>
</div>
<div class="addNew">
    <textarea id="messageArea" cols="160" rows="4" placeholder="Wpisz nową wiadomość"></textarea>
    <br/>
    <button id='actionbuttonclick' class="btn btn-success" onclick="saveUpdateMessage(1)">Zapisz</button>
</div>
<div class='divRightCenter' id='divRightCenter'>
</div>

<script type="text/javascript">
    showMessages(1);
</script>