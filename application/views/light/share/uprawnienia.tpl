{if isset($smarty.session.shares)}

{foreach from=$smarty.session.shares item=item key=key }             
    {if isset($smarty.session.przypisaneshares[$key])}
        
        {if $smarty.session.przypisaneshares[$key]['permission']=='r'}
            <script type="text/javascript">
                
                    if ( $('#{$key}').is( "a" ) )
                    {
                      
                          $('#{$key}').css('display','none');
                          $('#tr{$key}').css('display','none');
                    }
                    else if ( $('#{$key}').is( "img" ) )
                    {
                         $('#{$key}').css('display','none');
                         $('#tr{$key}').css('display','none');
                    }
                     else if ( $('{$key}').is( "div" ) )
                    {
                         $('#{$key}').css('display','none');
                        $('#tr{$key}').css('display','none');
                    }
                    else
                    {
                      
                        $('#{$key}').prop('disabled', true);
                    }
            </script>
        {/if}
    {else}
        <script type="text/javascript">
            $('#{$key}').css('display','none');
            $('#tr{$key}').css('display','none');
        </script>
    {/if}
    
    
    
{/foreach}
{/if}
