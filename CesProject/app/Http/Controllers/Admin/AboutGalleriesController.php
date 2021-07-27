<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AboutGalleriesRequest;
use App\Models\AboutGallery;
use Illuminate\Http\Request;

class AboutGalleriesController extends Controller
{
    /**
     * Display a listing of the about gallery
     *
     * @param  \App\Models\AboutGallery  $model
     * @return \Illuminate\View\View
     */
    public function index(AboutGallery $model)
    {
        $gallery = $model->orderBy('position', 'asc')->get();
        $max_position = $model->max('position') + 1;
        return view('admin.about.gallery', ['gallery' => $gallery, 'max_position' => $max_position]);
    }

    /**
     * Create data gallery
     *
     * @param  \App\Http\Requests\Admin\AboutGalleriesRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AboutGalleriesRequest $request)
    {
        $input = $request->validated();
  
        if ($image = $request->file('image')) {
            $destinationPath = 'images/about/';
            $profileImage = $request->input('name') . '-' . date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }

        if(AboutGallery::create($input)){
            toast('Imagem cadastrada com sucesso!', 'success');
            return back();
        }
        toast('Imagem não pode ser cadastrado!', 'error');
        return back();
    }

    /**
     * Show the form for editing the image gallery.
     * 
     * @param  \App\Models\AboutGallery  $model
     * @return \Illuminate\View\View
     */
    public function edit(AboutGallery $model, $image_id)
    {
        $gallery = $model->orderBy('position', 'asc')->get();
        $image = $model->find($image_id);
        $max_position = $image->position;
        return view('admin.about.gallery', ['gallery' => $gallery, 'max_position' => $max_position, 'image' => $image]);
    }

    /**
     * Update the image
     *
     * @param  \App\Http\Requests\Admin\AboutGalleriesRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AboutGalleriesRequest $request)
    {
        $img = AboutGallery::find($request->input('id'));
        if(!$img) {
            toast('Imagem não encontrada!', 'error');
            return redirect()->route('sobre.galeria');
        }

        $input = $request->validated();
  
        if ($image = $request->file('image')) {
            $destinationPath = 'images/about/';
            $profileImage = $request->input('name') . '-' .date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }else{
            unset($input['image']);
        }

        if($img->update($input)){
            toast('Imagem atualizada com sucesso!', 'success');
            return redirect()->route('sobre.galeria');
        }

        toast('Imagem não pode ser atualizada!', 'error');
        return redirect()->route('sobre.galeria');
    }

    /**
     * Toggle the status of the selected image
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggle($id)
    {
        $image = AboutGallery::find($id);

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
    public function reorder(Request $request)
    {        
        $gallery = AboutGallery::all();

        foreach ($gallery as $image) {
            foreach ($request->order as $order) {
                if ($order['id'] == $image->id) {
                    $image->update(['position' => $order['position']]);
                }
            }
        }
        
        return toast('Galeria do Sobre ordenada com sucesso!', 'success');
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
        $image = AboutGallery::find($id);
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
