<?php

namespace gloobus\gsb\web\components;

use Yii;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;

use gloobus\gsb\helpers\ArrayHelper;

/**
 * Class ThemeComponent
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\web\components
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class ThemeComponent extends BaseObject
{
    /**
     * @var string the default theme name
     */
    public $default = null;

    /**
     * @var the current theme name
     */
    public $current;

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();

        if ( $this->default === null ) {
            throw new InvalidConfigException(
                Yii::t('nucleo.exceptions', 'No default theme has been specified!', 500)
            );
        }

        $this->set($this->default);
    }

    /**
     * Get the current theme
     *
     * @return string the current theme name
     */
    public function get(): string
    {
        return $this->current;
    }

    /**
     * Set the current theme
     *
     * @param string $name    the theme name
     * @param array  $options custom configuration for the theme
     */
    public function set( string $name, array $options = [] ): void
    {
        Yii::$app->view->theme = new  \yii\base\Theme(
            ArrayHelper::merge(
                [
                    'baseUrl'  => '@web',
                    'basePath' => '@app/themes/' . $name,
                    'pathMap'  => [
                        '@app/views'   => '@app/themes/' . $name . '/views',
                        '@app/modules' => '@app/themes/' . $name . '/views/modules',
                    ],
                ],
                $options
            )
        );

        $this->current = $name;
    }

    /**
     * Get the current theme path
     *
     * @return string the current theme path
     */
    public function getThemePath(): string
    {
        return Yii::getAlias('@app/themes/' . $this->current);
    }

    /**
     * Get the current layout
     *
     * @return string the current layout name
     */
    public function getLayout(): string
    {
        return Yii::$app->layout;
    }

    /**
     * Set the current layout
     *
     * @param string $name the layout name
     */
    public function setLayout( string $name ): void
    {
        Yii::$app->controller->layout = '@app/themes/' . Yii::$app->theme->current . '/views/layouts/' . $name;
    }

    /**
     * Get the view path in a theme
     *
     * @param string $name the name of the view
     * @return string the view path
     */
    public function getViewPath( string $name ): string
    {
        $moduleId = Yii::$app->controller->module->id;
        $actionPath = Yii::$app->controller->id . '/' . Yii::$app->controller->action->id;

        if ( $moduleId === 'nucleo' ) {
            return '@app/views/' . $actionPath;
        }

        return '@app/modules/' . $moduleId . '/' . $actionPath;
    }

    /**
     * Get the current page slug
     *
     * @return string the current page slug generated from module-controller-action id's
     */
    public function getPageSlug()
    {
        $slug = Yii::$app->controller->action->getUniqueId();

        return str_replace('/', '-', $slug);
    }
}
