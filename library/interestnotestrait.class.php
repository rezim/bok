<?php

trait InterestNotesTrait
{
    function markInterestNoteAsPaid($buyerTaxNo, $fileName, $invoiceNb, $date)
    {
        $interestNoteFolderName = INTEREST_NOTE_FOLDER_NAME;
        $interestNoteNamePrefix = INTEREST_NOTE_NAME_PREFIX;
        $dir = "./{$interestNoteFolderName}/{$buyerTaxNo}/";
        $filePath = "{$dir}{$fileName}";
        if (file_exists($filePath)) {
            $paidDir = "./{$interestNoteFolderName}/{$buyerTaxNo}/";
            $interestNotePaidPrefix = INTEREST_NOTE_PAID_FOLDER_NAME . '-';
            $renamedFilePath = "{$paidDir}{$interestNotePaidPrefix}({$date})-{$fileName}";
            rename($filePath, $renamedFilePath);

            $mailing = new mailing();

            $mailing->sendInterestNoteEmail(INTEREST_NOTE_SEND_TO_ACCOUNTING_OFFICE,
                "Nota odsetkowa do FV numer: {$invoiceNb}",
                date_format(date_create($date), 'm/Y'),
                array(array("path" => $renamedFilePath, "filename" => "{$interestNoteNamePrefix}{$fileName}"))
            );

            $customerMessage = "Nota odsetkowa {$fileName} została opłacona {$date} i wysłana do biura rachunkowego.";
            $customerMessageParams = array("client_nip" => $buyerTaxNo, "message_date" => date("Y-m-d"), "message" => $customerMessage);
            $this->clientinvoice->addPaymentMessage($customerMessageParams, 'payments_messages');
        }

        return $this->resolveInterestNotes($buyerTaxNo);
    }

    function removeNotPaidInterestNote($buyerTaxNo, $fileName, $invoiceNb, $date)
    {
        $interestNoteFolderName = INTEREST_NOTE_FOLDER_NAME;

        $dir = "./{$interestNoteFolderName}/{$buyerTaxNo}/";
        $filePath = "{$dir}{$fileName}";
        if (file_exists($filePath)) {
            unlink($filePath);

            $customerMessage = "Nota odsetkowa {$fileName} została usunięta {$date}!.";
            $customerMessageParams = array("client_nip" => $buyerTaxNo, "message_date" => date("Y-m-d"), "message" => $customerMessage);
            $this->clientinvoice->addPaymentMessage($customerMessageParams, 'payments_messages');
        }

        return $this->resolveInterestNotes($buyerTaxNo);
    }

    function getInterestNoteUrl($invoiceNb)
    {
        $today = date("Y-m-d");
        $payment_days = 7;
        $due_date = date('Y-m-d', strtotime($today . " + {$payment_days} days"));
        $host = preg_replace("/^http:/i", "https:", FAKTUROWNIA_ENDPOINT);
        $token = FAKTUROWNIA_APITOKEN;
        return "{$host}/invoices/{$invoiceNb}.pdf?api_token={$token}&print_option=interest_note&interest_rate=&interest_type=legal&forced_payment_to={$due_date}";
    }

    function resolveInterestNotes($buyerTaxNo)
    {

        $interestNoteFolderName = INTEREST_NOTE_FOLDER_NAME;
        $dir = "./{$interestNoteFolderName}/{$buyerTaxNo}/";

        // return $this->attachInterestNotesToInvoice('158136955', $dir, ['nota_1.pdf', 'nota_2.pdf', 'nota_3.pdf', 'nota_4.pdf']);

        $noteNames = glob("$dir/*.pdf");

        $notesWithDate = array_map(function ($filePath) {

            $parsedInterestNote = $this->readInterestNote($filePath);

            $fileName = basename($filePath);
            $timestamp = filemtime($filePath);
            return array("name" => $fileName, "path" => $filePath, "date" => date("Y-m-d H:i:s", $timestamp), "timestamp" => $timestamp, "amount" => $parsedInterestNote['amount'], "text" => $parsedInterestNote["text"], "number" => $parsedInterestNote["number"], "nip" => $parsedInterestNote["nip"]);
        }, $noteNames);

        usort($notesWithDate, function ($a, $b) {
            return $b["timestamp"] - $a["timestamp"];
        });

        return $notesWithDate;
    }

