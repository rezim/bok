function acl_logowanie(adres,sciezka)
{
     var 
    doc=document,
    objLoad=doc.getElementById('actionloader'),
    objOk = doc.getElementById('actionok'),
    objError = doc.getElementById('actionerror'),
    objClick = doc.getElementById('actionbuttonclick');
    
    $(objClick).hide();
    $(objLoad).show();
    
     $.ajax({
            type:'POST',
            url:sciezka+"/acls/logowanie/notemplate",
            data: 
            {
                login:doc.getElementById('txtLogin').value,
                pass:doc.getElementById('txtPassword').value
            },
            success: function(dane) 
            {//poprawna rejestracja 
                $(objLoad).hide();
                 try
                  {
                    dane = $.parseJSON(dane);
                  }
                  catch(e)
                  {
                      showError(objError,objLoad,dane,objClick,3000);
                                        return false;
                    }
                if(dane.status===0)
                {
                    showError(objError,objLoad,dane.info,objClick,3000);
                    return false;
                }
                else
                {
                 
                   window.location=adres;
                }   
            },
            error: function(dane)
            {
                
                showError(objError,objLoad,null,objClick,3000);
                                        return false;
            }
            });
}