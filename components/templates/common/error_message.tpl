<div class="alert alert-danger{if !isset($dismissable) or $dismissable} alert-dismissable{/if}">

    {if !isset($dismissable) or $dismissable}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {/if}

    {if isset($caption) and $caption}
        <strong>{$caption}</strong><br>
    {/if}

    {$content}

</div>