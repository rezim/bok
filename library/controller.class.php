<?php

function formatNumberValue($params, $smarty)
{
    if (!isset($params['value']) || !is_numeric($params['value'])) {
        return '-';
    }

    $formattedValue = number_format($params['value'], 0, ",", " ");
    $formattedValue = str_replace(',00', '', $formattedValue);
    return htmlspecialchars($formattedValue, ENT_QUOTES, 'UTF-8');
}

function formatDateValue($params, $smarty)
{
    if (!isset($params['value']) || $params['value'] === '') {
        return '-';
    }
    $formattedDate = date('Y-m-d', strtotime($params['value']));
    $formattedTime = date('H:i:s', strtotime($params['value']));

    return "$formattedDate<br><small>$formattedTime</small>";
}


function showTextFilterOption($params, $smarty)
{
    if (!isset($params['label']) || !isset($params['id'])) {
        return '<div class="text-danger">Parametry "id" i "label" są wymagane!</div>';
    }

    $help = isset($params['help']) ?
        "<small id='{$params['id']}Help' class='form-text text-muted'><i class='fas fa-info-circle'></i> {$params['help']}</small>" : '';

    $value = isset($params['value']) ?
        "value='{$params['value']}'" : '';


    return "                
            <div class='form-group'>
                <label for='filterserial'>{$params['label']}</label>
            </div>
            <div class='form-group'>
                <input type='text' data-ref id='{$params['id']}' class='form-control'
                       aria-describedby='{$params['id']}Help' {$value}>$help
            </div>";
}

function showCheckboxFilterOption($params, $smarty)
{
    if (!isset($params['label']) || !isset($params['id'])) {
        return '<div class="text-danger">Parametry "id" i "label" są wymagane!</div>';
    }

    $help = isset($params['help']) ?
        "<small id='{$params['id']}Help' class='form-text text-muted'><i class='fas fa-info-circle'></i> {$params['help']}</small>" : '';

    $checked = isset($params['checked']) && filter_var($params['checked'], FILTER_VALIDATE_BOOLEAN) === true ? "checked" : "";

    return "                
                <div class='form-group mt-4'>
                    <input type='checkbox' data-ref id='{$params['id']}' aria-describedby='{$params['id']}Help' $checked />
                    <label for='{$params['id']}'>{$params['label']}</label>
                    $help
                </div>";
}

/**
 * Smarty modifier
 * Replaces Fakturownia host with configured FAKTUROWNIA_ENDPOINT
 *
 * Usage in tpl:
 * {$invoice.view_url|fakturownia_url}
 */
function fakturowniaUrl($url)
{
    if (empty($url) || !defined('FAKTUROWNIA_ENDPOINT')) {
        return $url;
    }

    $parsed = parse_url($url);
    if ($parsed === false) {
        return $url;
    }

    $endpoint = rtrim(FAKTUROWNIA_ENDPOINT, '/');

    return $endpoint
        . ($parsed['path'] ?? '')
        . (isset($parsed['query']) ? '?' . $parsed['query'] : '')
        . (isset($parsed['fragment']) ? '#' . $parsed['fragment'] : '');
}


class Controller
{

    protected $_model;
    protected $_controller;
    protected $_action;
    protected $_template;
    protected $_queryString, $notemplate = 0;
    protected $_czyjuzpopulate = 0;

    function __construct($model, $controller, $action, $queryString)
    {
        global $smarty;
        $this->_queryString = $queryString;
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_model = $model;

        $this->$model = new $model;
        $czyToDiv = 0;
        $this->notemplate = 0;
        $czytoDivFrame = 0;

        $customScriptPath = null;

        if ($queryString != null && $queryString != '') {
            // we call it also as an external method, without smarty
            if (isset($smarty)) {
                $smarty->assign('queryString', $queryString);
            }
            switch ($queryString[sizeof($queryString) - 1]) {
                case 'todiv':
                    $czyToDiv = 1;
                    break;
                case 'todivframe':
                    $czytoDivFrame = 1;
                    break;
                case 'notemplate':
                    $this->notemplate = 1;
                    break;
            }

        }

        if ($controller === (CUSTOM_SCRIPTS_CONTROLLER_NAME . 'Controller') && $this->_action === CUSTOM_SCRIPTS_ACTION_NAME) {
            $customScriptPath = implode(DS, $queryString);
        }

        if ($this->notemplate == 0) {
            $this->_template = new Template($controller, $action, $czyToDiv, $czytoDivFrame, $customScriptPath);
        }

        if (isset($smarty)) {
            $smarty->registerPlugin('function', 'format_number_value', 'formatNumberValue');
            $smarty->registerPlugin('function', 'format_date_value', 'formatDateValue');
            $smarty->registerPlugin('function', 'show_txt_filter_option', 'showTextFilterOption');
            $smarty->registerPlugin('function', 'show_check_filter_option', 'showCheckboxFilterOption');
            $smarty->registerPlugin('modifier', 'fakturownia_url', 'fakturowniaUrl');
            $smarty->assignGlobal('OUTDATED_COUNTERS_IN_DAYS_LIMIT', OUTDATED_COUNTERS_IN_DAYS_LIMIT);
        }
    }

