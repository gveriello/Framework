<?php

class FileHelper
{

    public static function CreateWord($htmlText, $fileName = 'julius_word.doc')
    {
        if(!empty($fileName) && !empty($htmlText))
        {
            header("Content-type: application/vnd.ms-word");
            header("Content-Disposition: attachment;Filename=".$fileName);
            echo $htmlText;
        }
    }

    public static function CreateExcel($htmlTable, $fileName = 'julius_excel.xls')
    {
        if(!empty($fileName) && !empty($htmlTable))
        {
            header ("Content-Type: application/vnd.ms-excel");
            header ("Content-Disposition: inline; filename=".$fileName);
            echo $htmlTable;
        }
    }

    public static function CreateTXT($text, $fileName = 'julius_txt.txt')
    {
        if (empty($text))
            return false;

        file_put_contents($fileName, $text, FILE_APPEND | LOCK_EX);
        return true;
    }

    public static function CreateGenericFile($body, $fileName = 'julius_generic_file', $extension = '.txt')
    {
        if (empty($body) || empty($fileName) || empty($extension))
            return false;

        file_put_contents(basename($fileName).$extension, $body, FILE_APPEND | LOCK_EX);
        return true;
    }

}