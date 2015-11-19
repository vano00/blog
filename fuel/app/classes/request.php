<?php

/**
 * Override \Fuel\Core\Request
 */
class Request extends \Fuel\Core\Request
{	
	/**
	 * Override the forge method to fix a bug in the $_SERVER['REQUEST_URI'] when using a Proxy
	 *
	 * @param   string   The URI of the request
	 * @param   mixed    Internal: whether to use the routes; external: driver type or array with settings (driver key must be set)
	 * @param   string   request method
	 * @return  Request  The new request object
	 */
	public static function forge($uri = null, $options = true, $method = null)
	{
		$request_scheme = \Arr::get($_SERVER, 'REQUEST_SCHEME', 'http');

		# The REQUEST_URI key is not set when the request is call from the CLI
		if (array_key_exists('REQUEST_URI', $_SERVER)) {

			$request_uri = \Arr::get($_SERVER, 'REQUEST_URI');

			# Apply the patch only if the request_uri start with http
			if (strpos($request_uri, $request_scheme) === 0) {
				$_SERVER['REQUEST_URI'] = str_replace("$request_scheme://" . $_SERVER['SERVER_NAME'], '', $request_uri);
			}

		}

		return parent::forge($uri, $options, $method);
	}	
}