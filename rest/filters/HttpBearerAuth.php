<?php

namespace gloobus\gsb\rest\filters;

use yii\filters\auth\HttpHeaderAuth;

use gloobus\gsb\database\models\Token;
use gloobus\gsb\database\repositories\TokenRepository;

/**
 * Class HttpBearerAuth
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\rest\filters
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class HttpBearerAuth extends HttpHeaderAuth
{
    /**
     * @var string the header key what of the bearer authorization
     */
    public $header = 'Authorization';

    /**
     * @var string the validation pattern
     */
    public $pattern = '/^Bearer\s+(.*?)$/';

    /**
     * {@inheritDoc}
     */
    public function authenticate( $user, $request, $response )
    {
        $authHeaders = $request->getHeaders();
        $authorization = $authHeaders->get($this->header);

        if ( $authorization === null ) {
            return null;
        }

        if ( $this->pattern === null ) {
            return null;
        }

        if ( preg_match($this->pattern, $authorization, $matches) ) {
            $authorization = $matches[1];
        } else {
            return null;
        }

        $token = TokenRepository::findByValue($authorization);

        if ( $this->validateToken($token) === false ) {
            return null;
        }

        return $token->identity;
    }

    /**
     * Validates the token data if is valid or not
     *
     * @param Token $token the token to validate
     * @return bool whatever the token is valid or not
     */
    private function validateToken( Token $token ): bool
    {
        if ( !$token ) {
            return false;
        }

        if ( $token->type !== 'api.authorization' ) {
            return false;
        }

        if ( (bool) $token->is_expired === true ) {
            return false;
        }

        return true;
    }
}
