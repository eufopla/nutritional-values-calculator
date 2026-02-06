<?php

$router->get('community/post/create', [
    'middleware' => [],
    'uses' => 'Community\CommunityPostController@createPost',
]);