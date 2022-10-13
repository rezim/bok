<?php

class mailTemplates
{

    function sendMailZarejestrowanoEmailTemplate($rowid)
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
    
    #u_body a {
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
  <table id=\"u_body\" style=\"border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #f9f9f9;width:100%\" cellpadding=\"0\" cellspacing=\"0\">
    <tbody>
      <tr style=\"vertical-align: top\">
        <td style=\"word-break: break-word;border-collapse: collapse !important;vertical-align: top\">
          <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td align=\"center\" style=\"background-color: #f9f9f9;\"><![endif]-->


          <div class=\"u-row-container\" style=\"padding: 0px;background-color: transparent\">
            <div class=\"u-row\" style=\"Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;\">
              <div style=\"border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;\">
                <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding: 0px;background-color: transparent;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px;\"><tr style=\"background-color: transparent;\"><![endif]-->

                <!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\" valign=\"top\"><![endif]-->
                <div class=\"u-col u-col-100\" style=\"max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;\">
                  <div style=\"height: 100%;width: 100% !important;\">
                    <!--[if (!mso)&(!IE)]><!-->
                    <div style=\"height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\">
                      <!--<![endif]-->

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <div style=\"color: #afb0c7; line-height: 170%; text-align: center; word-wrap: break-word;\">
                                <p style=\"font-size: 14px; line-height: 170%;\"><span style=\"font-size: 14px; line-height: 23.8px;\">View Email in Browser</span></p>
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
                    <div style=\"height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\">
                      <!--<![endif]-->

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:20px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                                <tr>
                                  <td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\">
                                    <a href=\"https://www.otus.pl/\" target=\"_blank\">
                                      <img align=\"center\" border=\"0\" src=\"https://ci6.googleusercontent.com/proxy/DFNuvo_0xwcAcOH0wZt7v0LypjnA_O1MlxpuPkj3d1ugMXhN8rUxd6DNq2JSfLT52bk_OUkbJ88RzLzrWWso8SIlWmfrg0fqIkKjTs_G=s0-d-e1-ft#https://www.otus.pl/wp-content/uploads/2021/06/logo_ot1.png\"
                                        alt=\"Image\" title=\"Image\" style=\"outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 19%;max-width: 106.4px;\"
                                        width=\"106.4\" />
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
            <div class=\"u-row\" style=\"Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #003399;\">
              <div style=\"border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;\">
                <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding: 0px;background-color: transparent;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px;\"><tr style=\"background-color: #003399;\"><![endif]-->

                <!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\" valign=\"top\"><![endif]-->
                <div class=\"u-col u-col-100\" style=\"max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;\">
                  <div style=\"height: 100%;width: 100% !important;\">
                    <!--[if (!mso)&(!IE)]><!-->
                    <div style=\"height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\">
                      <!--<![endif]-->

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:20px 10px 10px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                                <tr>
                                  <td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\">

                                    <img align=\"center\" border=\"0\" src=\"https://cdn.templates.unlayer.com/assets/1597218650916-xxxxc.png\" alt=\"Image\" title=\"Image\" style=\"outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 26%;max-width: 150.8px;\"
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
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <div style=\"color: #e5eaf5; line-height: 140%; text-align: center; word-wrap: break-word;\">
                                <p style=\"font-size: 14px; line-height: 140%;\"><strong>Dziękujemy za kontakt!</strong></p>
                              </div>

