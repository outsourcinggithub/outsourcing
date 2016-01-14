<?php

class ExternalAudioFileColumn extends ExternalImageColumn
{
    public function GetValue()
    {
        $fieldValue = $this->GetDataset()->GetFieldValueByName($this->GetFieldName());
        if ($fieldValue == null) {
            return '<em class="pgui-null-value">NULL</em>';
        } else {
            return '<audio controls>'.
            ' <source src="'.$this->GetSourcePrefix().$fieldValue.$this->GetSourceSuffix().'" type="audio/mpeg">'.
            ' Your browser does not support the audio element.'.
            '</audio>';
        }
    }
}