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
                                Dziękujemy za kontakt i potwierdzamy zarejestrowanie zgłoszenia pod numerem <b>{$rowid} </b>.&nbsp;
                                Zajmiemy się Twoją sprawą i udzielimy odpowiedzi najszybciej, jak to będzie możliwe.&nbsp;
                                Postaramy się, aby czas oczekiwania był możliwie najkrótszy.&nbsp;
                                Jeżeli będziesz kontynuować korespondencję prosimy o zachowanie tematu wiadomości - pozwoli nam to szybciej zidentyfikować Twoją sprawę.                                  
                                <br/><br/>
                                Zawsze służymy pomocą. W <a href='https://www.otus.pl/wsparcie/'>witrynie wsparcia Otus</a> znajdziesz wskazówki i rozwiązania które mogą pomóc rozwiązać Twoją sprawę.
                                <br/><br/>
                                W bardzo pilnych przypadkach prosimy o <a href=\"tel:+48713211906\">kontakt telefoniczny</a> podając numer tego zgłoszenia.
                                Pozdrawiamy <a href='https://www.otus.pl/kontakt/'>Wsparcie Otus</a>                            
                            ";


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


        $mailek->Body =  $tresc; // $this->getEmailBody($tresc);

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

    function getEmailBody($headerText)
    {
        return "
        <!DOCTYPE HTML PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
    <html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\">
    
    <head>
      <!--[if gte mso 9]>
    <xml>
      <o:OfficeDocumentSettings>
        <o:AllowPNG/>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
      <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
      <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
      <meta name=\"x-apple-disable-message-reformatting\">
      <!--[if !mso]><!-->
      <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
      <!--<![endif]-->
      <title></title>
    
      <style type=\"text/css\">
        @media only screen and (min-width: 620px) {
          .u-row {
            width: 600px !important;
          }
          .u-row .u-col {
            vertical-align: top;
          }
          .u-row .u-col-50 {
            width: 300px !important;
          }
          .u-row .u-col-100 {
            width: 600px !important;
          }
        }
        
        @media (max-width: 620px) {
          .u-row-container {
            max-width: 100% !important;
            padding-left: 0px !important;
            padding-right: 0px !important;
          }
          .u-row .u-col {
            min-width: 320px !important;
            max-width: 100% !important;
            display: block !important;
          }
          .u-row {
            width: calc(100% - 40px) !important;
          }
          .u-col {
            width: 100% !important;
          }
          .u-col>div {
            margin: 0 auto;
          }
        }
        
        body {
          margin: 0;
          padding: 0;
        }
        
        table,
        tr,
        td {
          vertical-align: top;
          border-collapse: collapse;
        }
        
        p {
          margin: 0;
        }
        
        .ie-container table,
        .mso-container table {
          table-layout: fixed;
        }
        
        * {
          line-height: inherit;
        }
        
        a[x-apple-data-detectors='true'] {
          color: inherit !important;
          text-decoration: none !important;
        }
        
        table,
        td {
          color: #000000;
        }
        
        a {
          color: #0000ee;
          text-decoration: underline;
        }
      </style>
    
    
    
      <!--[if !mso]><!-->
      <link href=\"https://fonts.googleapis.com/css?family=Cabin:400,700\" rel=\"stylesheet\" type=\"text/css\">
      <!--<![endif]-->
    
    </head>
    
    <body class=\"clean-body u_body\" style=\"margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #f9f9f9;color: #000000\">
      <!--[if IE]><div class=\"ie-container\"><![endif]-->
      <!--[if mso]><div class=\"mso-container\"><![endif]-->
      <table style=\"border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #f9f9f9;width:100%\" cellpadding=\"0\" cellspacing=\"0\">
        <tbody>
          <tr style=\"vertical-align: top\">
            <td style=\"word-break: break-word;border-collapse: collapse !important;vertical-align: top\">
              <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td align=\"center\" style=\"background-color: #f9f9f9;\"><![endif]-->
    
              <div class=\"u-row-container\" style=\"padding: 0px;background-color: transparent\">
                <div class=\"u-row\" style=\"Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;\">
                  <div style=\"border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;\">
                    <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding: 0px;background-color: transparent;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px;\"><tr style=\"background-color: #ffffff;\"><![endif]-->
    
                    <!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\" valign=\"top\"><![endif]-->
                    <div class=\"u-col u-col-100\" style=\"max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;\">
                      <div style=\"height: 100%;width: 100% !important;\">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style=\"padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\">
                          <!--<![endif]-->
    
                          <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                            <tbody>
                              <tr>
                                <td style=\"overflow-wrap:break-word;word-break:break-word;padding:20px;font-family:'Cabin',sans-serif;\" align=\"left\">
    
                                  <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                                    <tr>
                                      <td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\">
    
                                        <img align=\"center\" border=\"0\" src=\"https://www.otus.pl/wp-content/uploads/2021/06/logo_ot1.png\" alt=\"Image\" title=\"Image\" style=\"outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 100%;max-width: 110px;\"
                                          width=\"110\" />
                                      </td>
                                    </tr>
                                  </table>
    
                                </td>
                              </tr>
                            </tbody>
                          </table>
    
                          <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                      </div>
                    </div>
                    <!--[if (mso)|(IE)]></td><![endif]-->
                    <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                  </div>
                </div>
              </div>
    
    
    
              <div class=\"u-row-container\" style=\"padding: 0px;background-color: transparent\">
                <div class=\"u-row\" style=\"Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #003399;\">
                  <div style=\"border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;\">
                    <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding: 0px;background-color: transparent;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px;\"><tr style=\"background-color: #003399;\"><![endif]-->
    
                    <!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\" valign=\"top\"><![endif]-->
                    <div class=\"u-col u-col-100\" style=\"max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;\">
                      <div style=\"height: 100%;width: 100% !important;\">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style=\"padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\">
                          <!--<![endif]-->
    
                          <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                            <tbody>
                              <tr>
                                <td style=\"overflow-wrap:break-word;word-break:break-word;padding:40px 10px 10px;font-family:'Cabin',sans-serif;\" align=\"left\">
    
                                  <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                                    <tr>
                                      <td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\">
    
                                        <img align=\"center\" border=\"0\" src=\"https://www.otus.pl/wp-content/uploads/2021/08/Artboard-1-1024x639.png\" alt=\"Image\" title=\"Image\" style=\"outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 26%;max-width: 150.8px;\"
                                          width=\"150.8\" />
    
                                      </td>
                                    </tr>
                                  </table>
    
                                </td>
                              </tr>
                            </tbody>
                          </table>
    
                          <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                            <tbody>
                              <tr>
                                <td style=\"overflow-wrap:break-word;word-break:break-word;padding:0px 10px 31px;font-family:'Cabin',sans-serif;\" align=\"left\">
    
                                  <div style=\"color: #e5eaf5; line-height: 140%; text-align: center; word-wrap: break-word;\">
                                    <p style=\"font-size: 14px; line-height: 140%;\"><span style=\"font-size: 28px; line-height: 39.199999999999996px;\"><strong><span style=\"line-height: 39.199999999999996px; font-size: 28px;\">{$headerText}</span></strong>
                                      </span>
                                    </p>
                                  </div>
    
                                </td>
                              </tr>
                            </tbody>
                          </table>
    
                          <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                      </div>
                    </div>
                    <!--[if (mso)|(IE)]></td><![endif]-->
                    <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                  </div>
                </div>
              </div>
    
    
    
              <div class=\"u-row-container\" style=\"padding: 0px;background-color: transparent\">
                <div class=\"u-row\" style=\"Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;\">
                  <div style=\"border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;\">
                    <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding: 0px;background-color: transparent;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px;\"><tr style=\"background-color: #ffffff;\"><![endif]-->
    
                    <!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\" valign=\"top\"><![endif]-->
                    <div class=\"u-col u-col-100\" style=\"max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;\">
                      <div style=\"height: 100%;width: 100% !important;\">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style=\"padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\">
                          <!--<![endif]-->
    
                          <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                            <tbody>
                              <tr>
                                <td style=\"overflow-wrap:break-word;word-break:break-word;padding:33px 55px;font-family:'Cabin',sans-serif;\" align=\"left\">
    
                                  <div style=\"line-height: 160%; text-align: center; word-wrap: break-word;\">
                                    <p style=\"font-size: 14px; line-height: 160%;\"> </p>
                                    <p style=\"font-size: 14px; line-height: 160%;\"><strong><span style=\"font-size: 20px; line-height: 32px;\">Twoja opinia jest dla nas ważna</span></strong></p>
                                    <p style=\"font-size: 14px; line-height: 160%;\"><span style=\"font-size: 20px; line-height: 32px;\">Jeśli jesteś zadowolony z naszych usług powiedz o nas innym, jeżeli nie, <strong>powiedz nam</strong>, zrobimy wszystko, aby się poprawić.</span></p>
                                  </div>
    
                                </td>
                              </tr>
                            </tbody>
                          </table>
    
                          <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                      </div>
                    </div>
                    <!--[if (mso)|(IE)]></td><![endif]-->
                    <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                  </div>
                </div>
              </div>
    
    
    
              <div class=\"u-row-container\" style=\"padding: 0px;background-color: transparent\">
                <div class=\"u-row\" style=\"Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;\">
                  <div style=\"border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;\">
                    <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding: 0px;background-color: transparent;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px;\"><tr style=\"background-color: transparent;\"><![endif]-->
    
                    <!--[if (mso)|(IE)]><td align=\"center\" width=\"300\" style=\"width: 300px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;\" valign=\"top\"><![endif]-->
                    <div class=\"u-col u-col-50\" style=\"max-width: 320px;min-width: 300px;display: table-cell;vertical-align: top;\">
                      <div style=\"height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;\">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style=\"padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;\">
                          <!--<![endif]-->
    
                          <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                            <tbody>
                              <tr>
                                <td style=\"overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Cabin',sans-serif;\" align=\"left\">
    
                                  <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                                    <tr>
                                      <td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\">
                                        <a href=\"https://g.page/r/CYrqwLalBJ0qEAg/review\" target=\"_blank\">
                                          <img align=\"center\" border=\"0\" src=\"https://www.otus.pl/wp-content/uploads/2022/07/image.png\" alt=\"Zadowolony ? \" title=\"Zadowolony ? \" style=\"outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 100%;max-width: 280px;\"
                                            width=\"280\" />
                                        </a>
                                      </td>
                                    </tr>
                                  </table>
    
                                </td>
                              </tr>
                            </tbody>
                          </table>
    
                          <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                      </div>
                    </div>
                    <!--[if (mso)|(IE)]></td><![endif]-->
                    <!--[if (mso)|(IE)]><td align=\"center\" width=\"300\" style=\"width: 300px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;\" valign=\"top\"><![endif]-->
                    <div class=\"u-col u-col-50\" style=\"max-width: 320px;min-width: 300px;display: table-cell;vertical-align: top;\">
                      <div style=\"height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;\">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style=\"padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;\">
                          <!--<![endif]-->
    
                          <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                            <tbody>
                              <tr>
                                <td style=\"overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Cabin',sans-serif;\" align=\"left\">
    
                                  <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                                    <tr>
                                      <td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\">
                                        <a href=\"https://docs.google.com/forms/d/1zfEzgypY9bEAKs6BMstXnHsjMQX-2W5lpiodRQZSxrA/viewform?edit_requested=true\" target=\"_blank\">
                                          <img align=\"center\" border=\"0\" src=\"https://www.otus.pl/wp-content/uploads/2022/07/image-1.png\" alt=\"Niezadowolony ? \" title=\"Niezadowolony ? \" style=\"outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 100%;max-width: 280px;\"
                                            width=\"280\" />
                                        </a>
                                      </td>
                                    </tr>
                                  </table>
    
                                </td>
                              </tr>
                            </tbody>
                          </table>
    
                          <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                      </div>
                    </div>
                    <!--[if (mso)|(IE)]></td><![endif]-->
                    <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                  </div>
                </div>
              </div>
    
    
    
              <div class=\"u-row-container\" style=\"padding: 0px;background-color: transparent\">
                <div class=\"u-row\" style=\"Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #e5eaf5;\">
                  <div style=\"border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;\">
                    <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding: 0px;background-color: transparent;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px;\"><tr style=\"background-color: #e5eaf5;\"><![endif]-->
    
                    <!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\" valign=\"top\"><![endif]-->
                    <div class=\"u-col u-col-100\" style=\"max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;\">
                      <div style=\"height: 100%;width: 100% !important;\">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style=\"padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\">
                          <!--<![endif]-->
    
                          <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                            <tbody>
                              <tr>
                                <td style=\"overflow-wrap:break-word;word-break:break-word;padding:41px 55px 18px;font-family:'Cabin',sans-serif;\" align=\"left\">
    
                                  <div style=\"color: #003399; line-height: 160%; text-align: center; word-wrap: break-word;\">
                                    <p style=\"font-size: 14px; line-height: 160%;\"><span style=\"font-size: 16px; line-height: 25.6px; color: #000000;\">OTUS Sp. z o.o. <br />ul. Wrocławska 23 , 55-010 Radwanice<br />+48 71 321 19 06</span></p>
                                    <p style=\"font-size: 14px; line-height: 160%;\"><span style=\"font-size: 16px; line-height: 25.6px; color: #000000;\"><a rel=\"noopener\" href=\"mailto:info@otus.com.pl\" target=\"_blank\">info@otus.com.pl</a></span></p>
                                  </div>
    
                                </td>
                              </tr>
                            </tbody>
                          </table>
    
                          <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                      </div>
                    </div>
                    <!--[if (mso)|(IE)]></td><![endif]-->
                    <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                  </div>
                </div>
              </div>
    
    
    
              <div class=\"u-row-container\" style=\"padding: 0px;background-color: transparent\">
                <div class=\"u-row\" style=\"Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #003399;\">
                  <div style=\"border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;\">
                    <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding: 0px;background-color: transparent;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px;\"><tr style=\"background-color: #003399;\"><![endif]-->
    
                    <!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\" valign=\"top\"><![endif]-->
                    <div class=\"u-col u-col-100\" style=\"max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;\">
                      <div style=\"height: 100%;width: 100% !important;\">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div style=\"padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\">
                          <!--<![endif]-->
    
                          <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                            <tbody>
                              <tr>
                                <td style=\"overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Cabin',sans-serif;\" align=\"left\">
    
                                  <div style=\"color: #fafafa; line-height: 180%; text-align: center; word-wrap: break-word;\">
                                    <p style=\"font-size: 14px; line-height: 180%;\"><span style=\"font-size: 16px; line-height: 28.8px; color: #ffffff;\"><a rel=\"noopener\" href=\"https://www.otus.pl/kontakt/\" target=\"_blank\" style=\"color: #ffffff;\">Skonta<span style=\"font-size: 16px; line-height: 28.8px;\">ktuj się z nami</span></a>
                                      </span>
                                    </p>
                                  </div>
    
                                </td>
                              </tr>
                            </tbody>
                          </table>
    
                          <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                      </div>
                    </div>
                    <!--[if (mso)|(IE)]></td><![endif]-->
                    <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                  </div>
                </div>
              </div>
    
    
              <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
            </td>
          </tr>
        </tbody>
      </table>
      <!--[if mso]></div><![endif]-->
      <!--[if IE]></div><![endif]-->
    </body>
</html>
    ";
    }

}



?>