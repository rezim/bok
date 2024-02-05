<?php
if (file_exists("c:/work/bok/library/phpmailer/PHPMailerAutoload.php")) {
    require_once "c:/work/bok/library/phpmailer/PHPMailerAutoload.php";
} else {
    require_once "/volume1/web/bok/library/phpmailer/PHPMailerAutoload.php";
}

require_once "mailTemplates.php";

class mailing
{


    function br2nl($html)
    {
        return preg_replace('#<br\s*/?>#i', "\n", $html);
    }

    function sendMailPrzydzielonoZlecenie($rowid, $mail, $tresc, $temat, $clientname, $clientEmail = '',
                                          $osobazglaszajaca = '', $nrkontaktowy = '', $priority = '', $modelurzadzenia = '', $nrseryjny = '', $lokalizacja = '', $uwagi = '', $przebieg = '', $stantonera = '', $adresip = '', $firmware = '', $terminwykonania = '',
                                          $printerLogs, $dataZalacznikiFirst
    )
    {

        if (empty($mail) || $mail == '')
            return;

        $mailek = new PHPMailer;

        //$this->mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mailek->isSMTP();                                      // Set mailer to use SMTP
        $mailek->Host = SERWER_OTUS;  // Specify main and backup SMTP servers
        $mailek->SMTPAuth = true;                               // Enable SMTP authentication
        $mailek->Username = LOGIN_CASE;                 // SMTP username
        $mailek->Password = HASLO_CASE;                           // SMTP password
        $mailek->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mailek->Port = 587;                                    // TCP port to connect to

        $mailek->From = FROM_CASE;
        $mailek->FromName = NAME_CASE;
        $mailek->CharSet = 'UTF-8';
        $mailek->WordWrap = 50;                                 // Set word wrap to 50 characters

        if ($mail === TO_FRESHDESK_SUPPORT && $clientEmail !== '') {
            $mailek->addReplyTo($clientEmail, $clientname);
        } else {
            $mailek->addReplyTo(FROM_CASE, NAME_CASE);
        }
        $mailek->isHTML(true);


        $mailek->addAddress($mail);

        if (isset($dataZalacznikiFirst) && !empty($dataZalacznikiFirst)) {

            foreach ($dataZalacznikiFirst as $key => $item) {
                $mailek->AddAttachment($item['path'], $item['filename']);
            }

        }

        $mailek->Subject = $temat;
        $mailek->Body =
            "                                    
                                <b>Oryginalna wiadomość :</b><br/><br/>
                            "
            . $tresc
            . "<br/><br/>
                                Przydzielono nowe zgłoszenie do wykonania :<br/>
                                -Nr zgłoszenia: {$rowid}<br/>
                                -Nazwa klienta : {$clientname}<br/>
                                -Email klienta :  {$clientEmail}<br/>
                                -Osoba zgłaszająca : {$osobazglaszajaca}<br/>
                                -Nr kontaktowy do osoby zgłaszającej:<a href='tel:{$nrkontaktowy}'>{$nrkontaktowy}</a><br/>
                                -Model urządzenia:{$modelurzadzenia}<br/>
                                -NR Seryjny urządzenia:{$nrseryjny}<br/>
                                -Lokalizacja urządzenia: <a href='http://maps.google.com/maps?q={$lokalizacja}'>{$lokalizacja}</a><br/> 
                                -Uwagi:{$uwagi}<br/>
                            ";

        $mailek->AltBody =
            "
                                 Pojawiło się nowe zgłoszenie :
                                -Nr zgłoszenia: {$rowid}
                                Termin wykonania : {$terminwykonania}
                                -Nazwa klienta : {$clientname}
                            ";

        if (!$mailek->send()) {
            echo 'Błąd wysłania wiadomości.';
            echo 'Mailer Error: ' . $mailek->ErrorInfo;
        } else {

        }
    }

