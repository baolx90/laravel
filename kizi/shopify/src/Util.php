<?php

namespace Kizi\Shopify;

/**
 * Utilities and helpers used in various parts of the package.
 */
class Util
{
    /**
     * HMAC creation helper.
     *
     * @param array  $opts   The options for building the HMAC.
     * @param string $secret The app secret key.
     *
     * @return Hmac
     */
    public static function createHmac(array $opts, string $secret): Hmac
    {
        // Setup defaults
        // $data = $opts['data'];
        // $raw = $opts['raw'] ?? false;
        // $buildQuery = $opts['buildQuery'] ?? false;
        // $buildQueryWithJoin = $opts['buildQueryWithJoin'] ?? false;
        // $encode = $opts['encode'] ?? false;

        // if ($buildQuery) {
        //     //Query params must be sorted and compiled
        //     ksort($data);
        //     $queryCompiled = [];
        //     foreach ($data as $key => $value) {
        //         $queryCompiled[] = "{$key}=".(is_array($value) ? implode(',', $value) : $value);
        //     }
        //     $data = implode(
        //         $buildQueryWithJoin ? '&' : '',
        //         $queryCompiled
        //     );
        // }

        // // Create the hmac all based on the secret
        // $hmac = hash_hmac('sha256', $data, $secret, $raw);

        // // Return based on options
        // $result = $encode ? base64_encode($hmac) : $hmac;

        // return Hmac::fromNative($result);
    }
}