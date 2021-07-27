<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannersRequest;
use App\Models\Banners;
use Illuminate\Http\Request;

class BannersController extends Controller
{
    /**
     * Display a listing of the Banners
     *
     * @param  \App\Models\Banners  $model
     * @return \Illuminate\View\View
     */
    public function index(Banners $model)
    {
        $item_id = 1;
        $banner = (object) array('id' => 1);
        $banners = $model->orderBy('position', 'asc')->get();
        $max_position = $model->max('position') + 1;
        return view('admin.banners.index', ['banners' => $banners, 'max_position' => $max_position, 'banner' => $banner, 'item_id' => $item_id]);
    }

    /**
     * Create banners
     *
     * @param  \App\Http\Requests\Admin\BannersRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BannersRequest $request)
    {
        if(Banners::create($request->validated())){
            toast('Banner cadastrado com sucesso!', 'success');
            return back();
        }
        toast('Banner não pode ser cadastrado!', 'error');
        return back();
    }

    /**
     * Show the form for editing the banner
     * 
     * @param  \App\Models\Banners  $model
     * @return \Illuminate\View\View
     */
    public function edit(Banners $model, $banner_id)
    {
        $banners = $model->orderBy('position', 'asc')->get();
        $banner = $model->find($banner_id);
        $item_id = $banner->id;
        $max_position = $banner->position;
        return view('admin.banners.index', ['banners' => $banners, 'max_position' => $max_position, 'banner' => $banner, 'item_id' => $item_id]);
    }

    /**
     * Update the banners
     *
     * @param  \App\Http\Requests\Admin\BannersRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BannersRequest $request)
    {
        $banner = Banners::find($request->input('id'));
        if(!$banner) {
            toast('Banner não encontrado!', 'error');
            return redirect()->route('banners');
        }

        if($banner->update($request->validated())){
            toast('Banner atualizado com sucesso!', 'success');
            return redirect()->route('banners');
        }

        toast('Banner não pode ser atualizado!', 'error');
        return redirect()->route('banners');
    }

    /**
     * Toggle the status of the selected banner
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggle($id)
    {
        $banner = Banners::find($id);

        if(empty($banner)) {
            toast('Banner não encontrado!', 'error');
            return back();
        }

        $banner->status = !$banner->status;
        $banner->save();

        toast('Status do Banner alterado!', 'success');
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
        $banners = Banners::all();

        foreach ($banners as $banner) {
            foreach ($request->order as $order) {
                if ($order['id'] == $banner->id) {
                    $banner->update(['position' => $order['position']]);
                }
            }
        }
        
        return toast('Banners ordenados com sucesso!', 'success');
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
        $banner = Banners::find($id);
        if(empty($banner)) {
            toast('Banner não encontrado!', 'error');
            return back();
        }

        if(!$banner->delete()) {
            toast('Banner não pode ser deletado!', 'error');
            return back();
        }

        toast('Banner deletado com sucesso!', 'success');
        return back();
    }

    /**
     * Crop and save desktop image
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crop_desktop(Request $request, $id)
    {
        $destination = 'images/banners/desktop/';
        if(!$file = $request->file('bannerdesktopimage')){
            return response()->json(['status' => 0, 'msg' => 'Imagem não enviada!']); 
        }
        $name_image = 'Banner' . uniqid() . $file->getClientOriginalExtension();
        $move = $file->move(public_path($destination), $name_image);
        if(!$move) {
            return response()->json(['status' => 0, 'msg' => 'Imagem não pode ser enviada!']); 
        }
        if($move) {
            $config = Banners::find($id);
            $config_image = $config->image;
            if($config_image != '') {
                unlink($destination . $config_image);
            }
            Banners::find($id)->update(['image_desktop' => $name_image]);
            return response()->json(['status' => 1, 'msg' => 'Imagem cadastrada com sucesso!!!']);
        }
        return response()->json(['status' => 0, 'msg' => 'Erro!!!']);
    }

    /**
     * Crop and save mobile image
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crop_mobile(Request $request, $id)
    {
        $destination = 'images/banners/mobile/';
        if(!$file = $request->file('bannermobileimage')){
            return response()->json(['status' => 0, 'msg' => 'Imagem não enviada!']); 
        }
        $name_image = 'Banner' . uniqid() . $file->getClientOriginalExtension();
        $move = $file->move(public_path($destination), $name_image);
        if(!$move) {
            return response()->json(['status' => 0, 'msg' => 'Imagem não pode ser enviada!']); 
        }
        if($move) {
            $config = Banners::find($id);
            $config_image = $config->image;
            if($config_image != '') {
                unlink($destination . $config_image);
            }
            Banners::find($id)->update(['image_mobile' => $name_image]);
            return response()->json(['status' => 1, 'msg' => 'Imagem cadastrada com sucesso!!!']);
        }
        return response()->json(['status' => 0, 'msg' => 'Erro!!!']);
    }
}
