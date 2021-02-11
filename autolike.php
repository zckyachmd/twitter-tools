<?php

require 'vendor/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

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

// Config Auto Like
$i = 1;
$total_tweet = 3; // Tweet per Action

// Connect to Account
$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
$connection->get('account/verify_credentials');

if ($connection->getLastHttpCode() == 200) {
  // Get Tweet Status
  $get_status = $connection->get('statuses/home_timeline', ['count' => $total_tweet]);

  foreach ($get_status as $status) {
    $id = $status->id;

    // Like Tweet
    $connection->post('favorites/create', ['id' => $id]);

    if ($connection->getLastHttpCode() == 200) {
      echo $i . ' Successfully like ' . $id . '</br>';
      $i++;
    } else {
      echo 'Failed to like to the tweet!';
      break;
    }
  }
} else {
  echo 'Invalid API key!';
}
