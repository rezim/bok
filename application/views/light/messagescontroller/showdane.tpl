<div id="tableMessages" class="messages">
    {foreach from=$messages item=item key=key}
    <div>
        <span class="owner">{$item.owner}</span> &nbsp; <span class="created">{$item.created}</span>
        <span class="action fas fa-times fa-3 cursor-pointer" onclick="removeMessage({$item.rowid})"></span>
    </div>
    <div class="message">
        {$item.message}
    </div>
    {/foreach}
</div>
