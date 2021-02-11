<?php

require 'vendor/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

// Function Get Random Line
function randomTweet($tweets)
{
  $lines = file($tweets);
  return $lines[array_rand($lines)];
}

// API KEY TWITTER
$consumer_key         = '##################################################';
$consumer_secret      = '##################################################';
$access_token         = '##################################################';
$access_token_secret  = '##################################################';

/**************************************************************************/
/*                       Sell Account Twitter Dev                         */
/*                                                                        */
/* On P-Store.net : https://p-store.net/akun/55410/akun-twitter-developer */
/* Donation       : https://saweria.co/zckyachmd                          */
/*                                                                        */
/*   Created by Zacky Achmad | Powered by Zetbot Indonesia (zetbot.org)   */
/**************************************************************************/

// Config Auto Reply
$i = 1;
$total_tweet = 3; // Tweet per Action

// Connect to Account
$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
$connection->get('account/verify_credentials');

if ($connection->getLastHttpCode() == 200) {
  // Get Tweet Status
  $get_status = $connection->get('statuses/home_timeline', ['count' => $total_tweet]);

  foreach ($get_status as $status) {
    // // Get Reply from File
    // $tweet = '@' . $status->user->screen_name . ' ' . randomTweet('tweet_reply.txt');

    // // Reply to Tweet
    // $connection->post('statuses/update', ['in_reply_to_status_id' => $status->id, 'status' => $tweet]);

    // Reply with Media
    $tweet = '@' . $status->user->screen_name . ' ' . randomTweet('tweet_reply.txt');
    $media = $connection->upload('media/upload', ['media' => 'zetbot.jpg']);
    $data = [
      'in_reply_to_status_id' => $status->id,
      'status' => $tweet,
      'media_ids' => $media->media_id_string
    ];
    $connection->post('statuses/update', $data);

    if ($connection->getLastHttpCode() == 200) {
      echo $i . ' Successfully replied to ' . $tweet . '</br>';
      $i++;
    } else {
      echo 'Failed to reply to the tweet!';
      break;
    }
  }
} else {
  echo 'Invalid API key!';
}
