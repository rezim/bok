<?php
spl_autoload_register("autoload");
if (!isset($smarty))
    $smarty = new Smarty;

/** Check if environment is development and display errors **/

function setReporting()
{
    if (DEVELOPMENT_ENVIRONMENT == true) {
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        $_SESSION['dev'] = 1;
    } else {
        $_SESSION['dev'] = 0;
        error_reporting(E_ALL);
        ini_set('display_errors', '0');
        ini_set('log_errors', '1');
        ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'error.log');
    }
}

$months = array(
    '01' => 'styczeń',
    '02' => 'luty',
    '03' => 'marzec',
    '04' => 'kwiecień',
    '05' => 'maj',
    '06' => 'czerwiec',
    '07' => 'lipiec',
    '08' => 'sierpień',
    '09' => 'wrzesień',
    '10' => 'październik',
    '11' => 'listopad',
    '12' => 'grudzień',
);

/** Check register globals and remove them **/

function unregisterGlobals()
{
    if (ini_get('register_globals')) {

        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

/** Main Call Function **/
function startsWith($haystack, $needle)
{
    return strpos($haystack, $needle) === 0;
}

function callHook()
{

    if (!isSecure() && (!defined('DISABLE_HTTPS') || !DISABLE_HTTPS)) {
        redirectToHTTPS();
    }

    global $url;
    $controller = '';
    $action = '';
    $queryString = array();

    if ($url != '') {
        $urlArray = array();
        $urlArray = explode("/", $url);


        $controller = !isset($urlArray[0]) ? '' : str_replace('-', '_', $urlArray[0]);
        array_shift($urlArray);
        $action = !isset($urlArray[0]) ? '' : str_replace('-', '_', $urlArray[0]);

        array_shift($urlArray);
        $queryString = $urlArray;

    }
    if ($controller == '' || $controller == null) $controller = 'starts';
    if ($action == '' || $action == null) $action = 'show';

    checkUprawnienia($controller, $action, $queryString);

    $model = rtrim($controller, 's');
    $controller .= 'Controller';

    if (class_exists($controller)) {

    } else {
        header('Location: /starts/bladwywolania');
        exit;
        // błąd - błędne wywołanie adresu strony
    }
    $dispatch = new $controller($model, $controller, $action, $queryString);

    if ((int)method_exists($controller, $action)) {
        call_user_func_array(array($dispatch, $action), $queryString);
    } else {

    }
}

/** Autoload any classes that are required **/

function autoload($className)
{
    if (file_exists(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php')) {
        require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php');
    } else if (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php');
    } else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php');
    } else if (file_exists(ROOT . DS . 'library' . DS . 'smarty' . DS . $className . '.class.php')) {
        require_once(ROOT . DS . 'library' . DS . 'smarty' . DS . $className . '.class.php');
    } else if (file_exists(ROOT . DS . 'application' . DS . 'utils' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'utils' . DS . strtolower($className) . '.php');
    } else {

        /* Error Generation Code Here */
    }
}

function redirectToHTTP()
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
        $redirect = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header("Location:$redirect");
    }
}

function redirectToHTTPS()
{
    if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on") {
        $redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header("Location:$redirect");
    }
}

function validatesAsInt($number)
{
    $number = filter_var($number, FILTER_VALIDATE_INT);
    return ($number !== FALSE);
}

function validatesAsDecimal($number)
{
    $number = filter_var($number, FILTER_VALIDATE_FLOAT);
    return ($number !== FALSE);
}

