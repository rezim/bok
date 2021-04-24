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


class Email_reader
{

    // imap server connection
    public $conn;

    // inbox storage and inbox message count
    private $inbox;
    private $msg_cnt;

    // email login credentials
    private $server = SERWER;
    private $user = LOGIN;
    private $pass = HASLO;


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
        if (!$imap) {
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
                'detailed_header' => explode("\n", imap_fetchheader($this->conn, $i)),
                'body' => imap_fetchbody($this->conn, $i, 1),
                'structure' => imap_fetchstructure($this->conn, $i)
            );
        }

        $this->inbox = $in;
    }

}

function email_pull()
{
     // _readfileXML('2018-01-01', "'192.168.1.1'");
     // die();

    global $mysqli;
    $emailReader = new Email_reader();

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

        $ip = getIpAddress($email['detailed_header']);

        // for My Slow Low, check if I found an image attachment

        // TR NOTE: check if body contains information indicates minolta service data
        if (
            (($minoltaMessage = isMinoltaServiceMessage($email['body'])) != null)
            ||
            (($minoltaMessage = isMinoltaServiceMessage(base64_decode ($email['body']))) != null)
        ) {
            if (!saveMinoltaDataDevice($minoltaMessage)) {
                $emailReader->move($email['index'], 'INBOX.Rejected');
                continue;
            }

        // TR NOTE: check if subject contains the search text,
        //          this is because is could contains 'Fw:' 'Re:', others
        } else if (strpos($email['header']->subject, TEMATMINOLTA) !== false) {
            if (!_readMinolta($email['body'], $datawiadomosc, $ip)) {
                $emailReader->move($email['index'], 'INBOX.Rejected');
                continue;
            }

        } else if (strpos($email['header']->subject, TEMATKYOCERA) !== false) {
            // TR NOTE:
            // KYOCERA sends two emails, second one which is currently not very useful to us do NOT contains
            // 'event email' text, we will ignore it
            if (strpos($email['header']->subject, 'event mail') !== false) {
                if (!_readKyocera(base64_decode($email['body']), $datawiadomosc, $ip)) {
                    $emailReader->move($email['index'], 'INBOX.Rejected');
                    continue;
                }
            } else {
                $emailReader->move($email['index'], 'INBOX.Rejected');
                continue;
            }
        } else {
            $found_img = FALSE;
            foreach ($attachments as $a) {

                if ($a['is_attachment'] == 1) {
                    //     get information on the file
                    $finfo = pathinfo($a['filename']);

                    // check if the file is a jpg, png, or gif
                    if (preg_match('/(xml)/i', $finfo['extension'], $n)) {

                        $found_img = TRUE;
                        // process the image (save, resize, crop, etc.)
                        _process_xml($a['attachment'], $n[1]);

                        if (!_readfileXML($datawiadomosc, $ip)) {

                            $found_img = FALSE;
                        }
                        break;
                    }
                }
            }

            // if there was no image, move the email to the Rejected folder on the server
            if (!$found_img) {

                $emailReader->move($email['index'], 'INBOX.Rejected');
                continue;
            }
        }

        // get content from the email that I want to store
        $addr = $email['header']->from[0]->mailbox . "@" . $email['header']->from[0]->host;
        $sender = $email['header']->from[0]->mailbox;
        $subject = (!empty($email['header']->subject) ? $email['header']->subject : '');


        $size = $email['header']->Size;
        // move the email to Processed folder on the server
        $emailReader->move($email['index'], 'INBOX.Processed');

        $query = "insert into mails(sender,subject,datemail,size,dateimport, address_ip) values
                            ('{$addr}','{$subject}','{$datawiadomosc}','{$size}','" . date('Y-m-d H:i:s') . "', $ip)";

        if ($result = mysqli_query($mysqli, $query)) {
            if ($typ == 1)
                echo("Zapisano readtime : " . $query . "<br/>");
        } else {
            if ($typ == 0)
                file_put_contents(LOGFILE, 'Błąd zapisu odczytu maila:' . mysqli_error($mysqli) . date("Y-m-d H:i:s") . "\n\n", FILE_APPEND | LOCK_EX);
            else
                echo $mysqli->error;
        }

        // don't slam the server

        sleep(2);
    }

    // close the connection to the IMAP server
    $emailReader->close();
}


function _process_xml($atach, $b)
{
    file_put_contents(SCIEZKAPLIKU, $atach);

}

function _readOnlyfileXML()
{

    $dom = new DOMDocument();

    $dom->load(SCIEZKAPLIKU);
    // check if this is new HP format
    if ($dom->firstChild->tagName == 'dev:DeviceService') {
        $dataDevice = getHPDataDevice($dom);
    } else {
        $dataDevice = getOldHPDataDevice($dom);
    }


    print_r($dataDevice['system']);

    die();
    unset($dom);
    unset($dataDevice);
    return true;
}

function _readMinolta($message, $dataWiadomosci, $ip)
{

    $dataDevice = getDataDeviceMinolta($message);

    if (count($dataDevice) == 0) {
        return false;
    }
    if ($dataDevice['system']['dd:SerialNumber'] != '')
        saveDataDevice($dataDevice, $dataWiadomosci, $ip);

    unset($message);
    unset($dataDevice);
    return true;
}

function _readKyocera($message, $dataWiadomosci, $ip) {
    $dataDevice = getDataDeviceKyocera($message, $dataWiadomosci, $ip);

    if (count($dataDevice) == 0) {
        return false;
    }
    if ($dataDevice['system']['dd:SerialNumber'] != '')
        saveDataDevice($dataDevice, $dataWiadomosci, $ip);

    unset($message);
    unset($dataDevice);
    return true;
}

function _readfileXML($dataWiadomosci, $ip)
{

    $dom = new DOMDocument();

    $dom->load(SCIEZKAPLIKU);

    // check if this is new HP format
    if ($dom->firstChild->tagName == 'dev:DeviceService') {
        $dataDevice = getHPDataDevice($dom);
    } else {
        $dataDevice = getOldHPDataDevice($dom);
    }

    if (count($dataDevice) == 0) {
        return false;
    }
    if ($dataDevice['system']['dd:SerialNumber'] != '')
        saveDataDevice($dataDevice, $dataWiadomosci, $ip);

    unset($dom);
    unset($dataDevice);
    return true;
}

function debug_print($val)
{
    print('<pre>');
    print_r($val);
    print('<pre>');
}

function getCounterValue($counter)
{
    $counterValue = 0;
    $fixedPointNumber = $counter->getElementsByTagName('FixedPointNumber');
    if ($fixedPointNumber->length > 0 &&
        $fixedPointNumber[0]->getElementsByTagName('Significand')->length > 0
    ) {
        $significand = $fixedPointNumber[0]->getElementsByTagName('Significand')[0];
        $counterValue = $significand->nodeValue;
    }

    return $counterValue;
}

