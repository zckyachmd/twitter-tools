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
$consumer_key         = 'oPRCaB4fqe3NQyH0IokxAn7AQ';
$consumer_secret      = '9n2uc8PvsNjt3PBm0Kye6qqs6ttPYEfeFlVHD6ApyluguVM4ek';
$access_token         = '1252876435993145348-2RsfUp5C0fw7Ko3sDQRs8yFE6jO0lw';
$access_token_secret  = 'jVrWoZkIZxNAo7usb5fITqZFLbJChkNB7jq6I1hd8RR4i';

/**************************************************************************/
/*                       Sell Account Twitter Dev                         */
/*                                                                        */
/* On P-Store.net : https://p-store.net/akun/55410/akun-twitter-developer */
/* Donation       : https://saweria.co/zckyachmd                          */
/*                                                                        */
/*   Created by Zacky Achmad | Powered by Zetbot Indonesia (zetbot.org)   */
/**************************************************************************/

// Config Auto Reply
$total_tweet = 1; // Tweet per Action

// Connect to Account
$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
$connection->get('account/verify_credentials');

if ($connection->getLastHttpCode() == 200) {
  // Get Tweet Status
  $get_status = $connection->get('statuses/home_timeline', ['count' => $total_tweet]);

  foreach ($get_status as $status) {
    $i = 0;

    // // Get Reply from File
    $tweet = '@' . $status->user->screen_name . ' ' . randomTweet('tweet_reply.txt');

    // // Reply to Tweet
    $connection->post('statuses/update', ['in_reply_to_status_id' => $status->id, 'status' => $tweet]);

    // Reply with Media
    // $tweet = '@' . $status->user->screen_name . ' ' . randomTweet('tweet_reply.txt');
    // $media = $connection->upload('media/upload', ['media' => 'zetbot.jpg']);
    // $data = [
    //   'in_reply_to_status_id' => $status->id,
    //   'status' => $tweet,
    //   'media_ids' => $media->media_id_string
    // ];
    // $connection->post('statuses/update', $data);

    if ($connection->getLastHttpCode() == 200) {
      echo 'Successfully replied to ' . $tweet . '</br>';
      $i++;
    } else {
      echo 'Failed to reply to the tweet!';
      break;
    }
  }

  if ($i >= 1) {
    echo '</br> Success ' . $i . ' replies';
  }
} else {
  echo 'Invalid API key!';
}
