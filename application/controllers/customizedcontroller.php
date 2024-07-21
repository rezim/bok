<?php
class customizedController extends Controller {
    function show()
    {
        global $smarty;
        $smarty->assign('folderName', $this->_queryString[0]);
        $smarty->assign('fileName', $this->_queryString[1]);
    }

    function showfile()
    {
        // it should be file name parameters,
        // e.g. "/customized/showfile/cars/e100/notemplate" => `test` is the file name
        $folderName = $this->_queryString[0];
        $fileName = $this->_queryString[1];
        $url = ROOT . DS . 'application' . DS . 'apps' . DS . $folderName . DS . $fileName;
        $content = $this->fetchContent($url);

        echo $content;
    }
}