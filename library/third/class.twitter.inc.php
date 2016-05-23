<?php
/**
 * Tweets messages into Twitter
 * Some other useful links about Twitter:
 *
 * @link http://twitter.com/#!/USERNAME
 * @link http://api.twitter.com/1/statuses/update.json
 * @link http://www.twitter.com/status/user_timeline/USERNAME.xml
 * @link http://www.smarty.net/forums/viewtopic.php?t=20849
 */
class twitter
{
	private $xhttp_profile;
	private $donot_tweet = false;

	/**
	 * @todo Fix this class file
	 */
	public function __construct()
	{
	}
	
	public function tweet($message = '')
	{
		$this->donot_tweet = false;
		$parameters = array(
			'TWITTER_CONSUMER_TOKEN',
			'TWITTER_CONSUMER_SECRET',
			'TWITTER_OAUTH_TOKEN',
			'TWITTER_OAUTH_TOKEN_SECRET',
		);
		foreach($parameters as $constant)
		{
			if(!defined($constant) || !constant($constant))
			{
				throw new \Exception("One of the twitter configuration parameters is missing: {$constant}");
				$this->donot_tweet = true;
				break;
			}
		}

		$consumer_token = TWITTER_CONSUMER_TOKEN;
		$consumer_secret = TWITTER_CONSUMER_SECRET;
		$oauth_token = TWITTER_OAUTH_TOKEN;
		$oauth_token_secret = TWITTER_OAUTH_TOKEN_SECRET;

		/**
		 * @todo May be the class files can be called independently.
		 */
		xhttp::load('profile,oauth');

		$this->xhttp_profile = new xhttp_profile();
		$this->xhttp_profile->oauth($consumer_token, $consumer_secret, $oauth_token, $oauth_token_secret);

		/**
		 * Instantly publish the tweet
		 */
		$this->status($message);
	}

	/**
	 * One line status update to the twitter main listing
	 *
	 * @return String
	 */
	public function status($message = '')
	{
		if($this->donot_tweet || !$message)
		{
			return null;
		}

		# Sorry, no HTML allowed at the moment via our system
		$message = strip_tags($message);

		# Shorten the message to the capacity of Twitter only: 140
		# Use the URL shortening services like goo.gl, bit.ly etc. to have more space in writing
		$message = (strlen($message) > 140) ? (substr($message, 0, 136) . '...') : $message;

		$data = array();
		$data['post'] = array(
			'status' => $message,
		);

		$response = $this->xhttp_profile->fetch('http://api.twitter.com/1/statuses/update.json', $data);
		$this->error = $response['body'];

		return $response['successful'];
	}
}
