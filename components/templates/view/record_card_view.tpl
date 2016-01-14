<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">{$Captions->GetMessageString('View')}</h4>
        </div>
        <div class="modal-body">

            <div class="form-horizontal">
                {section name=RowGrid loop=$ColumnCount}
                    <div class="form-group" {if $RowCssStyles[$smarty.foreach.RowsGrid.index] != ''} style="{$RowCssStyles[$smarty.foreach.RowsGrid.index]}"{/if}>
                        <label class="col-sm-3 control-label">
                            {$Columns[$smarty.section.RowGrid.index]->GetCaption()}
                        </label>
                        <div class="col-sm-9">
                            <div class="form-control-static">
                                {$Row[$smarty.section.RowGrid.index]}
                            </div>
                        </div>
                    </div>
                {/section}
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>