                            </td>
                          </tr>
                        </tbody>
                      </table>

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:0px 10px 31px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <div style=\"color: #e5eaf5; line-height: 140%; text-align: center; word-wrap: break-word;\">
                                <p style=\"font-size: 14px; line-height: 140%;\"><span style=\"font-size: 24px; line-height: 33.6px;\"><strong><span style=\"line-height: 33.6px; font-size: 24px;\">Potwierdzamy zarejestrowanie </span></strong>
                                  </span><span style=\"font-size: 24px; line-height: 33.6px;\"><strong><span style=\"line-height: 33.6px; font-size: 24px;\">zgłoszenia. </span></strong>
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
                    <div style=\"height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\">
                      <!--<![endif]-->

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:20px 55px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <div style=\"line-height: 160%; text-align: center; word-wrap: break-word;\">
                                <p style=\"font-size: 14px; line-height: 160%;\"><span style=\"font-size: 22px; line-height: 35.2px;\">Dzień Dobry,</span></p>
                                <p style=\"font-size: 14px; line-height: 160%;\"> </p>
                                <p style=\"font-size: 14px; line-height: 160%;\"><span style=\"font-size: 16px; line-height: 25.6px;\">Dziękujemy za kontakt i potwierdzamy </span></p>
                                <p style=\"font-size: 14px; line-height: 160%;\"><span style=\"font-size: 16px; line-height: 25.6px;\">zarejestrowanie zgłoszenia pod numerem: <strong>{$rowid}</strong>.<br /></span></p>
                                <p style=\"font-size: 14px; line-height: 160%;\"> </p>
                                <p style=\"font-size: 14px; line-height: 160%;\"><span style=\"font-size: 16px; line-height: 25.6px;\">Zajmiemy się Twoją sprawą i udzielimy odpowiedzi najszybciej,</span></p>
                                <p style=\"font-size: 14px; line-height: 160%;\"><span style=\"font-size: 16px; line-height: 25.6px;\"> jak to będzie możliwe, oraz postaramy się </span><span style=\"font-size: 16px; line-height: 25.6px;\">aby czas</span></p>
                                <p style=\"font-size: 14px; line-height: 160%;\"><span style=\"font-size: 16px; line-height: 25.6px;\"> oczekiwania był możliwie najkrótszy.</span></p>
                                <p style=\"font-size: 14px; line-height: 160%;\"> </p>
                                <p style=\"font-size: 14px; line-height: 160%;\"><span style=\"font-size: 16px; line-height: 25.6px;\">Jeżeli będziesz kontynuować korespondencję prosimy o zachowanie tematu wiadomości - pozwoli nam to szybciej</span></p>
                                <p style=\"font-size: 14px; line-height: 160%;\"><span style=\"font-size: 16px; line-height: 25.6px;\"> zidentyfikować Twoją sprawę. </span></p>
                              </div>

                            </td>
                          </tr>
                        </tbody>
                      </table>

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <table height=\"0px\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%\">
                                <tbody>
                                  <tr style=\"vertical-align: top\">
                                    <td style=\"word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%\">
                                      <span>&#160;</span>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>

                            </td>
                          </tr>
                        </tbody>
                      </table>

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:20px 55px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <div style=\"line-height: 160%; text-align: center; word-wrap: break-word;\">
                                <p style=\"line-height: 160%; font-size: 14px;\"><span style=\"font-size: 16px; line-height: 25.6px; font-family: arial, helvetica, sans-serif;\">W bardzo pilnych przypadkach prosimy o</span></p>
                                <p style=\"line-height: 160%; font-size: 14px;\"><span style=\"font-size: 16px; line-height: 25.6px;\"><span style=\"line-height: 25.6px; font-family: arial, helvetica, sans-serif; color: #1155cc; font-size: 16px;\"> <a rel=\"noopener\" href=\"tel:+48713211906\" target=\"_blank\" style=\"color: #1155cc;\">kontakt telefoniczny</a> </span>
                                  <span
                                    style=\"line-height: 25.6px; font-family: arial, helvetica, sans-serif; font-size: 16px;\">podając numer tego zgłoszenia.</span>
                                    </span>
                                </p>
                                <p style=\"line-height: 160%; font-size: 14px; text-align: center;\"><br /><span style=\"font-size: 16px; line-height: 25.6px; font-family: arial, helvetica, sans-serif;\">Pozdrawiamy <span style=\"color: #1155cc; line-height: 25.6px; font-size: 16px;\"><a rel=\"noopener\" href=\"https://www.otus.pl/wsparcie\" target=\"_blank\" style=\"color: #1155cc;\"><span style=\"line-height: 25.6px; font-size: 16px;\">Wsparcie Otus</span></a>
                                  </span>
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
            <div class=\"u-row\" style=\"Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #e5eaf5;\">
              <div style=\"border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;\">
                <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding: 0px;background-color: transparent;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px;\"><tr style=\"background-color: #e5eaf5;\"><![endif]-->