function validEmail($email)
{
    $isValid = true;
    $atIndex = strrpos($email, "@");
    if (is_bool($atIndex) && !$atIndex) {
        $isValid = false;
    } else {
        $domain = substr($email, $atIndex + 1);
        $local = substr($email, 0, $atIndex);
        $localLen = strlen($local);
        $domainLen = strlen($domain);
        if ($localLen < 1 || $localLen > 64) {
            // local part length exceeded
            $isValid = false;
        } else if ($domainLen < 1 || $domainLen > 255) {
            // domain part length exceeded
            $isValid = false;
        } else if ($local[0] == '.' || $local[$localLen - 1] == '.') {
            // local part starts or ends with '.'
            $isValid = false;
        } else if (preg_match('/\\.\\./', $local)) {
            // local part has two consecutive dots
            $isValid = false;
        } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
            // character not valid in domain part
            $isValid = false;
        } else if (preg_match('/\\.\\./', $domain)) {
            // domain part has two consecutive dots
            $isValid = false;
        } else if
        (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
            str_replace("\\\\", "", $local))) {
            // character not valid in local part unless
            // local part is quoted
            if (!preg_match('/^"(\\\\"|[^"])+"$/',
                str_replace("\\\\", "", $local))) {
                $isValid = false;
            }
        }
        if ($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A"))) {
            // domain not found in DNS
            $isValid = false;
        }
    }
    return $isValid;
}

function getUniqueIdNumber()
{

    return substr(number_format(time() * mt_rand(), 0, '', ''), 0, 10);

}

function checkUprawnienia($controller, $action, $queryString)
{

    if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
        if (($controller == 'acls' && $action == 'login') || ($controller == 'starts' && $action == 'bladwywolania') || ($controller == 'acls' && $action == 'logowanie')) {

        } else {

            header("Location: " . SCIEZKA . "/acls/login");

            die();
        }
    } else { // sprawedzenie uprawnień

        $prawaDostepu = '';

        foreach ($_SESSION['shares'] as $key => $item) {
            if ($item['controller'] == $controller && $item['action'] == $action) { // sprawddzamy uprawnienia

                if (isset($_SESSION['przypisaneshares'])) {
                    foreach ($_SESSION['przypisaneshares'] as $key2 => $item2) {
                        if ($item['controller'] == $item2['controller'] && $item['action'] == $item2['action']) {
                            if (($item2['permission'] == 'w' || $item2['permission'] == 'rw') && $prawaDostepu == 'r') {

                            } else
                                $prawaDostepu = $item2['permission'];


                        }
                    }
                }
                if ($prawaDostepu == '') { // rejest
                    if ($queryString != null && $queryString != '') {
                        switch ($queryString[sizeof($queryString) - 1]) {
                            case 'todiv':
                                header("Location: " . SCIEZKA . "/acls/brakuprawnien/todiv");
                                die();
                                break;
                            case 'notemplate':
                                echo('Brak uprawnień');
                                die();
                                break;
                            default :
                                header("Location: " . SCIEZKA . "/acls/brakuprawnien");
                                break;
                        }

                    } else {
                        header("Location: " . SCIEZKA . "/acls/brakuprawnien");
                    }
                } else { // do smartego

                }

            } else
                continue;
        }

        // fix for security gap, in case the access is not defined, do not allow
        if (!defined('DISABLE_SECURITY_MODE') &&
            ($prawaDostepu == '' && $controller != 'starts' && $controller != 'acls' && $action != 'brakuprawnien' && $action != 'light')) {

            echo('Controller: ' . $controller . 'Action: ' . $action);
            if ($queryString != null && $queryString != '') {
                switch ($queryString[sizeof($queryString) - 1]) {
                    case 'todiv':
                        header("Location: " . SCIEZKA . "/acls/brakuprawnien/todiv");
                        break;
                    case 'notemplate':
                        echo('Brak uprawnień');
                        break;
                    default :
                        header("Location: " . SCIEZKA . "/acls/brakuprawnien");
                        break;
                }

            } else {
                header("Location: " . SCIEZKA . "/acls/brakuprawnien");
            }
            die();
        } else {
            global $smarty;
            $smarty->assign('uprawnienia', $prawaDostepu);
        }
    }
}

function isSecure()
{
    return
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || $_SERVER['SERVER_PORT'] == 443;
}

require ROOT . DS . 'library' . DS . 'vendor' . DS . 'autoload.php';

date_default_timezone_set('Europe/Warsaw');

setReporting();
unregisterGlobals();
callHook();



