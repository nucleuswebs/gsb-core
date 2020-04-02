<?php

namespace gloobus\gsb\helpers;

use gloobus\gsb\helpers\ArrayHelper;

/**
 * Class RestResponse helper
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\helpers
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class RestResponseHelper
{
    /**
     * @var array the default format of the api response
     */
    const RESPONSE_FORMAT
        = [
            'status'  => 200,
            'message' => '',
            'data'    => [],
        ];

    /**
     * Formats the api response data
     *
     * @param array       $response   the response data
     * @param string|null $message    the message of the response or null if you don't want to override the default
     *                                message
     * @param int|null    $statusCode the response data status code or null if you don't want to override the default
     *                                status code
     * @return array the formatted response data
     */
    public static function formatResponse( array $response, string $message = null, int $statusCode = null ): array
    {
        $formattedResponse = self::RESPONSE_FORMAT;
        $formattedResponse = ArrayHelper::merge($formattedResponse, $response);

        if ( $message !== null ) {
            $formattedResponse['message'] = $message;
        }

        if ( $statusCode !== null ) {
            $formattedResponse['status'] = $statusCode;
        }

        \Yii::$app->response->statusCode = $formattedResponse['status'];

        return $formattedResponse;
    }

    /**
     * Generate the api response data based on given parameters
     *
     * @param array  $data       the response body content data
     * @param string $message    the response message
     * @param int    $statusCode the response status code
     * @return array the generated response data
     */
    public static function generateResponse( array $data, string $message, int $statusCode ): array
    {
        $response = self::RESPONSE_FORMAT;
        $response['data'] = $data;
        $response['status'] = $statusCode;
        $response['message'] = $message;

        return $response;
    }

    /**
     * Generates a model error response based on the ActiveRecord->getModelErrors() data
     *
     * @param array  $modelErrors the model errors list
     * @param string $message     the message of the response
     * @return array the generated response data
     */
    public static function generateModelErrorResponse( array $modelErrors, string $message ): array
    {
        $response = self::RESPONSE_FORMAT;
        $response['status'] = 400;
        $response['data'] = $modelErrors;
        $response['message'] = $message;

        return $response;
    }
}