                <!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\" valign=\"top\"><![endif]-->
                <div class=\"u-col u-col-100\" style=\"max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;\">
                  <div style=\"height: 100%;width: 100% !important;\">
                    <!--[if (!mso)&(!IE)]><!-->
                    <div style=\"height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\">
                      <!--<![endif]-->

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:20px 55px 18px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <div style=\"color: #003399; line-height: 160%; text-align: center; word-wrap: break-word;\">
                                <p style=\"font-size: 14px; line-height: 160%;\"><span style=\"color: #000000; font-size: 14px; line-height: 22.4px; font-family: arial, helvetica, sans-serif;\">OTUS Sp. z o.o.</span><br /><span style=\"color: #000000; font-size: 14px; line-height: 22.4px; font-family: arial, helvetica, sans-serif;\">ul. Wrocławska 23 , 55-010 Radwanice</span><br
                                  /><span style=\"color: #000000; font-size: 14px; line-height: 22.4px; font-family: arial, helvetica, sans-serif;\">+48 71 321 19 06</span></p>
                                <p style=\"font-size: 14px; line-height: 160%;\"><span style=\"color: #000000; font-size: 14px; line-height: 22.4px; font-family: arial, helvetica, sans-serif;\"><a rel=\"noopener\" href=\"mailto:info@otus.com.pl?subject=Dotyczy%20zg%C5%82oszenia%20numer%20{$rowid}&body=\" target=\"_blank\">info@otus.com.pl</a></span></p>
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
                    <div style=\"height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\">
                      <!--<![endif]-->

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <div style=\"color: #fafafa; line-height: 180%; text-align: center; word-wrap: break-word;\">
                                <p style=\"font-size: 14px; line-height: 180%;\"><span style=\"font-size: 16px; line-height: 28.8px;\"><span style=\"color: #ffffff; font-size: 16px; line-height: 28.8px;\"><a rel=\"noopener\" href=\"https://www.otus.pl/kontakt\" target=\"_blank\" style=\"color: #ffffff;\">Skontaktuj się z nami</a></span></span>
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

    function sendMailZakonczonoEmailTemplate($rowid) {
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
      .u-row .u-col-33p33 {
        width: 199.98px !important;
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
      .no-stack .u-col {
        min-width: 0 !important;
        display: table-cell !important;
      }
      .no-stack .u-col-33p33 {
        width: 33.33% !important;
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
    
    #u_body a {
      color: #0000ee;
      text-decoration: underline;
    }
    
    @media (max-width: 480px) {
      #u_row_7 .v-row-background-color {
        background-color: #ffffff !important;
      }
      #u_row_7.v-row-background-color {
        background-color: #ffffff !important;
      }
    }
  </style>



  <!--[if !mso]><!-->
  <link href=\"https://fonts.googleapis.com/css?family=Cabin:400,700\" rel=\"stylesheet\" type=\"text/css\">
  <!--<![endif]-->

</head>

<body class=\"clean-body u_body\" style=\"margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #f9f9f9;color: #000000\">
  <!--[if IE]><div class=\"ie-container\"><![endif]-->
  <!--[if mso]><div class=\"mso-container\"><![endif]-->
  <table id=\"u_body\" style=\"border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #f9f9f9;width:100%\" cellpadding=\"0\" cellspacing=\"0\">
    <tbody>
      <tr style=\"vertical-align: top\">
        <td style=\"word-break: break-word;border-collapse: collapse !important;vertical-align: top\">
          <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td align=\"center\" style=\"background-color: #f9f9f9;\"><![endif]-->


          <div class=\"u-row-container v-row-background-color\" style=\"padding: 0px;background-color: transparent\">
            <div class=\"u-row\" style=\"Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;\">
              <div style=\"border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;\">
                <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td class=\"v-row-background-color\" style=\"padding: 0px;background-color: transparent;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px;\"><tr style=\"background-color: transparent;\"><![endif]-->

                <!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\" valign=\"top\"><![endif]-->
                <div class=\"u-col u-col-100\" style=\"max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;\">
                  <div style=\"height: 100%;width: 100% !important;\">
                    <!--[if (!mso)&(!IE)]><!-->
                    <div style=\"height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\">
                      <!--<![endif]-->

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <div style=\"color: #afb0c7; line-height: 170%; text-align: center; word-wrap: break-word;\">
                                <p style=\"font-size: 14px; line-height: 170%;\"><span style=\"font-size: 14px; line-height: 23.8px;\">View Email in Browser</span></p>
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



