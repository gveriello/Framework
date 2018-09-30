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

    public static function LoadHtmlFromString($htmlString)
    {
        self::$document = new DOMDocument;
        self::$bindingdone = array();
        self::$stringer = Allocator::allocate_helper('Stringer');
        self::$document->loadHTML($htmlString);
        foreach (self::$document->childNodes as $item)
            if ($item->nodeType == XML_PI_NODE)
                self::$document->removeChild($item);
        return true;
    }

    public static function LoadHtmlFromFile($htmlFilePath)
    {
        $input = file_get_contents(string_for_allocate_file(LAYOUT, $htmlFilePath));
        $input = trim(str_replace("\r\n", "", $input));
        if (empty($input))
            return false;

        return self::LoadHtmlFromString($input);
    }

    public static function RunHtml()
    {
        $editedHtml = self::$document->saveHTML();
        echo $editedHtml;
    }

    public static function Clear()
    {
        self::$document = new DOMDocument;
    }

    public static function ClearConfigurations($tagName)
    {
        self::RemoveControlByTagName($tagName);
    }

    public static function CreateNodeFromHtmlString($parentNode, $htmlString)
    {
        $tmpDoc = new DOMDocument();
        $tmpDoc->loadHTML($htmlString);
        foreach ($tmpDoc->getElementsByTagName('html')->item(0)->childNodes as $node)
        {
            $importedNode = $parentNode->ownerDocument->importNode($node, TRUE);
            $parentNode->appendChild($importedNode);
        }
    }

    public static function RemoveControlById($controlId)
    {
        $control = self::GetControlById($controlId);
        if (!is_null($control))
            self::$document->removeChild($control);
    }
    public static function RemoveControlByName($controlName)
    {
        $control = self::GetControlByName($controlName);
        if (!is_null($control))
            self::$document->removeChild($control);
    }
    public static function RemoveControlByTagName($tagName)
    {
        $controls = self::GetAllControlsByTag($tagName);
        foreach($controls as $control)
            if (!is_null($control))
                $control->parentNode->removeChild($control);
    }

    public static function GetAllControlsByTag($tag)
    {
        return self::$document->getElementsByTagName($tag);
    }

    public static function GetAllControls()
    {
        $allControls = self::GetAllControlsByTag('*');
        foreach ($allControls as $control)
        {
            $text_node = $control->nodeValue;
            if (!empty($text_node))
                $text_node = trim($text_node);
        }
        return $allControls;
    }

    public static function NodeHasAttribute($node, $attribute)
    {
        if (!is_null($node->attributes))
            return $node->hasAttribute($attribute);
        return false;
    }
    public static function GetControlByName($control_name)
    {
        $xpath = new DOMXpath(self::$document);
        $xpathquery = "//*[@name='".$control_name."']";
        return $xpath->query($xpathquery)[0];
    }

    public static function GetControlById($controlId)
    {
        $xpath = new DOMXpath(self::$document);
        $xpathquery="//*[@id='".$controlId."']";
        return $xpath->query($xpathquery);
    }

    public static function GetAttribute($controlId, $attributeName)
    {
        $control = self::GetControlById($controlId);
        return self::GetAttributeByNode($control, $attributeName);
    }

    public static function GetAttributeByNode($node, $attributeName)
    {
        if (self::NodeHasAttribute($node, $attributeName))
            return $node->getAttribute($attributeName);
        return '';
    }

    public static function SetAttribute($controlId, $attributeName, $attributeValue)
    {
        $control = self::GetControlById($controlId);
        return $control->setAttribute($attributeName, $attributeValue);
    }

    public static function SetAttributeByNode($node, $attributeName, $attributeValue)
    {
        if (!self::NodeHasAttribute($node, $attributeName))
            return false;

        $node->setAttribute($attributeName, $attributeValue);
        array_push(self::$bindingdone[$node], $attributeValue);
        return true;
    }

    public static function SetNodeValueByNode($node, $value)
    {
        $node->nodeValue = $value;
        array_push(self::$bindingdone[$node], $value);
        return true;
    }

    public static function RemoveAttributeByNode($node, $attributeName)
    {
        if (!self::NodeHasAttribute($node, $attributeName))
            return false;
        $node->removeAttribute($attributeName);
        return true;
    }
}