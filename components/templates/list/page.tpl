{capture assign="ContentBlock"}

    {include file="page-header.tpl" pageTitle=$Page->GetCaption()}
    {include file="list/page_navigator_modal.tpl"}

    {include file="page_description_block.tpl" Description=$Page->GetGridHeader()}

    {$PageNavigator1}

    {$Grid}

    {$PageNavigator2}

{/capture}

{* Base template *}
{include file="common/list_page_template.tpl"}