    function resolveNotPaidInterestNotes($buyerTaxNo)
    {
        $filterPaidInterestNotes = function ($interestNote) {
            return !startsWith($interestNote['name'], 'paid-(');
        };

        return array_filter($this->resolveInterestNotes($buyerTaxNo), $filterPaidInterestNotes);
    }

    function readInterestNote($filePath)
    {

        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($filePath);
        $textArr = array_map(fn($lineOfText) => preg_replace("/\s+/", "", $lineOfText), preg_split('/\r\n|\r|\n/', $pdf->getText()));

        $result = array();

        /**
         * ...
         * 47: "Razem"
         * 48: "1,61PLN"
         * 49: "Słownie"
         * ...
         */
        $amountPosition = array_search("Słownie", $textArr);

        $result['text'] = $textArr;


        if ($amountPosition && count($textArr) > 2 && $textArr[$amountPosition - 2] === "Razem") {
            $result['amount'] = floatval(str_replace(",", ".", $textArr[$amountPosition - 1]));
        } else {
            $result['amount'] = -1;
        }

        $invoiceNumber = '';
        $nip = '';

        foreach ($textArr as $value) {
            if (strpos($value, '1Fakturanumer') === 0) {
                $invoiceNumber = str_replace('1Fakturanumer', '', $value);
            }
            if (strpos($value, 'NIP') === 0) {
                $nip = str_replace('NIP', '', $value);
            }
        }

        $result['number'] = $invoiceNumber;

        $result['nip'] = $nip;

        return $result;
    }


    function resolveAllInterestNotes()
    {
        $interestNoteFolderName = INTEREST_NOTE_FOLDER_NAME;
        $interestNoteDir = "./{$interestNoteFolderName}/";

        if (!is_dir($interestNoteDir)) {
            return [];
        }

        $clientNips = scandir($interestNoteDir);

        $nipToInterestNotesMap = array();
        array_walk($clientNips, function (&$nip, $key) use (&$nipToInterestNotesMap) {
            if ($nip !== '.' && $nip !== '..') {
                $nipToInterestNotesMap[$nip] = $this->resolveInterestNotes($nip);
            }
        });
        return $nipToInterestNotesMap;
    }

    function issueInterestNote($id, $number, $buyerTaxNo, $buyerEmail, $sellDate, $paymentTo, $paidDate, $isLateDays)
    {
        $url = $this->getInterestNoteUrl($id);

        $interestNoteFolderName = INTEREST_NOTE_FOLDER_NAME;
        $dir = "./{$interestNoteFolderName}/{$buyerTaxNo}/";
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $normalizedInvoiceNumber = str_replace('/', '-', $number);
        $fileName = "{$normalizedInvoiceNumber}.pdf";
        $filePath = "{$dir}{$fileName}";

        $result = array('status' => 0, 'path' => $filePath, 'file_name' => $fileName);

        $mail = array(
            "mailTo" => INTEREST_NOTE_DEBUG_SEND_TO !== '' ? INTEREST_NOTE_DEBUG_SEND_TO : $buyerEmail,
            "message" => "Dzie� Dobry,<br /><br /> W za��czniku przesy�amy not� odsetkow� do faktury vat numer: {$number}.<br />Termin p�atno�ci faktury: {$paymentTo},<br />Data p�atno�ci faktury: {$paidDate},<br />Op�nienie w p�atno�ci dni: {$isLateDays}.<br /><br />Prosimy o terminowe p�atno�ci,<br />pozdrawiamy,<br />Otus.pl",
            "topic" => "Nota odsetkowa do faktury vat {$number}.",
            "attachments" => array(array("path" => $filePath, "filename" => $fileName))
        );

        // $customerMessage = "Wysłano notę odsetkową {$fileName} na adres email: {$mail['mailTo']}.";
        $customerMessage = "Wystawiono notę odsetkową {$fileName}.";
        $customerMessageParams = array("client_nip" => $buyerTaxNo, "message_date" => date("Y-m-d"), "message" => $customerMessage);
        if (file_exists($filePath)) {
            if (INTEREST_NOTE_SEND_EMAIL_TO_CLIENT) {
                $mailing = new mailing();
                $mailing->sendInterestNoteEmail(
                    $mail['mailTo'],
                    $mail['message'],
                    $mail['topic'],
                    $mail['attachments']
                );
                unset($mailing);
            }

            $this->clientinvoice->addPaymentMessage($customerMessageParams, 'payments_messages');

            return array_merge($result, array('status' => -1, 'message' => 'file already exists'));
        }

        // Use file_get_contents() function to get the file
        // from url and use file_put_contents() function to
        // save the file by using base name
        if (file_put_contents($filePath, file_get_contents($url))) {
            if (INTEREST_NOTE_SEND_EMAIL_TO_CLIENT) {
                $mailing = new mailing();
                $mailing->sendInterestNoteEmail(
                    $mail['mailTo'],
                    $mail['message'],
                    $mail['topic'],
                    $mail['attachments']
                );
                unset($mailing);
            }

            $this->clientinvoice->addPaymentMessage($customerMessageParams, 'payments_messages');

            return array_merge($result, array('message' => 'file created successful'));
        } else {
            return array_merge($result, array('status' => -1, 'message' => 'file download failed'));
        }
    }


