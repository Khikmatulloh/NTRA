<?php

declare(strict_types=1);

use App\Router;

Router::get('/', fn()=> loadController('home'));

Router::get('/branch', fn()=> loadController('branch'));

Router::get('/ads/{id}', function (int $id) {
    loadController('showAd', ['id'=>$id]);
});

Router::get('/ads/create', fn()=> loadController('create-ad'));
Router::post('/ads/create', fn()=> loadController('createAd'));


Router::get('/login', fn()=> loadView('dashboard/create-login'));
Router::post('/login', fn()=> loadController('createlogin'));

Router::get('/registar', fn()=> loadView('dashboard/create-registar'));
Router::post('/registar', fn()=> loadController('createuser'));







Router::get('/status/create', fn()=> loadView('dashboard/create-status'));
Router::post('/status/create', fn()=> loadController('createStatus'));

Router::get('/branch/create', fn()=> loadView('dashboard/create-branch'));
Router::post('/branch/create', fn()=> loadController('createBranch'));
Router::errorResponse(404, 'Not Found');