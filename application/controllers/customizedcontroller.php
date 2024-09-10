<?php
class customizedController extends Controller {
    function show()
    {
        global $smarty;
        $smarty->assign('folderName', $this->_queryString[0]);
        $smarty->assign('fileName', $this->_queryString[1]);

        $queryParams = $_GET;
        unset($queryParams['url']);
        $queryString = http_build_query($queryParams);

        $smarty->assign('queryString', $queryString);

    }

    function showfile()
    {
        // it should be file name parameters,
        // e.g. "/customized/showfile/cars/e100/notemplate" => `test` is the file name
        $folderName = $this->_queryString[0];
        $fileName = $this->_queryString[1];
        $query = $this->_queryString[3];
        $url = ROOT . DS . 'application' . DS . 'apps' . DS . $folderName . DS . $fileName;
        $content = $this->fetchContent($url , $query);

        echo $content;
    }
}