    function addNotPaidInterestNotesToInvoice($invoiceId, $buyerTaxNo)
    {
        $interestNotes = $this->resolveInterestNotes($buyerTaxNo);
        $filterPaidInterestNotes = function ($note) {
            $paidNotePrefix = INTEREST_NOTE_PAID_FOLDER_NAME . '-';
            $len = strlen($paidNotePrefix);
            return (substr($note['name'], 0, $len) !== $paidNotePrefix);
        };

        $notPaidInterestNotes = array_filter($interestNotes, $filterPaidInterestNotes);

        if (count($notPaidInterestNotes) > 0) {
            $firstNote = $notPaidInterestNotes[0];
            $notePath = str_replace($firstNote['name'], '', $firstNote['path']);
            $resolveNoteName = function ($note) {
                return $note['name'];
            };
            $this->attachInterestNotesToInvoice($invoiceId, $notePath, array_map($resolveNoteName, $notPaidInterestNotes));
        }

        return array("status" => "OK", "notes" => $notPaidInterestNotes);
    }

    function attachInterestNotesToInvoice($invoiceNumber, $attachmentPath, $attachmentNames)
    {
        // configuration
        $token = FAKTUROWNIA_APITOKEN;
        $httpHost = FAKTUROWNIA_ENDPOINT;

        $invoicesUrl = "{$httpHost}/invoices/{$invoiceNumber}";

        // resolve s3 bucket credentials
        $url = "{$invoicesUrl}/get_new_attachment_credentials.json?api_token={$token}";
        $result = curl_get($url);

        if (isset($result['error'])) {
            return array_merge($result, array("Could not resolve s3 bucket credentials for new attachment. Error: {$result['message']}"));
        }
        $s3BucketCredentials = json_decode($result, true);
        unset($s3BucketCredentials['url']); // extra input fields are forbidden by s3 policy

        foreach ($attachmentNames as $attachmentName) {
            $attachmentFilePath = "{$attachmentPath}{$attachmentName}";
            $attachementFileNameWithPrefix = INTEREST_NOTE_NAME_PREFIX . $attachmentName;

            // send file to amazon s3 bucket
            $curlFile = new CURLFile(realpath($attachmentFilePath), 'application/pdf', $attachementFileNameWithPrefix);
            $amazonS3BucketUrl = 'https://s3-eu-west-1.amazonaws.com/fs.firmlet.com';

            $data = array_merge($s3BucketCredentials, array('file' => $curlFile));
            $result = curl_post($amazonS3BucketUrl, $data, false);
            if (isset($result['error'])) {
                return array_merge($result, array("message" => "Could not send file to s3 bucket. Error: {$result['message']}"));
            }

            // assign attachment to the invoice
            $url = "{$invoicesUrl}/add_attachment.json?api_token={$token}&file_name={$attachementFileNameWithPrefix}";
            $result = curl_post($url);
            if (isset($result['error'])) {
                return array_merge($result, array("Could not assign attachment {$attachementFileNameWithPrefix} to invoice {$invoiceNumber}. Error: {$result['error']}"));
            }
        }

        // set attachments are visible for the user
        $url = "{$invoicesUrl}.json";
        $data = array(
            "api_token" => $token,
            "invoice" => array(
                "show_attachments" => true
            )
        );
        $result = curl_put($url, $data);
        if (isset($result['error'])) {
            return array_merge($result, array("Could set attachments to be visible to the user for invoice {$invoiceNumber}. Error: {$result['error']}"));
        }

        return array("message" => "OK");
    }

    function getUpdatedPaymentsWithInvoiceId($clients) {
        foreach($clients as $client) {
            $client_tax_no = $client['nip'];
            $externalClient = $this->getClientByTaxNo($client_tax_no);
            // $externalClient['id']

        }
    }

}