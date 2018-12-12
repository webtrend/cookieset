<?php
/**
 * Cookie Set plugin for Craft CMS 3.x
 *
 * A plugin that stores Google Analytics utm_parameter query string to a client cookies
 *
 * @link      https://google.com
 * @copyright Copyright (c) 2018 Webtrend
 */

namespace webtrend\cookieset;

use webtrend\cookieset\variables\CookieSetVariable;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

/**
 * Class CookieSet
 *
 * @author    Webtrend
 * @package   CookieSet
 * @since     1.0.1
 *
 */
class CookieSet extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var CookieSet
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.1';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('cookieSet', CookieSetVariable::class);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'cookie-set',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
        // Adds a hook 'SetMyCookies'
        // Syntax - {% hook 'SetMyCookies' %}
        Craft::$app->view->hook('SetMyCookies', function(&$context, $cookieName = 'tts', $expire = null, $path = '/', $domain = null, $secure = false, $httpOnly = false)
        {

            if (!$expire) {
                $expire = time() + 60*60*24*365*2;
            }
            isset($_GET['utm_term']) ? $utmParams['utm_term'] = $_GET['utm_term'] : NULL;
            isset($_GET['utm_campaign']) ? $utmParams['utm_campaign'] = $_GET['utm_campaign'] : NULL;
            isset($_GET['utm_source']) ? $utmParams['utm_source'] = $_GET['utm_source'] : NULL;
            isset($_GET['utm_medium']) ? $utmParams['utm_medium'] = $_GET['utm_medium'] : NULL;
            isset($_GET['utm_content']) ? $utmParams['utm_content'] = $_GET['utm_content'] : NULL;
            if (!isset($_COOKIE[$cookieName])) {
                $cookieData = array('firstContactDatetime' => date('c'));
                if (isset($_SERVER['HTTP_REFERER'])) {
                    $cookieData['referer'] = $_SERVER['HTTP_REFERER'];
                }
                else {
                    $cookieData['referer'] = 'direct';
                }

            } else  {
                $tempcookieData = (array) json_decode($_COOKIE[$cookieName]);
                if (isset($tempcookieData['firstContactDatetime']) ) {
                    $cookieData['firstContactDatetime'] = $tempcookieData['firstContactDatetime'];
                }
                if (isset($_SERVER['HTTP_REFERER'])) {
                    $cookieData['referer'] = $_SERVER['HTTP_REFERER'];
                }
                else {
                    if (isset($tempcookieData['referer']) ) {
                        $cookieData['referer'] = $tempcookieData['referer'];
                    }
                }
            }
            if (isset($utmParams) && is_array($utmParams)) {
                foreach ($utmParams as $key => $val) {
                    $cookieData[$key] = (isset($_REQUEST[$key])) ? $_REQUEST[$key] : null;
                }
                if (isset($cookieData)) {
                    setcookie($cookieName, json_encode($cookieData), $expire, $path, $domain, $secure, $httpOnly);
                }
            }
            //var_dump($cookieData);
        });
    }

    // Protected Methods
    // =========================================================================

}