    function set($name, $value)
    {
        $this->_template->set($name, $value);
    }

    function __destruct()
    {
        if ($this->notemplate == 0)
            $this->_template->render();
    }

    function addedit()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            global $smarty;
            $nameOfModel = ($this->_model);
            $this->$nameOfModel->populateWithPost();


            if ($_POST['keyVal'] == 0) {
                $this->$nameOfModel->_filedsToEdit['activity']['value'] = '1';
                $this->$nameOfModel->_filedsToEdit['user_insert']['value'] = $_SESSION['user']['rowid'];
            } else {

                $dane = $this->$nameOfModel->getEditDane();

                $smarty->assign('dane', $dane);
                $smarty->assign('filedsToEdit', $this->$nameOfModel->_filedsToEdit);
                unset($dane);
            }

            $smarty->assign('keyVal', $_POST['keyVal']);
            $smarty->assign('filedsToEdit', $this->$nameOfModel->_filedsToEdit);
        } else {
            header("Location: /");
        }
    }

    function save()
    {

        $nameOfModel = ($this->_model);

        if ($this->_czyjuzpopulate == 0) {

            $this->$nameOfModel->populateFieldsToSave('_filedsToEdit', '1');
            $this->$nameOfModel->set('czydelete', $_POST['czydelete']);
        }

        return $this->$nameOfModel->save();
    }

    function validatePostParams($postParams)
    {
        $emptyParams = array_filter($postParams, function ($param) {
            return !isset($_POST[$param]) || (!$_POST[$param] && $_POST[$param] != 0);
        });

        if (count($emptyParams) > 0) {
            echo("Blad! Parametry: " . implode(",", $emptyParams) . " sa wymagane!");

            http_response_code(400);

            return false;
        }

        return true;
    }

    function badRequest($message)
    {
        header('X-PHP-Response-Code: 400', true, 400);
        die($message);
    }

    function forbidden($message)
    {
        header('X-PHP-Response-Code: 403', true, 403);
        die($message);
    }

    function notImplemented($message)
    {
        header('X-PHP-Response-Code: 501', true, 501);
        die($message);
    }

    function internalServerError($message)
    {
        header('X-PHP-Response-Code: 500', true, 500);
        die($message);
    }

    protected function getControllerName(): string {
        return get_called_class();
    }

    function logInfo($operationType, $actionType, $message): void {
        $this->{$this->_model}->logInfo($operationType, $actionType, $message);
    }
    function logWarning($operationType, $actionType, $message): void {
        $this->{$this->_model}->logWarning($operationType, $actionType, $message);
    }
    function logError($operationType, $actionType, $message): void {
        $this->{$this->_model}->logError($operationType, $actionType, $message);
    }

    function hasAccessToAction(string $action): bool
    {
        if (!isset($_SESSION['przypisaneshares'])) {
            return false;
        }

        $controller = $this->getControllerName();
        $normalizedController = preg_replace('/Controller$/', '', $controller);

        foreach ($_SESSION['przypisaneshares'] as $item) {
            if (
                isset($item['controller'], $item['action'], $item['permission']) &&
                $item['controller'] === $normalizedController &&
                $item['action'] === $action &&
                $item['permission'] === 'rw'
            ) {
                return true;
            }
        }

        return false;
    }

    public
    function fetchContent($filePath, $strParams, $postParams)
    {
        if (file_exists($filePath)) {
            $originalGet = $_GET;

            if ($strParams !== null) {
                parse_str($strParams, $params);
//                parse_str($strPostParams, $postParams);

                $_GET = array_merge($_GET, $params);
                $_POST = array_merge($_POST, $postParams);
            }

            ob_start();
            include $filePath;
            $content = ob_get_clean();

            $_GET = $originalGet;

            return $content;
        } else {
            return "Plik $filePath nie istnieje.";
        }
    }

    protected function renderPdf(
        string $html,
        string $filename = 'document.pdf',
        array $options = []
    ): void {
        $mpdf = new \Mpdf\Mpdf(array_merge([
            'mode' => 'utf-8',
            'format' => 'A4',

            // margins for CONTENT
            'margin_top'    => 25,
            'margin_bottom' => 20,

            // header/footer height
            'margin_header' => 10,
            'margin_footer' => 8,

            'default_font'  => 'dejavusans',
        ], $options));

        header('Content-Type: application/pdf');
        header('X-Content-Type-Options: nosniff');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');

        $mpdf->WriteHTML($html);
        $mpdf->Output($filename, \Mpdf\Output\Destination::INLINE);
        exit;
    }
}