<?php

class Allocator
{
    public static function AllocateModel($_model)
    {
        if ($_model !== '' && $_model !== null){
            Allocate(MODEL, $_model);
            if (class_exists($_model))
                return new $_model();
        }
        return null;
    }

    public static function AllocatePHPBehavior($_behavior)
    {
        if ($_behavior !== '' && $_behavior !== null){
            Allocate(BEHAVIOR, $_behavior);
            if (class_exists($_behavior))
                return new $_behavior();
        }
        return null;
    }

    public static function AllocateJSBehavior($jsbehind)
    {
        Allocate(JSBEHIND, $jsbehind);
    }

	public static function AllocateORMClass($_class)
	{
        if ($_class !== '' && $_class !== null){
            Allocate(ORMCLASSES, $_class);
            if (class_exists($_class))
                return new $_class();
        }
        return null;
	}

    public static function AllocateController($_controller)
    {
        if ($_controller !== '' && $_controller !== null){
            Allocate(CONTROLLER, $_controller);
            if (class_exists($_controller))
            {
                Event::EventTrigger('OnControllerLoaded');
                return new $_controller();
            }
        }
        return null;
    }

    public static function AllocateLayout($_layout, $classic_layout = true)
    {
        Event::EventTrigger('OnPreRender');

        if (!class_exists(HtmlParserHelper))
            Allocator::AllocateHelper("HtmlParser");

        if (!class_exists(ViewBagHelper))
            Allocator::AllocateHelper("ViewBag");

        if ($classic_layout)
        {

            if (HtmlParserHelper::LoadHtmlFromFile(PathFileToAllocate(LAYOUT, $_layout)))
            {
                Binding();
                HtmlParserHelper::ClearConfigurations('table-configuration');
                HtmlParserHelper::RunHtml();
            }
        }
        else
            Allocate(LAYOUT, $_layout, ViewBagHelper::GetBag());
    }

    public static function AllocateHelper($helper)
    {
        $helper = $helper.'Helper';
        if ($helper !== '' && $helper !== null){
            Allocate(HELPERS, $helper);
            if (class_exists($helper))
                return new $helper();
        }
        return null;
    }

    public static function AllocateAPI($api)
    {
        if ($api !== '' && $api !== null){
            Allocate(API, $api);
            if (class_exists($api))
                return true;
        }
        return null;
    }

    public static function AllocateLibrary($library)
    {
        if ($library !== '' && $library !== null){
            Allocate(LIBRARIES, $library);
            if (class_exists($library))
                return new $library();
        }
        return null;
    }

    public static function AllocateCSS($css)
    {
        if ($css !== '' && $css !== null)
            if (filter_var($css, FILTER_VALIDATE_URL))
                return '<link rel="stylesheet" type="text/css" href="'.$css.'" >';
            else
                if (CanAllocate(CSS, $css))
                    return '<link rel="stylesheet" type="text/css" href="'.PathFileToAllocate(CSS, $css).'" />';
        return '';
    }

    public static function AllocateJS($js)
    {
        if ($js !== '' && $js !== null)
            if (filter_var($js, FILTER_VALIDATE_URL))
                return '<script src="'.$js.'" ></script>';
            else
                if (CanAllocate(JS, $js))
                    return '<script src="'.PathFileToAllocate(JS, $js).'" ></script>';

        return '';
    }

    public static function AllocateJQuery()
    {
        global $jquery_url;
        return Allocator::AllocateJS($jquery_url);
    }
}