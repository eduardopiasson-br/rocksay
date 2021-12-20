<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductCategories;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCategoriesRequest;

class ProductCategoriesController extends Controller
{
    /**
     * Display a listing of the about categories
     *
     * @param  \App\Models\ProductCategories  $model
     * @return \Illuminate\View\View
     */
    public function index(ProductCategories $model)
    {
        $categories = $model->orderBy('position', 'asc')->get();
        $max_position = $model->max('position') + 1;
        $item_id = 1;
        return view('admin.categories.index', ['categories' => $categories, 'max_position' => $max_position, 'item_id' => $item_id]);
    }

    /**
     * Create data categories
     *
     * @param  \App\Http\Requests\Admin\ProductCategoriesRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductCategoriesRequest $request)
    {
        if(ProductCategories::create($request->validated())){
            toast('Categoria cadastrada com sucesso!', 'success');
            return back();
        }
        toast('Categoria não pode ser cadastrada!', 'error');
        return back();
    }

    /**
     * Show the form for editing the image categories.
     * 
     * @param  \App\Models\ProductCategories  $model
     * @return \Illuminate\View\View
     */
    public function edit(ProductCategories $model, $category_id)
    {
        $categories = $model->orderBy('position', 'asc')->get();
        $category = $model->find($category_id);
        $max_position = $category->position;
        $item_id = $category->id;
        return view('admin.categories.index', ['categories' => $categories, 'max_position' => $max_position, 'category' => $category, 'item_id' => $item_id]);
    }

    /**
     * Update the category
     *
     * @param  \App\Http\Requests\Admin\ProductCategoriesRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductCategoriesRequest $request)
    {
        $category = ProductCategories::find($request->input('id'));
        if(!$category) {
            toast('Categoria não encontrada!', 'error');
            return redirect()->route('categorias');
        }

        if($category->update($request->validated())){
            toast('Categoria atualizada com sucesso!', 'success');
            return redirect()->route('categorias');
        }

        toast('Categoria não pode ser atualizada!', 'error');
        return redirect()->route('categorias');
    }

    /**
     * Toggle the status of the selected category
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggle($id)
    {
        $category = ProductCategories::find($id);

        if(empty($category)) {
            toast('Categoria não encontrada!', 'error');
            return back();
        }

        $category->status = !$category->status;
        $category->save();

        toast('Status da Categoria alterado!', 'success');
        return back();
    }

    /**
     * Change item placement
     *     
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reorder(Request $request)
    {        
        $categories = ProductCategories::all();
        foreach ($categories as $category) {
            foreach ($request->order as $order) {
                if ($order['id'] == $category->id) {
                    $category->update(['position' => $order['position']]);
                }
            }
        }
        
        return toast('Categorias ordenadas com sucesso!', 'success');
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
        $category = ProductCategories::find($id);
        if(empty($category)) {
            toast('Categoria não encontrada!', 'error');
            return redirect()->route('categorias');
        }

        if(!$category->delete()) {
            toast('Categoria não pode ser deletada!', 'error');
            return redirect()->route('categorias');
        }

        $config_image = $category->image;
        if(!empty($config_image)) {
            unlink('images/categories/' . $config_image);
        }
        toast('Categoria deletada com sucesso!', 'success');
        return redirect()->route('categorias');
    }
    
    /**
     * Crop and save image
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crop(Request $request, $id)
    {
        $config = ProductCategories::find($id);
        $destination = 'images/categories/';
        if(!$file = $request->file('categoryimage')){
            return response()->json(['status' => 0, 'msg' => 'Imagem não enviada!']); 
        }
        $name_image = Str::of($config->name)->slug('-') . '-' . date('YmdHis') . "-" .  $file->getClientOriginalName();;
        $move = $file->move(public_path($destination), $name_image);
        if(!$move) {
            return response()->json(['status' => 0, 'msg' => 'Imagem não pode ser enviada!']); 
        }
        if($move) {
            $config_image = $config->image;
            if(!empty($config_image)) {
                unlink($destination . $config_image);
            }
            ProductCategories::find($id)->update(['image' => $name_image]);
            return response()->json(['status' => 1, 'msg' => 'Imagem cadastrada com sucesso!!!']);
        }
        return response()->json(['status' => 0, 'msg' => 'Erro!!!']);
    }
}
