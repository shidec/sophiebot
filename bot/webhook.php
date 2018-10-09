<?php
	define('BASEPATH', '/');
	define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

	require_once '../application/config/database.php';
	require_once '../application/config/config.php';

	define('DB_HOST', $db[$active_group]['hostname']);
	define('DB_USER', $db[$active_group]['username']);
	define('DB_PASSWD', $db[$active_group]['password']);
	define('DB_DATABASE', $db[$active_group]['database']);
	define('BASE_URL', $config['base_url']);

	
	//--CLASSES
	require_once 'classes/Database.php';
	require_once 'classes/Line_Apps.php';
	require_once 'classes/LineBot.php';
	require_once 'classes/Session.php';
	require_once 'classes/Option.php';
	require_once 'helper.php';
	
	$option = new Option();
	$active_app = 'CEBot';
	$client = new LineBot($option->get('channel_access_token'), $option->get('channel_secret'));
	
	require_once './apps/' . $active_app  . '.php';
	
	
	foreach ($client->parseEvents() as $event) {
		$source = $event['source'];
		if($source['type'] == 'user'){
			$profile = check_profile($client, $source['userId']);
			$app = new $active_app($client, $profile, $option);
			$messages = array();
			if($event['type'] == 'follow'){
				$messages = process_messages($app->on_follow());
			}else if($event['type'] == 'message'){
				$messages = process_messages($app->on_message($event['message']['text']));
			}else if($event['type'] == 'postback'){
				$messages = process_messages($app->on_postback($event['postback']['data']));
			}else if($event['type'] == 'unfollow'){
				$app->on_unfollow();
			}
		}
	}
				
	if($messages){
		$client->replyMessage(array(
			'replyToken' => $event['replyToken'],
			'messages' => $messages
		));
	}
	
	
	