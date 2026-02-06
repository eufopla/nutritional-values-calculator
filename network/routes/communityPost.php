<?php

$router->get('community/post/create', [
    'middleware' => [],
    'uses' => 'Community\CommunityPostController@createPost',
]);
$router->get('community/post/update', [
    'middleware' => [],
    'uses' => 'Community\CommunityPostController@updatePost',
]);
$router->get('community/post/harddelete', [
    'middleware' => [],
    'uses' => 'Community\CommunityPostController@hardDeletePost',
]);