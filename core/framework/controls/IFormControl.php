<?php

#region INTERFACE TO HTML STRUCTURED CONTROLS
/*
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *  INTERFACE TO STRUCTURED CONTROLS
 *~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 * This interface allows html structured controls to be implemented.
 *
 * Example:
 *
 *     select, a, label, input etc..
 *     
 *
 */
#endregion
interface IFormControl
{
    function set_value($_attribute, $_value);

    function get_value($_attribute);

    function add_child($_child);
}




