<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogRequest;
use App\Models\BlogGalleries;
use App\Models\Blogs;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    /**
     * Display a listing of the Items
     *
     * @param  \App\Models\Blogs  $model
     * @return \Illuminate\View\View
     */
    public function index(Blogs $model)
    {
        $item_id = 1;
        $itens = $model->orderBy('start_post', 'asc')->get();
        return view('admin.blogs.index', ['itens' => $itens, 'item_id' => $item_id]);
    }

    /**
     * Create item
     *
     * @param  \App\Http\Requests\Admin\BlogRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BlogRequest $request)
    {
        if(Blogs::create($request->validated())){
            toast('Post cadastrado com sucesso!', 'success');
            return back();
        }
        toast('Post não pode ser cadastrado!', 'error');
        return back();
    }

    /**
     * Show the form for editing the item
     * 
     * @param  \App\Models\Blogs  $model
     * @return \Illuminate\View\View
     */
    public function edit(Blogs $model, $item_id)
    {
        $itens =$model->orderBy('start_post', 'asc')->get();
        $item = $model->find($item_id);
        $item_id = $item->id;
        return view('admin.blogs.index', ['itens' => $itens, 'item' => $item, 'item_id' => $item_id]);
    }

    /**
     * Update the items
     *
     * @param  \App\Http\Requests\Admin\BlogRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogRequest $request)
    {
        $item = Blogs::find($request->input('id'));
        if(!$item) {
            toast('Post não encontrado!', 'error');
            return redirect()->route('blog');
        }

        if($item->update($request->validated())){
            toast('Post atualizado com sucesso!', 'success');
            return redirect()->route('blog');
        }

        toast('Post não pode ser atualizado!', 'error');
        return redirect()->route('blog');
    }

    /**
     * Toggle the status of the selected item
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggle($id)
    {
        $item = Blogs::find($id);

        if(empty($item)) {
            toast('Post não encontrado!', 'error');
            return back();
        }

        $item->status = !$item->status;
        $item->save();

        toast('Status do Post alterado!', 'success');
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
        $item = Blogs::find($id);

        if(empty($item)) {
            toast('Post não encontrado!', 'error');
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
        $item = Blogs::find($id);
        if(empty($item)) {
            toast('Post não encontrado!', 'error');
            return redirect()->route('blog');
        }

        $related = BlogGalleries::where('blog_id', $item->id)->get();
        if(!empty($related)) {
            foreach($related as $img) {
                $img_image = $img->image;
                if(!empty($img_image)) {
                    unlink('images/blogs/gallery/' . $img_image);
                }
                $img->delete();
            }
        }

        if(!$item->delete()) {
            toast('Post não pode ser deletado!', 'error');
            return redirect()->route('blog');
        }

        $config_image = $item->image;
        if(!empty($config_image)) {
            unlink('images/blogs/posts/' . $config_image);
        }

        toast('Post deletado com sucesso!', 'success');
        return redirect()->route('blog');
    }

    /**
     * Crop and save image
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crop(Request $request, $id)
    {
        $destination = 'images/blogs/posts/';
        if(!$file = $request->file('blogimage')){
            return response()->json(['status' => 0, 'msg' => 'Imagem não enviada!']); 
        }
        $name_image = 'Post' . uniqid() . $file->getClientOriginalExtension();
        if(!$move = $this->compressImage($file, $destination . $name_image, 80)) {
            return response()->json(['status' => 0, 'msg' => 'Imagem não pode ser enviada!']); 
        }
        if($move) {
            $config = Blogs::find($id);
            $config_image = $config->image;
            if(!empty($config_image)) {
                unlink($destination . $config_image);
            }
            Blogs::find($id)->update(['image' => $name_image]);
            return response()->json(['status' => 1, 'msg' => 'Imagem cadastrada com sucesso!!!']);
        }
        return response()->json(['status' => 0, 'msg' => 'Erro!!!']);
    }

    function compressImage($source_path, $destination_path, $quality) {
        $info = getimagesize($source_path);
    
        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($source_path);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source_path);
        }
    
        imagejpeg($image, $destination_path, $quality);
    
        return $destination_path;
    }
}
