<?php
/**
 * Cookie Set plugin for Craft CMS 3.x
 *
 * A plugin that stores Google Analytics utm_parameter query string to a client cookie.
 *
 * @link      http://sidd3.com
 * @copyright Copyright (c) 2018 Bhashkar Yadav
 */

namespace webtrend\cookieset\variables;

use webtrend\cookieset\CookieSet;

use Craft;

/**
 * @author    Bhashkar Yadav
 * @package   CookieSet
 * @since     1.0.0
 */
class CookieSetVariable
{
    /**
     * set() takes the same parameters as PHP's builtin setcookie();
     *
     * @param string $name
     * @param string $value
     * @param int $expire
     * @param string $path
     * @param string $domain
     * @param mixed $secure
     * @param mixed $httponly
     */
    function set($name = "", $value = "", $expire = null, $path = "/", $domain = "", $secure = false, $httponly = false)
    {
        if (!$expire) {
                $expire = time() + 60*60*24*365*2;
            }
        setcookie($name, $value, (int) $expire, $path, $domain, $secure, $httponly);
        $_COOKIE[$name] = $value;
    }
    /**
     * get() lets you retrieve the value of a cookie.
     *
     * @param mixed $name
     */
    function get($name, $querystring='',$referer='')
    {
        $cookie_string = '';
        if (!empty($querystring))
        {
            parse_str($querystring, $params);
            foreach ($params as $key=>$param)
            {
                if ($key =='utm_campaign')
                {
                    $cookie_string .= '&utm_campaign='.urlencode($param);
                }
                if ($key =='utm_medium')
                {
                    $cookie_string .= '&utm_medium='.urlencode($param);
                }
                if ($key =='utm_term')
                {
                    $cookie_string .= '&utm_term='.urlencode($param);
                }
                if ($key =='utm_source')
                {
                    $cookie_string .= '&utm_source='.urlencode($param);
                }
                if ($key =='utm_content')
                {
                    $cookie_string .= '&utm_content='.urlencode($param);
                }
                
            }
            
        }
        if (empty($cookie_string))
            if (isset($_COOKIE[$name]))
            {
                $cookies = json_decode($_COOKIE[$name], true);
                if (json_last_error() == JSON_ERROR_NONE)
                {
                    $cookie_string = '';
                    foreach ($cookies as $key=>$cookie )
                    {
                        $cookie_string .= '&';
                        $cookie_string .= $key.'='.urlencode($cookie);
                    }
                    return $cookie_string;
                }
            }
            else
            {
                return '&utm_campaign=organic&referer='.urlencode($referer).'&firstContactDatetime='.date('c');
            }

        else {
            $cookie_string .= '&referer='.urlencode($referer).'&firstContactDatetime='.date('c');
            return $cookie_string;
        }
    }

    function getSource($name, $querystring='')
    {

        if (!empty($querystring))
        {
            parse_str($querystring, $params);
            foreach ($params as $key=>$param)
            {
                if ($key =='utm_source')
                {
                    return $param;
                }

            }
            return '';

        }
        else if (isset($_COOKIE[$name]))
        {
            $cookies = json_decode($_COOKIE[$name], true);
            if (json_last_error() == JSON_ERROR_NONE)
            {
                foreach ($cookies as $key=>$cookie )
                {
                    if ($key =='utm_source')
                    {
                        return $cookie;
                    }

                }
                return '';
            }
        }
        else
        {
            return '';
        }


    }

    function getMedium($name, $querystring='')
    {

        if (!empty($querystring))
        {
            parse_str($querystring, $params);
            foreach ($params as $key=>$param)
            {
                if ($key =='utm_medium')
                {
                    return $param;
                }

            }
            return '';

        }
        else if (isset($_COOKIE[$name]))
        {
            $cookies = json_decode($_COOKIE[$name], true);
            if (json_last_error() == JSON_ERROR_NONE)
            {
                foreach ($cookies as $key=>$cookie )
                {
                    if ($key =='utm_medium')
                    {
                        return $cookie;
                    }

                }
                return '';
            }
        }
        else
        {
            return '';
        }


    }
    function getCampaign($name, $querystring='')
    {

        if (!empty($querystring))
        {
            parse_str($querystring, $params);
            foreach ($params as $key=>$param)
            {
                if ($key =='utm_campaign')
                {
                    return $param;
                }

            }
            return '';

        }
        else if (isset($_COOKIE[$name]))
        {
            $cookies = json_decode($_COOKIE[$name], true);
            if (json_last_error() == JSON_ERROR_NONE)
            {
                foreach ($cookies as $key=>$cookie )
                {
                    if ($key =='utm_campaign')
                    {
                        return $cookie;
                    }

                }
                return '';
            }
        }
        else
        {
            return '';
        }


    }
    function getTerm($name, $querystring='')
    {

        if (!empty($querystring))
        {
            parse_str($querystring, $params);
            foreach ($params as $key=>$param)
            {
                if ($key =='utm_term')
                {
                    return $param;
                }

            }
            return '';

        }
        else if (isset($_COOKIE[$name]))
        {
            $cookies = json_decode($_COOKIE[$name], true);
            if (json_last_error() == JSON_ERROR_NONE)
            {
                foreach ($cookies as $key=>$cookie )
                {
                    if ($key =='utm_term')
                    {
                        return $cookie;
                    }

                }
                return '';
            }
        }
        else
        {
            return '';
        }


    }

    function getContent($name, $querystring='')
    {

        if (!empty($querystring))
        {
            parse_str($querystring, $params);
            foreach ($params as $key=>$param)
            {
                if ($key =='utm_content')
                {
                    return $param;
                }

            }
            return '';

        }
        else if (isset($_COOKIE[$name]))
        {
            $cookies = json_decode($_COOKIE[$name], true);
            if (json_last_error() == JSON_ERROR_NONE)
            {
                foreach ($cookies as $key=>$cookie )
                {
                    if ($key =='utm_content')
                    {
                        return $cookie;
                    }

                }
                return '';
            }
        }
        else
        {
            return '';
        }


    }
}