<?php
/**
  * This is the core of the Elliot XML-RPC error reporting system for WordPress.
  * It is intended to provide plug-in authors with the unique ability to record
  * and act on custom errors thrown by their plug-ins.  Elliot will parse errors
  * as XML-RPC calls and report them back to a centrally-located database on the
  * plug-in author's server.  
  *
  * This is one-way communication only!
  *
  * For security purposes, Elliot will not accept any returned parameters on the
  * plug-in side of things.  The XML-RPC client will only recognize "success"
  * or "failure."
  *
  * You must define the location of the XML-RPC server when you instantiate your reporter.  Do
  * not modify anything in the Elliot package!
  *
  * Copyright 2010  Eric Mann  (email : eric@eamann.com)
  *
  * This program is free software; you can redistribute it and/or modify
  * it under the terms of the GNU General Public License, version 2, as 
  * published by the Free Software Foundation.
  *
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  *
  * You should have received a copy of the GNU General Public License
  * along with this program; if not, write to the Free Software
  * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  */
include(ABSPATH . WPINC . '/class-IXR.php');

if(!class_exists('ElliotClient')) :
class ElliotClient {
	/* Define Variables */
	private static $blog;
	private static $admin;
	private static $wp_ver;
	private static $php_ver;
	private static $fopen;
	private static $server;
	private static $plugin;
	private static $version;
	
	private $client;
	
	public function __construct($serv, $plug, $ver) {
		$this->blog = get_bloginfo('url');
		$this->admin = get_bloginfo('admin_email');
		$this->wp_ver = get_bloginfo('version');
		$this->php_ver = PHP_VERSION;
		$this->fopen = ini_get('allow_url_fopen');
		$this->server = $serv;
		$this->plugin = $plug;
		$this->version = $ver;				
		
		$this->client = new IXR_Client($this->server);
	}
	
	public function dispatch($message) {
			
		if(!$this->client->query('elliot.phoneHome', $this->blog, $this->admin,$this->wp_ver,$this->php_ver,$this->fopen,$this->plugin,$this->version,$message)) {
			$response = 'Something went wrong';
		} else {
			$response = $this->client->getResponse();
		}
		
		return $response;

	}
	
}
endif;
?>