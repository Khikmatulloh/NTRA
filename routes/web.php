<?php

declare(strict_types=1);

use App\Router;
use Controller\UserController;
use Controller\AdController;
use Controller\BranchController;




Router::get('/', fn()=> loadController('home'));

Router::get('/branch', fn()=> loadController('branch'));
Router::get('/ads/{id}', fn(int $id) => (new AdController())->show($id));
Router::get('/ads/create', fn() => (new AdController())->create());
Router::post('/ads/create', fn() => (new AdController())->store());

Router::get('/ads/update/{id}', fn(int $id) => (new AdController())->edit($id));
Router::patch('/ads/update/{id}', fn(int $id) => (new AdController())->update($id));

Router::delete('/ads/delete/{id}', fn(int $id) => (new AdController())->delete($id));

Router::get('/login', fn()=> loadView('dashboard/create-login'),'guest');
Router::post('/login', fn() => (new \Controller\AuthController())->login());

Router::get('/registar', fn()=> loadView('dashboard/create-registar'));
Router::post('/registar', fn()=> loadController('createuser'));
// Router::get('/admin/branches', fn()=> (new BranchController())->index(), 'auth');


Router::get('/admin', fn()=> loadView('dashboard/home'),'auth');
Router::get('/admin/ads', fn()=> (new AdController())->index(),'auth');

Router::get('/admin/branches', fn()=> (new \Controller\BranchController())->index(), 'auth');


Router::get('/profile', fn() => (new \Controller\UserController())->loadProfile(),'auth');




Router::get('/status/create', fn()=> loadView('dashboard/create-status'));
Router::post('/status/create', fn()=> loadController('createStatus'));

Router::get('/branch/create', fn()=> loadView('dashboard/create-branch'));
Router::post('/branch/create', fn()=> loadController('createBranch'));
Router::errorResponse(404, 'Not Found');