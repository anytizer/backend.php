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
			'Scooter/',
			'Ask Jeeves',
			'Baiduspider+(',
			'Exabot/',
			'FAST Enterprise Crawler',
			'FAST-WebCrawler/',
			'http://www.neomo.de/',
			'Gigabot/',
			'Mediapartners-Google',
			'Google Desktop',
			'Feedfetcher-Google',
			'Googlebot',
			'heise-IT-Markt-Crawler',
			'heritrix/1.',
			'ibm.com/cs/crawler',
			'ICCrawler - ICjobs',
			'ichiro/2',
			'MJ12bot/',
			'MetagerBot/',
			'msnbot-NewsBlogs/',
			'msnbot/',
			'msnbot-media/',
			'NG-Search/',
			'http://lucene.apache.org/nutch/',
			'NutchCVS/',
			'OmniExplorer_Bot/',
			'online link validator',
			'psbot/0',
			'Seekbot/',
			'Sensis Web Crawler',
			'SEO search Crawler/',
			'Seoma [SEO Crawler]',
			'SEOsearch/',
			'Snappy/1.1 ( http://www.urltrends.com/ )',
			'http://www.tkl.iis.u-tokyo.ac.jp/~crawler/',
			'SynooBot/',
			'crawleradmin.t-info@telekom.de',
			'TurnitinBot/',
			'voyager/1.0',
			'W3 SiteSearch Crawler',
			'W3C-checklink/',
			'W3C_*Validator',
			'http://www.WISEnutbot.com',
			'yacybot',
			'Yahoo-MMCrawler/',
			'Yahoo! DE Slurp',
			'Yahoo! Slurp',
			'YahooSeeker/',
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
