<?php
namespace common;

/**
 * In Smarty Template, encrypted a configuration variable name/key.
 * @see smarty.config
 */
class hack_smarty
{
	/**
	 * Set this flag to true/false if your config files are encrypted.
	 *  true : Encrypted config file.
	 *  false: Readable config file - as if you did not use this encryption feature.
	 */
	const is_already_encrypted = false;


	/**
	 * Keys are one way encrypted, and may not be reverted back.
	 * All templates have readable keys. But config files have encrypted them.
	 * So, while trying to replace the value, just encrypt the readable key to
	 * the one that matches as in the config file.
	 * Decryption of a key is never required.
	 */
	public static function encrypt_key($key = '')
	{
		$key = (self::is_already_encrypted === true) ? md5($key) : $key;

		return $key;
	}


	/**
	 * Encrypt a value - useful while producing encrypted config file.
	 *
	 * @param string $value Plain input string to encrypt in config file.
	 * @return string
	 */
	public static function encrypt_value($value = '')
	{
		# You may write your own stronger encryption codes here.
		$value = (self::is_already_encrypted === true) ? base64_encode($value) : $value;

		return $value;
	}


	/**
	 * Decrypt the value for replacement from config file into template.
	 * Template configuration values were encrypted.
	 * Just decrypt them for display.
	 */
	public static function decrypt_value($value = '')
	{
		# Make sure that this is an "exact reverse" of self::encrypt_value().
		$value = (self::is_already_encrypted === true) ? base64_decode($value) : $value;

		return $value;
	}
}

