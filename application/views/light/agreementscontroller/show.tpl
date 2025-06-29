<div class="container-fluid agreements">
    {include file="$templates/partials/filters/agreemnts.tpl"}
    {include file="$templates/partials/main.tpl" mainId="divRightCenter{$czycolorbox}"}
</div>
<script type="text/javascript">
    $('#txtfilternrumowy{$czycolorbox}').unbind("keypress");
    $('#txtfilternrumowy{$czycolorbox}').keypress(function (event) {
        if (event.keyCode == 13) {
            showAgreements('{$czycolorbox}');
            return false;
        }
    });
    $('#txtfilterserial{$czycolorbox}').unbind("keypress");
    $('#txtfilterserial{$czycolorbox}').keypress(function (event) {
        if (event.keyCode == 13) {
            showAgreements('{$czycolorbox}');
            return false;
        }
    });
    $('#txtfilternazwaklienta{$czycolorbox}').unbind("keypress");
    $('#txtfilternazwaklienta{$czycolorbox}').keypress(function (event) {
        if (event.keyCode == 13) {
            showAgreements('{$czycolorbox}');
            return false;
        }
    });
    showAgreements('{$czycolorbox}');
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const badges = document.querySelectorAll('.badge-status');
        const input = document.getElementById('selectedStatuses');

        function updateHiddenInput() {
            const selected = Array.from(badges)
                .filter(b => b.classList.contains('selected'))
                .map(b => b.dataset.value);
            input.value = selected.join(',');

            showAgreements();
        }

        badges.forEach(badge => {
            badge.addEventListener('click', function () {
                this.classList.toggle('selected');
                updateHiddenInput();
            });
        });

        updateHiddenInput();
    });
</script>