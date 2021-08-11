<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductColorRequest;
use App\Models\ProductColor;

class ProductColorController extends Controller
{
    /**
     * Display a listing of the about colors
     *
     * @param  \App\Models\ProductColor  $model
     * @return \Illuminate\View\View
     */
    public function index(ProductColor $model, $product_id)
    {
        $colors = $model->where('product_id', $product_id)->get();
        return view('admin.products.colors', ['colors' => $colors, 'product_id' => $product_id]);
    }

    /**
     * Create data colors
     *
     * @param  \App\Http\Requests\Admin\ProductColorRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductColorRequest $request, $product_id)
    {
        if(ProductColor::create($request->validated())){
            toast('Cor cadastrada com sucesso!', 'success');
            return back();
        }
        toast('Cor não pode ser cadastrada!', 'error');
        return back();
    }

    /**
     * Show the form for editing the color.
     * 
     * @param  \App\Models\ProductColor  $model
     * @return \Illuminate\View\View
     */
    public function edit(ProductColor $model, $product_id, $color_id)
    {
        $colors = $model->where('product_id', $product_id)->get();
        $color = $model->find($color_id);
        return view('admin.products.colors', ['colors' => $colors, 'color' => $color, 'product_id' => $product_id]);
    }

    /**
     * Update the color
     *
     * @param  \App\Http\Requests\Admin\ProductColorRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductColorRequest $request, $product_id)
    {
        $img = ProductColor::find($request->input('id'));
        if(!$img) {
            toast('Cor não encontrada!', 'error');
            return redirect()->route('produtos.cores', $product_id);
        }

        if($img->update($request->validated())){
            toast('Cor atualizada com sucesso!', 'success');
            return redirect()->route('produtos.cores', $product_id);
        }

        toast('Cor não pode ser atualizada!', 'error');
        return redirect()->route('produtos.cores', $product_id);
    }

    /**
     * Toggle the status of the selected image
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggle($product_id, $id)
    {
        $color = ProductColor::find($id);

        if(empty($color)) {
            toast('Cor não encontrada!', 'error');
            return back();
        }

        $color->status = !$color->status;
        $color->save();

        toast('Status da Cor alterado!', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id, $id)
    {
        $color = ProductColor::find($id);
        if(empty($color)) {
            toast('Cor não encontrada!', 'error');
            return redirect()->route('produtos.cores', $product_id);
        }

        if(!$color->delete()) {
            toast('Cor não pode ser deletada!', 'error');
            return redirect()->route('produtos.cores', $product_id);
        }

        toast('Cor deletada com sucesso!', 'success');
        return redirect()->route('produtos.cores', $product_id);
    }
}
