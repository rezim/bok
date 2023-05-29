<?php

class clientpaymentsController extends InvoicesController
{
    function sendpaymentsreport()
    {
        global $smarty;
        global $months;

        $today = date('Y-m-d');
        $previousMonth = date('Y-m-d', strtotime('-1 month', strtotime($today)));
        $firstDayOfPreviousMonth = date('Y-m-01', strtotime($previousMonth));
        $lastDayOfPreviousMonth = date('Y-m-t', strtotime($previousMonth));

        $date = new DateTime($firstDayOfPreviousMonth);
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $statementNumber = $year . '/' . str_pad($month, 3, '0', STR_PAD_LEFT);
        $headerDate = implode("-", array($day, $month, $year));
        $monthName = $months[$month];

        $csvContent = $this->clientpayment->getPayments($firstDayOfPreviousMonth, $lastDayOfPreviousMonth, $statementNumber);

        $csvHeader = array($statementNumber, $headerDate, $headerDate, null, null, '86 1090 2398 0000 0001 5252 1901', 'PLN', null, null, null, null, null, null, count($csvContent), 'N');

        $fileCSV = 'Raport ' . $monthName .'.csv';

        $this->createCSVFile($fileCSV, $csvHeader, $csvContent);

        $topic = 'Raport platnosci za miesiac ' . $monthName . '.';

        $message = 'Dzieñ Dobry,' . '<br/><br/>' .
            'W za³¹czeniu znajduje siê plik z raportem.<br/><br/>' .
            'Pozdrawiamy,' . '<br/>' .
            'Zespó³ Otus.pl';

        $attachments = [["path" => $fileCSV, "filename" => $fileCSV]];

        $mailTo = $_SESSION['appConfig']['email_raportu_platnosci'];

        $mailing = new mailing();
        $mailing->sendNewMail($mailTo, $message, $topic, $attachments, $mailFrom = null, $mailFromName = null);
        unset($mailing);

        unlink($fileCSV);
    }

    function createCSVFile(&$fileName, $header, $content) {
        $handle = fopen($fileName, 'w');

        fputs($handle, implode(',', $header) . "\n");
        foreach ($content as $row) {
            fputs($handle, implode(',', $row) . "\n");
        }

        fclose($handle);
    }
}
