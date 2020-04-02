<?php

namespace gloobus\gsb\modules\api\models\forms;

use yii\base\Model;

use gloobus\gsb\database\models\Identity;

class AuthenticationForm extends Model
{
    /**
     * @var string will be poppulated with the email address field value
     */
    public $emailAddress;

    /**
     * @var string will be poppulated with the password field value
     */
    public $password;

    /**
     * @var Identity|null will be populated with the identity
     */
    private $identity = null;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [ [ 'emailAddress', 'password' ], 'required' ],
            [ [ 'emailAddress' ], 'email' ],
            [ [ 'password' ], 'validateIdentityPassword' ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function validateIdentityPassword( $attribute, $params ): void
    {
        $identity = $this->getIdentity();

        if ( $this->hasErrors() ) {
            return;
        }

        if ( $this->identity === null ) {
            $this->addError(
                'authentication',
                'The email address or password was wrong'
            );

            return;
        }

        if ( !$this->identity->validatePassword($this->password) ) {
            $this->addError(
                'emailAddress',
                'The email address or password was wrong'
            );
        }
    }

    /**
     * Retrieves the identity with the given email address
     *
     * @return Identity|null the identity or null if no identity was found
     */
    public function getIdentity(): ?Identity
    {
        if ( $this->identity === null ) {
            $this->identity = Identity::findByAttributes([ 'email_address' => $this->emailAddress ]);
        }

        return $this->identity;
    }
}
