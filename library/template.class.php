<?php

class Template
{

    protected $variables = array();
    protected $_controller;
    protected $_action;
    protected $_czyToDiv = 0, $_czytoDivFrame = 0, $_isCustomScript = false;
    protected $_queryString;

    function __construct($controller, $action, $czyToDiv, $czytoDivFrame, $customScriptPath)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_czyToDiv = $czyToDiv;
        $this->_czytoDivFrame = $czytoDivFrame;
        $this->_customScriptPath = $customScriptPath;
    }

    /** Set Variables **/

    function set($name, $value)
    {
        $this->variables[$name] = $value;
    }

    /** Display Template **/

    function render()
    {
        global $smarty;

        $basePath = ROOT . DS . 'application' . DS;

        $smarty->assign('controller', $this->_controller);
        $smarty->assign('action', $this->_action);
        $smarty->assign('templates', ROOT . DS . 'application' . DS . 'templates' . DS);

        if ($this->_customScriptPath) {
            $smarty->display($basePath . 'views' . DS . SMARTVERSION . DS . 'share' . DS . 'header.tpl');
            $this->renderPhpFile($basePath . CUSTOM_SCRIPTS_FOLDER_NAME . DS . $this->_customScriptPath);
            $smarty->display($basePath . 'views' . DS . SMARTVERSION . DS . 'share' . DS . 'footer.tpl');
            return;
        }

        if ($this->_czyToDiv != 1) {
            $smarty->display($basePath . 'views' . DS . SMARTVERSION . DS . 'share' . DS . 'header.tpl');
        }

        if (file_exists($basePath . 'views' . DS . SMARTVERSION . DS . strtolower($this->_controller) . DS . $this->_action . '.tpl')) {
            $smarty->display($basePath . 'views' . DS . SMARTVERSION . DS . strtolower($this->_controller) . DS . $this->_action . '.tpl');
        } else if (file_exists($basePath . 'views' . DS . SMARTVERSION . DS . 'share' . DS . $this->_action . '.tpl')) {
            $smarty->display($basePath . 'views' . DS . SMARTVERSION . DS . 'share' . DS . $this->_action . '.tpl');
        }

        if ($this->_czyToDiv != 1) {
            $smarty->display($basePath . 'views' . DS . SMARTVERSION . DS . 'share' . DS . 'footer.tpl');
        }

        $smarty->display($basePath . 'views' . DS . SMARTVERSION . DS . 'share' . DS . 'uprawnienia.tpl');
    }


    function renderPhpFile($phpFilePath)
    {
        if (file_exists($phpFilePath)) {
            include $phpFilePath;
        }
    }

}