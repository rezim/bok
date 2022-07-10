<?php


$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$typ = 1;

if (mysqli_connect_errno()) {
    if ($typ == 0)
        file_put_contents(LOGFILE, 'Błąd:' . mysqli_connect_error() . date("Y-m-d H:i:s") . "\n", FILE_APPEND | LOCK_EX);
    else
        echo mysqli_connect_error();
    die();
}
$mysqli->query("SET NAMES 'utf8'");


class Email_reader2
{

    // imap server connection
    public $conn;

    // inbox storage and inbox message count
    private $inbox;
    private $msg_cnt;

    // email login credentials
    private $server = SERWER_CASE;
    private $user = LOGIN_CASE;
    private $pass = HASLO_CASE;


    // connect to the server and get the inbox emails
    function __construct()
    {
        $this->connect();
        $this->inbox();
    }

    // close the server connection
    function close()
    {
        $this->inbox = array();
        $this->msg_cnt = 0;

        imap_close($this->conn);
    }

    // open the server connection
    // the imap_open function parameters will need to be changed for the particular server
    // these are laid out to connect to a Dreamhost IMAP server
    function connect()
    {
        $this->conn = imap_open($this->server, $this->user, $this->pass);
        if (!$this->conn) {
            echo imap_last_error();
        }
    }

    // move the message to a new folder
    function move($msg_index, $folder = 'INBOX.Processed')
    {
        // move on server
        imap_mail_move($this->conn, $msg_index, $folder);
        imap_expunge($this->conn);

        // re-read the inbox
        $this->inbox();
    }

    // get a specific message (1 = first email, 2 = second email, etc.)
    function get($msg_index = NULL)
    {
        if (count($this->inbox) <= 0) {
            return array();
        } elseif (!is_null($msg_index) && isset($this->inbox[$msg_index])) {
            return $this->inbox[$msg_index];
        }

        return $this->inbox[0];
    }

    // read the inbox
    function inbox()
    {
        $this->msg_cnt = imap_num_msg($this->conn);

        $in = array();
        for ($i = 1; $i <= min($this->msg_cnt, 100); $i++) {
            $in[] = array(
                'index' => $i,
                'header' => imap_headerinfo($this->conn, $i),
                'structure' => imap_fetchstructure($this->conn, $i),
                'body' => $this->getBody($this->conn, $i)
            );

        }

        $this->inbox = $in;
    }

    function getBody($mail, $n)
    {

        $st = imap_fetchstructure($mail, $n);

        if (!empty($st->parts)) {
            for ($i = 0, $j = count($st->parts); $i < $j; $i++) {
                $part = $st->parts[$i];

                if ($part->subtype == 'PLAIN') {
                    $body = imap_fetchbody($mail, $n, $i + 1);
                } else {

                    $body = str_replace('&nbsp;', ' ', $this->strip_html_tags((imap_fetchbody($mail, $n, 1.2))));
                    if ($body == '') {
                        $body = str_replace('&nbsp;', ' ', $this->strip_html_tags((imap_fetchbody($mail, $n, 1.0))));
                    }

                }
            }
        } else {
            $body = imap_body($mail, $n);
        }

        $body = preg_replace("/[\r\n]+/", "\n", quoted_printable_decode($body));

        if ($this->is_utf8($body))
            return imap_utf8($body);
        else
            return iconv("ISO-8859-2", "UTF-8", imap_utf8($body));


    }

    function strip_html_tags($text)
    {
        $text = preg_replace(
            array(
                // Remove invisible content
                '@<head[^>]*?>.*?</head>@siu',
                '@<style[^>]*?>.*?</style>@siu',
                '@<script[^>]*?.*?</script>@siu',
                '@<object[^>]*?.*?</object>@siu',
                '@<embed[^>]*?.*?</embed>@siu',
                '@<applet[^>]*?.*?</applet>@siu',
                '@<noframes[^>]*?.*?</noframes>@siu',
                '@<noscript[^>]*?.*?</noscript>@siu',
                '@<noembed[^>]*?.*?</noembed>@siu',
                // Add line breaks before and after blocks
                '@</?((address)|(blockquote)|(center)|(del))@iu',
                '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
                '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
                '@</?((table)|(th)|(td)|(caption))@iu',
                '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
                '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
                '@</?((frameset)|(frame)|(iframe))@iu',
            ),
            array(
                ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
                "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
                "\n\$0", "\n\$0",
            ),
            $text);
        return strip_tags($text);
    }

