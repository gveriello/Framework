<?php

/**
 * HtmlParserHelper short summary.
 *
 * HtmlParserHelper description.
 *
 * @version 1.0
 * @author gveriello
 */
class HtmlParserHelper
{
    private static $document;
    private static $bindingdone;
    private static $stringer;

    public static function LoadHtmlFromString($html_string)
    {
        self::$document = new DOMDocument;
        self::$bindingdone = array();
        self::$stringer = Allocator::allocate_helper('Stringer');
        self::$document->loadHTML($html_string);
        foreach (self::$document->childNodes as $item)
            if ($item->nodeType == XML_PI_NODE)
                self::$document->removeChild($item);
    }
    public static function LoadHtmlFromFile($html_file_path)
    {
        self::$document = new DOMDocument;
        self::$bindingdone = array();
        self::$stringer = Allocator::allocate_helper('Stringer');
        self::$document->loadHTML($html_file_path);
        foreach (self::$document->childNodes as $item)
            if ($item->nodeType == XML_PI_NODE)
                self::$document->removeChild($item);
    }
    public static function RunHtml()
    {
        $editedHtml = self::$document->saveHTML();
        echo $editedHtml;
    }
    public static function Binding($view_bag)
    {
        if ($view_bag->Length() === 0)
            throw new Exception("Binding required Data");

        $elements = self::$document->getElementsByTagName('*');

        foreach ($elements as $node)
        {
            $text_node = $node->nodeValue;
            if (!empty($text_node))
                $text_node = trim($text_node);

            if (!is_null($node->attributes))
                if($node->hasAttribute('binding-property'))
                    if (!empty($node->getAttribute('binding-property')))
                    {
                        $value = $view_bag->getValue($node->getAttribute('binding-property'));
                        if (!empty($value)){

                            if ((self::$stringer)::string_is_html($value))
                                self::AddHtmlFromString($node, $value);
                            else
                            {
                                $node->setAttribute('value', $value);
                                $node->nodeValue = $value;
                            }
                            array_push(self::$bindingdone[$node], $value);
                        }
                        $node->removeAttribute('binding-property');
                    }
        }

        Event::trigger('OnLayoutBinded');
    }

    private static function AddHtmlFromString($parent, $html_string) {
        $tmpDoc = new DOMDocument();
        $tmpDoc->loadHTML($html_string);
        foreach ($tmpDoc->getElementsByTagName('body')->item(0)->childNodes as $node) {
            $importedNode = $parent->ownerDocument->importNode($node, TRUE);
            $parent->appendChild($importedNode);
        }
    }

    public static function GetAllControlsByTag($tag)
    {
        return self::$document->getElementsByTagName($tag);
    }

    public static function GetControlByName($control_name)
    {
        $xpath = new DOMXpath(self::$document);
        $xpathquery="//*[@name='".$control_name."']";
        return $xpath->query($xpathquery)[0];
    }
    public static function GetControlById($control_name)
    {
        $xpath = new DOMXpath(self::$document);
        $xpathquery="//*[@id='".$control_name."']";
        return $xpath->query($xpathquery);
    }
    public static function GetAttribute($control_name, $attribute_name)
    {
        $control = self::GetControlByName($control_name);
        return $control->getAttribute($attribute_name);
    }
}