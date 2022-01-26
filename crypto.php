<?php
define('JOTFORM_DEFAULT_CLIENT_SECRET', 'jotformsecretkey7v957697q8N');

class Crypto {

    static $cipher   = 'AES-128-CBC';
    static $hmac     = 'sha256';
    static $hmacsize = 32;

    public static function encrypt_openssl($str, $key = JOTFORM_DEFAULT_CLIENT_SECRET) {
        $key = md5($key);

        $ivlen = openssl_cipher_iv_length(self::$cipher);
        // echo $ivlen;
        // echo "   PLACKI   ";
        $iv = openssl_random_pseudo_bytes($ivlen);

        $ciphertext_raw = openssl_encrypt($str, self::$cipher, $key, OPENSSL_RAW_DATA, $iv);
        // echo base64_encode($ciphertext_raw); echo "    ";
        $hmac = hash_hmac(self::$hmac, $ciphertext_raw, $key, true);
        // echo $hmac; echo "    :     \n    ";
        echo base64_encode( $iv . $hmac . $ciphertext_raw );
    }

    public static function decrypt_openssl($str, $key = JOTFORM_DEFAULT_CLIENT_SECRET) {
        $key = md5($key);

        $ciphertext_raw = base64_decode($str);
        $ivlen = openssl_cipher_iv_length(self::$cipher);
        $iv = substr($ciphertext_raw, 0, $ivlen);

        $hmac = substr($ciphertext_raw, $ivlen, self::$hmacsize);
        $str_raw = substr($ciphertext_raw, $ivlen + self::$hmacsize);

        $plaintext = openssl_decrypt($str_raw, self::$cipher, $key, OPENSSL_RAW_DATA, $iv);

        $calculated_hmac = hash_hmac(self::$hmac, $str_raw, $key, true);
        if (hash_equals($hmac, $calculated_hmac)) {
            return $plaintext;
        } else {
          return 'error';
        }
    }
}