          <div class=\"u-row-container v-row-background-color\" style=\"padding: 0px;background-color: transparent\">
            <div class=\"u-row\" style=\"Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;\">
              <div style=\"border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;\">
                <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td class=\"v-row-background-color\" style=\"padding: 0px;background-color: transparent;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px;\"><tr style=\"background-color: #ffffff;\"><![endif]-->

                <!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\" valign=\"top\"><![endif]-->
                <div class=\"u-col u-col-100\" style=\"max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;\">
                  <div style=\"height: 100%;width: 100% !important;\">
                    <!--[if (!mso)&(!IE)]><!-->
                    <div style=\"height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\">
                      <!--<![endif]-->

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:20px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                                <tr>
                                  <td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\">
                                    <a href=\"https://www.otus.pl/\" target=\"_blank\">
                                      <img align=\"center\" border=\"0\" src=\"https://ci6.googleusercontent.com/proxy/DFNuvo_0xwcAcOH0wZt7v0LypjnA_O1MlxpuPkj3d1ugMXhN8rUxd6DNq2JSfLT52bk_OUkbJ88RzLzrWWso8SIlWmfrg0fqIkKjTs_G=s0-d-e1-ft#https://www.otus.pl/wp-content/uploads/2021/06/logo_ot1.png\"
                                        alt=\"Image\" title=\"Image\" style=\"outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 19%;max-width: 106.4px;\"
                                        width=\"106.4\" />
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



          <div class=\"u-row-container v-row-background-color\" style=\"padding: 0px;background-color: transparent\">
            <div class=\"u-row\" style=\"Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #003399;\">
              <div style=\"border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;\">
                <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td class=\"v-row-background-color\" style=\"padding: 0px;background-color: transparent;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px;\"><tr style=\"background-color: #003399;\"><![endif]-->

                <!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\" valign=\"top\"><![endif]-->
                <div class=\"u-col u-col-100\" style=\"max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;\">
                  <div style=\"height: 100%;width: 100% !important;\">
                    <!--[if (!mso)&(!IE)]><!-->
                    <div style=\"height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\">
                      <!--<![endif]-->

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:20px 10px 10px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                                <tr>
                                  <td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\">

                                    <img align=\"center\" border=\"0\" src=\"https://cdn.templates.unlayer.com/assets/1597218650916-xxxxc.png\" alt=\"Image\" title=\"Image\" style=\"outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 26%;max-width: 150.8px;\"
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
                                <p style=\"font-size: 14px; line-height: 140%;\"><span style=\"font-size: 24px; line-height: 33.6px;\"><strong><span style=\"line-height: 33.6px; font-size: 24px;\">Potwierdzamy zakończenie zlecenia!</span></strong>
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



          <div class=\"u-row-container v-row-background-color\" style=\"padding: 0px;background-color: transparent\">
            <div class=\"u-row\" style=\"Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;\">
              <div style=\"border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;\">
                <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td class=\"v-row-background-color\" style=\"padding: 0px;background-color: transparent;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px;\"><tr style=\"background-color: #ffffff;\"><![endif]-->