    function sendMailZarejestrowano($rowid, $mailto, $tresc, $temat)
    {

        if ($mailto != '') {
            $mailek = new PHPMailer;

            $this->mail->SMTPDebug = 3;                               // Enable verbose debug output

            $mailek->isSMTP();                                      // Set mailer to use SMTP
            $mailek->Host = SERWER_OTUS;  // Specify main and backup SMTP servers
            $mailek->SMTPAuth = true;                               // Enable SMTP authentication
            $mailek->Username = LOGIN_CASE;                 // SMTP username
            $mailek->Password = HASLO_CASE;                           // SMTP password
            $mailek->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mailek->Port = 587;                                    // TCP port to connect to

            $mailek->From = FROM_CASE;
            $mailek->FromName = NAME_CASE;
            $mailek->CharSet = 'UTF-8';
            $mailek->WordWrap = 50;                                 // Set word wrap to 50 characters
            $mailek->addReplyTo(FROM_CASE, NAME_CASE);
            $mailek->isHTML(true);
            $mailek->addAddress($mailto);     // Add a recipient


            $mailek->Subject = $temat;

            $templates = new mailTemplates();

            $mailek->Body = $templates->sendMailZarejestrowanoEmailTemplate($rowid);

            $mailek->AltBody =
                "
                                Dziękujemy za kontakt i potwierdzamy zarejestrowanie zgłoszenia pod numerem <{$rowid}>
                                Zajmiemy się Twoją sprawą i udzielimy odpowiedzi najszybciej, jak to będzie możliwe.
                                Postaramy się, aby czas oczekiwania był możliwie najkrótszy.                                
                                
                                Jeżeli będziesz kontynuować korespondencję prosimy o zachowanie tematu wiadomości - pozwoli nam to szybciej zidentyfikować Twoją sprawę.                                  
                                Zawsze służymy pomocą. W witrynie wsparcia Otus - https://www.otus.pl/wsparcie/ znajdziesz wskazówki i rozwiązania które mogą pomóc rozwiązać Twoją sprawę.                                
                                
                                W bardzo pilnych przypadkach prosimy o kontakt telefoniczny (tel: +48 71 321 19 06) podając numer tego zgłoszenia.
                                Pozdrawiamy Wsparcie Otus - https://www.otus.pl/kontakt/
                            ";

            if (!$mailek->send()) {
                echo 'Błąd wysłania wiadomości.';
                echo 'Mailer Error: ' . $mailek->ErrorInfo;
            } else {


                $_POST['notimailfields2'] = array(
                    'noti_rowid' => $rowid,
                    'email' => $mailto,
                    'temat' => $mailek->Subject,
                    'tresc_wiadomosci' => $this->br2nl($mailek->Body),
                    'date_email' => date('Y-m-d H:i:s'),
                    'size' => '0',
                    'user_insert' => '0',
                    'date_insert' => date('Y-m-d H:i:s'),
                    'activity' => '1',
                    'czywyslany' => '1',
                    'replyrowid' => '0',
                    'rowid' => ''
                );

                $notimail = new notimail();
                $notimail->populateFieldsToSave('notimailfields2', '0');

                $notimail->save();
                unset($notimail);


            }
            unset($mailek);
        }
    }

    function sendMailZakonczono($rowid, $mailto, $tresc, $temat)
    {

        if (empty($mailto) || $mailto == '')
            return;

        $mailek = new PHPMailer;

        //$this->mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mailek->isSMTP();                                      // Set mailer to use SMTP
        $mailek->Host = SERWER_OTUS;  // Specify main and backup SMTP servers
        $mailek->SMTPAuth = true;                               // Enable SMTP authentication
        $mailek->Username = LOGIN_CASE;                 // SMTP username
        $mailek->Password = HASLO_CASE;                           // SMTP password
        $mailek->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mailek->Port = 587;                                    // TCP port to connect to

        $mailek->From = FROM_CASE;
        $mailek->FromName = NAME_CASE;
        $mailek->CharSet = 'UTF-8';
        $mailek->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mailek->addReplyTo(FROM_CASE, NAME_CASE);
        $mailek->isHTML(true);
        $mailek->addAddress($mailto);     // Add a recipient


        $mailek->Subject = "Re: [Ticket#{$rowid}] . " . $temat;

        $templates = new mailTemplates();

        $mailek->Body = $templates->sendMailZakonczonoEmailTemplate($rowid);

        $mailek->AltBody =
            "
                                 Informujemy , że zlecenie o numerze <ID> zostało zakończone.
                                Państwa doświadczenie związane z realizacją tego zlecenia jest dla nas bardzo ważne i może być pomocne w ciągłym podnoszeniu jakości naszych usług.
                                Zależy nam na Państwa opinii.
                                Dziękujemy za poświęcenie czasu na podzielenie się z nami swoimi przemyśleniami.
                                Pozdrawiamy,
                                Otus Sp. z o.o.
                                +48 71 321 19 06
                                www.otus.pl
                            ";

        if (!$mailek->send()) {
            echo 'Błąd wysłania wiadomości.';
            echo 'Mailer Error: ' . $mailek->ErrorInfo;
        } else {

            $_POST['notimailfields2'] = array(
                'noti_rowid' => $rowid,
                'email' => $mailto,
                'temat' => $mailek->Subject,
                'tresc_wiadomosci' => $mailek->Body,
                'date_email' => date('Y-m-d H:i:s'),
                'size' => '0',
                'user_insert' => '0',
                'date_insert' => date('Y-m-d H:i:s'),
                'activity' => '1',
                'czywyslany' => '1',
                'replyrowid' => '0',
                'rowid' => ''
            );

            $notimail = new notimail();
            $notimail->populateFieldsToSave('notimailfields2', '0');

            $notimail->save();
            unset($notimail);

        }
    }

