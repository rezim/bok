<?php

class startsController extends Controller
{
    function show()
    {
        if (!defined('DISABLE_HTTPS') || !DISABLE_HTTPS) {
            redirectToHTTPS();
        } else {
            redirectToHTTP();
        }

        global $smarty;
        // TODO: add to configuration
        $smarty->assign('folderName', 'dashboard');
        $smarty->assign('fileName', 'dashboard.php');
    }

    function bladwywolania()
    {
        if (!defined('DISABLE_HTTPS') || !DISABLE_HTTPS) {
            redirectToHTTPS();
        } else {
            redirectToHTTP();
        }
    }

    function showfile()
    {
        // it should be file name parameters,
        // e.g. "/customized/showfile/cars/e100/notemplate" => `test` is the file name
        $folderName = $this->_queryString[0];
        $fileName = $this->_queryString[1];
        // TODO: move apps into configuration
        $url = ROOT . DS . 'application' . DS . 'apps' . DS . $folderName . DS . $fileName;
        $content = $this->fetchContent($url);

        echo $content;
    }
}