// <dev:DeviceService>
//  <dev:TicketMetaData></>
//  <config:SystemConfigurationService></>
//  <print:PrintService></>
//  <dusi:DeviceUsageService></>
// </dev:DeviceService>
function getHPDataDevice($dom)
{
    $assoc = array();

    $printService = $dom->getElementsByTagName('PrintService');

    // get system configuration
    $systemConfigurationService = $dom->getElementsByTagName('SystemConfigurationService');

    if ($systemConfigurationService->length > 0) {
        if ($systemConfigurationService[0]->getElementsByTagName('DeviceIdentification')->length > 0) {
            foreach ($systemConfigurationService[0]->getElementsByTagName('DeviceIdentification')[0]->childNodes as $deviceIdent) {
                if ($deviceIdent->nodeName != '#text') {
                    $assoc['system'][$deviceIdent->nodeName] = $deviceIdent->nodeValue;
                }
            }
        }
        if ($systemConfigurationService[0]->getElementsByTagName('DeviceInformation')->length > 0 &&
            $systemConfigurationService[0]->getElementsByTagName('DeviceInformation')[0]->getElementsByTagName('ServiceID')->length > 0
        ) {
            $serviceID = $systemConfigurationService[0]->getElementsByTagName('DeviceInformation')[0]->getElementsByTagName('ServiceID')[0];
            $assoc['system'][$serviceID->nodeName] = $serviceID->nodeValue;
        }
        // <log:Logs>
        if ($systemConfigurationService[0]->getElementsByTagName('Logs')->length > 0) {
            $arrLogs = array();
            $logs = $systemConfigurationService[0]->getElementsByTagName('Logs')[0];
            foreach($logs->getElementsByTagName('Log') as $log) {
                $type = ($log->getElementsByTagName('Type')->length > 0) ?
                    $log->getElementsByTagName('Type')[0]->nodeValue : '';
                if ($type === 'error') {
                    $entries = $log->getElementsByTagName('Entries');
                    if ($entries->length > 0) {
                        foreach ($entries[0]->getElementsByTagName('Entry') as $entry) {
                            foreach ($entry->childNodes as $entryRow) {
                                switch ($entryRow->nodeName) {
                                    case 'dd:SequenceNumber':
                                        $arrLogs['sequencenumber'] = $entryRow->nodeValue;
                                        break;
                                    case 'dd:EventCode':
                                        $arrLogs['eventcode'] = $entryRow->nodeValue;
                                        break;
                                    case 'dd:Description':
                                        $arrLogs['description'] = '[' . $type . ']' . $entryRow->nodeValue;
                                        break;
                                    case 'dd:TimeStamp':
                                        $arrLogs['timestamp'] = $entryRow->nodeValue;
                                        break;
                                    case 'ct:Counter':
                                    case 'Counter':
                                        if ($entryRow->getElementsByTagName('FixedPointNumber')->length > 0) {
                                            $fixedPointNumber = $entryRow->getElementsByTagName('FixedPointNumber')[0];
                                            if ($fixedPointNumber->getElementsByTagName('Significand')->length > 0) {
                                                $arrLogs['valuefloat'] =
                                                    $fixedPointNumber->getElementsByTagName('Significand')[0]->nodeValue;
                                            }
                                        }
                                        break;
                                    case 'log:Payload':
                                        foreach ($entryRow->getElementsByTagName('KeyValuePair') as $keyValuePair) {
                                            if ($keyValuePair->getElementsByTagName('Key')[0]->nodeValue == 'FirmwareVersion') {
                                                $arrLogs['revision'] =
                                                    $keyValuePair->getElementsByTagName('ValueString')[0]->nodeValue;
                                                break;
                                            }
                                        }
                                        break;
                                }
                            }

                            $assoc['logs'][] = $arrLogs;
                        }
                    }
                }
            }
        }
    }
    // end get system configuration

    // this means that we are not able to read device information,
    // there is no sens to continue
    if (empty($assoc)) return $assoc;

    // get device usage information
    $deviceUsageService = $dom->getElementsByTagName('DeviceUsageService');

    if ($deviceUsageService->length > 0) {
        $printerSubunit = $deviceUsageService[0]->getElementsByTagName('PrinterSubunit');
        if ($printerSubunit->length > 0) {
            $counterGroups = $printerSubunit[0]->getElementsByTagName('CounterGroup');

            foreach ($counterGroups as $counterGroup) {
                $groupName = $counterGroup->getElementsByTagName('CounterGroupName');

                if ($groupName->length > 0 && $groupName->item(0)->nodeValue == 'ImpressionsByMediaSizeID') {

                    $monochromeImpressions = $colorImpressions = $totalImpressions = 0;
                    $mediaGroups = $counterGroup->getElementsByTagName('CounterGroup');
                    foreach ($mediaGroups as $mediaGroup) {
                        $counters = $mediaGroup->getElementsByTagName('Counter');

                        foreach ($counters as $counter) {
                            $counterType = $counter->getElementsByTagName('CounterName')->item(0);
                            if ($counterType->nodeValue == 'MonochromeImpressions') {
                                $monochromeImpressions += getCounterValue($counter);
                            }
                            if ($counterType->nodeValue == 'ColorImpressions') {
                                $colorImpressions += getCounterValue($counter);
                            }
                            if ($counterType->nodeValue == 'TotalImpressions') {
                                $totalImpressions += getCounterValue($counter);
                            }
                        }
                    }

                    $assoc['system']['wydruk'] = $monochromeImpressions;
                    $assoc['system']['wydrukkolor'] = $colorImpressions;
                    $assoc['system']['wydruktotal'] = $totalImpressions;
                }
            }
        }
    }

    // end device information

    return $assoc;
}

