<?php

class Template
{

    private string $basePath = ROOT . DS . 'application' . DS;
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

        $smarty->assign('controller', $this->_controller);
        $smarty->assign('action', $this->_action);
        $smarty->assign('templates', ROOT . DS . 'application' . DS . 'templates' . DS);

//        <div class="container-fluid">
//    <main id='divRightCenter' class="col-12">
//    </main>
//</div>

        if ($this->_customScriptPath) {
            $smarty->display($this->basePath . 'views' . DS . SMARTVERSION . DS . 'share' . DS . 'header.tpl');
            $this->renderPhpFile($this->basePath . CUSTOM_SCRIPTS_FOLDER_NAME . DS . $this->_customScriptPath);
            $smarty->display($this->basePath . 'views' . DS . SMARTVERSION . DS . 'share' . DS . 'footer.tpl');
            return;
        }

        if ($this->_czyToDiv != 1) {
            $smarty->display($this->basePath . 'views' . DS . SMARTVERSION . DS . 'share' . DS . 'header.tpl');
        }

        if (file_exists($this->basePath . 'views' . DS . SMARTVERSION . DS . strtolower($this->_controller) . DS . $this->_action . '.tpl')) {
            $smarty->display($this->basePath . 'views' . DS . SMARTVERSION . DS . strtolower($this->_controller) . DS . $this->_action . '.tpl');
        } else if (file_exists($this->basePath . 'views' . DS . SMARTVERSION . DS . 'share' . DS . $this->_action . '.tpl')) {
            $smarty->display($this->basePath . 'views' . DS . SMARTVERSION . DS . 'share' . DS . $this->_action . '.tpl');
        }

        if ($this->_czyToDiv != 1) {
            $smarty->display($this->basePath . 'views' . DS . SMARTVERSION . DS . 'share' . DS . 'footer.tpl');
        }

        $smarty->display($this->basePath . 'views' . DS . SMARTVERSION . DS . 'share' . DS . 'uprawnienia.tpl');
    }


    function renderPhpFile($phpFilePath)
    {

        register_shutdown_function(function () {
            global $smarty;
            // in case script will end with exit/die
            $smarty->display($this->basePath . 'views' . DS . SMARTVERSION . DS . 'share' . DS . 'footer.tpl');
        });

        if (file_exists($phpFilePath)) {
            include $phpFilePath;
        }
    }

}