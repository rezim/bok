<?php
class log extends Model 
{
    protected $umowa='',$drukarka='',$toner='',$klient='',$rodzaj='';
    
    function getLogs()
    {
        
        switch ($this->rodzaj) 
        {
                case 'klient':
                    $query = 
                    "
                        
                    ";
                    break;
                case 'drukarka':
                    
                    break;
                case 'toner':
                    
                    break;
                case 'umowa':
                    
                    break;
        }
        
        
        return $this->query($query,null,false); 

    }   
}