    function sendNewMail($mailto, $tresc, $temat, $zalaczniki = null, $mailFrom = null, $mailFromName = null)
    {


        if (empty($mailto) || $mailto == '')
            return;


        $mailek = new PHPMailer;

        //$this->mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mailek->isSMTP();                                      // Set mailer to use SMTP
        $mailek->Host = SERWER_OTUS;  // Specify main and backup SMTP servers
        $mailek->SMTPAuth = true;                               // Enable SMTP authentication
        $mailek->Username = LOGIN_CASE;                 // SMTP username
        $mailek->Password = HASLO_CASE;                           // SMTP password
        $mailek->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mailek->Port = 587;                                    // TCP port to connect to

        $mailek->From = $mailFrom ? $mailFrom : FROM_CASE;
        $mailek->FromName = $mailFromName ? $mailFromName : NAME_CASE;
        $mailek->CharSet = 'UTF-8';
        $mailek->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mailek->addReplyTo(FROM_CASE, NAME_CASE);
        $mailek->isHTML(true);
        $mailek->addAddress($mailto);     // Add a recipient


        $mailek->Subject = $temat;

        if (isset($zalaczniki) && !empty($zalaczniki)) {

            foreach ($zalaczniki as $key => $item) {
                $mailek->AddAttachment($item['path'], $item['filename']);
            }

        }


        $mailek->Body = $tresc; //  $this->getEmailWithPollBody($tresc);

        $mailek->AltBody = $tresc .
            "
                                     
                                    Pozdrawiamy,
                                    Otus Sp. z o.o.
                                    +48 71 321 19 06
                                    www.otus.pl
                                ";

        $result = $mailek->send();
        if (!$result) {
            echo 'Błąd wysłania wiadomości.';
            echo 'Mailer Error: ' . $mailek->ErrorInfo;
        } else {

        }

        return $result;
    }

    function sendNewOverduePaymentsMail($mailto, $tresc, $temat)
    {


        if (empty($mailto) || $mailto == '')
            return;

        $mailek = new PHPMailer;
        $mailek->isSMTP(); // Set mailer to use SMTP
        $mailek->Host = SERWER_OTUS; // Specify main and backup SMTP servers
        $mailek->SMTPAuth = true; // Enable SMTP authentication
        $mailek->Username = LOGIN_INVOICES; // LOGIN_CASE;                 // SMTP username
        $mailek->Password = HASLO_INVOICES; // HASLO_CASE;                           // SMTP password
        $mailek->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mailek->Port = 587;                                    // TCP port to connect to

        $mailek->From = LOGIN_INVOICES; // FROM_CASE;
        $mailek->FromName = NAME_INVOICES;
        $mailek->CharSet = 'UTF-8';
        $mailek->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mailek->addReplyTo(LOGIN_INVOICES, NAME_INVOICES);
        $mailek->isHTML(true);
        $mailek->addAddress($mailto);     // Add a recipient

        $mailek->Subject = $temat;

        $mailek->Body = $tresc
            . "Pozdrawiamy," . "<br />"
            . "Otus Sp. z o.o." . "<br />"
            . "+48 71 321 19 06" . "<br />"
            . "www.otus.pl";

        $mailek->AltBody = $tresc .
            "
                                     
                                    Pozdrawiamy,
                                    Otus Sp. z o.o.
                                    +48 71 321 19 06
                                    www.otus.pl
                                ";

        $result = $mailek->send();
        if (!$result) {
            echo 'Błąd wysłania wiadomości.';
            echo 'Mailer Error: ' . $mailek->ErrorInfo;
        } else {

        }

        return $result;
    }

    function sendInterestNoteEmail($mailto, $tresc, $temat, $zalaczniki)
    {
        if (empty($mailto) || $mailto == '')
            return;
        $mailek = new PHPMailer;

        $mailek->isSMTP(); // Set mailer to use SMTP
        $mailek->Host = SERWER_OTUS; // Specify main and backup SMTP servers
        $mailek->SMTPAuth = true; // Enable SMTP authentication
        $mailek->Username = LOGIN_INVOICES; // LOGIN_CASE;                 // SMTP username
        $mailek->Password = HASLO_INVOICES; // HASLO_CASE;                           // SMTP password
        $mailek->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mailek->Port = 587;                                    // TCP port to connect to

        $mailek->From = LOGIN_INVOICES; // FROM_CASE;
        $mailek->FromName = NAME_INVOICES;
        $mailek->CharSet = 'UTF-8';
        $mailek->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mailek->addReplyTo(LOGIN_INVOICES, NAME_INVOICES);
        $mailek->isHTML(true);
        $mailek->addAddress($mailto);     // Add a recipient


        $mailek->Subject = $temat;

        if (isset($zalaczniki) && !empty($zalaczniki)) {

            foreach ($zalaczniki as $key => $item) {
                $mailek->AddAttachment($item['path'], $item['filename']);
            }

        }


        $mailek->Body = $tresc;

        $mailek->AltBody = $tresc .
            "
                                     
                                    Pozdrawiamy,
                                    Otus Sp. z o.o.
                                    +48 71 321 19 06
                                    www.otus.pl
                                ";

        $result = $mailek->send();
        if (!$result) {
            echo 'Błąd wysłania wiadomości.';
            echo 'Mailer Error: ' . $mailek->ErrorInfo;
        } else {

        }

        return $result;
    }
}

?>