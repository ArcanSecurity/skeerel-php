<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\Util;


use phpseclib\Crypt\AES;
use phpseclib\Crypt\RSA;
use Skeerel\Exception\CryptoException;
use Skeerel\Exception\DecodingException;
use Skeerel\Exception\IllegalArgumentException;

class Crypto
{
    public static function verifySignatureAndDecrypt($complexCipher, $rsaInstance) {
        if (!is_array($complexCipher) ||
            !isset($complexCipher['encrypted_key']) || !is_string($complexCipher['encrypted_key']) ||
            !isset($complexCipher['cipher']) || !is_string($complexCipher['cipher']) ||
            !isset($complexCipher['mac']) || !is_string($complexCipher['mac'])) {
            throw new IllegalArgumentException('addresses to verify and decrypt must be an array containing "encrypted_key", "cipher", "mac"');
        }

        if (!($rsaInstance instanceof RSA)) {
            throw new IllegalArgumentException('rsaInstance must be an instance of phpseclib\Crypt\RSA');
        }

        $keys = self::decryptKeys($complexCipher['encrypted_key'], $rsaInstance);
        self::verifySignature($complexCipher['cipher'], $complexCipher['mac'], $keys['hmac']);

        $decrypted = self::decrypt($complexCipher['cipher'], $keys['aes']);
        $json = json_decode($decrypted, true);

        if ($json === null) {
            throw new DecodingException("decrypted cipher does not seem to be a valid json");
        }

        return $json;
    }

    /**
     * @param string $encryptedKey
     * @param RSA $rsaInstance
     * @return array
     * @throws CryptoException
     * @throws IllegalArgumentException
     */
    private static function decryptKeys($encryptedKey, $rsaInstance) {
        $sessionKey = @$rsaInstance->decrypt(base64_decode($encryptedKey));
        if ($sessionKey === false) {
            throw new CryptoException("cannot decrypt session key with the provided RSA private key");
        }

        if (strlen($sessionKey) != 64) {
            throw new IllegalArgumentException("session key must be 64 bytes long, got " . strlen($sessionKey));
        }

        return array(
            "aes" => substr($sessionKey, 0, 32),
            "hmac" => substr($sessionKey, 32)
        );
    }

    private static function verifySignature($cipher, $mac, $key) {
        if (base64_encode(hash_hmac("sha256", $cipher, $key, true)) !== $mac) {
            throw new CryptoException("the hmac signature is invalid");
        }
    }

    private static function decrypt($cipher, $key) {
        $base64Decoded = base64_decode($cipher);

        $aes = new AES();
        @$aes->setKeyLength(256);
        @$aes->setKey($key);
        @$aes->setIV(substr($base64Decoded, 0, 16));

        return @$aes->decrypt(substr($base64Decoded, 16));
    }
}