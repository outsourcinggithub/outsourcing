<?xml version="1.0" encoding="utf-8" ?>
<errorinfo>
    <errormessage><![CDATA[
        {include file='common/error_message.tpl' dismissable=false caption=$Captions->GetMessageString($ErrorCaption) content=$ErrorMessage}
    ]]></errormessage>
{foreach from=$ColumnEditors key=name item=editor name=Editors}
    <editor name="{$name}">
        <html>
            <![CDATA[
                {$editor.Html}
            ]]>
        </html>
        <script>
            <![CDATA[
                {$editor.Script}
            ]]>
        </script>
    </editor>
{/foreach}
</errorinfo>