                <!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\" valign=\"top\"><![endif]-->
                <div class=\"u-col u-col-100\" style=\"max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;\">
                  <div style=\"height: 100%;width: 100% !important;\">
                    <!--[if (!mso)&(!IE)]><!-->
                    <div style=\"height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\">
                      <!--<![endif]-->

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:20px 55px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <div style=\"line-height: 160%; text-align: center; word-wrap: break-word;\">
                                <p style=\"font-size: 14px; line-height: 160%;\"><span style=\"font-size: 22px; line-height: 35.2px;\">Dzień Dobry,</span></p>
                                <p style=\"font-size: 14px; line-height: 160%;\"> </p>
                                <p style=\"font-size: 14px; line-height: 160%;\"><span style=\"font-size: 16px; line-height: 25.6px;\">Informujemy, że zlecenie o numerze </span><strong style=\"font-size: 16px;\">{$rowid}</strong><span style=\"font-size: 16px; line-height: 25.6px;\"> zostało zakończone.</span></p>
                                <p style=\"font-size: 14px; line-height: 160%;\"> </p>
                                <p style=\"font-size: 14px; line-height: 160%;\"><span style=\"font-size: 16px; line-height: 25.6px;\"><strong>Twoja opinia jest dla nas ważna!</strong></span></p>
                                <p style=\"line-height: 160%; font-size: 14px;\"> </p>
                                <p style=\"line-height: 160%; font-size: 14px;\"><span style=\"font-size: 16px; line-height: 25.6px;\">Jeżeli jesteś zadowolony zadowolony z naszych usług</span></p>
                                <p style=\"line-height: 160%; font-size: 14px;\"><span style=\"font-size: 16px; line-height: 25.6px;\"> powiedz o nas innym.</span></p>
                                <p style=\"line-height: 160%; font-size: 14px;\"> </p>
                                <p style=\"line-height: 160%; font-size: 14px;\"><span style=\"font-size: 16px; line-height: 25.6px;\">Jeżeli nie, powiedz nam, zrobimy wszystko, aby się poprawić.</span></p>
                                <p style=\"font-size: 14px; line-height: 160%;\"> </p>
                              </div>

                            </td>
                          </tr>
                        </tbody>
                      </table>

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <table height=\"0px\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%\">
                                <tbody>
                                  <tr style=\"vertical-align: top\">
                                    <td style=\"word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%\">
                                      <span>&#160;</span>
                                    </td>
                                  </tr>
                                </tbody>
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



          <div id=\"u_row_7\" class=\"u-row-container v-row-background-color\" style=\"padding: 5px;background-color: transparent\">
            <div class=\"u-row no-stack\" style=\"Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;\">
              <div style=\"border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;\">
                <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td class=\"v-row-background-color\" style=\"padding: 5px;background-color: transparent;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px;\"><tr style=\"background-color: transparent;\"><![endif]-->

                <!--[if (mso)|(IE)]><td align=\"center\" width=\"200\" style=\"background-color: #ffffff;width: 200px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;\" valign=\"top\"><![endif]-->
                <div class=\"u-col u-col-33p33\" style=\"max-width: 320px;min-width: 200px;display: table-cell;vertical-align: top;\">
                  <div style=\"background-color: #ffffff;height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;\">
                    <!--[if (!mso)&(!IE)]><!-->
                    <div style=\"height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;\">
                      <!--<![endif]-->

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                                <tr>
                                  <td style=\"padding-right: 0px;padding-left: 0px;\" align=\"right\">
                                    <a href=\"https://docs.google.com/forms/d/1zfEzgypY9bEAKs6BMstXnHsjMQX-2W5lpiodRQZSxrA/viewform?edit_requested=true\" target=\"_blank\">
                                      <img align=\"right\" border=\"0\" src=\"https://assets.unlayer.com/projects/106709/1665585323407-132914.jpg\" alt=\"\" title=\"\" style=\"outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 100%;max-width: 100px;\"
                                        width=\"100\" />
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
                <!--[if (mso)|(IE)]><td align=\"center\" width=\"200\" style=\"background-color: #ffffff;width: 200px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;\" valign=\"top\"><![endif]-->
                <div class=\"u-col u-col-33p33\" style=\"max-width: 320px;min-width: 200px;display: table-cell;vertical-align: top;\">
                  <div style=\"background-color: #ffffff;height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;\">
                    <!--[if (!mso)&(!IE)]><!-->
                    <div style=\"height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;\">
                      <!--<![endif]-->

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                                <tr>
                                  <td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\">
                                    <a href=\"https://docs.google.com/forms/d/1zfEzgypY9bEAKs6BMstXnHsjMQX-2W5lpiodRQZSxrA/viewform?edit_requested=true\" target=\"_blank\">
                                      <img align=\"center\" border=\"0\" src=\"https://assets.unlayer.com/projects/106709/1665585308531-584026.jpg\" alt=\"\" title=\"\" style=\"outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 100%;max-width: 100px;\"
                                        width=\"100\" />
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
                <!--[if (mso)|(IE)]><td align=\"center\" width=\"200\" style=\"background-color: #ffffff;width: 200px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;\" valign=\"top\"><![endif]-->
                <div class=\"u-col u-col-33p33\" style=\"max-width: 320px;min-width: 200px;display: table-cell;vertical-align: top;\">
                  <div style=\"background-color: #ffffff;height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;\">
                    <!--[if (!mso)&(!IE)]><!-->
                    <div style=\"height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;\">
                      <!--<![endif]-->

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                                <tr>
                                  <td style=\"padding-right: 0px;padding-left: 0px;\" align=\"left\">
                                    <a href=\"https://g.page/r/CYrqwLalBJ0qEAg/review\" target=\"_blank\">
                                      <img align=\"left\" border=\"0\" src=\"https://assets.unlayer.com/projects/106709/1665585289500-805885.jpg\" alt=\"\" title=\"\" style=\"outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 100%;max-width: 100px;\"
                                        width=\"100\" />
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



