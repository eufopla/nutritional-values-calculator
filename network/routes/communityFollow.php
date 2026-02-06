<?php

$router->get('community/follow/follow', [
    'middleware' => [],
    'uses' => 'Community\CommunityFollowController@follow',
]);
$router->get('community/follow/unfollow', [
    'middleware' => [],
    'uses' => 'Community\CommunityFollowController@unfollow',
]);
$router->get('community/follow/getfollows', [
    'middleware' => [],
    'uses' => 'Community\CommunityFollowController@getFollows',
]);
$router->get('community/follow/getfollowers', [
    'middleware' => [],
    'uses' => 'Community\CommunityFollowController@getFollowers',
]);