    function is_utf8($str)
    {
        return (bool)preg_match('//u', $str);
    }


}

function getdecodevalue($message, $coding)
{
    switch ($coding) {
        case 0:
        case 1:
            $message = imap_8bit($message);
            break;
        case 2:
            $message = imap_binary($message);
            break;
        case 3:
        case 5:
            $message = imap_base64($message);
            break;
        case 4:
            $message = imap_qprint($message);
            break;
    }
    return $message;
}

function readEmailNotifications()
{
    global $mysqli;
    $emailReader = new Email_reader2();
    $count = 0;
    while (1) {

        $email = $emailReader->get();


        if (count($email) <= 0) {
            break;
        }
        $attachments = array();

        if (isset($email['structure']->parts) && count($email['structure']->parts)) {

            for ($i = 0; $i < count($email['structure']->parts); $i++) {

                $attachments[$i] = array(
                    'is_attachment' => FALSE,
                    'filename' => '',
                    'name' => '',
                    'attachment' => ''
                );


                if ($email['structure']->parts[$i]->ifdparameters) {
                    foreach ($email['structure']->parts[$i]->dparameters as $object) {

                        if (strtolower($object->attribute) == 'filename') {
                            $attachments[$i]['is_attachment'] = TRUE;
                            $attachments[$i]['filename'] = $object->value;
                        }
                    }
                }


                if ($email['structure']->parts[$i]->ifparameters) {
                    foreach ($email['structure']->parts[$i]->parameters as $object) {
                        if (strtolower($object->attribute) == 'name') {
                            $attachments[$i]['is_attachment'] = TRUE;
                            $attachments[$i]['name'] = $object->value;
                        }
                    }
                }


                if ($attachments[$i]['is_attachment']) {

                    $attachments[$i]['attachment'] = imap_fetchbody($emailReader->conn, $email['index'], $i + 1);


                    if ($email['structure']->parts[$i]->encoding == 3) { // 3 = BASE64
                        $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                    } elseif ($email['structure']->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
                        $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                    }
                }
            }
        }


        $datawiadomosc = date("Y-m-d H:i:s", $email['header']->udate);
        // for My Slow Low, check if I found an image attachment


        // get content from the email that I want to store
        $addr = $email['header']->from[0]->mailbox . "@" . $email['header']->from[0]->host;
        $sender = $email['header']->from[0]->mailbox;
        $subject = (!empty($email['header']->subject) ? imap_utf8($email['header']->subject) : '');


        if (empty($subject) || $subject == '' || strpos($subject, 'Undelivered') !== false) {
            $emailReader->move($email['index'], 'INBOX.Rejected');
            sleep(2);
            continue;
        }


        $tresc = $email['body'];

        $size = $email['header']->Size;
        // move the email to Processed folder on the server
        $emailReader->move($email['index'], 'INBOX.Processed');

        if (strpos($subject, "[ZlecenieSerwisowe#") !== false) {
            $ticketarray = "";
            $start = "\[";
            $end = "\]";
            preg_match("/\[[^\]]*\]/", $subject, $ticketarray);
            $reversNumber = "";


            foreach ($ticketarray as $key => $item) {
                if (strpos($item, "[ZlecenieSerwisowe#") !== false) {
                    $reversNumber = str_replace("]", "", str_replace("[ZlecenieSerwisowe#", "", $item));
                    break;
                }
            }

            if ($reversNumber !== "") {
                $_POST['email'] = $addr;
                $_POST['tresc_wiadomosci'] = $tresc;
                $_POST['temat'] = $subject;
                $_POST['revers_number'] = $reversNumber;

                $service = new service();

                $service->add($_POST, 'service_mails');
            }
        } else {

            $ticketarray = "";
            $start = "\[";
            $end = "\]";
            preg_match("/\[[^\]]*\]/", $subject, $ticketarray);
            $rowidCase = "";


            foreach ($ticketarray as $key => $item) {
                if (strpos($item, "[Ticket#") !== false) {
                    $rowidCase = str_replace("]", "", str_replace("[Ticket#", "", $item));
                    break;
                }
            }

            $_POST['fields'] = array(
                'rowid' => $rowidCase,
                'email' => $addr,
                'status' => '1',
                'temat' => $subject,
                'date_email' => $datawiadomosc,
                'tresc_wiadomosci' => $tresc,
                'user_insert' => '0',
                'date_insert' => date('Y-m-d H:i:s'),
                'activity' => '1'
            );


            $_POST['notimailfields'] = array(
                'email' => $addr,
                'temat' => $subject,
                'tresc_wiadomosci' => $tresc,
                'date_email' => $datawiadomosc,
                'size' => $size,
                'user_insert' => '0',
                'date_insert' => date('Y-m-d H:i:s'),
                'activity' => '1',
                'rowid' => '',
                'replyrowid' => '0',
                'czywyslany' => '0'
            );


            saveSprawa();

            saveMail($attachments);
        }
        // don't slam the server

        sleep(2);

    }

    // close the connection to the IMAP server
    $emailReader->close();

}

