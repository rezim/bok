<?php
class mail extends Model
{
    protected $from,$to,$nazwa,$temat,$tresc;
    
    
    
    function valideMessage()
    {
        
           if(empty($this->nazwa))
           {
               echo('Wpisz poprawne imię i nazwisko');return false;die();
           }
           if(empty($this->from) || !validEmail($this->from))
           {
               echo('Wpisz poprawny e-mail');return false;die();
           }
           if(empty($this->to) || !validEmail($this->to))
           {
               echo('Wpisz poprawny adres odbiorcy');return false;die();
           }
           if(empty($this->temat))
           {
               echo('Uzupełnij temat wiadomość');return false;die();
           }
           if(empty($this->tresc))
           {
               echo('Uzupełnij treść wiadomość');return false;die();
           }
           return true;
    }
    function sendMessage()
    {
        
        $od = '';
        if(!empty($this->nazwa))
        {
            $od = "---------------------------------<br/>Wiadomość od : {$this->nazwa}<br/>---------------------------------<br/><br/>";
        }
        
                                $message = "<html>
                                <head>
                                </head>
                                <body>
                                 {$od}".
                                 ($od==''?$this->tresc: nl2br($this->tresc))."
                                  <br/><br/>
                                
                                  <div style='display:block;margin-top:-20px;'>
                                  z poważaniem<br/>
                                  zespół 
                                  <a href='".ADRESHTTP."' title='brandPOS.pl - sprzedaż powierzchni reklamowych oraz reklam'>
                                  <span style='font-weight: bold;color:#d81a1a;font-style:italic;text-decoration:none'> brandPOS.pl</span>
                                  </a>
                                  </div>
                                  <a href='".ADRESHTTP."' title='brandPOS.pl - sprzedaż powierzchni reklamowych oraz reklam'>
                                    <img src='".ADRESHTTP."/".SMARTVERSION."/img/logo.png' style='border:none;'></img>
                                  </a>
                                </body>
                                </html>
                                ";
                                $headers  = 'MIME-Version: 1.0' . "\r\n";
                                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                                $headers .= "From: "."{$this->from}"."" . "\r\n";
                                mail($this->to, $this->temat, $message, $headers);
    }
}