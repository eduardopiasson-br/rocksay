<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductGalleryRequest;
use App\Models\ProductGalleries;
use Illuminate\Http\Request;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the about gallery
     *
     * @param  \App\Models\ProductGalleries  $model
     * @return \Illuminate\View\View
     */
    public function index(ProductGalleries $model, $product_id)
    {
        $gallery = $model->orderBy('position', 'asc')->where('product_id', $product_id)->get();
        $max_position = $model->max('position') + 1;
        return view('admin.products.gallery', ['gallery' => $gallery, 'max_position' => $max_position, 'product_id' => $product_id]);
    }

    /**
     * Create data gallery
     *
     * @param  \App\Http\Requests\Admin\ProductGalleryRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductGalleryRequest $request, $product_id)
    {
        $input = $request->validated();
  
        if ($image = $request->file('image')) {
            $destinationPath = 'images/products/gallery/';
            $profileImage = $product_id . '-' . date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }

        if(ProductGalleries::create($input)){
            toast('Imagem cadastrada com sucesso!', 'success');
            return back();
        }
        toast('Imagem não pode ser cadastrada!', 'error');
        return back();
    }

    /**
     * Show the form for editing the image gallery.
     * 
     * @param  \App\Models\ProductGalleries  $model
     * @return \Illuminate\View\View
     */
    public function edit(ProductGalleries $model, $product_id, $image_id)
    {
        $gallery = $model->orderBy('position', 'asc')->where('product_id', $product_id)->get();
        $image = $model->find($image_id);
        $max_position = $image->position;
        return view('admin.products.gallery', ['gallery' => $gallery, 'max_position' => $max_position, 'image' => $image, 'product_id' => $product_id]);
    }

    /**
     * Update the image
     *
     * @param  \App\Http\Requests\Admin\ProductGalleryRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductGalleryRequest $request, $product_id)
    {
        $img = ProductGalleries::find($request->input('id'));
        if(!$img) {
            toast('Imagem não encontrada!', 'error');
            return redirect()->route('produtos.galeria', $product_id);
        }

        $input = $request->validated();
  
        if ($image = $request->file('image')) {
            $destinationPath = 'images/products/gallery/';
            $profileImage = $product_id . '-' . date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }else{
            unset($input['image']);
        }

        if($img->update($input)){
            toast('Imagem atualizada com sucesso!', 'success');
            return redirect()->route('produtos.galeria', $product_id);
        }

        toast('Imagem não pode ser atualizada!', 'error');
        return redirect()->route('produtos.galeria', $product_id);
    }

    /**
     * Toggle the status of the selected image
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggle($product_id, $id)
    {
        $image = ProductGalleries::find($id);

        if(empty($image)) {
            toast('Imagem não encontrada!', 'error');
            return back();
        }

        $image->status = !$image->status;
        $image->save();

        toast('Status da Imagem alterado!', 'success');
        return back();
    }

    /**
     * Change item placement
     *     
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reorder(Request $request, $product_id)
    {        
        $gallery = ProductGalleries::where('product_id', $product_id)->get();
        foreach ($gallery as $image) {
            foreach ($request->order as $order) {
                if ($order['id'] == $image->id) {
                    $image->update(['position' => $order['position']]);
                }
            }
        }
        
        return toast('Imagens do Produto ordenadas com sucesso!', 'success');
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
        $image = ProductGalleries::find($id);
        if(empty($image)) {
            toast('Imagem não encontrada!', 'error');
            return back();
        }

        if(!$image->delete()) {
            toast('Imagem não pode ser deletada!', 'error');
            return back();
        }

        toast('Imagem deletada com sucesso!', 'success');
        return back();
    }
}
