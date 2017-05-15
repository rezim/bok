<?php
class Template {

	protected $variables = array();
	protected $_controller;
	protected $_action;
        protected $_czyToDiv=0,$_czytoDivFrame=0;

	function __construct($controller,$action,$czyToDiv,$czytoDivFrame) {
		$this->_controller = $controller;
		$this->_action = $action;
                $this->_czyToDiv=$czyToDiv;
                $this->_czytoDivFrame=$czytoDivFrame;
	}

	/** Set Variables **/

	function set($name,$value) {
		$this->variables[$name] = $value;
	}

	/** Display Template **/

        function render() 
        {
            global $smarty;
                $smarty->assign('controller',$this->_controller); 
                $smarty->assign('action',$this->_action);
                $smarty->assign('templates', ROOT . DS . 'application' . DS . 'templates' . DS);
                
                
                    if($this->_czyToDiv!=1)
                        $smarty->display(ROOT . DS . 'application' . DS . 'views' . DS.SMARTVERSION.DS . 'share'. DS . 'header.tpl');
                    
                    
                    if (file_exists(ROOT . DS . 'application' . DS . 'views' . DS.SMARTVERSION.DS . strtolower($this->_controller) . DS . $this->_action . '.tpl'))
                    {
                        $smarty->display(ROOT . DS . 'application' . DS . 'views' . DS.SMARTVERSION.DS . strtolower($this->_controller) . DS . $this->_action . '.tpl');	
                    }
                    else if(file_exists(ROOT . DS . 'application' . DS . 'views' . DS.SMARTVERSION.DS .'share' . DS . $this->_action . '.tpl'))
                    {
                        $smarty->display(ROOT . DS . 'application' . DS . 'views' . DS.SMARTVERSION.DS . 'share' . DS . $this->_action . '.tpl');	
                    }
                      
                    if($this->_czyToDiv!=1)
                        $smarty->display(ROOT . DS . 'application' . DS . 'views' . DS.SMARTVERSION.DS . 'share'. DS . 'footer.tpl');
                $smarty->display(ROOT . DS . 'application' . DS . 'views' . DS.SMARTVERSION.DS . 'share' . DS . 'uprawnienia.tpl');	
                        
        }
                
		
    

}