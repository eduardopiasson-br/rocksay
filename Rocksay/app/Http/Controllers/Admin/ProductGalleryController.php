<?php

namespace App\Http\Controllers\Admin;

use App\Models\Products;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductGalleries;
use App\Http\Controllers\Controller;
use Throwable;

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

    public function saveUpload(Request $request, $product_id)
    {
        try {
            $max_position = ProductGalleries::max('position') + 1;
            $product = Products::find($product_id);
            $validatedData = $request->validate([
                'images' => 'required',
                'images.*' => 'mimes:jpg,png,jpeg,gif,svg',
                'name' => ['max:150'],
            ]);
     
            if($request->TotalImages > 0)
            {
                    
                for ($x = 0; $x < $request->TotalImages; $x++) 
                {
        
                    if ($request->hasFile('images'.$x)) 
                        {
                            $file      = $request->file('images'.$x);
        
                            $outro = $request->input('name') ? Str::of($request->input('name'))->slug('-') : Str::of($product->title)->slug('-');
                            $name = $outro . '-' . date('YmdHis') . "-" .  $file->getClientOriginalName();
                            $file->move('images/products/gallery/', $name);
    
                            $insert[$x]['image'] = $name;
                            $insert[$x]['name'] = $request->input('name') ? $request->input('name') : NULL;
                            $insert[$x]['product_id'] = $product_id;
                            $insert[$x]['user_id'] = auth()->user()->id;
                            $insert[$x]['position'] = $max_position + ($x + 1);
    
                        }
                }
     
                ProductGalleries::insert($insert);
     
                toast('Imagens cadastradas com sucesso!', 'success');
                return response()->json(['success'=>'Imagens cadastradas com sucesso!']);
            }
        } catch (Throwable $e) {
            toast($e->getMessage(), 'error');
            return response()->json(["message" => $e->getMessage()]);
        }
 
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
            return redirect()->route('produtos.galeria', $product_id);
        }

        if(!$image->delete()) {
            toast('Imagem não pode ser deletada!', 'error');
            return redirect()->route('produtos.galeria', $product_id);
        }

        $config_image = $image->image;
        if(!empty($config_image)) {
            unlink('images/products/gallery/' . $config_image);
        }
        toast('Imagem deletada com sucesso!', 'success');
        return redirect()->route('produtos.galeria', $product_id);
    }
}
