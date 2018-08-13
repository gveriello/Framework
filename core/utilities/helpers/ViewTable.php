<?php

class ViewTable
{
    private $Column;
    private $Data;
    private $ColumnData;
    private $Row;
    private $Style;
    private $Class;
    function __construct()
    {
        $this->Row = 0;
        $this->ColumnData = array();
        $this->Column = array();
        $this->Data = array();
        $this->Style = array(
            "table" => '',
            "thead" => array(),
            "tbody" => array(),
            "row" => array(),
            "column" => array(),
        );
        $this->Class = array(
            "table" => '',
            "thead" => array(),
            "tbody" => array(),
            "row" => array(),
            "column" => array(),
        );
    }

    #region Style
    function SetStyle($_formcontrol, $_controlname, $_style)
    {
        $this->Style[$_formcontrol][$_controlname] = $_style;
    }
    function RemoveStyle($_formcontrol, $_controlname){
        if (in_array($_controlname, $this->Style[$_formcontrol])){
            unset($this->Style[$_formcontrol][$_controlname]);
        }
    }
    function GetStyle($_formcontrol, $_controlname = ''){
        if (is_array($this->Style[$_formcontrol])){
            if (empty($_controlname)){
                if (in_array($_formcontrol, $this->Style))
                    return $this->Style[$_formcontrol];
                else
                    return '';
            }else{
                if (array_key_exists($_controlname,$this->Style[$_formcontrol]))
                    return $this->Style[$_formcontrol][$_controlname];
                else
                    return '';
            }
        }else{
            return (empty($this->Style[$_formcontrol]) ? '' : $this->Style[$_formcontrol]);
        }
    }
    #endregion

    #region Class
    function SetClass($_formcontrol, $_controlname, $_style)
    {
        $this->Class[$_formcontrol][$_controlname] = $_style;
    }
    function RemoveClass($_formcontrol, $_controlname){
        if (in_array($_controlname, $this->Class[$_formcontrol])){
            unset($this->Class[$_formcontrol][$_controlname]);
        }
    }
    function GetClass($_formcontrol, $_controlname = ''){
        if (is_array($this->Class[$_formcontrol])){
            if (empty($_controlname)){
                if (in_array($_formcontrol, $this->Class))
                    return $this->Class[$_formcontrol];
                else
                    return '';
            }else{
                if (array_key_exists($_controlname,$this->Class[$_formcontrol]))
                    return $this->Class[$_formcontrol][$_controlname];
                else
                    return '';
            }
        }else{
            return (empty($this->Class[$_formcontrol]) ? '' : $this->Class[$_formcontrol]);
        }
    }
    #endregion

    #region Operation to column
    function AddColumn($_column)
    {
        if ($_column !== NULL){
            if (!in_array($_column, $this->Column)){
                if (!strpos($_column, ',')){
                    array_push($this->Column, $_column);
                    $this->ColumnData[$_column] = array();
                }else{
                    $_columntemp = explode(',', $_column);
                    foreach($_columntemp as $ColumnKey){
                        array_push($this->Column, $ColumnKey);
                        $this->ColumnData[$ColumnKey] = array();
                    }
                }
            }else{
                throw new InvalidArgumentException("Column exist");
            }
        }else{
            throw new InvalidArgumentException("Column must be a string");
        }
    }
    function RemoveColumn($_columnname){
        if (!in_array($_columnname, $this->Column)){
            unset($this->Column[$_columnname]);
        }
    }
    #endregion

    #region Operation to Data
    function AddData($_data){
        if (is_array($_data)){
            $this->Data = $_data;
        }else{
            throw new InvalidArgumentException("Data must be an array or matrix");
        }
    }
    function RemoveData(){
        $this->Data = array();
    }
    #endregion

    #region DataBinding Control
    function DataBinding(){
        if ($this->Data !== NULL && count($this->Column) > 0){
            for($i = 0; $i < count($this->Data); $i++){
                if (count($this->Data[$i]) > $this->Row) $this->Row = count($this->Data[$i]);
                for($k = 0; $k < count($this->Column); $k++){
                    if (array_key_exists($this->Column[$k], $this->Data[$i]))
                        array_push($this->ColumnData[$this->Column[$k]], $this->Data[$i][$this->Column[$k]]);
                    else
                        array_push($this->ColumnData[$this->Column[$k]], '');
                }
            }
        }else{
            throw new InvalidArgumentException("Data or Columns is null");
        }
    }
    #endregion

    #region Result Html
    function TableToHtml(){
        if (count($this->ColumnData) > 0){
            $table = '<table '
                .(!empty($this->GetStyle('table')) ? 'style="'.$this->GetStyle('table').'" ': null)
                .(!empty($this->GetClass('table')) ? 'class="'.$this->GetClass('table').'" ': null)
                .'>';
            $table .= '<thead '
                .(!empty($this->GetStyle('thead')) ? 'style="'.$this->GetStyle('thead').'" ': null)
                .(!empty($this->GetClass('thead')) ? 'class="'.$this->GetClass('thead').'" ': null)
                .'>';
            foreach($this->Column as $ColumnKey){
                $table .= '<th '
                .(!empty($this->GetStyle('column', $ColumnKey)) ? 'style="'.$this->GetStyle('column', $ColumnKey).'" ': null)
                .(!empty($this->GetClass('column', $ColumnKey)) ? 'class="'.$this->GetClass('column', $ColumnKey).'" ': null)
                .'>'.$ColumnKey.'</th>';
            }
            $table .= '</thead>';

            $table .= '<tbody '
                .(!empty($this->GetStyle('tbody')) ? 'style="'.$this->GetStyle('tbody').'" ': null)
                .(!empty($this->GetClass('tbody')) ? 'class="'.$this->GetClass('tbody').'" ': null)
                .'>';
            for($r = 0; $r < $this->Row; $r++){
                $table .= '<tr '
                .(!empty($this->GetStyle('row')) ? 'style="'.$this->GetStyle('row').'" ': null)
                .(!empty($this->GetClass('row')) ? 'class="'.$this->GetClass('row').'" ': null)
                    .'>';
                for($k = 0; $k < count($this->Column); $k++){
                    $table .= '<td '
                .(!empty($this->GetStyle('column', $this->ColumnData[$this->Column[$k]][$r])) ? 'style="'.$this->GetStyle('column', $this->ColumnData[$this->Column[$k]][$r]).'" ': null)
                .(!empty($this->GetClass('column', $this->ColumnData[$this->Column[$k]][$r])) ? 'class="'.$this->GetClass('column', $this->ColumnData[$this->Column[$k]][$r]).'" ': null)
                        .'>';
                    $table .= $this->ColumnData[$this->Column[$k]][$r];
                    $table .= '</td>';
                }
                $table .= '</tr>';
            }
            $table .= '</tbody>';
            $table .= '</table>';

            return $table;
        }else{
            throw new InvalidArgumentException("Data or Columns is null");
        }
    }
    #endregion
}