<?php
namespace backend;

/**
 * Locations - Where is a user visiting within your website?
 */
class where
	extends \common\mysql
{
	/**
	 * Record a human page access
	 */
	public function save()
	{
		if(!$this->is_bot())
		{
			$variable = new \common\variable();
			$user_id = $variable->session('user_id', 'int');
			$session_id = $variable->session('session_id', 'string');
			$ip_address = addslashes($_SERVER['REMOTE_ADDR']);
			$request_uri = addslashes($_SERVER['REQUEST_URI']);
			$user_agent = addslashes($_SERVER['HTTP_USER_AGENT']);

			$sql = "
INSERT INTO query_logs (
	`user_id`, `session_id`, `accessed_on`,
	`ip_address`,
	`request_uri`, `user_agent`
) VALUES (
	{$user_id}, '{$session_id}',CURRENT_TIMESTAMP(),
	'{$ip_address}',
	'{$request_uri}', '{$user_agent}'
);";
			$this->query($sql);
		}
	}

	/**
	 * Clean up the visit logs.
	 */
	public function clean()
	{
		$sql = "DELETE FROM query_logs WHERE accessed_on < DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL 3 HOUR);";

		return $this->query($sql);
	}

	/**
	 * Find out, if a user agent is a known bot
	 */
	private function is_bot()
	{
		//popular bots list
		$bots = array(
			'ia_archiver',
			'scooter/',
			'ask jeeves',
			'baiduspider+(',
			'exabot/',
			'fast enterprise crawler',
			'fast-webcrawler/',
			'http://www.neomo.de/',
			'gigabot/',
			'mediapartners-google',
			'google desktop',
			'feedfetcher-google',
			'googlebot',
			'heise-it-markt-crawler',
			'heritrix/1.',
			'ibm.com/cs/crawler',
			'iccrawler - icjobs',
			'ichiro/2',
			'mj12bot/',
			'metagerbot/',
			'msnbot-newsblogs/',
			'msnbot/',
			'msnbot-media/',
			'ng-search/',
			'http://lucene.apache.org/nutch/',
			'nutchcvs/',
			'omniexplorer_bot/',
			'online link validator',
			'psbot/0',
			'seekbot/',
			'sensis web crawler',
			'seo search crawler/',
			'seoma [seo crawler]',
			'seosearch/',
			'snappy/1.1 ( http://www.urltrends.com/ )',
			'http://www.tkl.iis.u-tokyo.ac.jp/~crawler/',
			'synoobot/',
			'crawleradmin.t-info@telekom.de',
			'turnitinbot/',
			'voyager/1.0',
			'w3 sitesearch crawler',
			'w3c-checklink/',
			'w3c_*validator',
			'http://www.wisenutbot.com',
			'yacybot',
			'yahoo-mmcrawler/',
			'yahoo! de slurp',
			'yahoo! slurp',
			'yahooseeker/',
		);

		$is_bot = false;
		foreach($bots as $bot_name)
		{
			if(!empty($_SERVER['HTTP_USER_AGENT']) && (stristr($_SERVER['HTTP_USER_AGENT'], $bot_name) === true))
			{
				$is_bot = true;
				break;
			}
		}

		return $is_bot;
	}
}
