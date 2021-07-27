<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogGalleryRequest;
use App\Models\BlogGalleries;
use Illuminate\Http\Request;

class BlogGalleryController extends Controller
{
    /**
     * Display a listing of the about gallery
     *
     * @param  \App\Models\BlogGalleries  $model
     * @return \Illuminate\View\View
     */
    public function index(BlogGalleries $model, $blog_id)
    {
        $gallery = $model->orderBy('position', 'asc')->where('blog_id', $blog_id)->get();
        $max_position = $model->max('position') + 1;
        return view('admin.blogs.gallery', ['gallery' => $gallery, 'max_position' => $max_position, 'blog_id' => $blog_id]);
    }

    /**
     * Create data gallery
     *
     * @param  \App\Http\Requests\Admin\BlogGalleryRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BlogGalleryRequest $request, $blog_id)
    {
        $input = $request->validated();
  
        if ($image = $request->file('image')) {
            $destinationPath = 'images/blogs/gallery/';
            $profileImage = $blog_id . '-' . date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }

        if(BlogGalleries::create($input)){
            toast('Imagem cadastrada com sucesso!', 'success');
            return back();
        }
        toast('Imagem não pode ser cadastrada!', 'error');
        return back();
    }

    /**
     * Show the form for editing the image gallery.
     * 
     * @param  \App\Models\BlogGalleries  $model
     * @return \Illuminate\View\View
     */
    public function edit(BlogGalleries $model, $blog_id, $image_id)
    {
        $gallery = $model->orderBy('position', 'asc')->where('blog_id', $blog_id)->get();
        $image = $model->find($image_id);
        $max_position = $image->position;
        return view('admin.blogs.gallery', ['gallery' => $gallery, 'max_position' => $max_position, 'image' => $image, 'blog_id' => $blog_id]);
    }

    /**
     * Update the image
     *
     * @param  \App\Http\Requests\Admin\BlogGalleryRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogGalleryRequest $request, $blog_id)
    {
        $img = BlogGalleries::find($request->input('id'));
        if(!$img) {
            toast('Imagem não encontrada!', 'error');
            return redirect()->route('blog.galeria', $blog_id);
        }

        $input = $request->validated();
  
        if ($image = $request->file('image')) {
            $destinationPath = 'images/blogs/gallery/';
            $profileImage = $blog_id . '-' . date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }else{
            unset($input['image']);
        }

        if($img->update($input)){
            toast('Imagem atualizada com sucesso!', 'success');
            return redirect()->route('blog.galeria', $blog_id);
        }

        toast('Imagem não pode ser atualizada!', 'error');
        return redirect()->route('blog.galeria', $blog_id);
    }

    /**
     * Toggle the status of the selected image
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggle($blog_id, $id)
    {
        $image = BlogGalleries::find($id);

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
    public function reorder(Request $request, $blog_id)
    {        
        $gallery = BlogGalleries::where('blog_id', $blog_id)->get();
        foreach ($gallery as $image) {
            foreach ($request->order as $order) {
                if ($order['id'] == $image->id) {
                    $image->update(['position' => $order['position']]);
                }
            }
        }
        
        return toast('Imagens do Blog ordenadas com sucesso!', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($blog_id, $id)
    {
        $image = BlogGalleries::find($id);
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
