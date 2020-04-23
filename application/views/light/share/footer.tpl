
</div><!--divContainerCenterKoniec-->

{if isset($smarty.session.login) && $smarty.session.login==1}
<div id='divFooter' class="footer">
        <div class="text-right text-muted p-3">
            <a href="{$smarty.const.SCIEZKA}/">powered by OTUS&nbsp;&copy;</a>
        </div>
</div>
{else}
<div class="text-right text-muted fixed-bottom p-3">
    <a href="{$smarty.const.SCIEZKA}/">powered by OTUS&nbsp;&copy;</a>
</div>
{/if}

</div><!--divContainerKoniec-->
<div>

    <script type="text/javascript">
   
        loadScript('{$smarty.const.SCIEZKA}/js/jquery.colorbox.js');
    </script>

</div>

<script>
    let timeout = undefined;
    const interval = 5;
    const delay = 100;

    const updateProgress = function(currentWidth) {
        currentWidth += interval;
        if (currentWidth <= 100) {
            $("#progressBar").width(currentWidth  + '%');
            timeout = setTimeout(function() {
                updateProgress(currentWidth);
            }, delay);
        }
    };

    $(document).ajaxStart(function () {
        $("#progress").css("display","flex");
        $("#progress").css("display","flex");
        updateProgress(0);
    }).ajaxComplete(function() {
        if (timeout) {
            clearTimeout(timeout);
        }
        $("#progressBar").width("100%");

        setTimeout(function() {
            $("#progress").css("display","none");
            $("#progressBar").width("0%");
        }, delay);
    });
</script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
{*<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>*}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html> 