function saveSprawa()
{

    $noti = new notification();
    $noti->populateFieldsToSave('fields', '0');

    $wynik = $noti->save('1');

    if (isset($wynik['keyval'])) {

        $_POST['notimailfields']['noti_rowid'] = $wynik['keyval'];
        if (!strpos($_POST['notimailfields']['temat'], "[Ticket#"))
            $_POST['notimailfields']['temat'] = "[Ticket#{$wynik['keyval']}] " . $_POST['notimailfields']['temat'];
    }
    if (isset($wynik['isnew'])) {
        $mailing = new mailing();
        $mailing->sendMailZarejestrowano($_POST['notimailfields']['noti_rowid'],
            $_POST['notimailfields']['email'],
            nl2br($_POST['notimailfields']['tresc_wiadomosci']), $_POST['notimailfields']['temat']);
        unset($mailing);
    }
    unset($noti);
}

function saveMail($attachments)
{
    global $DOZWOLONETYPYPLIKOW;
    $notimail = new notimail();
    $notimail->populateFieldsToSave('notimailfields', '0');
    $wynik = $notimail->save();
    unset($notimail);

    if ($wynik['status'] == 1 && $wynik['isnew'] == 1) {

        $target_dir = SCIEZKAZALACZNIKI . MAILATTACH;
        $target_dir2 = MAILATTACH;

        $type = 'automat';
        $prefix = 'mails';


        if ($prefix != '') {
            $target_dir .= $prefix . '/';
            $target_dir2 .= $prefix . '/';
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
        }

        foreach ($attachments as $attachment) {
            if ($attachment['is_attachment'] == 1) {
                if (empty($attachment['name'])) {
                    $attachment['name'] = time() . ".dat";
                }
                $orgName = $attachment['name'];
                $ext = end((explode(".", $orgName)));
                $newfilename = $wynik['keyval'] . '_' . date('m-d-Y-his') . '.' . $ext;
                $target_file = $target_dir . $newfilename;
                $target_file2 = $target_dir2 . $newfilename;
                if (file_exists($target_file)) {
                    continue;
                }
                if (!in_array($type, $DOZWOLONETYPYPLIKOW)) {
                    continue;
                }


                $fp = fopen($target_file, "w+");
                fwrite($fp, $attachment['attachment']);
                fclose($fp);


                $sendfile = new sendfile();

                $sendfile->_filedsToEdit['prefix']['value'] = $prefix;
                $sendfile->_filedsToEdit['rowid_parent']['value'] = $wynik['keyval'];
                $sendfile->_filedsToEdit['newname']['value'] = $newfilename;
                $sendfile->_filedsToEdit['newpath']['value'] = $target_file2;
                $sendfile->_filedsToEdit['extension']['value'] = $ext;
                $sendfile->_filedsToEdit['oldname']['value'] = $orgName;
                $sendfile->_filedsToEdit['filetype']['value'] = $type;
                $sendfile->_filedsToEdit['size']['value'] = filesize($target_file);
                $sendfile->_filedsToEdit['activity']['value'] = 1;
                $sendfile->_filedsToEdit['rowid']['value'] = '0';
                $sendfile->_filedsToEdit['user_insert']['value'] = '0';


                $wynikzapisu = $sendfile->save();

                unset($sendfile);
            }

        }

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