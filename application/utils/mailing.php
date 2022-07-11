<?php
if (file_exists("c:/work/bok/library/phpmailer/PHPMailerAutoload.php")) {
    require_once "c:/work/bok/library/phpmailer/PHPMailerAutoload.php";
} else {
    require_once "/volume1/web/bok/library/phpmailer/PHPMailerAutoload.php";
}

class mailing
{


    function br2nl($html)
    {
        return preg_replace('#<br\s*/?>#i', "\n", $html);
    }

    function sendMailPrzydzielonoZlecenie($rowid, $mail, $tresc, $temat, $clientname,
                                          $osobazglaszajaca = '', $nrkontaktowy = '', $priority = '', $modelurzadzenia = '', $nrseryjny = '', $lokalizacja = '', $przebieg = '', $stantonera = '', $adresip = '', $firmware = '', $terminwykonania = '',
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
        $mailek->addReplyTo(FROM_CASE, NAME_CASE);
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
                                -Termin wykonania : {$terminwykonania}<br/>
                                -Piorytet : {$priority}<br/>
                                -Nazwa klienta : {$clientname}<br/>
                                -Osoba zgłaszająca :{$osobazglaszajaca}<br/>
                                -Nr kontaktowy do osoby zgłaszającej:<a href='tel:{$nrkontaktowy}'>{$nrkontaktowy}</a><br/>
                                -Model urządzenia:{$modelurzadzenia}<br/>
                                -NR Seryjny urządzenia:{$nrseryjny}<br/>
                                -Lokalizacja urządzenia: <a href='http://maps.google.com/maps?q={$lokalizacja}'>{$lokalizacja}</a><br/> 
                                -Przebieg:{$przebieg}<br/>
                                -Stan tonera:{$stantonera}<br/>
                                -Adres IP:{$adresip}<br/>
                                -Logi: <br/>{$printerLogs}
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
            $mailek->Body =
                "
                                Dziękujemy za kontakt i potwierdzamy zarejestrowanie zgłoszenia pod numerem <b>{$rowid} </b>.<br/>
                                Nasz pracownik zajmie się tym zleceniem tak szybko, jak to będzie możliwe.<br/>
                                Jeżeli będziesz kontynuować korespondencję prosimy o zachowanie tematu wiadomości - pozwoli to nam zidentyfikować Twoją sprawę.<br/>
                                <br/><br/>
                                Pozdrawiamy,<br/>
                                Otus Sp. z o.o.<br/>
                                +48 71 321 19 06<br/>
                                <a href='http://www.otus.pl/kontakt'>www.otus.pl/kontakt</a><br/>
                                <img src='http://www.otus.pl/templates/otus/images/obraz/logo.png' alt='Otus' title='Otus' border='0' height='82' width='150'></img>
                                <br/><br/>
                            
                            ";


            $mailek->AltBody =
                "
                                 Dziękujemy za kontakt i potwierdzamy zarejestrowanie zgłoszenia pod numerem <{$rowid}>
                                Nasz pracownik zajmie się tym zleceniem tak szybko, jak to będzie możliwe
                                Jeżeli będziesz kontynuować korespondencję prosimy o zachowanie tematu wiadomości - pozwoli to nam zidentyfikować Twoją sprawę

                                Pozdrawiamy,
                                Otus Sp. z o.o.
                                +48 71 321 19 06
                                www.otus.pl/kontakt
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
        $mailek->Body =
            "
                               Informujemy , że zlecenie o numerze {$rowid} zostało zakończone.<br/>
                                Państwa doświadczenie związane z realizacją tego zlecenia jest dla nas bardzo ważne i może być pomocne w ciągłym podnoszeniu jakości naszych usług.<br/>
                                Bardzo prosimy o wypełnienie krótkiej <a href='https://docs.google.com/forms/d/1zfEzgypY9bEAKs6BMstXnHsjMQX-2W5lpiodRQZSxrA/edit'>ankiety tutaj</a>.<br/>
                                Zależy nam na Państwa opinii. 
                                <br/>
                                Dziękujemy za poświęcenie czasu na podzielenie się z nami swoimi przemyśleniami.
                                <br/><br/>
                                Pozdrawiamy,<br/>
                                Otus Sp. z o.o.<br/>
                                +48 71 321 19 06<br/>
                                <a href='http://www.otus.pl'>www.otus.pl</a><br/>
                                <img src='http://www.otus.pl/templates/otus/images/obraz/logo.png' alt='Otus' title='Otus' border='0' height='82' width='150'></img>
                                <br/><br/>
                            
                            ";


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

    function sendNewMail($mailto, $tresc, $temat, $zalaczniki)
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