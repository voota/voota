<?php

/**
 * @file
 * A single location to store configuration.
 */

define('CONSUMER_KEY', '12zhPy8brdLEZwUbLPQ1A');
define('CONSUMER_SECRET', 'r6uunjGnmKf4pkNhcvJuUpCIjhOyBZtblATk8e7qLqg');
define('OAUTH_CALLBACK', 'http://local.voota.es/frontend_dev.php/user/login?op=tw');

/*
 * https://api.twitter.com/oauth/request_token
Access token URL

https://api.twitter.com/oauth/access_token
Authorize URL

https://api.twitter.com/oauth/authorize
We support hmac-sha1 signatures. We do not support the plaintext signature method.
Registered OAuth Callback URL

http://voota.es/user/login?op=tw
 * */
