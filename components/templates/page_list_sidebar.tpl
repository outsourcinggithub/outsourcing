<div class="sidebar-nav">

    {foreach item=Group from=$List.Groups}
        <ul class="nav nav-pills nav-stacked">
            <li class="sidebar-nav-head">
                <span class="sidebar-nav-item">
                    {if $Group == 'Default'}
                        {$Captions->GetMessageString('PageList')}
                    {else}
                        {$Group}
                    {/if}
                </span>
            </li>

            {foreach item=PageListPage from=$List.Pages}

                {if $PageListPage.GroupName == $Group}

                    {if $PageListPage.BeginNewGroup}
                        <li class="nav-divider"></li>
                    {/if}

                    {if $PageListPage.IsCurrent}
                        <li class="active" title="{$PageListPage.Hint}">
                            <span class="sidebar-nav-item">
                                <i class="icon-page"></i>
                                {$PageListPage.Caption}
                                {if $List.RSSLink}
                                    <a href="{$List.RSSLink}" class="pull-right link-icon">
                                        <i class="icon-rss"></i>
                                    </a>
                                {/if}
                            </span>
                        </li>
                    {else}
                        <li><a class="sidebar-nav-item" href="{$PageListPage.Href|escapeurl}" title="{$PageListPage.Hint}">
                            <i class="icon-page"></i>
                            {$PageListPage.Caption}
                        </a></li>
                    {/if}

                {/if}

            {/foreach}

        </ul>
    {/foreach}

</div>