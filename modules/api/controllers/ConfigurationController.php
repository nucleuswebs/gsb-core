<?php

namespace gloobus\gsb\modules\api\controllers;

use gloobus\gsb\database\models\Configuration;
use gloobus\gsb\database\models\Identity;
use gloobus\gsb\database\models\Language;
use gloobus\gsb\database\models\Role;
use gloobus\gsb\database\models\Token;
use gloobus\gsb\database\repositories\ConfigurationRepository;
use gloobus\gsb\database\repositories\IdentityRepository;
use gloobus\gsb\database\repositories\TokenRepository;
use gloobus\gsb\rest\Controller;

/**
 * Class ConfigurationController
 */
class ConfigurationController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);

        return $behaviors;
    }

    public function actionIndex()
    {
        return ConfigurationRepository::getFrontendConfiguration();
    }

    public function actionSetup()
    {
        $isConfigured = Configuration::findBySlug('configuration.configured');

        if( $isConfigured ) {
            return [
                'message' => 'The application is already configured'
            ];
        }

        $language =  new Language();
        $language->name = 'English';
        $language->slug = 'en';
        $language->is_core = (int) true;
        $language->is_published = (int) true;
        $language->save();


        $configuration = new Configuration();
        $configuration->name = 'Default language';
        $configuration->description = 'The default language of the application';
        $configuration->slug = 'language.defualt';
        $configuration->is_core = (int) true;
        $configuration->is_serialized = (int) false;
        $configuration->language_id = Language::findBySlug('en')->id;
        $configuration->value = 'en';
        $configuration->save();

        $rolesList = ['admin', 'client', 'guest'];

        foreach ($rolesList as $roleName) {
            $role = new Role();
            $role->name = ucfirst($roleName);
            $role->slug = $roleName;
            $role->save();
        }


        $identity = new Identity();
        $identity->email_address = 'palecian.tamas@gloobus.it';
        $identity->password = 'adminforever';
        $identity->first_name = 'Tamas';
        $identity->last_name = 'Palecian';
        $identity->is_organization = false;
        $identity->role_id = Role::findBySlug('admin')->id;
        $identity = IdentityRepository::create($identity);

        TokenRepository::create('api.authorization', $identity->id);

        $configurationCreated = new Configuration();
        $configuration->name = 'Configured setup';
        $configuration->description = 'The initial configuration setup for test';
        $configuration->slug = 'configuration.configured';
        $configuration->is_core = (int) true;
        $configuration->is_serialized = (int) false;
        $configuration->language_id = Language::findBySlug('en')->id;
        $configuration->value = 'en';
        $configuration->save();

        return [
            'configuration' => Configuration::findAll([]),
            'roles' => Role::findAll(),
            'identity' => $identity,
            'token' => $token,
            'languages' => Language::findAll([])
        ];
    }
}