function getOldHPDataDevice($dom)
{
    $assoc = array();

    $bookElemList = $dom->getElementsByTagName('Information');
    foreach ($bookElemList as $book) {
        foreach ($book->childNodes as $book2) {
            if ($book2->nodeName == 'xdm:Component') {
                if ($book2->getAttribute('id') == 'system' || $book2->getAttribute('id') == 'iSystem') {
                    foreach ($book2->childNodes as $book3) {
                        if ($book3->nodeName == 'dd:Version') {
                            $assoc['system'][$book3->nodeName] = getChildNodes($book3);

                        } else {
                            $assoc['system'][$book3->nodeName] = $book3->nodeValue;
                        }
                    }
                }
                if ($book2->getAttribute('id') == 'blackToner' || $book2->getAttribute('id') == 'iBlackToner') {

                    foreach ($book2->childNodes as $book3) {

                        if ($book3->nodeName == 'dd:Capacity' && ($book3->getAttribute('id') == 'BlackTonerSystem' || $book3->getAttribute('id') == 'blackTonerSysCapacity')) {
                            foreach ($book3->childNodes as $book4) {
                                if ($book4->nodeName == 'dd:MaxCapacity') {
                                    $assoc['system']['tonermax'] = $book4->nodeValue;
                                    $assoc['tonerek']['tonermax'] = $book4->nodeValue;
                                }
                            }
                        }
                        if ($book3->nodeName == 'dd:Description') {
                            $assoc['tonerek']['description'] = $book3->nodeValue;
                        }
                        if ($book3->nodeName == 'dd:ProductNumber') {
                            $assoc['tonerek']['productnumber'] = $book3->nodeValue;
                        }
                        if ($book3->nodeName == 'dd:SerialNumber') {
                            $assoc['tonerek']['serialnumber'] = $book3->nodeValue;
                        }
                        if ($book3->nodeName == 'dd:Installation') {
                            $assoc['tonerek']['installation'] = $book3->nodeValue;
                        }
                    }

                }
                if ($book2->getAttribute('id') == 'cyanToner' || $book2->getAttribute('id') == 'iCyanToner') {

                    foreach ($book2->childNodes as $book3) {

                        if ($book3->nodeName == 'dd:Capacity' && ($book3->getAttribute('id') == 'CyanTonerSystem' || $book3->getAttribute('id') == 'cyanTonerSysCapacity')) {
                            foreach ($book3->childNodes as $book4) {
                                if ($book4->nodeName == 'dd:MaxCapacity') {
                                    $assoc['tonerekcyan']['tonermax'] = $book4->nodeValue;
                                }
                            }
                        }
                        if ($book3->nodeName == 'dd:Description') {
                            $assoc['tonerekcyan']['description'] = $book3->nodeValue;
                        }
                        if ($book3->nodeName == 'dd:ProductNumber') {
                            $assoc['tonerekcyan']['productnumber'] = $book3->nodeValue;
                        }
                        if ($book3->nodeName == 'dd:SerialNumber') {
                            $assoc['tonerekcyan']['serialnumber'] = $book3->nodeValue;
                        }
                        if ($book3->nodeName == 'dd:Installation') {
                            $assoc['tonerekcyan']['installation'] = $book3->nodeValue;
                        }
                    }

                }
                if ($book2->getAttribute('id') == 'magentaToner' || $book2->getAttribute('id') == 'iMagentaToner') {

                    foreach ($book2->childNodes as $book3) {

                        if ($book3->nodeName == 'dd:Capacity' && ($book3->getAttribute('id') == 'MagentaTonerSystem' || $book3->getAttribute('id') == 'magentaTonerSysCapacity')) {
                            foreach ($book3->childNodes as $book4) {
                                if ($book4->nodeName == 'dd:MaxCapacity') {
                                    $assoc['tonerekmagenta']['tonermax'] = $book4->nodeValue;
                                }
                            }
                        }
                        if ($book3->nodeName == 'dd:Description') {
                            $assoc['tonerekmagenta']['description'] = $book3->nodeValue;
                        }
                        if ($book3->nodeName == 'dd:ProductNumber') {
                            $assoc['tonerekmagenta']['productnumber'] = $book3->nodeValue;
                        }
                        if ($book3->nodeName == 'dd:SerialNumber') {
                            $assoc['tonerekmagenta']['serialnumber'] = $book3->nodeValue;
                        }
                        if ($book3->nodeName == 'dd:Installation') {
                            $assoc['tonerekmagenta']['installation'] = $book3->nodeValue;
                        }
                    }

                }
                if ($book2->getAttribute('id') == 'yellowToner' || $book2->getAttribute('id') == 'iYellowToner') {

                    foreach ($book2->childNodes as $book3) {

                        if ($book3->nodeName == 'dd:Capacity' && ($book3->getAttribute('id') == 'YellowTonerSystem' || $book3->getAttribute('id') == 'yellowTonerSysCapacity')) {
                            foreach ($book3->childNodes as $book4) {
                                if ($book4->nodeName == 'dd:MaxCapacity') {
                                    $assoc['tonerekyellow']['tonermax'] = $book4->nodeValue;
                                }
                            }
                        }
                        if ($book3->nodeName == 'dd:Description') {
                            $assoc['tonerekyellow']['description'] = $book3->nodeValue;
                        }
                        if ($book3->nodeName == 'dd:ProductNumber') {
                            $assoc['tonerekyellow']['productnumber'] = $book3->nodeValue;
                        }
                        if ($book3->nodeName == 'dd:SerialNumber') {
                            $assoc['tonerekyellow']['serialnumber'] = $book3->nodeValue;
                        }
                        if ($book3->nodeName == 'dd:Installation') {
                            $assoc['tonerekyellow']['installation'] = $book3->nodeValue;
                        }
                    }

                }
            }

        }
    }

    if (empty($assoc)) return $assoc;


    $bookElemList = $dom->getElementsByTagName('BSIService');
    foreach ($bookElemList as $book) {
        $ip = '';
        foreach ($book->childNodes as $book2) {

            if ($book2->nodeName == 'bsi:LocationURI') {

                $tekst = str_replace('https://', '', str_replace('http://', '', $book2->nodeValue . replace));
                $ip = substr
                (
                    $tekst,
                    0,
                    strpos($tekst, '/')
                );
                if ($ip != '')
                    $assoc['system']['ip'] = $ip;
                break;

            }

        }
        if ($ip != '') break;
    }
    $bookElemList = $dom->getElementsByTagName('Status');
    $black = '';
    foreach ($bookElemList as $book) {
        foreach ($book->childNodes as $book2) {

            if ($book2->nodeName == 'xdm:StatusGroup') {

                foreach ($book2->childNodes as $book3) {

                    if ($book3->nodeName == 'xdm:StatusCollection' && $book3->getAttribute('idRef') == 'blackTonerSysCapacity') {
                        foreach ($book3->childNodes as $book4) {
                            if ($book4->nodeName == 'dd:Level') {
                                $a = str_replace('unknown', '', $book4->nodeValue);
                                $assoc['tonerek']['pozostalo'] = $a;
                                $assoc['system']['black_toner'] =
                                    100 -
                                    (($assoc['system']['tonermax'] - $a) / $assoc['system']['tonermax']) * 100;
                            }
                        }


                        break;
                    }
                }
            }

            if ($book2->nodeName == 'xdm:StatusCollection') {
                switch ($book2->getAttribute('idRef')) {
                    case 'iBlackToner':
                        $a = str_replace('impressions', '', $book2->nodeValue);
                        $a = str_replace('unknown', '', $a);
                        $assoc['tonerek']['pozostalo'] = $a;
                        if ($assoc['system']['tonermax'] == 0)
                            $assoc['system']['black_toner'] = 0;
                        else
                            $assoc['system']['black_toner'] =
                                100 -
                                (($assoc['system']['tonermax'] - $a) / $assoc['system']['tonermax']) * 100;
                        break;
                    case 'iCyanToner':
                        foreach ($book2->childNodes as $book3) {
                            if ($book3->nodeName == 'dd:Level') {
                                $assoc['tonerekcyan']['pozostalo'] = $book3->nodeValue;
                                break;
                            }
                        }

                        break;
                    case 'iCyanTonerElabel':
                        $assoc['system']['cyan_toner'] = str_replace('percent', '', $book2->nodeValue);
                        break;
                    case 'iMagentaToner':
                        foreach ($book2->childNodes as $book3) {
                            if ($book3->nodeName == 'dd:Level') {
                                $assoc['tonerekmagenta']['pozostalo'] = $book3->nodeValue;
                                break;
                            }
                        }

                        break;
                    case 'iMagentaTonerElabel':
                        $assoc['system']['magenta_toner'] = str_replace('percent', '', $book2->nodeValue);
                        break;
                    case 'iYellowToner':
                        foreach ($book2->childNodes as $book3) {
                            if ($book3->nodeName == 'dd:Level') {
                                $assoc['tonerekyellow']['pozostalo'] = $book3->nodeValue;
                                break;
                            }
                        }

                        break;
                    case 'iYellowTonerElabel':
                        $assoc['system']['yellow_toner'] = str_replace('percent', '', $book2->nodeValue);
                        break;
                    case 'iBlackDrumElabel':
                        $assoc['system']['blackdrum_toner'] = str_replace('percent', '', $book2->nodeValue);
                        break;
                    case 'iCyanDrumElabel':
                        $assoc['system']['cyandrum_toner'] = str_replace('percent', '', $book2->nodeValue);
                        break;
                    case 'iMagentaDrumElabel':
                        $assoc['system']['magentadrum_toner'] = str_replace('percent', '', $book2->nodeValue);
                        break;
                    case 'iYellowDrumElabel':
                        $assoc['system']['yellowdrum_toner'] = str_replace('percent', '', $book2->nodeValue);
                        break;
                }
            }
        }
    }

    $bookElemList = $dom->getElementsByTagName('Data');
    $count = 0;
    $count2 = 0;
    $rozaj = '';
    $iloscBlack = '';
    $iloscColor = '';
    $iloscTotal = '';

    if ($assoc['system']['dd:MakeAndModel'] !== 'HP LaserJet P3010 Series') {

        foreach ($bookElemList as $book) {
            foreach ($book->childNodes as $book2) {

                if ($book2->nodeName == 'xdm:DataItem' && $book2->getAttribute('idRef') == 'system') {
                    foreach ($book2->childNodes as $book3) {

                        foreach ($book3->childNodes as $book4) {

                            if ($book4->nodeName == 'dd:CounterScale')
                                $rozaj = $book4->nodeValue;
                            if ($book4->nodeName == 'dd:ValueFloat') {

                                $ilosc = $book4->nodeValue;
                            }
                        }
                        $iloscBlack = $ilosc;

                        $iloscTotal = $ilosc;
                        if ($rozaj == 'normalized')
                            break;
                    }
                    $count++;
                    if ($count == 1) break;
                } else if ($book2->nodeName == 'xdm:DataItem' && $book2->getAttribute('idRef') == 'iSystem') {

                    foreach ($book2->childNodes as $book3) {
                        $wartosc = "";
                        $chromatic = "";
                        foreach ($book3->childNodes as $book4) {
                            if ($book4->nodeName == 'dd:ValueFloat') {
                                $wartosc = $book4->nodeValue;
                            }
                            if ($book4->nodeName == 'dd:ChromaticMode') {
                                $chromatic = $book4->nodeValue;
                            }


                        }
                        if ($chromatic == 'color') {
                            $iloscColor = $wartosc;
                        }
                        if ($chromatic == 'monochrome') {
                            $iloscBlack = $wartosc;
                        }
                        if ($chromatic == '') {
                            $iloscTotal = $wartosc;
                        }

                    }


                    $count2++;
                    if ($count2 == 2) break;
                } else
                    break;

            }
        }

    } else {
        // this is for 'HP LaserJet P3010 Series' printers, probably we have to check other printers
        // if they should be processed in the same way
        foreach ($bookElemList as $book) {
            foreach ($book->childNodes as $book2) {
                if ($book2->nodeName == 'xdm:DataItem' && $book2->getAttribute('idRef') == 'iSystem') {

                    foreach ($book2->childNodes as $book3) {
                        $wartosc = "";
                        $chromatic = "";
                        foreach ($book3->childNodes as $book4) {
                            if ($book4->nodeName == 'dd:ValueFloat') {
                                $wartosc = intval( $book4->nodeValue );
                            }
                            if ($book4->nodeName == 'dd:ChromaticMode') {
                                $chromatic = intval( $book4->nodeValue );
                            }


                        }
                        if ($chromatic == 'color') {
                            $iloscColor = $wartosc;
                        }
                        if ($chromatic == 'monochrome') {
                            $iloscBlack = $wartosc;
                        }
                        if ($chromatic == '') {
                            $iloscTotal = $wartosc;
                        }

                    }
                    break; // :(
                } else
                    break;

            }
        }
    }

    if ($iloscColor == "") {
        $assoc['system']['wydruk'] = $iloscTotal;
        $assoc['system']['wydrukkolor'] = "";
        $assoc['system']['wydruktotal'] = $iloscTotal;
    } else {
        $assoc['system']['wydruk'] = $iloscBlack;
        $assoc['system']['wydrukkolor'] = $iloscColor;
        $assoc['system']['wydruktotal'] = $iloscTotal;
    }


    $bookElemList = $dom->getElementsByTagName('Logs');
    foreach ($bookElemList as $book) {
        foreach ($book->childNodes as $book2) {
            if ($book2->nodeName == 'xdm:Log' && ($book2->getAttribute('idRef') == 'system' || $book2->getAttribute('idRef') == 'iSystem')) {

                foreach ($book2->childNodes as $book3) {
                    if ($book3->nodeName == 'dd:Event') {
                        $assocTemp = array();
                        foreach ($book3->childNodes as $book4) {

                            switch ($book4->nodeName) {
                                case 'dd:SequenceNumber':
                                    $assocTemp['sequencenumber'] = $book4->nodeValue;
                                    break;
                                case 'dd:EventCode':
                                    $assocTemp['eventcode'] = $book4->nodeValue;
                                    break;
                                case 'dd:Description':
                                    $assocTemp['description'] = $book4->nodeValue;
                                    break;
                                case 'dd:TimeStamp':
                                    $assocTemp['timestamp'] = $book4->nodeValue;
                                    break;
                                case 'count:Counter':
                                    foreach ($book4->childNodes as $book5) {
                                        if ($book5->nodeName == 'dd:ValueFloat') {
                                            $assocTemp['valuefloat'] = $book5->nodeValue;
                                            break;
                                        }
                                    }
                                    break;
                                case 'dd:Version':
                                    foreach ($book4->childNodes as $book5) {
                                        if ($book5->nodeName == 'dd:Revision') {
                                            $assocTemp['revision'] = $book5->nodeValue;
                                            break;
                                        }
                                    }
                                    break;
                            }
                        }
                        $assoc['logs'][] = $assocTemp;
                    }
                }
            }
            if ($book2->nodeName == 'xdm:Log' && ($book2->getAttribute('idRef') == 'blackToner' || $book2->getAttribute('idRef') == 'iBlackTonerElabel')) {

                $assoc['tonerek']['lastuse'] = $book2->nodeValue;

            }
            if ($book2->nodeName == 'xdm:Log' && ($book2->getAttribute('idRef') == 'cyanToner' || $book2->getAttribute('idRef') == 'iCyanTonerElabel')) {

                $assoc['tonerekcyan']['lastuse'] = $book2->nodeValue;

            }
            if ($book2->nodeName == 'xdm:Log' && ($book2->getAttribute('idRef') == 'magentaToner' || $book2->getAttribute('idRef') == 'iMagentaTonerElabel')) {

                $assoc['tonerekmagenta']['lastuse'] = $book2->nodeValue;

            }
            if ($book2->nodeName == 'xdm:Log' && ($book2->getAttribute('idRef') == 'yellowToner' || $book2->getAttribute('idRef') == 'iYellowTonerElabel')) {

                $assoc['tonerekyellow']['lastuse'] = $book2->nodeValue;

            }
        }
    }

    /*  if($assoc['system']['fuser']!='' && $assoc['system']['fuser']!=0)
              $assoc['system']['fuser'] = (($assoc['system']['wydruk']%$assoc['system']['fuser'])/$assoc['system']['fuser'])*100;
      */


    return $assoc;
}

