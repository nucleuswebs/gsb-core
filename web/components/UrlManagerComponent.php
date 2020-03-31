<?php

namespace gloobus\gsb\web\components;

use yii\base\InvalidConfigException;
use yii\web\Request;

/**
 * Class UrlManagerComponent
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\web\components
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class UrlManagerComponent extends \yii\web\UrlManager
{
    const HOST_SEPARATOR = '.';
    const PATH_SEPARATOR = '/';
    const DOMAIN_WWW = 'www';

    /**
     * @var array the application languages
     */
    public $languages = [];

    /**
     * @var bool
     * - true: process the URL like "en.example.com"
     * - false: process the URL like "example.com/en"
     * NOTE: If the property set to true, the domain containing a language, must be the first on the left side,
     * for example:
     * - en.it.example.com - is valid
     * - it.en.example.com - is invalid
     */
    public $languageSubdomainExists = false;

    /**
     * @var array the regular expression patterns list, applied to path info, if there are matches, the request,
     * containing a language, will not be processed.
     * For performance reasons, the blacklist does not applied for URL creation (Take a look at an example).
     * @see \yii\web\Request::getPathInfo()
     * An example:
     * ```php
     * [
     *     '/^api.*$/'
     * ]
     * ```
     * - Requesting the blacklisted URL
     *   - $existsLanguageSubdomain = true
     *     - en.example.com/api (404 Not Found)
     *     - en.example.com/api/create (404 Not Found)
     *   - $existsLanguageSubdomain = false
     *     - example.com/en/api (404 Not Found)
     *     - example.com/en/api/create (404 Not Found)
     * - Creating the blacklisted URL
     *   - echo \yii\helpers\Html::a('API', ['api/index', Yii::$app->urlManager->queryParam => null]);
     */
    public $blacklist = [];

    /**
     * @var string the query parameter name that contains a language.
     * @see \yii\web\Request::getQueryParams()
     */
    public $queryParam = 'language';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if ( !$this->enablePrettyUrl ) {
            throw new InvalidConfigException(
                'The "enablePrettyUrl" property must be set to "true"'
            );
        }

        //$this->languages = \Yii::$app->translation->activeLanguages;

        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function parseRequest( $request )
    {
        $pathInfo = $request->getPathInfo();

        if ( !$this->languageSubdomainExists ) {
            $language = explode(self::PATH_SEPARATOR, $pathInfo)[0];

            if ( in_array($language, $this->languages) ) {
                $pathInfo = ltrim($pathInfo, $language);

                if ( !$this->isBlacklisted($pathInfo) ) {
                    $request->setPathInfo($pathInfo);
                    $this->setQueryParam($request, $language);
                }
            }

            return parent::parseRequest($request);
        } else {
            $hostChunks = $this->getHostChunks($request);
            $language = ArrayHelper::getValue($hostChunks, 0);

            if ( !in_array($language, $this->languages) ) {
                return parent::parseRequest($request);
            } else {
                if ( $this->isBlacklisted($pathInfo) ) {
                    return false;
                } else {
                    $this->setQueryParam($request, $language);

                    return parent::parseRequest($request);
                }
            }
        }
    }

    /**
     * Sets the query parameter that contains a language.
     *
     * @param Request $request the Request component instance.
     * @param string  $value   a language value.
     */
    protected function setQueryParam( Request $request, $value )
    {
        $queryParams = $request->getQueryParams();
        $queryParams[$this->queryParam] = $value;
        $request->setQueryParams($queryParams);
    }

    /**
     * Returns the "Host" header value splitted by the separator.
     *
     * @param Request $request the Request component instance.
     * @return array the header value
     * @see UrlManager::SEPARATOR_HOST
     */
    protected function getHostChunks( Request $request )
    {
        $host = parse_url($request->getHostInfo(), PHP_URL_HOST);

        return explode(self::SEPARATOR_HOST, $host);
    }

    /**
     * Returns whether the path info is blacklisted.
     *
     * @param string $pathInfo the path info of the currently requested URL.
     * @return bool whatever the path is blacklister or not
     * @see $blacklist
     */
    protected function isBlacklisted( $pathInfo )
    {
        $pathInfo = ltrim($pathInfo, self::PATH_SEPARATOR);

        foreach ( $this->blacklist as $pattern ) {
            if ( preg_match($pattern, $pathInfo) ) {
                return true;
            }
        }

        return false;
    }
}
