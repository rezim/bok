<div class="container-fluid agreements">
    {include file="$templates/partials/filters/toners.tpl"}
    {include file="$templates/partials/main.tpl" mainId="divRightCenter"}
</div>

<script type="text/javascript">
    $('#txtfilterserial').unbind("keypress");
    $('#txtfilterserial').keypress(function(event) {
        if (event.keyCode == 13) {
            pokazTonery();return false;
        }
    });

    pokazTonery();
</script>