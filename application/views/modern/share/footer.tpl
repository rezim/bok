
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

<!-- Common Bootstrap Modal Placeholder  -->
<div id="commonModalPlaceholder"></div>

<!-- ===============================================-->
<!--    JavaScripts-->
<!-- ===============================================-->
<script src="{$smarty.const.SCIEZKA}/vendors/popper/popper.min.js"></script>
<script src="{$smarty.const.SCIEZKA}/vendors/bootstrap/bootstrap.min.js"></script>
<script src="{$smarty.const.SCIEZKA}/vendors/anchorjs/anchor.min.js"></script>
<script src="{$smarty.const.SCIEZKA}/vendors/is/is.min.js"></script>
<script src="{$smarty.const.SCIEZKA}/vendors/fontawesome/all.min.js"></script>
<script src="{$smarty.const.SCIEZKA}/vendors/lodash/lodash.min.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
<script src="{$smarty.const.SCIEZKA}/vendors/list.js/list.min.js"></script>
<script src="{$smarty.const.SCIEZKA}/vendors/feather-icons/feather.min.js"></script>
<script src="{$smarty.const.SCIEZKA}/vendors/dayjs/dayjs.min.js"></script>
<script src="{$smarty.const.SCIEZKA}/vendors/leaflet/leaflet.js"></script>
<script src="{$smarty.const.SCIEZKA}/vendors/leaflet.markercluster/leaflet.markercluster.js"></script>
<script src="{$smarty.const.SCIEZKA}/vendors/leaflet.tilelayer.colorfilter/leaflet-tilelayer-colorfilter.min.js"></script>
<script src="{$smarty.const.SCIEZKA}/assets/js/phoenix.js"></script>
<script src="{$smarty.const.SCIEZKA}/vendors/echarts/echarts.min.js"></script>
<script src="{$smarty.const.SCIEZKA}/assets/js/ecommerce-dashboard.js"></script>

</body>
</html> 