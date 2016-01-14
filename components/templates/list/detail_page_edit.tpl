{capture assign="ContentBlock"}

    {include file="page-header.tpl" pageTitle=$Page->GetCaption()}

    {include file="page_description_block.tpl" Description=$Page->GetGridHeader()}

    <p>{$Captions->GetMessageString('MasterRecord')}
        (<a href="{$Page->GetParentPageLink()|escapeurl}">{$Captions->GetMessageString('ReturnFromDetailToMaster')}</a>)
    </p>

    {$MasterGrid}

    {if count($SiblingDetails) > 1}
        <ul class="nav nav-tabs">
            {foreach from=$SiblingDetails item=SiblingDetail name=SiblingDetailsSection}
                <li class="{if $DetailPageName == $SiblingDetail.Name}active{/if}">
                    <a href="{$SiblingDetail.Link|escapeurl}">
                        {$SiblingDetail.Caption}
                    </a>
                </li>
            {/foreach}
        </ul>
    {/if}

    {$PageNavigator1}

    {$Grid}

    {$PageNavigator2}

    {include file="list/page_navigator_modal.tpl"}
{/capture}

{* Base template *}
{include file="common/list_page_template.tpl"}