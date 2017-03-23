<?php
namespace backend;

/**
 * Handles the products referred by a party.
 */
class referral
    extends \common\mysql
{
    public function is_valid_referrer($referrer_id = 0)
    {
        $referrer_id += 0;

        # Check the referrer, if valid
        return true;
    }

    public function is_valid_product($product_id = 0)
    {
        $product_id += 0;

        # Check the product, if valid
        return true;
    }

    public function is_valid_category($category_id = 0)
    {
        $category_id += 0;

        # Check the category, if valid
        return true;
    }

    /**
     * Keep a history that there was a referral.
     */
    public function record_referral($referrer_id = 0, $referral_code = "")
    {
        $referrer_id += 0;
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "";
        $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "";
        $browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
        $record_referral_sql = "
INSERT INTO `referrer_history`(
	`referrer_id`, `referrer_code`,
	`referred_on`,`referred_ip`,
	`referred_from_url`, `referred_browser`
) VALUES (
	'{$referrer_id}', '{$referral_code}',
	CURRENT_TIMESTAMP(), '{$ip}',
	'{$url}', '{$browser}'
);";

        return $this->query($record_referral_sql);
    }
}

