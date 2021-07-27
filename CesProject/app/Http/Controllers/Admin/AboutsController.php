<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AboutsRequest;
use App\Models\About;

class AboutsController extends Controller
{
    /**
     * Display a listing of the 'about'
     *
     * @param  \App\Models\About  $model
     * @return \Illuminate\View\View
     */
    public function index(About $model)
    {
        return view('admin.about.index', ['about' => $model->find(1)]);
    }

    /**
     * Create the 'about'
     *
     * @param  \App\Http\Requests\Admin\AboutsRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AboutsRequest $request)
    {
        if(About::create($request->validated())){
            toast('Sobre cadastrado com sucesso!', 'success');
            return back();
        }
        toast('Sobre não pode ser cadastrado!', 'error');
        return back();
    }

    /**
     * Update the 'about'
     *
     * @param  \App\Http\Requests\Admin\AboutsRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AboutsRequest $request)
    {
        $about = About::find($request->input('id'));
        if(!$about) {
            toast('Sobre não encontrado!', 'error');
            return back();
        }

        if($about->update($request->validated())){
            toast('Atualização realizada com sucesso!', 'success');
            return back();
        }

        toast('Sobre não pode ser atualizado!', 'error');
        return back();
    }

}