function getChildNodes($book)
{
    $assoc = array();
    foreach ($book->childNodes as $book) {
        $assoc[$book->nodeName] = $book->nodeValue;
    }
    return $assoc;
}

function getDataDeviceMinolta($message)
{


    $podz = preg_split('/\r\n|\r|\n/', $message);

    $dane = array();
    $dataDevice = array();
    foreach ($podz as $key => $item) {
        $eks = explode("],", $item);
        if (count($eks) >= 2) {
            $dane[str_replace('[', '', trim($eks[0]))] = $eks[1];
        }
    }

    $dataDevice['system']['dd:SerialNumber'] = trim(strip_tags(html_entity_decode($dane['Serial Number'])));

    $dataDevice['system']['dd:MakeAndModel'] = trim($dane['Model Name']);
    $dataDevice['system']['dd:ProductNumber'] = "Minolta";
    $dataDevice['system']['dd:Version']['dd:Revision'] = "";
    $dataDevice['system']['dd:Version']['dd:Date'] = "";
    $dataDevice['system']['ip'] = "";
    if ($dane['Total Color Counter'] != null) {
        $dataDevice['system']['wydruk'] = trim(strip_tags(html_entity_decode($dane['Total Black Counter'])));
        $dataDevice['system']['wydrukkolor'] = trim(strip_tags(html_entity_decode($dane['Total Color Counter'])));
        $dataDevice['system']['wydruktotal'] = trim(strip_tags(html_entity_decode($dane['Total Counter'])));
    } else {
        $dataDevice['system']['wydruk'] = trim(strip_tags(html_entity_decode($dane['Total Counter'])));
        $dataDevice['system']['wydrukkolor'] = 0;
        $dataDevice['system']['wydruktotal'] = trim(strip_tags(html_entity_decode($dane['Total Counter'])));
    }
    $dataDevice['system']['black_toner'] = "";
    $dataDevice['system']['cyan_toner'] = "";
    $dataDevice['system']['magenta_toner'] = "";
    $dataDevice['system']['yellow_toner'] = "";
    $dataDevice['system']['blackdrum_toner'] = "";
    $dataDevice['system']['cyandrum_toner'] = "";
    $dataDevice['system']['magentadrum_toner'] = "";
    $dataDevice['system']['yellowdrum_toner'] = "";
    $dataDevice['system']['fuser'] = "";


    return $dataDevice;
}


