<?php

namespace Devim\Provider\MttServiceProvider\Helper;

use Devim\Provider\MttServiceProvider\Exception\SmsErrorException;

class MttResponseFilter
{
    const SMS_STATUS_ACCEPTED = 0;
    const SMS_STATUS_DELIVERED = 1;
    const SMS_STATUS_EXPIRED = 2;
    const SMS_STATUS_UNDELIVERABLE = 4;
    const SMS_STATUS_REJECTED = 8;

    const RESPONSES = [
        'accepted' => self::SMS_STATUS_ACCEPTED,
        'delivered' => self::SMS_STATUS_DELIVERED,
        'expired' => self::SMS_STATUS_EXPIRED,
        'undeliverable' => self::SMS_STATUS_UNDELIVERABLE,
        'rejected' => self::SMS_STATUS_REJECTED,
    ];

    const ERRORS = [
        'login/password is incorrect',
        'system error',
        'not supported operation',
        'invalid ID',
        'invalid MSISDN',
        'invalid shortcode',
        'billing failed',
        'throttling error',
        'transaction not found',
        'invalid parameter text',
        'billing error'
    ];

    /**
     * @param string $response
     *
     * @return string|int
     *
     * @throws SmsErrorException
     */
    public static function filter(string $response)
    {
        if (array_search($response, self::ERRORS) !== false) {
            throw new SmsErrorException($response);
        }

        return self::RESPONSES[$response] ?? $response;
    }
}