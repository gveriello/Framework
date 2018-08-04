<?php

class ViewTable
{
    private $Column;
    private $Data;
    private $ColumnData;
    private $Row = 0;
    function __construct(){
        $this->Column = array();
        $this->Data = array();
        $this->ColumnData = array();
    }

    function AddColumn($_column){
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

    function AddData($_data){
        if (is_array($_data)){
            $this->Data = $_data;
        }else{
            throw new InvalidArgumentException("Data must be an array or matrix");
        }
    }


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

    function TableToHtml(){

        if (count($this->ColumnData) > 0){
            $table = '<table>';
            $table .= '<thead>';
            foreach($this->Column as $ColumnKey) $table .= '<th>'.$ColumnKey.'</th>';
            $table .= '</thead>';
            $table .= '<tbody>';
            for($r = 0; $r < $this->Row; $r++){
                $table .= '<tr>';
                for($k = 0; $k < count($this->Column); $k++){
                    $table .= '<td>';
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

}