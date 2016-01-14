<!DOCTYPE html>
<html{if $Page->GetPageDirection() != null} dir="{$Page->GetPageDirection()}"{/if}>
    <head>
        <title>{$Page->GetCaption()}</title>
        <meta http-equiv="content-type" content="text/html{if $Page->GetContentEncoding() != null}; charset={$Page->GetContentEncoding()}{/if}">
<style>
img
{ldelim}
    border-width: 0;
{rdelim}
body
{ldelim}
    font-family: Verdana, sans-serif;
{rdelim}
table
{ldelim}
    border-collapse: collapse;
    border: 0;
{rdelim}
table.wide
{ldelim}
    width: 95%;
{rdelim}
td
{ldelim}
    font-size: 11px;
    padding: 5px;
    margin: 0;
    border-width: 1px;
    border-style: solid;
    border-color: #000000;
    vertical-align:top;
{rdelim}
.text-center
{ldelim}
    text-align: center;
{rdelim}
@media print
{ldelim}
    a.pdf
    {ldelim}
        display:none
    {rdelim}
{rdelim}

</style>
</head>
<body style="background-color:white">
    <h1>{$Page->GetCaption()}</h1>

{$Grid}
</body>
</html>