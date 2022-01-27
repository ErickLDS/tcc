<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RedefinirController;
use App\Http\Controllers\MontarChurrosController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\MinhaContaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SaboresController;
use App\Http\Controllers\TiposSaboresController;

// Páginas
Route::get('/', [IndexController::class, 'index']);
Route::get('/montarchurros', [MontarChurrosController::class, 'index']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/redefinirsenha', [RedefinirController::class, 'index']);
Route::get('/redefinirsenha/{token}/{email}', [RedefinirController::class, 'redefinirSenha'])->name('password.reset');
Route::get('/ck10dashboard/{rota?}', [DashboardController::class, 'index']);
Route::get('/dashboard/login', [DashboardController::class, 'login'])->name('loginAdm');
Route::get('/politicas', function () {
    return view('site.politicas');
});

// Visualizar
Route::get('/pedido/formapagamento/get', [PedidoController::class, 'showFormaPagamento']);
Route::get('/pedido/status/get', [PedidoController::class, 'showStatus']);
Route::get('/sabores/get/{id}', [SaboresController::class, 'show']);
Route::get('/tiposabores/get', [TiposSaboresController::class, 'show']);
Route::get('/getchurros/{codigo}', [SaboresController::class, 'showChurros']);
Route::get('/getrandom', [SaboresController::class, 'showRandom']);
Route::get('/getpreco/{churros}', [SaboresController::class, 'showPreco']);

// Adicionar
Route::post('/login/set', [LoginController::class, 'store']);

// Editar
Route::post('/novasenha', [RedefinirController::class, 'novaSenha']);

// Ações
Route::post('/login/do', [LoginController::class, 'login']);
Route::get('/login/logout', [LoginController::class, 'logout']);
Route::post('/login/check', [LoginController::class, 'check']);
Route::post('/dashboard/login/do', [DashboardController::class, 'loginDo']);
Route::get('/dashboard/logout', [DashboardController::class, 'logout']);
Route::post('/confirmarEmail', [RedefinirController::class, 'email']);

// Rotas somente Usuários
Route::middleware('auth')->group(function () {
    // Páginas
    Route::get('/minhaconta/{pedidos?}', [MinhaContaController::class, 'index'])->name('minhaconta');
    Route::get('/pedido', [PedidoController::class, 'index']);
    Route::get('/pedido/{id}', [MinhaContaController::class, 'indexPedido']);

    // Visualizar
    Route::get('/pedido/get/all', [PedidoController::class, 'showAll']);
    Route::get('/pedido/get/{id}', [PedidoController::class, 'show']);

    // Adicionar
    Route::post('/pedido/set', [PedidoController::class, 'store']);

    // Editar
    Route::post('/login/edit', [LoginController::class, 'edit']);

    // Ações
    Route::post('/pedido/validar/endereco', [PedidoController::class, 'validarEndereco']);
    Route::post('/pedido/validar/pagamento', [PedidoController::class, 'validarPagamento']);
});

// Rotas somente Admin
Route::middleware('auth:admin')->group(function () {
    // Visualizar
    Route::get('/ck10dashboard/pedidos/get/{dia?}/{mes?}/{ano?}', [DashboardController::class, 'showPedidos']);

    // Adicionar
    Route::post('/sabores/set/{id}', [SaboresController::class, 'store']);
    Route::post('/tiposabores/set', [TiposSaboresController::class, 'store']);

    // Editar
    Route::post('/pedido/status/set', [PedidoController::class, 'editStatus']);
    Route::post('/sabores/edit/{id}', [SaboresController::class, 'edit']);
    Route::post('/tiposabores/edit/{id}', [TiposSaboresController::class, 'edit']);

    // Deletar
    Route::delete('/sabores/delete/{id}', [SaboresController::class, 'destroy']);
    Route::delete('/tiposabores/delete/{id}', [TiposSaboresController::class, 'destroy']);
});