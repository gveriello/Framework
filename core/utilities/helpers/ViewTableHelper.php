<?php

class ViewTableHelper
{
    static private $Column = array();
    static private $Data = array();
    static private $ColumnData = array();
    static private $Row = 0;
    static private $Style = array(
            "table" => '',
            "thead" => array(),
            "tbody" => array(),
            "row" => array(),
            "column" => array(),
        );
    static private $Class = array(
            "table" => '',
            "thead" => array(),
            "tbody" => array(),
            "row" => array(),
            "column" => array(),
        );


    #region Style
    public static function SetStyle($_formcontrol, $_controlname, $_style)
    {
        self::$Style[$_formcontrol][$_controlname] = $_style;
    }

    public static function RemoveStyle($_formcontrol, $_controlname){
        if (in_array($_controlname, self::$Style[$_formcontrol])){
            unset(self::$Style[$_formcontrol][$_controlname]);
        }
    }

    public static function GetStyle($_formcontrol, $_controlname = ''){
        if (is_array(self::$Style[$_formcontrol])){
            if (empty($_controlname)){
                if (in_array($_formcontrol, self::$Style))
                    return self::$Style[$_formcontrol];
                else
                    return '';
            }else{
                if (array_key_exists($_controlname,self::$Style[$_formcontrol]))
                    return self::$Style[$_formcontrol][$_controlname];
                else
                    return '';
            }
        }else{
            return (empty(self::$Style[$_formcontrol]) ? '' : self::$Style[$_formcontrol]);
        }
    }
    #endregion

    #region Class
    public static function SetClass($_formcontrol, $_controlname, $_style)
    {
        self::$Class[$_formcontrol][$_controlname] = $_style;
    }

    public static function RemoveClass($_formcontrol, $_controlname){
        if (in_array($_controlname, self::$Class[$_formcontrol])){
            unset(self::$Class[$_formcontrol][$_controlname]);
        }
    }

    public static function GetClass($_formcontrol, $_controlname = ''){
        if (is_array(self::$Class[$_formcontrol])){
            if (empty($_controlname)){
                if (in_array($_formcontrol, self::$Class))
                    return self::$Class[$_formcontrol];
                else
                    return '';
            }else{
                if (array_key_exists($_controlname,self::$Class[$_formcontrol]))
                    return self::$Class[$_formcontrol][$_controlname];
                else
                    return '';
            }
        }else{
            return (empty(self::$Class[$_formcontrol]) ? '' : self::$Class[$_formcontrol]);
        }
    }
    #endregion

    #region Operation to column
    public static function AddColumn($_column)
    {
        if ($_column !== NULL){
            if (!in_array($_column, self::$Column)){
                if (!strpos($_column, ',')){
                    array_push(self::$Column, $_column);
                    self::$ColumnData[$_column] = array();
                }else{
                    $_columntemp = explode(',', $_column);
                    foreach($_columntemp as $ColumnKey){
                        array_push(self::$Column, $ColumnKey);
                        self::$ColumnData[$ColumnKey] = array();
                    }
                }
            }else{
                throw new InvalidArgumentException("Column exist");
            }
        }else{
            throw new InvalidArgumentException("Column must be a string");
        }
    }

    public static function RemoveColumn($_columnname)
    {
        if (!in_array($_columnname, self::$Column)){
            unset(self::$Column[$_columnname]);
        }
    }

    public static function ConfigurationFromLayout($layoutFile, $idTable)
    {
        if (!class_exists('HtmlParserHelper'))
            Allocator::allocate_helper('HtmlParser');

        HtmlParserHelper::LoadHtmlFromFile($layoutFile);
        $configuration = HtmlParserHelper::GetControlByName($idTable);
        if (!empty($configuration))
        {
            foreach($configuration->childNodes as $column)
                if ($column->nodeName === 'column')
                    if($column->hasAttribute('id'))
                    {
                        if ($column->hasAttribute('binding-property'))
                            if (!empty($column->getAttribute('binding-property')))
                                self::AddColumn($column->getAttribute('binding-property'));
                        if ($column->hasAttribute('style'))
                            if (!empty($column->getAttribute('style')))
                                self::SetStyle('column', $column->getAttribute('id'), $column->getAttribute('style'));
                    }
        }

        HtmlParserHelper::Clear();
    }
    #endregion

    #region Operation to Data
    public static function AddData($_data){
        if (is_array($_data)){
            self::$Data = $_data;
        }else{
            throw new InvalidArgumentException("Data must be an array or matrix");
        }
    }

    public static function RemoveData(){
        self::$Data = array();
    }
    #endregion

    #region DataBinding Control
    public static function DataBinding(){
        if (self::$Data !== NULL && count(self::$Column) > 0){
            for($i = 0; $i < count(self::$Data); $i++){
                if (count(self::$Data[$i]) > self::$Row)
					self::$Row = count(self::$Data[$i]);
                for($k = 0; $k < count(self::$Column); $k++){
                    if (array_key_exists(self::$Column[$k], self::$Data[$i]))
                        array_push(self::$ColumnData[self::$Column[$k]], self::$Data[$i][self::$Column[$k]]);
                    else
                        array_push(self::$ColumnData[self::$Column[$k]], '');
                }
            }
        }else{
            throw new InvalidArgumentException("Data or Columns is null");
        }
    }
    #endregion

    #region Result Html
    public static function TableToHtml(){
        if (count(self::$ColumnData) > 0){
            $table = '<table '
                .(!empty(self::GetStyle('table')) ? 'style="'.self::GetStyle('table').'" ': null)
                .(!empty(self::GetClass('table')) ? 'class="'.self::GetClass('table').'" ': null)
                .'>';
            $table .= '<thead '
                .(!empty(self::GetStyle('thead')) ? 'style="'.self::GetStyle('thead').'" ': null)
                .(!empty(self::GetClass('thead')) ? 'class="'.self::GetClass('thead').'" ': null)
                .'>';
            foreach(self::$Column as $ColumnKey){
                $table .= '<th '
                .(!empty(self::GetStyle('column', $ColumnKey)) ? 'style="'.self::GetStyle('column', $ColumnKey).'" ': null)
                .(!empty(self::GetClass('column', $ColumnKey)) ? 'class="'.self::GetClass('column', $ColumnKey).'" ': null)
                .'>'.$ColumnKey.'</th>';
            }
            $table .= '</thead>';

            $table .= '<tbody '
                .(!empty(self::GetStyle('tbody')) ? 'style="'.self::GetStyle('tbody').'" ': null)
                .(!empty(self::GetClass('tbody')) ? 'class="'.self::GetClass('tbody').'" ': null)
                .'>';
            for($r = 0; $r < self::$Row; $r++){
                $table .= '<tr '
                .(!empty(self::GetStyle('row')) ? 'style="'.self::GetStyle('row').'" ': null)
                .(!empty(self::GetClass('row')) ? 'class="'.self::GetClass('row').'" ': null)
                    .'>';
                for($k = 0; $k < count(self::$Column); $k++){
                    $table .= '<td '
                .(!empty(self::GetStyle('column', self::$ColumnData[self::$Column[$k]][$r])) ? 'style="'.self::GetStyle('column', self::$ColumnData[self::$Column[$k]][$r]).'" ': null)
                .(!empty(self::GetClass('column', self::$ColumnData[self::$Column[$k]][$r])) ? 'class="'.self::GetClass('column', self::$ColumnData[self::$Column[$k]][$r]).'" ': null)
                        .'>';
                    $table .= self::$ColumnData[self::$Column[$k]][$r];
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