          <div class=\"u-row-container v-row-background-color\" style=\"padding: 0px;background-color: transparent\">
            <div class=\"u-row\" style=\"Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #e5eaf5;\">
              <div style=\"border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;\">
                <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td class=\"v-row-background-color\" style=\"padding: 0px;background-color: transparent;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px;\"><tr style=\"background-color: #e5eaf5;\"><![endif]-->

                <!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\" valign=\"top\"><![endif]-->
                <div class=\"u-col u-col-100\" style=\"max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;\">
                  <div style=\"height: 100%;width: 100% !important;\">
                    <!--[if (!mso)&(!IE)]><!-->
                    <div style=\"height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\">
                      <!--<![endif]-->

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:20px 55px 18px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <div style=\"color: #003399; line-height: 160%; text-align: center; word-wrap: break-word;\">
                                <p style=\"font-size: 14px; line-height: 160%;\"><span style=\"color: #000000; font-size: 14px; line-height: 22.4px; font-family: arial, helvetica, sans-serif;\">OTUS Sp. z o.o.</span><br /><span style=\"color: #000000; font-size: 14px; line-height: 22.4px; font-family: arial, helvetica, sans-serif;\">ul. Wrocławska 23 , 55-010 Radwanice</span><br
                                  /><span style=\"color: #000000; font-size: 14px; line-height: 22.4px; font-family: arial, helvetica, sans-serif;\">+48 71 321 19 06</span></p>
                                <p style=\"font-size: 14px; line-height: 160%;\"><span style=\"color: #000000; font-size: 14px; line-height: 22.4px; font-family: arial, helvetica, sans-serif;\"><a rel=\"noopener\" href=\"mailto:info@otus.com.pl?subject=Dotyczy%20zg%C5%82oszenia%20numer%20{$rowid}&body=\" target=\"_blank\">info@otus.com.pl</a></span></p>
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



          <div class=\"u-row-container v-row-background-color\" style=\"padding: 0px;background-color: transparent\">
            <div class=\"u-row\" style=\"Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #003399;\">
              <div style=\"border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;\">
                <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td class=\"v-row-background-color\" style=\"padding: 0px;background-color: transparent;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px;\"><tr style=\"background-color: #003399;\"><![endif]-->

                <!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\" valign=\"top\"><![endif]-->
                <div class=\"u-col u-col-100\" style=\"max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;\">
                  <div style=\"height: 100%;width: 100% !important;\">
                    <!--[if (!mso)&(!IE)]><!-->
                    <div style=\"height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;\">
                      <!--<![endif]-->

                      <table style=\"font-family:'Cabin',sans-serif;\" role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                        <tbody>
                          <tr>
                            <td style=\"overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Cabin',sans-serif;\" align=\"left\">

                              <div style=\"color: #fafafa; line-height: 180%; text-align: center; word-wrap: break-word;\">
                                <p style=\"font-size: 14px; line-height: 180%;\"><span style=\"font-size: 16px; line-height: 28.8px;\"><span style=\"color: #ffffff; font-size: 16px; line-height: 28.8px;\"><a rel=\"noopener\" href=\"https://www.otus.pl/kontakt\" target=\"_blank\" style=\"color: #ffffff;\">Skontaktuj się z nami</a></span></span>
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