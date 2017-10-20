<?php
 
require_once('./vendor/autoload.php');

use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;

$channel_token = '2MCOyCeaBipmw3ZzJG8BrsiO4KzCoaoPddMgbZtEu5HHVeIaWU+PDKcCZRJEY76zqxv56d15kZeMoU/vQ0zuzPFlbhFM7AhRMZwLrSkLdciLCuKUgV6aFrvAAuuG1mMWe7DCzfEW9FfHQhJR4F/m0AdB04t89/1O/w1cDnyilFU=';
$channel_secret = 'd4afd7da941ac195c155fe67dcb5a338';

// Get message from Line API
$content = file_get_contents('php://input');
$events = json_decode($content, true);

if (!is_null($events['events'])) {

	// Loop through each event
	foreach ($events['events'] as $event) {
    
        // Line API send a lot of event type, we interested in message only.
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {

            // Get replyToken
            $replyToken = $event['replyToken'];

            // Split message then keep it in database. 
            $appointments = explode(',', $event['message']['text']);

            if(count($appointments) == 2) {

                $host = 'ec2-174-129-223-193.compute-1.amazonaws.com';
                $dbname = 'd74bjtc28mea5m';
                $user = 'eozuwfnzmgflmu';
                $pass = '2340614a293db8e8a8c02753cd5932cdee45ab90bfcc19d0d306754984cbece1';
                $connection = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass); 
                
                $params = array(
                    'time' => $appointments[0],
                    'content' => $appointments[1],
                );
    
                $statement = $connection->prepare("INSERT INTO appointments (time, content) VALUES (:time, :content)");
                $result = $statement->execute($params);
    
                $respMessage = 'Your appointment has saved.';
            }else{
                $respMessage = 'You can send appointment like this "12.00,House keeping." ';
            }
            
            $httpClient = new CurlHTTPClient($channel_token);
            $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret));

            $textMessageBuilder = new TextMessageBuilder($respMessage);
            $response = $bot->replyMessage($replyToken, $textMessageBuilder);
 
		}
	}
}

echo "OK";