function getDataDeviceKyocera($message, $dataWiadomosci, $ip) {
    $messageRows = preg_split('/\r\n|\r|\n/', $message);

    $data = array();
    $dataDevice = array();

    $counterArray = null;
    $counterPropertyArray = null;

    foreach ($messageRows as $key => $item) {
        $property = explode(":", $item);
        if (count($property) === 2) {
            $propertyName = trim($property[0]);
            $propertyValue = trim($property[1]);

            if (strpos($propertyName, 'Counters') !== false) {
                $data[$propertyName] = array();
                $counterArray = &$data[$propertyName];
                unset($counterPropertyArray);
                $counterPropertyArray = null;
            } else if (is_array($counterArray) && $propertyValue === '') {
                $counterArray[$propertyName] = array();
                $counterPropertyArray = &$counterArray[$propertyName];
            } else {
                if (!is_array($counterArray)) {
                    $data[$propertyName] = $propertyValue;
                } else {
                    if (is_array($counterPropertyArray)) {
                        $counterPropertyArray[$propertyName] = $propertyValue;
                    } else {
                        $counterArray[$propertyName] = $propertyValue;
                    }
                }
            }
        } else if (strpos(trim($item), '[ ]', 0) === 0 || strpos(trim($item), '[*]', 0) === 0) {
            $property = explode(" ", trim( str_replace("[ ]", "[-]", $item)));
            $propertyValue = array_shift($property);
            $propertyName = implode(" ", $property);
            if (!array_key_exists($propertyName, $data)) {
                $data[$propertyName] = $propertyValue === "[*]" ? true: false;
            }
        } else if ($item === '') {
            // toners
            unset($counterPropertyArray);
            unset($counterArray);
            $counterPropertyArray = null;
            $counterArray = null;
        }
    }


    $dataDevice['system']['dd:SerialNumber'] = $data['Serial Number'];

    $dataDevice['system']['dd:MakeAndModel'] = mapKyoceraModelName($data['Model Name']);
    $dataDevice['system']['dd:ProductNumber'] = "KYOCERA";
    $dataDevice['system']['dd:Version']['dd:Revision'] = "";
    $dataDevice['system']['dd:Version']['dd:Date'] = "";
    $dataDevice['system']['ip'] = "";

    $dataDevice['system']['wydruk'] = $data['Counters by Function']['Printed Pages']['Total'];
    $dataDevice['system']['wydrukkolor'] = 0;
    $dataDevice['system']['wydruktotal'] = $data['Counters by Function']['Printed Pages']['Total'];

    $dataDevice['system']['black_toner'] = str_replace('%', '', $data['black']);
    $dataDevice['system']['cyan_toner'] = "";
    $dataDevice['system']['magenta_toner'] = "";
    $dataDevice['system']['yellow_toner'] = "";
    $dataDevice['system']['blackdrum_toner'] = "";
    $dataDevice['system']['cyandrum_toner'] = "";
    $dataDevice['system']['magentadrum_toner'] = "";
    $dataDevice['system']['yellowdrum_toner'] = "";
    $dataDevice['system']['fuser'] = "";
//    $dataDevice['system']['low_toner'] = $data['Low Toner'];
//    $dataDevice['system']['add_toner'] = $data['Add Toner'];
//    $dataDevice['system']['paper_jam'] = $data['Paper Jam'];
//    $dataDevice['system']['add_paper'] = $data['Add Paper'];
//    $dataDevice['system']['cover_open'] = $data['Cover Open'];
//    $dataDevice['system']['other_errors'] = $data['All Other Errors'];
//    $dataDevice['system']['full_waste_toner'] = $data['Near Full Waste Toner'];

    // if it is needed, add an event log to replace toner for this printer
    if ($data['Near Full Waste Toner']) {
        $eventLog = array();
        $eventLog['sequencenumber'] = -1;
        $eventLog['eventcode'] = 'Wymien pojemnik na zuzyty toner.';
        $eventLog['description'] = '';
        $eventLog['timestamp'] = $dataWiadomosci;
        $eventLog['valuefloat'] = -1;
        $eventLog['revision'] = $ip;
        $dataDevice['logs'][] = $eventLog;
    }

    return $dataDevice;
}

