<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->get('/doc', function () {
        return view('doc');
    });

    $router->group(['prefix' => 'youtube', 'middleware' => 'api'], function () use ($router) {
        $router->group(['prefix' => 'videos', 'namespace' => 'Youtube'], function ($router) {
            $router->get('/item/{id}', ['as' => 'video', 'uses' => 'YouTubeController@videoById']);
            $router->get('/popular', ['as' => 'video.popular', 'uses' => 'YouTubeController@videoPopular']);
        });
        $router->group(['prefix' => 'channels', 'namespace' => 'Youtube'], function ($router) {
            $router->get('/item/{idChannel}', ['as' => 'channel.index', 'uses' => 'YouTubeController@channelById']);
            $router->get('/search/{q}', ['as' => 'channel.search', 'uses' => 'YouTubeController@channelSearch']);
        });
    });

    $router->group(['prefix' => 'disputes', 'namespace' => 'Api', 'middleware' => 'api'], function ($router) {
        $router->get('/tape', ['as' => 'disputes.tape', 'uses' => 'DisputesController@tape']);
        $router->get('/item/{id}', ['as' => 'disputes.item', 'uses' => 'DisputesController@item']);
        $router->post('/rate', ['as' => 'disputes.rate', 'uses' => 'UserDisputesController@rate']);
    });
});

$router->group(['prefix' => 'auth', 'namespace' => 'Auth'], function ($router) {
    $router->post('login', 'AuthController@login');
//    $router->get('google', 'GoogleAuthController@redirectToGoogle');
//    $router->get('google/callback', 'GoogleAuthController@handleGoogleCallback');

    $router->group(['middleware' => 'api'], function ($router) {
        $router->get('logout', 'AuthController@logout');
        $router->get('refresh', 'AuthController@refresh');
        $router->get('me', 'AuthController@me');
    });
});
