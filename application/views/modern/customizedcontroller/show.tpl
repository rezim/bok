<div class="container-fluid">
    <main id='divRightCenter' class="col-12">
    </main>
</div>
<script type="text/javascript">
    const templateUrl = "/customized/showfile/{$folderName}/{$fileName}/notemplate/{$queryString}/{$postParamsString}";
    const templateContainerId = 'divRightCenter';
    alert(templateUrl);
    alert(templateContainerId);
    renderTemplateWithDataAction(templateUrl, null, templateContainerId);
</script>