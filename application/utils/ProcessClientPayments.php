<?php
function processClientPayments($notificationEmail = null)
{
    $model = 'clientpayment';
    $controller = 'clientpaymentsController';
    $action = 'addClientsPayments';
    $queryString = array('notemplate');
    $dispatch = new $controller($model, $controller, $action, $queryString);

    if ((int)method_exists($controller, $action)) {
        $result = call_user_func_array(array($dispatch, $action), $queryString);

        if ($notificationEmail !== null) {

            $succeedProcessedPayments = $result['succeedProcessedPayments'];
            $succeedProcessedPaymentsCount = count($result['succeedProcessedPayments']);
            $notProcessedPayments = $result['notProcessedPayments'];
            $notProcessedPaymentsCount = count($notProcessedPayments);
            $emailText = "Ilość płanoście NIE DODANYCH do Fakturownii: $notProcessedPaymentsCount<br />";
            if ($notProcessedPaymentsCount > 0) {
                $emailText .= implode("<br />", array_map(function ($notProcessedPayment) {
                    return implode(" , ", $notProcessedPayment);
                }, $notProcessedPayments)) . "<br />";
            }
            $emailText .= "<br />";
            $emailText .= "Platności dodane do fakturownii: $succeedProcessedPaymentsCount<br />";
            if ($succeedProcessedPaymentsCount > 0) {
                $emailText .= implode("<br />", array_map(function ($succeedProcessedPayment) {
                        return implode(" , ", $succeedProcessedPayment);
                    }, $succeedProcessedPayments)) . "<br />";
            }

            $mailing = new mailing();
            $date = date("Y-m-d");
            $time = date("H:i");
            $mailing->sendNewMail($notificationEmail, $emailText, "Wynik procesowania płatności dnia $date o godzinie $time.");
        }
    }
}