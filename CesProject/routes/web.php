<?php

use App\Http\Controllers\Admin\AboutGalleriesController;
use App\Http\Controllers\Admin\AboutsController;
use App\Http\Controllers\Admin\BannersController;
use App\Http\Controllers\Admin\BlogGalleryController;
use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Admin\DefaultConfigurationsController;
use App\Http\Controllers\Admin\DeliverysController;
use App\Http\Controllers\Admin\FeedbacksController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('gerenciar/painel-de-controle', [HomeController::class, 'index'])->name('painel-de-controle');

Route::group(['middleware' => 'auth'], function () {
    // Rotas iniciais
    Route::post('gerenciar/anotacoes/salvar', [HomeController::class, 'store_notes'])->name('anotacoes.salvar');

    // Rotas de usuários
    Route::get('gerenciar/usuarios', [UserController::class, 'index'])->name('usuarios');
    Route::post('gerenciar/usuarios/cadastro', [UserController::class, 'store'])->name('usuarios.cadastro');
    Route::get('gerenciar/usuarios/edicao/{id}', [UserController::class, 'edit'])->name('usuarios.edicao');
    Route::put('gerenciar/usuarios/atualizacao', [UserController::class, 'update'])->name('usuarios.atualizacao');
    Route::get('gerenciar/usuarios/alternar/{id}', [UserController::class, 'toggle'])->name('usuarios.alternar');
    Route::get('gerenciar/usuarios/deletar/{id}', [UserController::class, 'destroy'])->name('usuarios.deletar');

    // Rotas de configuração
    Route::get('gerenciar/configuracoes', [DefaultConfigurationsController::class, 'index'])->name('configuracoes');
    Route::post('gerenciar/configuracoes/cadastro', [DefaultConfigurationsController::class, 'store'])->name('configuracoes.cadastro');
    Route::put('gerenciar/configuracoes/atualizacao', [DefaultConfigurationsController::class, 'update'])->name('configuracoes.atualizacao');
    Route::post('gerenciar/configuracoes/cortar', [DefaultConfigurationsController::class, 'crop'])->name('configuracoes.cortar');

    // Rotas do 'Sobre'
    Route::get('gerenciar/sobre', [AboutsController::class, 'index'])->name('sobre');
    Route::post('gerenciar/sobre/cadastro', [AboutsController::class, 'store'])->name('sobre.cadastro');
    Route::put('gerenciar/sobre/atualizacao', [AboutsController::class, 'update'])->name('sobre.atualizacao');
    // Rotas de galeria do 'Sobre'
    Route::get('gerenciar/sobre/galeria', [AboutGalleriesController::class, 'index'])->name('sobre.galeria');
    Route::post('gerenciar/sobre/galeria/cadastro', [AboutGalleriesController::class, 'store'])->name('sobre.galeria.cadastro');
    Route::get('gerenciar/sobre/galeria/edicao/{id}', [AboutGalleriesController::class, 'edit'])->name('sobre.galeria.edicao');
    Route::put('gerenciar/sobre/galeria/atualizacao', [AboutGalleriesController::class, 'update'])->name('sobre.galeria.atualizacao');
    Route::get('gerenciar/sobre/galeria/alternar/{id}', [AboutGalleriesController::class, 'toggle'])->name('sobre.galeria.alternar');
    Route::post('gerenciar/sobre/galeria/reposicionar', [AboutGalleriesController::class, 'reorder'])->name('sobre.galeria.reposicionar');
    Route::get('gerenciar/sobre/galeria/deletar/{id}', [AboutGalleriesController::class, 'destroy'])->name('sobre.galeria.deletar');

    // Rotas de Feedbacks
    Route::get('gerenciar/feedback', [FeedbacksController::class, 'index'])->name('feedback');
    Route::post('gerenciar/feedback/cadastro', [FeedbacksController::class, 'store'])->name('feedback.cadastro');
    Route::get('gerenciar/feedback/edicao/{id}', [FeedbacksController::class, 'edit'])->name('feedback.edicao');
    Route::put('gerenciar/feedback/atualizacao', [FeedbacksController::class, 'update'])->name('feedback.atualizacao');
    Route::get('gerenciar/feedback/alternar/{id}', [FeedbacksController::class, 'toggle'])->name('feedback.alternar');
    Route::post('gerenciar/feedback/reposicionar', [FeedbacksController::class, 'reorder'])->name('feedback.reposicionar');
    Route::post('gerenciar/feedback/cortar/{id}', [FeedbacksController::class, 'crop'])->name('feedback.cortar');
    Route::get('gerenciar/feedback/deletar/{id}', [FeedbacksController::class, 'destroy'])->name('feedback.deletar');
    
    // Rotas de Entregas
    Route::get('gerenciar/entregas', [DeliverysController::class, 'index'])->name('entregas');
    Route::post('gerenciar/entregas/cadastro', [DeliverysController::class, 'store'])->name('entregas.cadastro');
    Route::get('gerenciar/entregas/edicao/{id}', [DeliverysController::class, 'edit'])->name('entregas.edicao');
    Route::put('gerenciar/entregas/atualizacao', [DeliverysController::class, 'update'])->name('entregas.atualizacao');
    Route::get('gerenciar/entregas/alternar/{id}', [DeliverysController::class, 'toggle'])->name('entregas.alternar');
    Route::post('gerenciar/entregas/reposicionar', [DeliverysController::class, 'reorder'])->name('entregas.reposicionar');
    Route::get('gerenciar/entregas/deletar/{id}', [DeliverysController::class, 'destroy'])->name('entregas.deletar');

    // Rotas de Pagamentos
    Route::get('gerenciar/pagamentos', [PaymentController::class, 'index'])->name('pagamentos');
    Route::post('gerenciar/pagamentos/cadastro', [PaymentController::class, 'store'])->name('pagamentos.cadastro');
    Route::get('gerenciar/pagamentos/edicao/{id}', [PaymentController::class, 'edit'])->name('pagamentos.edicao');
    Route::put('gerenciar/pagamentos/atualizacao', [PaymentController::class, 'update'])->name('pagamentos.atualizacao');
    Route::get('gerenciar/pagamentos/alternar/{id}', [PaymentController::class, 'toggle'])->name('pagamentos.alternar');
    Route::post('gerenciar/pagamentos/reposicionar', [PaymentController::class, 'reorder'])->name('pagamentos.reposicionar');
    Route::get('gerenciar/pagamentos/deletar/{id}', [PaymentController::class, 'destroy'])->name('pagamentos.deletar');

    // Rotas de Banners
    Route::get('gerenciar/banners', [BannersController::class, 'index'])->name('banners');
    Route::post('gerenciar/banners/cadastro', [BannersController::class, 'store'])->name('banners.cadastro');
    Route::get('gerenciar/banners/edicao/{id}', [BannersController::class, 'edit'])->name('banners.edicao');
    Route::put('gerenciar/banners/atualizacao', [BannersController::class, 'update'])->name('banners.atualizacao');
    Route::get('gerenciar/banners/alternar/{id}', [BannersController::class, 'toggle'])->name('banners.alternar');
    Route::post('gerenciar/banners/reposicionar', [BannersController::class, 'reorder'])->name('banners.reposicionar');
    Route::post('gerenciar/banners/cortar/desktop/{id}', [BannersController::class, 'crop_desktop'])->name('banners.cortar.desktop');
    Route::post('gerenciar/banners/cortar/mobile/{id}', [BannersController::class, 'crop_mobile'])->name('banners.cortar.mobile');
    Route::get('gerenciar/banners/deletar/{id}', [BannersController::class, 'destroy'])->name('banners.deletar');

    // Rotas de Blogs
    Route::get('gerenciar/blog', [BlogsController::class, 'index'])->name('blog');
    Route::post('gerenciar/blog/cadastro', [BlogsController::class, 'store'])->name('blog.cadastro');
    Route::get('gerenciar/blog/edicao/{id}', [BlogsController::class, 'edit'])->name('blog.edicao');
    Route::put('gerenciar/blog/atualizacao', [BlogsController::class, 'update'])->name('blog.atualizacao');
    Route::get('gerenciar/blog/alternar/{id}', [BlogsController::class, 'toggle'])->name('blog.alternar');
    Route::get('gerenciar/blog/destaque/{id}', [BlogsController::class, 'highlight'])->name('blog.destaque');
    Route::post('gerenciar/blog/cortar/{id}', [BlogsController::class, 'crop'])->name('blog.cortar');
    Route::get('gerenciar/blog/deletar/{id}', [BlogsController::class, 'destroy'])->name('blog.deletar');

    // Rotas de Galeria de Blogs
    Route::get('gerenciar/blog/{blog_id}/galeria', [BlogGalleryController::class, 'index'])->name('blog.galeria');
    Route::post('gerenciar/blog/{blog_id}/galeria/cadastro', [BlogGalleryController::class, 'store'])->name('blog.galeria.cadastro');
    Route::get('gerenciar/blog/{blog_id}/galeria/edicao/{image_id}', [BlogGalleryController::class, 'edit'])->name('blog.galeria.edicao');
    Route::put('gerenciar/blog/{blog_id}/galeria/atualizacao', [BlogGalleryController::class, 'update'])->name('blog.galeria.atualizacao');
    Route::post('gerenciar/blog/{blog_id}/galeria/reposicionar', [BlogGalleryController::class, 'reorder'])->name('blog.galeria.reposicionar');
    Route::get('gerenciar/blog/{blog_id}/galeria/alternar/{image_id}', [BlogGalleryController::class, 'toggle'])->name('blog.galeria.alternar');
    Route::post('gerenciar/blog/{blog_id}/galeria/cortar/{image_id}', [BlogGalleryController::class, 'crop'])->name('blog.galeria.cortar');
    Route::get('gerenciar/blog/{blog_id}/galeria/deletar/{image_id}', [BlogGalleryController::class, 'destroy'])->name('blog.galeria.deletar');

    // Rotas de Produtos
    Route::get('gerenciar/produtos', [ProductsController::class, 'index'])->name('produtos');
    Route::post('gerenciar/produtos/cadastro', [ProductsController::class, 'store'])->name('produtos.cadastro');
    Route::get('gerenciar/produtos/edicao/{id}', [ProductsController::class, 'edit'])->name('produtos.edicao');
    Route::put('gerenciar/produtos/atualizacao', [ProductsController::class, 'update'])->name('produtos.atualizacao');
    Route::get('gerenciar/produtos/alternar/{id}', [ProductsController::class, 'toggle'])->name('produtos.alternar');
    Route::get('gerenciar/produtos/destaque/{id}', [ProductsController::class, 'highlight'])->name('produtos.destaque');
    Route::post('gerenciar/produtos/cortar/{id}', [ProductsController::class, 'crop'])->name('produtos.cortar');
    Route::get('gerenciar/produtos/deletar/{id}', [ProductsController::class, 'destroy'])->name('produtos.deletar');

    // Rotas de Galeria de Produtos
    Route::get('gerenciar/produtos/{product_id}/galeria', [ProductGalleryController::class, 'index'])->name('produtos.galeria');
    Route::post('gerenciar/produtos/{product_id}/galeria/cadastro', [ProductGalleryController::class, 'store'])->name('produtos.galeria.cadastro');
    Route::get('gerenciar/produtos/{product_id}/galeria/edicao/{image_id}', [ProductGalleryController::class, 'edit'])->name('produtos.galeria.edicao');
    Route::put('gerenciar/produtos/{product_id}/galeria/atualizacao', [ProductGalleryController::class, 'update'])->name('produtos.galeria.atualizacao');
    Route::post('gerenciar/produtos/{product_id}/galeria/reposicionar', [ProductGalleryController::class, 'reorder'])->name('produtos.galeria.reposicionar');
    Route::get('gerenciar/produtos/{product_id}/galeria/alternar/{image_id}', [ProductGalleryController::class, 'toggle'])->name('produtos.galeria.alternar');
    Route::post('gerenciar/produtos/{product_id}/galeria/cortar/{image_id}', [ProductGalleryController::class, 'crop'])->name('produtos.galeria.cortar');
    Route::get('gerenciar/produtos/{product_id}/galeria/deletar/{image_id}', [ProductGalleryController::class, 'destroy'])->name('produtos.galeria.deletar');
});
