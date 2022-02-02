<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Blogs;
use App\Models\Banners;
use App\Models\Payments;
use App\Models\Products;
use App\Models\Deliverys;
use App\Models\Feedbacks;
use App\Models\ProductColor;
use App\Models\AboutGallery;
use App\Models\BlogGalleries;
use App\Models\ProductGalleries;
use App\Models\ProductCategories;
use App\Models\DefaultConfiguration;


class SiteController extends Controller
{
    /**
     * Apresenta a página inicial do site
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $site_title = 'Rocksay Store';
        $site_keys = ', Roupas e Acessórios Online, Loja Online de Roupas Segura, Novidades da moda moderna';
        $site_description = 'Venha conhecer a nossa loja online! Aqui você fica por dentro de tudo sobre a loja: nossos produtos, formas de pagamento, entregas, acompanha as novidades no blog da Rocksay, encontra todos os nossos contatos e localização e muito mais';
        $config = DefaultConfiguration::find(1);
        $about = About::count();
        $feedback = Feedbacks::where('status', 1)->count();
        $blog_general = Blogs::where('status', 1)->count();
        $blog = Blogs::orderBy('start_post', 'asc')->limit(10)->where('status', 1)->where('highlight', 1)->get();
        $products = Products::orderBy('created_at', 'desc')->where('status', 1)->get();
        $categories = ProductCategories::orderBy('position', 'asc')->where('status', 1)->get();

        return view('welcome', ['site_title' => $site_title, 'site_keys' => $site_keys, 'site_description' => $site_description, 'config' => $config, 'about' => $about, 'feedback' => $feedback, 'blog_general' => $blog_general, 'blog' => $blog, 'products' => $products, 'categories' => $categories, 'index_css' => 1, 'glide1_css' => 1, 'glide2_css' => 1,]);
    }

    /**
     * Apresenta a página sobre a empresa
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function about()
    {
        $site_title = 'Sobre a Rocksay Store';
        $site_keys = ', Roupas e Acessórios Online, Loja Online de Roupas Segura, Novidades da moda moderna';
        $site_description = 'Conheça um pouco de nossa tragetória, as coisas que nos motivam, os objetivos que temos com nosso atendimento e onde pretendemos chegar!';
        $config = DefaultConfiguration::find(1);
        $about = About::find(1);
        $about_gallery = AboutGallery::orderBy('position', 'asc')->where('status', 1)->get();
        $feedback = Feedbacks::where('status', 1)->count();
        $blog_general = Blogs::where('status', 1)->count();
        $products = Products::where('status', 1)->count();

        return view('about', ['site_title' => $site_title, 'site_keys' => $site_keys, 'site_description' => $site_description, 'config' => $config, 'about' => $about, 'about_gallery' => $about_gallery, 'feedback' => $feedback, 'blog_general' => $blog_general, 'products' => $products, 'about_css' => 1, 'simple_css' => 1]);
    }

    /**
     * Apresenta a página de erros
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function error_404()
    {
        $site_title = 'Rocksay Store';
        $site_keys = ', Roupas e Acessórios Online, Loja Online de Roupas Segura, Novidades da moda moderna';
        $site_description = 'Conheça um pouco de nossa tragetória, as coisas que nos motivam, os objetivos que temos com nosso atendimento e onde pretendemos chegar!';
        $config = DefaultConfiguration::find(1);
        $about = About::find(1);
        $feedback = Feedbacks::where('status', 1)->count();
        $blog_general = Blogs::where('status', 1)->count();
        $products = Products::where('status', 1)->count();

        return view('error_404', ['site_title' => $site_title, 'site_keys' => $site_keys, 'site_description' => $site_description, 'config' => $config, 'about' => $about, 'feedback' => $feedback, 'blog_general' => $blog_general, 'products' => $products, 'erro_css' => 1]);
    }

    /**
     * Apresenta a página de produtos
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function products()
    {
        $site_title = 'Nossos Produtos Rocksay';
        $site_keys = ', Roupas e Acessórios Online, Loja Online de Roupas Segura, Novidades da moda moderna, Comprar Roupas Online, Novidades Cutie And Sweet, Roupas Cutie And Sweet';
        $site_description = 'Conheça os produtos disponíveis na loja! Tem algo que gostaria? Conta pra gente que vamos dar um jeitinho pra você!';

        $config = DefaultConfiguration::find(1);
        $about = About::count();
        $feedback = Feedbacks::where('status', 1)->count();
        $blog_general = Blogs::where('status', 1)->count();
        $products = Products::orderBy('created_at', 'desc')->where('status', 1)->paginate(12);
        foreach ($products as $product) {
            $product->load('categories');
        }
        $categories = ProductCategories::orderBy('position', 'asc')->where('status', 1)->get();
        $payments = Payments::orderBy('position', 'asc')->where('status', 1)->get();
        $deliverys = Deliverys::orderBy('position', 'asc')->where('status', 1)->get();

        return view('products', ['site_title' => $site_title, 'site_keys' => $site_keys, 'site_description' => $site_description, 'config' => $config, 'about' => $about, 'feedback' => $feedback, 'blog_general' => $blog_general, 'products' => $products, 'categories' => $categories, 'payments' => $payments, 'deliverys' => $deliverys, 'products_css' => 1]);
    }

    /**
     * Apresenta a página de detalhes de um produto selecionado
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function product_selected($product_id, $product_name)
    {
        // Verifica presença de id ao requisitar função
        if (empty($product_id)) {
            return redirect()->route('404');
        }

        // Seleciona o produto requisitado com suas categorias e verifica existencia
        $product_selected = Products::find($product_id);
        if (empty($product_selected) || $product_selected->status == 0) {
            return redirect()->route('404');
        }
        $product_selected->load('categories');
        if (!empty($product_selected->sizes)) {
            $product_selected->new_sizes = explode(',', $product_selected->sizes);
        }
        $product_selected->colors = ProductColor::where('product_id', $product_id)->where('status', 1)->get();
        $product_selected->gallery = ProductGalleries::orderBy('position', 'asc')->where('product_id', $product_id)->where('status', 1)->get();

        // Carrega demais objetos necessários
        $config = DefaultConfiguration::find(1);
        $config->image = 'images/products/product/' . $product_selected->image;
        $about = About::count();
        $feedback = Feedbacks::where('status', 1)->count();
        $blog_general = Blogs::where('status', 1)->count();
        $products = Products::inRandomOrder()->limit(10)->where('status', 1)->where('id', '!=', $product_id)->get();
        $categories = ProductCategories::orderBy('position', 'asc')->where('status', 1)->get();
        $payments = Payments::orderBy('position', 'asc')->where('status', 1)->get();
        $deliverys = Deliverys::orderBy('position', 'asc')->where('status', 1)->get();

        $site_title = $product_selected->title . ' | Rocksay Store';
        $site_keys = ', Roupas e Acessórios Online, Loja Online de Roupas Segura, Novidades da moda moderna, ' . $product_selected->title;
        $site_description = $product_selected->abstract ? $product_selected->abstract : '';

        // retorno com objetos e permissões css da página
        return view('product_selected', ['site_title' => $site_title, 'site_keys' => $site_keys, 'site_description' => $site_description, 'product_selected' => $product_selected, 'config' => $config, 'about' => $about, 'feedback' => $feedback, 'blog_general' => $blog_general, 'products' => $products, 'categories' => $categories, 'payments' => $payments, 'deliverys' => $deliverys, 'product_detail_css' => 1, 'glide1_css' => 1, 'glide2_css' => 1, 'simple_css' => 1, 'meta_product' => 1]);
    }

    /**
     * Apresenta a página de blog
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function blog()
    {
        $site_title = 'Blog Rocksay | Rocksay Store';
        $site_keys = ', Roupas e Acessórios Online, Loja Online de Roupas Segura, Novidades da moda moderna, Comprar Roupas Online, Novidades Cutie And Sweet, Roupas Cutie And Sweet';
        $site_description = 'Fique por dentro das novidades da moda e dos produtos que vão chegando na loja através do blog da Cutie and Sweet, vem conhecer!';

        $config = DefaultConfiguration::find(1);
        $about = About::count();
        $feedback = Feedbacks::where('status', 1)->count();
        $blog_general = Blogs::orderBy('start_post', 'desc')->where('status', 1)->paginate(7);
        $products = Products::where('status', 1)->count();
        $banners = Banners::orderBy('position', 'asc')->where('status', 1)->get();

        return view('blog', ['site_title' => $site_title, 'site_keys' => $site_keys, 'site_description' => $site_description, 'config' => $config, 'about' => $about, 'feedback' => $feedback, 'blog_general' => $blog_general, 'products' => $products, 'banners' => $banners, 'glide1_css' => 1, 'glide2_css' => 1, 'blog_css' => 1, 'banners_css' => 1]);
    }

    /**
     * Apresenta a página de detalhes de um post selecionado
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function post_selected($post_id, $post_name)
    {
        // Verifica presença de id ao requisitar função
        if (empty($post_id)) {
            return redirect()->route('404');
        }

        // Seleciona o post requisitado e verifica existencia
        $post_selected = Blogs::find($post_id);
        if (empty($post_selected) || $post_selected->status == 0) {
            return redirect()->route('404');
        }
        $post_selected->gallery = BlogGalleries::orderBy('position', 'asc')->where('blog_id', $post_id)->where('status', 1)->get();

        // Carrega demais objetos necessários
        $config = DefaultConfiguration::find(1);
        $config->image = 'images/blogs/posts/' . $post_selected->image;
        $about = About::count();
        $feedback = Feedbacks::where('status', 1)->count();
        $blog_general = Blogs::inRandomOrder()->limit(10)->where('status', 1)->get();
        $products = Products::where('status', 1)->count();
        $banners = Banners::orderBy('position', 'asc')->where('status', 1)->get();

        $site_title = $post_selected->title . ' | Rocksay Store';
        $site_keys = ', Roupas e Acessórios Online, Loja Online de Roupas Segura, Novidades da moda moderna, ' . $post_selected->title;
        $site_description = 'Conheça as novidades da moda moderna e saiba mais sobre ' . $post_selected->title;

        // retorno com objetos e permissões css da página
        return view('post_selected', ['site_title' => $site_title, 'site_keys' => $site_keys, 'site_description' => $site_description, 'post_selected' => $post_selected, 'config' => $config, 'about' => $about, 'feedback' => $feedback, 'blog_general' => $blog_general, 'products' => $products, 'banners' => $banners, 'post_detail_css' => 1, 'glide1_css' => 1, 'glide2_css' => 1, 'simple_css' => 1, 'banners_css' => 1]);
    }

    /**
     * Apresenta a página de feedbacks
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function feedback()
    {
        $site_title = 'Feedback - Cutie And Sweet';
        $site_keys = ', Roupas e Acessórios Online, Loja Online de Roupas Segura, Novidades da moda moderna, Comprar Roupas Online, Novidades Cutie And Sweet, Roupas Cutie And Sweet';
        $site_description = 'Conheça um pouco do nosso trabalho através do feedback de nossos clientes! Estamos esperando pelo seu feedback também!';

        $config = DefaultConfiguration::find(1);
        $about = About::count();
        $feedback = Feedbacks::orderBy('position', 'asc')->where('status', 1)->get();
        $blog_general = Blogs::where('status', 1)->count();
        $products = Products::where('status', 1)->count();

        return view('feedback', ['site_title' => $site_title, 'site_keys' => $site_keys, 'site_description' => $site_description, 'config' => $config, 'about' => $about, 'feedback' => $feedback, 'blog_general' => $blog_general, 'products' => $products, 'glide1_css' => 1, 'glide2_css' => 1, 'simple_css' => 1, 'feedback_css' => 1]);
    }

    /**
     * Apresenta a página de contato
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contact()
    {
        $site_title = 'Contatos - Cutie And Sweet';
        $site_keys = ', Roupas e Acessórios Online, Loja Online de Roupas Segura, Novidades da moda moderna, Comprar Roupas Online, Novidades Cutie And Sweet, Roupas Cutie And Sweet';
        $site_description = 'Entre em contato conosco e tire todas as suas dúvidas. Estamos a disposição para sugestões e pedidos sempre que precisar.';

        $config = DefaultConfiguration::find(1);
        $about = About::count();
        $feedback = Feedbacks::where('status', 1)->count();
        $blog_general = Blogs::where('status', 1)->count();
        $products = Products::where('status', 1)->count();

        return view('contact', ['site_title' => $site_title, 'site_keys' => $site_keys, 'site_description' => $site_description, 'config' => $config, 'about' => $about, 'feedback' => $feedback, 'blog_general' => $blog_general, 'products' => $products, 'contact_css' => 1]);
    }

    public function login() {
        return view('auth/login');
    }
    public function erro() {
        return view('errors/404');
    }
}
