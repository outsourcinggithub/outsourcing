<?php

// require_once 'renderer.php';
// require_once 'components/utils/file_utils.php';

include_once dirname(__FILE__) . '/' . 'renderer.php';
include_once dirname(__FILE__) . '/' . '../utils/file_utils.php';


class PdfRenderer extends Renderer
{
    function RenderPageNavigator($PageNavigator)
    { }

    function RenderDetailPageEdit($page)
    {
        $this->RenderPage($page);
    }

    /**
     * @param Page $Page
     * @return void
     */
    function RenderPage(Page $Page)
    {
        include_once 'components/utils/check_utils.php';
        CheckMbStringExtension();
        CheckIconvExtension();

        include_once 'libs/mpdf/mpdf.php';

        set_time_limit(0);
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        
        $html = $this->Render($Page->GetGrid());

        $mpdf = new mPDF('utf-8', 'A4', '8', '', 10, 10, 7, 7, 10, 10);
        $mpdf->charset_in = $Page->GetContentEncoding();


        $stylesheet = FileUtils::ReadAllText('components/assets/css/pdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->list_indent_first_level = 0;
        $mpdf->WriteHTML($html, 2);
        //echo $html;
        $mpdf->Output('mpdf.pdf', 'I');

        $this->result =  '';
    }


    protected function GetCustomRenderedViewColumn(CustomViewColumn $column, $rowValues)
    {
        $result = '';
        $handled = false;
        $column->GetGrid()->OnCustomRenderExportColumn->Fire(array(
            'pdf', $this->GetFriendlyColumnName($column), $column->GetData(), $rowValues, &$result, &$handled)
        );

        if ($handled)
            return $result;
        else
            return null;
    }


    private function CreateTableHeaderData(Grid $Grid)
    {
        $headCellsData = array();
        $exportColumns = $Grid->GetExportColumns();
        foreach($exportColumns as $Column)
        {
            $headColumnsStyleBuilder = new StyleBuilder();

            if ($Column->GetFixedWidth() != null)
                $headColumnsStyleBuilder->Add('width', $Column->GetFixedWidth());

            array_push(
                $headCellsData,
                array(
                    'Caption' => $Column->GetCaption(),
                    'Style' => $headColumnsStyleBuilder->GetStyleString()
                ));
        }
        return array(
            'Cells' => $headCellsData
        );
    }

    private function GetStylesForColumn(Grid $grid, $rowData)
    {
        $rowCssStyle = '';
        $cellCssStyles = array();
        $rowClasses = '';
        $cellClasses = array();
        $grid->OnCustomDrawCell->Fire(array($rowData, &$cellCssStyles, &$rowCssStyle, &$rowClasses, &$cellClasses));

        $cellFontColor = array();
        $cellFontSize = array();
        $cellBgColor = array();
        $cellItalicAttr = array();
        $cellBoldAttr = array();

        $grid->OnCustomDrawCell_Simple->Fire(array($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr));

        $result = array();
        $fieldNames = array_unique(array_merge(
            array_keys($cellFontColor),
            array_keys($cellFontSize),
            array_keys($cellBgColor),
            array_keys($cellItalicAttr),
            array_keys($cellBoldAttr)));

        $fieldStylesBuilder = new StyleBuilder();
        foreach ($fieldNames as $fieldName)
        {
            $fieldStylesBuilder->Clear();
            if (array_key_exists($fieldName, $cellFontColor))
                $fieldStylesBuilder->Add('color', $cellFontColor[$fieldName]);
            if (array_key_exists($fieldName, $cellFontSize))
                $fieldStylesBuilder->Add('font-size', $cellFontSize[$fieldName]);
            if (array_key_exists($fieldName, $cellBgColor))
                $fieldStylesBuilder->Add('background-color', $cellBgColor[$fieldName]);
            if (array_key_exists($fieldName, $cellItalicAttr))
                $fieldStylesBuilder->Add('font-style',
                    $cellItalicAttr[$fieldName] ? 'italic' : 'normal');
            if (array_key_exists($fieldName, $cellBoldAttr))
            {
                $fieldStylesBuilder->Add('font-weight',
                    $cellBoldAttr[$fieldName] ? 'bold' : 'normal');
            }
            $result[$fieldName] = $fieldStylesBuilder->GetStyleString();
        }

        return array_merge($result, $cellCssStyles);
    }

    function RenderGrid(Grid $Grid)
    {
        $Rows = array();
        $HeaderCaptions = array();
        $Grid->GetDataset()->Open();
        foreach($Grid->GetExportColumns() as $Column)
            $HeaderCaptions[] = $Column->GetCaption();
        while($Grid->GetDataset()->Next())
        {
            $Row = array();
            $rowValues = $Grid->GetDataset()->GetFieldValues();
            $cellStyles = $this->GetStylesForColumn($Grid, $rowValues);

            foreach($Grid->GetExportColumns() as $column)
            {
                $columnName = $Grid->GetColumnName($column);

                $cell['Value'] = $this->RenderViewColumn($column, $rowValues);
                $cell['Align'] = $column->GetAlign();

                $cellStyle = new StyleBuilder();
                $cellStyle->Add('width', $column->GetFixedWidth());
                if (!$column->GetWordWrap())
                    $cellStyle->Add('white-space', 'nowrap');
                $cellStyle->AddStyleString(ArrayUtils::GetArrayValueDef($cellStyles, $columnName));

                $cell['Style'] = $cellStyle->GetStyleString();

                $Row[] = $cell;
            }
            $Rows[] = $Row;
        }

        $this->DisplayTemplate('export/pdf_grid.tpl',
            array(),
            array(
                'TableHeader' => $this->CreateTableHeaderData($Grid),
                'Rows' => $Rows
            ));
    }

    protected function HttpHandlersAvailable() 
    { 
        return false;
    }

    protected function HtmlMarkupAvailable() 
    { 
        return false;
    }    
}
?>