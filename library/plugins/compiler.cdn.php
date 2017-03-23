<?php
#namespace plugins;

/**
 * CDN
 * @todo Read configured variable and return correct value of CDN data. eg. TinyMCE, JQuery, ...
 *
 * @param $params
 * @param Smarty $smarty
 * @return string
 */
function smarty_compiler_cdn($params, Smarty $smarty)
{
    return "#tinymce";
}
