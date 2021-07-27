<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductsRequest;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
            /**
     * Display a listing of the Items
     *
     * @param  \App\Models\Products  $model
     * @return \Illuminate\View\View
     */
    public function index(Products $model)
    {
        $item_id = 1;
        $itens = $model->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.products.index', ['itens' => $itens, 'item_id' => $item_id]);
    }

    /**
     * Create item
     *
     * @param  \App\Http\Requests\Admin\ProductsRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductsRequest $request)
    {
        if(Products::create($request->validated())){
            toast('Produto cadastrado com sucesso!', 'success');
            return back();
        }
        toast('Produto não pode ser cadastrado!', 'error');
        return back();
    }

    /**
     * Show the form for editing the item
     * 
     * @param  \App\Models\Products  $model
     * @return \Illuminate\View\View
     */
    public function edit(Products $model, $item_id)
    {
        $itens =$model->orderBy('created_at', 'desc')->paginate(10);
        $item = $model->find($item_id);
        $item_id = $item->id;
        return view('admin.products.index', ['itens' => $itens, 'item' => $item, 'item_id' => $item_id]);
    }

    /**
     * Update the items
     *
     * @param  \App\Http\Requests\Admin\ProductsRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductsRequest $request)
    {
        $item = Products::find($request->input('id'));
        if(!$item) {
            toast('Produto não encontrado!', 'error');
            return redirect()->route('produtos');
        }

        if($item->update($request->validated())){
            toast('Produto atualizado com sucesso!', 'success');
            return redirect()->route('produtos');
        }

        toast('Produto não pode ser atualizado!', 'error');
        return redirect()->route('produtos');
    }

    /**
     * Toggle the status of the selected item
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggle($id)
    {
        $item = Products::find($id);

        if(empty($item)) {
            toast('Produto não encontrado!', 'error');
            return back();
        }

        $item->status = !$item->status;
        $item->save();

        toast('Status do Produto alterado!', 'success');
        return back();
    }

    /**
     * Highlight the status of the selected item
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function highlight($id)
    {
        $item = Products::find($id);

        if(empty($item)) {
            toast('Produto não encontrado!', 'error');
            return back();
        }

        $item->highlight = !$item->highlight;
        $item->save();

        toast('Status de Destaque alterado!', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Products::find($id);
        if(empty($item)) {
            toast('Produto não encontrado!', 'error');
            return back();
        }

        if(!$item->delete()) {
            toast('Produto não pode ser deletado!', 'error');
            return back();
        }

        toast('Produto deletado com sucesso!', 'success');
        return back();
    }

    /**
     * Crop and save image
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crop(Request $request, $id)
    {
        $destination = 'images/products/product/';
        if(!$file = $request->file('productimage')){
            return response()->json(['status' => 0, 'msg' => 'Imagem não enviada!']); 
        }
        $name_image = 'Produto' . uniqid() . $file->getClientOriginalExtension();
        $move = $file->move(public_path($destination), $name_image);
        if(!$move) {
            return response()->json(['status' => 0, 'msg' => 'Imagem não pode ser enviada!']); 
        }
        if($move) {
            $config = Products::find($id);
            $config_image = $config->image;
            if($config_image != '') {
                unlink($destination . $config_image);
            }
            Products::find($id)->update(['image' => $name_image]);
            return response()->json(['status' => 1, 'msg' => 'Imagem cadastrada com sucesso!!!']);
        }
        return response()->json(['status' => 0, 'msg' => 'Erro!!!']);
    }
}