function validateDate($date, $format)
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function saveMinoltaDataDevice($minoltaMessage) {
    global $mysqli;
    $statement = $mysqli->prepare("INSERT INTO logs (sequencenumber, eventcode, description,timestamp,valuefloat,revision,dateinsert,serial)
                                    VALUES (?,?,?,?,?,?,?,?)");

    $d = DateTime::createFromFormat('d/m/Y H:i:s', $minoltaMessage['timestamp']);

    if (!$d || !$d->format('Y-m-d H:i:s')) {
        echo 'timestamp: - [' . $minoltaMessage['timestamp'] . ']';
        return false;
    }

    $statement->bind_param("isssdsss", $minoltaMessage['sequencenumber'], $minoltaMessage['eventcode'], $minoltaMessage['description'],
        $d->format('Y-m-d H:i:s'), $minoltaMessage['valuefloat'], $minoltaMessage['revision'], date('Y-m-d H:i:s'), $minoltaMessage['serial']);

    return $statement->execute();
}

function saveDataDevice($dataDevice, $dataWiadomosci, $ip)
{

    global $mysqli;
    $query = "select serial,dateupdate,deleted from printers where serial='{$dataDevice['system']['dd:SerialNumber']}'";
    $dateupdate = '';
    $deleted = 0;

    if ($result = mysqli_query($mysqli, $query)) {

        if ($result->num_rows === 0) //if($readtime==null || $readtime<$item->get_date("Y-m-d H:i:s"))
        {

            $query = "insert into printers(serial,model,product_number,nr_firmware,date_firmware,date_insert,ip,iloscstron,
                              black_toner,cyan_toner,magenta_toner,yellow_toner,blackdrum_toner,cyandrum_toner,magentadrum_toner,yellowdrum_toner,
                              stan_fuser,datawiadomosci,iloscstron_kolor,iloscstron_total, address_ip
                                ) values 
                            ('{$dataDevice['system']['dd:SerialNumber']}','{$dataDevice['system']['dd:MakeAndModel']}'
                                ," . ($dataDevice['system']['dd:ProductNumber'] == '' ? 'null' : "'" . $dataDevice['system']['dd:ProductNumber'] . "'") . "
                                    ," . ($dataDevice['system']['dd:Version']['dd:Revision'] == '' ? 'null' : "'" . $dataDevice['system']['dd:Version']['dd:Revision'] . "'") . "
                                    ," . ($dataDevice['system']['dd:Version']['dd:Date'] == '' ? 'null' : "'" . $dataDevice['system']['dd:Version']['dd:Date'] . "'") . "
                                        ,'" . date('Y-m-d H:i:s') . "'
                                ," . ($dataDevice['system']['ip'] == '' ? 'null' : "'" . $dataDevice['system']['ip'] . "'") . "
                                        ,{$dataDevice['system']['wydruk']},
                                 " . ($dataDevice['system']['black_toner'] == '' ? 'null' : $dataDevice['system']['black_toner']) . "
                                 ," . ($dataDevice['system']['cyan_toner'] == '' ? 'null' : $dataDevice['system']['cyan_toner']) . "
                                ," . ($dataDevice['system']['magenta_toner'] == '' ? 'null' : $dataDevice['system']['magenta_toner']) . "
                                ," . ($dataDevice['system']['yellow_toner'] == '' ? 'null' : $dataDevice['system']['yellow_toner']) . "
                                ," . ($dataDevice['system']['blackdrum_toner'] == '' ? 'null' : $dataDevice['system']['blackdrum_toner']) . " ," . ($dataDevice['system']['cyandrum_toner'] == '' ? 'null' : $dataDevice['system']['cyandrum_toner']) . "
                                ," . ($dataDevice['system']['magentadrum_toner'] == '' ? 'null' : $dataDevice['system']['magentadrum_toner']) . "
                                ," . ($dataDevice['system']['yellowdrum_toner'] == '' ? 'null' : $dataDevice['system']['yellowdrum_toner']) . "
                                ," . ($dataDevice['system']['fuser'] == '' ? 'null' : $dataDevice['system']['fuser']) . "
                                ,'" . ($dataWiadomosci == '' ? 'null' : $dataWiadomosci) . "'
                                ," . ($dataDevice['system']['wydrukkolor'] == '' ? 'null' : $dataDevice['system']['wydrukkolor']) . "
                                ," . ($dataDevice['system']['wydruktotal'] == '' ? 'null' : $dataDevice['system']['wydruktotal']) . "
                                , $ip                
                            )";

            if ($result2 = mysqli_query($mysqli, $query)) {

            } else {
                echo $mysqli->error;
            }

        } else {

            while ($row = $result->fetch_object()) {
                $dateupdate = $row->dateupdate;
                $deleted = $row->deleted;
                break;
            }

            if ($deleted === 1) {
                $result->close();
                return;
            }

            $query = "update printers set
                                  model = '{$dataDevice['system']['dd:MakeAndModel']}'
                                 ,product_number =" . ($dataDevice['system']['dd:ProductNumber'] == '' ? 'null' : "'" . $dataDevice['system']['dd:ProductNumber'] . "'") . "
                                 ,nr_firmware = " . ($dataDevice['system']['dd:Version']['dd:Revision'] == '' ? 'null' : "'" . $dataDevice['system']['dd:Version']['dd:Revision'] . "'") . "
                                 ,date_firmware=" . ($dataDevice['system']['dd:Version']['dd:Date'] == '' ? 'null' : "'" . $dataDevice['system']['dd:Version']['dd:Date'] . "'") . "
                                 ,dateupdate='" . date('Y-m-d H:i:s') . "'
                                 ,iloscstron=" . $dataDevice['system']['wydruk'] . "
                                 ,ip=" . ($dataDevice['system']['ip'] == '' ? 'null' : "'" . $dataDevice['system']['ip'] . "'") . "
                                 ,black_toner=" . ($dataDevice['system']['black_toner'] == '' ? 'null' : $dataDevice['system']['black_toner']) . "
                                 ,cyan_toner=" . ($dataDevice['system']['cyan_toner'] == '' ? 'null' : $dataDevice['system']['cyan_toner']) . "
                                 ,magenta_toner=" . ($dataDevice['system']['magenta_toner'] == '' ? 'null' : $dataDevice['system']['magenta_toner']) . "
                                 ,yellow_toner=" . ($dataDevice['system']['yellow_toner'] == '' ? 'null' : $dataDevice['system']['yellow_toner']) . "
                                 ,blackdrum_toner=" . ($dataDevice['system']['blackdrum_toner'] == '' ? 'null' : $dataDevice['system']['blackdrum_toner']) . "
                                 ,cyandrum_toner=" . ($dataDevice['system']['cyandrum_toner'] == '' ? 'null' : $dataDevice['system']['cyandrum_toner']) . "
                                 ,magentadrum_toner=" . ($dataDevice['system']['magentadrum_toner'] == '' ? 'null' : $dataDevice['system']['magentadrum_toner']) . "
                                 ,yellowdrum_toner=" . ($dataDevice['system']['yellowdrum_toner'] == '' ? 'null' : $dataDevice['system']['yellowdrum_toner']) . "
                                 ,stan_fuser=" . ($dataDevice['system']['fuser'] == '' ? 'null' : $dataDevice['system']['fuser']) . "
                                 ,datawiadomosci='" . ($dataWiadomosci == '' ? 'null' : $dataWiadomosci) . "'
                                 ,iloscstron_kolor=" . ($dataDevice['system']['wydrukkolor'] == '' ? 'null' : $dataDevice['system']['wydrukkolor']) . "
                                 ,iloscstron_total=" . ($dataDevice['system']['wydruktotal'] == '' ? 'null' : $dataDevice['system']['wydruktotal']) . "
                                 ,address_ip=" . $ip . " 
                                 where serial = '{$dataDevice['system']['dd:SerialNumber']}'
                                ";

            if ($result2 = mysqli_query($mysqli, $query)) {

            } else {

                echo $mysqli->error;
            }
        }

        $result->close();
    }

    $query = "DELETE FROM `pages` WHERE datawiadomosci = '{$dataWiadomosci}' AND serial = '{$dataDevice['system']['dd:SerialNumber']}'";

    mysqli_query($mysqli, $query);

    $query = "insert into pages(serial,ilosc,dateinsert,datawiadomosci,ilosckolor,ilosctotal,rowid_agreement,product_version) values 
                            (
                                '{$dataDevice['system']['dd:SerialNumber']}',{$dataDevice['system']['wydruk']},'" . date('Y-m-d H:i:s') . "','{$dataWiadomosci}'
                                ," . ($dataDevice['system']['wydrukkolor'] == '' ? 'null' : $dataDevice['system']['wydrukkolor']) . "
                                ," . ($dataDevice['system']['wydruktotal'] == '' ? 'null' : $dataDevice['system']['wydruktotal']) . ",
                                (select rowid from agreements where serial='" . $dataDevice['system']['dd:SerialNumber'] . "' and activity=1),
                                (select product_version FROM printers where serial = '" . $dataDevice['system']['dd:SerialNumber'] . "')
                                )";



    if ($result2 = mysqli_query($mysqli, $query)) {

    } else {

        echo $mysqli->error;
    }


    // tonery

    // <editor-fold defaultstate="collapsed" desc="Toner czarny">
    if (isset($dataDevice['tonerek'])) {
        $query5 = "select serialdrukarka,serial,rowid  from toners where zakonczony=0 and serialdrukarka='{$dataDevice['system']['dd:SerialNumber']}'";
        if ($result5 = mysqli_query($mysqli, $query5)) {

            if ($result5->num_rows === 0) {
                $query = "insert into toners(
                                        `serialdrukarka`, `serial`, `number`, `description`, `datainstalacji`, `stronmax`, 
                                        `stronpozostalo`, `ostatnieuzycie`, `dateinsert`, `source`,`dateupdate`,`sourceupdate`,`licznikstart`) values 
                                    (
                                      '{$dataDevice['system']['dd:SerialNumber']}',
                                      '{$dataDevice['tonerek']['serialnumber']}',
                                      '{$dataDevice['tonerek']['productnumber']}',
                                      '{$dataDevice['tonerek']['description']}',
                                      '{$dataDevice['tonerek']['installation']}',
                                      {$dataDevice['tonerek']['tonermax']},
                                      {$dataDevice['tonerek']['pozostalo']},
                                      '{$dataDevice['tonerek']['lastuse']}',
                                         '" . date('Y-m-d H:i:s') . "',
                                      'mail','" . date('Y-m-d H:i:s') . "','mail',{$dataDevice['system']['wydruk']}
                                    )";
                if ($result2 = mysqli_query($mysqli, $query)) {

                } else {
                    echo $mysqli->error;
                }
            } else {
                $serialek = '';
                $rowid = 0;
                while ($row = $result5->fetch_assoc()) {
                    $serialek = $row['serial'];
                    $rowid = $row['rowid'];
                    break;
                }

                if ($serialek == $dataDevice['tonerek']['serialnumber']) // update istniejącego
                {
                    $query = "update toners set
                                            `serialdrukarka`='{$dataDevice['system']['dd:SerialNumber']}', 
                                            `datainstalacji`='{$dataDevice['tonerek']['installation']}', 
                                            `stronmax`={$dataDevice['tonerek']['tonermax']}, 
                                            `stronpozostalo`={$dataDevice['tonerek']['pozostalo']}, 
                                            `ostatnieuzycie`='{$dataDevice['tonerek']['lastuse']}',
                                            `dateupdate`='" . date('Y-m-d H:i:s') . "',
                                            `sourceupdate`='mail'
                                            where
                                            `rowid` = {$rowid}";

                    if ($result2 = mysqli_query($mysqli, $query)) {

                    } else {
                        echo $mysqli->error;
                    }
                } else  // kończymy istniejący i dokładamy nowy toner
                {

                    $query = "update toners 
                                                set zakonczony=1, licznikkoniec = {$dataDevice['system']['wydruk']},
                                                    `dateupdate`='" . date('Y-m-d H:i:s') . "',
                                                    `sourceupdate`='mail'
                                            where
                                            `rowid` = {$rowid}";

                    if ($result2 = mysqli_query($mysqli, $query)) {

                    } else {
                        echo $mysqli->error;
                    }

                    $query = "insert into toners(
                                        `serialdrukarka`, `serial`, `number`, `description`, `datainstalacji`, `stronmax`, 
                                        `stronpozostalo`, `ostatnieuzycie`, `dateinsert`, `source`,`dateupdate`,`sourceupdate`,`licznikstart`) values 
                                        (
                                          '{$dataDevice['system']['dd:SerialNumber']}',
                                          '{$dataDevice['tonerek']['serialnumber']}',
                                          '{$dataDevice['tonerek']['productnumber']}',
                                          '{$dataDevice['tonerek']['description']}',
                                          '{$dataDevice['tonerek']['installation']}',
                                          {$dataDevice['tonerek']['tonermax']},
                                          {$dataDevice['tonerek']['pozostalo']},
                                          '{$dataDevice['tonerek']['lastuse']}',
                                             '" . date('Y-m-d H:i:s') . "',
                                          'mail','" . date('Y-m-d H:i:s') . "','mail',{$dataDevice['system']['wydruk']}
                                        )";
                    if ($result2 = mysqli_query($mysqli, $query)) {

                    } else {
                        echo $mysqli->error;
                    }

                }
            }
        }
    }
    // </editor-fold>
    if (isset($dataDevice['tonerekcyan'])) {
        // <editor-fold defaultstate="collapsed" desc="Toner cyan">
        $query5 = "select serialdrukarka,serial,rowid  from tonerscyan where zakonczony=0 and serialdrukarka='{$dataDevice['system']['dd:SerialNumber']}'";
        if ($result5 = mysqli_query($mysqli, $query5)) {

            if ($result5->num_rows === 0) {
                $query = "insert into tonerscyan(
                                        `serialdrukarka`, `serial`, `number`, `description`, `datainstalacji`, `stronmax`, 
                                        `stronpozostalo`, `ostatnieuzycie`, `dateinsert`, `source`,`dateupdate`,`sourceupdate`,`licznikstart`) values 
                                    (
                                      '{$dataDevice['system']['dd:SerialNumber']}',
                                      '{$dataDevice['tonerekcyan']['serialnumber']}',
                                      '{$dataDevice['tonerekcyan']['productnumber']}',
                                      '{$dataDevice['tonerekcyan']['description']}',
                                      '{$dataDevice['tonerekcyan']['installation']}',
                                      {$dataDevice['tonerekcyan']['tonermax']},
                                      {$dataDevice['tonerekcyan']['pozostalo']},
                                      '{$dataDevice['tonerekcyan']['lastuse']}',
                                         '" . date('Y-m-d H:i:s') . "',
                                      'mail','" . date('Y-m-d H:i:s') . "','mail',{$dataDevice['system']['wydruk']}
                                    )";
                if ($result2 = mysqli_query($mysqli, $query)) {

                } else {
                    echo $mysqli->error;
                }
            } else {
                $serialek = '';
                $rowid = 0;
                while ($row = $result5->fetch_assoc()) {
                    $serialek = $row['serial'];
                    $rowid = $row['rowid'];
                    break;
                }

                if ($serialek == $dataDevice['tonerekcyan']['serialnumber']) // update istniejącego
                {
                    $query = "update tonerscyan set
                                            `serialdrukarka`='{$dataDevice['system']['dd:SerialNumber']}', 
                                            `datainstalacji`='{$dataDevice['tonerekcyan']['installation']}', 
                                            `stronmax`={$dataDevice['tonerekcyan']['tonermax']}, 
                                            `stronpozostalo`={$dataDevice['tonerekcyan']['pozostalo']}, 
                                            `ostatnieuzycie`='{$dataDevice['tonerekcyan']['lastuse']}',
                                            `dateupdate`='" . date('Y-m-d H:i:s') . "',
                                            `sourceupdate`='mail'
                                            where
                                            `rowid` = {$rowid}";

                    if ($result2 = mysqli_query($mysqli, $query)) {

                    } else {
                        echo $mysqli->error;
                    }
                } else  // kończymy istniejący i dokładamy nowy toner
                {

                    $query = "update tonerscyan
                                                set zakonczony=1, licznikkoniec = {$dataDevice['system']['wydruk']},
                                                    `dateupdate`='" . date('Y-m-d H:i:s') . "',
                                                    `sourceupdate`='mail'
                                            where
                                            `rowid` = {$rowid}";

                    if ($result2 = mysqli_query($mysqli, $query)) {

                    } else {
                        echo $mysqli->error;
                    }

                    $query = "insert into tonerscyan(
                                        `serialdrukarka`, `serial`, `number`, `description`, `datainstalacji`, `stronmax`, 
                                        `stronpozostalo`, `ostatnieuzycie`, `dateinsert`, `source`,`dateupdate`,`sourceupdate`,`licznikstart`) values 
                                        (
                                          '{$dataDevice['system']['dd:SerialNumber']}',
                                          '{$dataDevice['tonerekcyan']['serialnumber']}',
                                          '{$dataDevice['tonerekcyan']['productnumber']}',
                                          '{$dataDevice['tonerekcyan']['description']}',
                                          '{$dataDevice['tonerekcyan']['installation']}',
                                          {$dataDevice['tonerekcyan']['tonermax']},
                                          {$dataDevice['tonerekcyan']['pozostalo']},
                                          '{$dataDevice['tonerekcyan']['lastuse']}',
                                             '" . date('Y-m-d H:i:s') . "',
                                          'mail','" . date('Y-m-d H:i:s') . "','mail',{$dataDevice['system']['wydruk']}
                                        )";
                    if ($result2 = mysqli_query($mysqli, $query)) {

                    } else {
                        echo $mysqli->error;
                    }

                }
            }
        }
        // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="Toner magenta">
        $query5 = "select serialdrukarka,serial,rowid  from tonersmagenta where zakonczony=0 and serialdrukarka='{$dataDevice['system']['dd:SerialNumber']}'";
        if ($result5 = mysqli_query($mysqli, $query5)) {

            if ($result5->num_rows === 0) {
                $query = "insert into tonersmagenta(
                                        `serialdrukarka`, `serial`, `number`, `description`, `datainstalacji`, `stronmax`, 
                                        `stronpozostalo`, `ostatnieuzycie`, `dateinsert`, `source`,`dateupdate`,`sourceupdate`,`licznikstart`) values 
                                    (
                                      '{$dataDevice['system']['dd:SerialNumber']}',
                                      '{$dataDevice['tonerekmagenta']['serialnumber']}',
                                      '{$dataDevice['tonerekmagenta']['productnumber']}',
                                      '{$dataDevice['tonerekmagenta']['description']}',
                                      '{$dataDevice['tonerekmagenta']['installation']}',
                                      {$dataDevice['tonerekmagenta']['tonermax']},
                                      {$dataDevice['tonerekmagenta']['pozostalo']},
                                      '{$dataDevice['tonerekmagenta']['lastuse']}',
                                         '" . date('Y-m-d H:i:s') . "',
                                      'mail','" . date('Y-m-d H:i:s') . "','mail',{$dataDevice['system']['wydruk']}
                                    )";
                if ($result2 = mysqli_query($mysqli, $query)) {

                } else {
                    echo $mysqli->error;
                }
            } else {
                $serialek = '';
                $rowid = 0;
                while ($row = $result5->fetch_assoc()) {
                    $serialek = $row['serial'];
                    $rowid = $row['rowid'];
                    break;
                }

                if ($serialek == $dataDevice['tonerekmagenta']['serialnumber']) // update istniejącego
                {
                    $query = "update tonersmagenta set
                                            `serialdrukarka`='{$dataDevice['system']['dd:SerialNumber']}', 
                                            `datainstalacji`='{$dataDevice['tonerekmagenta']['installation']}', 
                                            `stronmax`={$dataDevice['tonerekmagenta']['tonermax']}, 
                                            `stronpozostalo`={$dataDevice['tonerekmagenta']['pozostalo']}, 
                                            `ostatnieuzycie`='{$dataDevice['tonerekmagenta']['lastuse']}',
                                            `dateupdate`='" . date('Y-m-d H:i:s') . "',
                                            `sourceupdate`='mail'
                                            where
                                            `rowid` = {$rowid}";

                    if ($result2 = mysqli_query($mysqli, $query)) {

                    } else {
                        echo $mysqli->error;
                    }
                } else  // kończymy istniejący i dokładamy nowy toner
                {

                    $query = "update tonersmagenta
                                                set zakonczony=1, licznikkoniec = {$dataDevice['system']['wydruk']},
                                                    `dateupdate`='" . date('Y-m-d H:i:s') . "',
                                                    `sourceupdate`='mail'
                                            where
                                            `rowid` = {$rowid}";

                    if ($result2 = mysqli_query($mysqli, $query)) {

                    } else {
                        echo $mysqli->error;
                    }

                    $query = "insert into tonersmagenta(
                                        `serialdrukarka`, `serial`, `number`, `description`, `datainstalacji`, `stronmax`, 
                                        `stronpozostalo`, `ostatnieuzycie`, `dateinsert`, `source`,`dateupdate`,`sourceupdate`,`licznikstart`) values 
                                        (
                                          '{$dataDevice['system']['dd:SerialNumber']}',
                                          '{$dataDevice['tonerekmagenta']['serialnumber']}',
                                          '{$dataDevice['tonerekmagenta']['productnumber']}',
                                          '{$dataDevice['tonerekmagenta']['description']}',
                                          '{$dataDevice['tonerekmagenta']['installation']}',
                                          {$dataDevice['tonerekmagenta']['tonermax']},
                                          {$dataDevice['tonerekmagenta']['pozostalo']},
                                          '{$dataDevice['tonerekmagenta']['lastuse']}',
                                             '" . date('Y-m-d H:i:s') . "',
                                          'mail','" . date('Y-m-d H:i:s') . "','mail',{$dataDevice['system']['wydruk']}
                                        )";
                    if ($result2 = mysqli_query($mysqli, $query)) {

                    } else {
                        echo $mysqli->error;
                    }

                }
            }
        }
        // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="Toner yellow">
        $query5 = "select serialdrukarka,serial,rowid  from tonersyellow where zakonczony=0 and serialdrukarka='{$dataDevice['system']['dd:SerialNumber']}'";
        if ($result5 = mysqli_query($mysqli, $query5)) {

            if ($result5->num_rows === 0) {
                $query = "insert into tonersyellow(
                                        `serialdrukarka`, `serial`, `number`, `description`, `datainstalacji`, `stronmax`, 
                                        `stronpozostalo`, `ostatnieuzycie`, `dateinsert`, `source`,`dateupdate`,`sourceupdate`,`licznikstart`) values 
                                    (
                                      '{$dataDevice['system']['dd:SerialNumber']}',
                                      '{$dataDevice['tonerekyellow']['serialnumber']}',
                                      '{$dataDevice['tonerekyellow']['productnumber']}',
                                      '{$dataDevice['tonerekyellow']['description']}',
                                      '{$dataDevice['tonerekyellow']['installation']}',
                                      {$dataDevice['tonerekyellow']['tonermax']},
                                      {$dataDevice['tonerekyellow']['pozostalo']},
                                      '{$dataDevice['tonerekyellow']['lastuse']}',
                                         '" . date('Y-m-d H:i:s') . "',
                                      'mail','" . date('Y-m-d H:i:s') . "','mail',{$dataDevice['system']['wydruk']}
                                    )";
                if ($result2 = mysqli_query($mysqli, $query)) {

                } else {
                    echo $mysqli->error;
                }
            } else {
                $serialek = '';
                $rowid = 0;
                while ($row = $result5->fetch_assoc()) {
                    $serialek = $row['serial'];
                    $rowid = $row['rowid'];
                    break;
                }

                if ($serialek == $dataDevice['tonerekyellow']['serialnumber']) // update istniejącego
                {
                    $query = "update tonersyellow set
                                            `serialdrukarka`='{$dataDevice['system']['dd:SerialNumber']}', 
                                            `datainstalacji`='{$dataDevice['tonerekyellow']['installation']}', 
                                            `stronmax`={$dataDevice['tonerekyellow']['tonermax']}, 
                                            `stronpozostalo`={$dataDevice['tonerekyellow']['pozostalo']}, 
                                            `ostatnieuzycie`='{$dataDevice['tonerekyellow']['lastuse']}',
                                            `dateupdate`='" . date('Y-m-d H:i:s') . "',
                                            `sourceupdate`='mail'
                                            where
                                            `rowid` = {$rowid}";

                    if ($result2 = mysqli_query($mysqli, $query)) {

                    } else {
                        echo $mysqli->error;
                    }
                } else  // kończymy istniejący i dokładamy nowy toner
                {

                    $query = "update tonersyellow
                                                set zakonczony=1, licznikkoniec = {$dataDevice['system']['wydruk']},
                                                    `dateupdate`='" . date('Y-m-d H:i:s') . "',
                                                    `sourceupdate`='mail'
                                            where
                                            `rowid` = {$rowid}";

                    if ($result2 = mysqli_query($mysqli, $query)) {

                    } else {
                        echo $mysqli->error;
                    }

                    $query = "insert into tonersyellow(
                                        `serialdrukarka`, `serial`, `number`, `description`, `datainstalacji`, `stronmax`, 
                                        `stronpozostalo`, `ostatnieuzycie`, `dateinsert`, `source`,`dateupdate`,`sourceupdate`,`licznikstart`) values 
                                        (
                                          '{$dataDevice['system']['dd:SerialNumber']}',
                                          '{$dataDevice['tonerekyellow']['serialnumber']}',
                                          '{$dataDevice['tonerekyellow']['productnumber']}',
                                          '{$dataDevice['tonerekyellow']['description']}',
                                          '{$dataDevice['tonerekyellow']['installation']}',
                                          {$dataDevice['tonerekyellow']['tonermax']},
                                          {$dataDevice['tonerekyellow']['pozostalo']},
                                          '{$dataDevice['tonerekyellow']['lastuse']}',
                                             '" . date('Y-m-d H:i:s') . "',
                                          'mail','" . date('Y-m-d H:i:s') . "','mail',{$dataDevice['system']['wydruk']}
                                        )";
                    if ($result2 = mysqli_query($mysqli, $query)) {

                    } else {
                        echo $mysqli->error;
                    }

                }
            }
        }
        // </editor-fold>
    }

    // koniec tonerów
    if ($dataDevice['logs'] != null) {
        if ($dateupdate == '') // insertujemy wszystkie logi
        {
            $statement = $mysqli->prepare("INSERT INTO logs (sequencenumber, eventcode, description,timestamp,valuefloat,revision,dateinsert,serial) 
                                    VALUES (?,?,?,?,?,?,?,?)");
            foreach ($dataDevice['logs'] as $key => $item) {
                // 2018-01-01T12:00:01.123+01:00 => 2018-01-01 12:00:01
                $timestamp = str_replace('T', ' ', explode('.', $item['timestamp'])[0]);
                $statement->bind_param("isssdsss", $item['sequencenumber'], $item['eventcode'], $item['description'],
                    $timestamp, $item['valuefloat'], $item['revision'], date('Y-m-d H:i:s'), $dataDevice['system']['dd:SerialNumber']);
                $statement->execute();
            }
        } else // porównujemy dane updateu
        {
            $statement = $mysqli->prepare("INSERT INTO logs (sequencenumber, eventcode, description,timestamp,valuefloat,revision,dateinsert,serial) 
                                    VALUES (?,?,?,?,?,?,?,?)");
            foreach ($dataDevice['logs'] as $key => $item) {
                // 2018-01-01T12:00:01.123+01:00 => 2018-01-01 12:00:01
                $timestamp = str_replace('T', ' ', explode('.', $item['timestamp'])[0]);

                $query = "select rowid  from logs where serial='{$dataDevice['system']['dd:SerialNumber']}' and 
                                              timestamp = '" . $timestamp . "'";


                if ($result = mysqli_query($mysqli, $query)) {

                    if ($result->num_rows === 0) //if($readtime==null || $readtime<$item->get_date("Y-m-d H:i:s"))
                    {
                        $statement->bind_param("isssdsss", $item['sequencenumber'], $item['eventcode'], $item['description'],
                            $timestamp, $item['valuefloat'], $item['revision'], date('Y-m-d H:i:s'), $dataDevice['system']['dd:SerialNumber']);
                        $statement->execute();
                    }
                }

            }

        }
    }
}

// returns ip_address or "NULL" string, value could be used in mysql operations
function getIpAddress($email_header)
{
    $reverseInfo = array_reverse($email_header);
    $found = null;
    while ($found == null && list($var, $val) = each($reverseInfo)) {
        if (substr($val, 0, strlen("Received:")) === "Received:") {
            $found = $val;
        }
    }

    if ($found != null) {
        preg_match('/\[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\]/', $found, $ip_match);

        $found = (count($ip_match) > 0) ? str_replace(array('[', ']'), '', $ip_match[0]) : null;

        $found = $found ? "'" . $found . "'" : "NULL";
    }

    return $found;
}



function isMinoltaServiceMessage($email_body) {
    $result = array();
    $result['sequencenumber'] = -1;
    $result['valuefloat'] = -1;
    $result['description'] = "";
    $arrRows = explode("\n", $email_body);
    foreach($arrRows as $row) {
        $value = strRight(":", $row);
        if (startWith($row, "Miejsce instalacji") && $value != "") {
            $result['serial'] = $value;
        }
        if (startWith($row, "Adres IP")) {
            $result['revision'] = $value;
        }
        if (startWith($row, "Czas zdarzenia")) {
            $result['timestamp'] = $value;
        }
        if (startWith(preg_replace('/[^A-Za-z0-9:]/','',$row), "BBd")) {
            $result['eventcode'] = $value;

            if (base64_encode($result['eventcode']) == 'VXp1cGUBQm5paiB0b25lci4gAXvzAUJ0eQ==') {
                $result['eventcode'] = 'UzupeBnij toner. Zolty';
            }
        }
    }


    if (!array_key_exists('serial', $result)) {
        $result = null;
    }

    return $result;
}

function mapKyoceraModelName($modelName) {
    return str_replace('ECOSYS', 'KYOCERA', $modelName);
}

function strRight($delimiter, $str) {
    return strpos($str, $delimiter) !== false ? trim(explode($delimiter, $str, 2)[1]) : "";
}

function startWith($str, $subStr) {
    return (substr($str, 0, strlen($subStr)) === $subStr);
}