<?php
#namespace plugins;

/**
 * Selects a random `modified` duration for sitemaps
 */
function _random_modification()
{
    return date('Y-m-d');
}

/**
 * Really random frequency
 */
function _random_frequency()
{
    # Choose those used meaningfully only.
    $frequencies = array();
    #$frequencies[] = 'always';
    #$frequencies[] = 'hourly';
    $frequencies[] = 'daily';
    $frequencies[] = 'weekly';
    $frequencies[] = 'monthly';
    $frequencies[] = 'yearly';

    #$frequencies[] = 'never';

    return $frequencies[mt_rand(0, count($frequencies) - 1)];
}

/**
 * Random priortiy between 0.1 and 0.9
 */
function _random_priority($default = '0.0')
{
    # 0.1 to 0.9
    return '0.' . mt_rand(1, 9);
}

/**
 * Puts random modified on flag in the sitemap XML.
 */
function smarty_function_sitemap($parameters = array(), &$smarty)
{
    $parameters['modification'] = isset($parameters['modification']) ? $parameters['modification'] : "";
    $parameters['frequency'] = isset($parameters['frequency']) ? $parameters['frequency'] : "";
    $parameters['priority'] = isset($parameters['priority']) ? $parameters['priority'] : "";

    if ($parameters['modification']) {
        return _random_modification();
    } else if ($parameters['frequency']) {
        return _random_frequency();
    } else if ($parameters['priority']) {
        return _random_priority();
    } else {
        return "";
    }
}
