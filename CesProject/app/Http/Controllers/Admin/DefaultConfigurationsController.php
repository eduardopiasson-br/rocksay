<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ConfigurationRequest;
use App\Models\DefaultConfiguration;
use Illuminate\Http\Request;

class DefaultConfigurationsController extends Controller
{
    /**
     * Display a listing of the configuration
     *
     * @param  \App\Models\DefaultConfiguration  $model
     * @return \Illuminate\View\View
     */
    public function index(DefaultConfiguration $model)
    {
        return view('admin.config.index', ['config' => $model->find(1)]);
    }

    /**
     * Create the profile
     *
     * @param  \App\Http\Requests\Admin\ConfigurationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ConfigurationRequest $request)
    {
        if(DefaultConfiguration::create($request->validated())){
            toast('Configuraçao cadastrada com sucesso!', 'success');
            return back();
        }
        toast('Configuração não pode ser cadastrada!', 'error');
        return back();
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\Admin\ConfigurationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ConfigurationRequest $request)
    {
        $default = DefaultConfiguration::find($request->input('id'));
        if(!$default) {
            toast('Configuração não encontrada!', 'error');
            return back();
        }

        if($default->update($request->validated())){
            toast('Atualização realizada com sucesso!', 'success');
            return back();
        }

        toast('Configuração não pode ser atualizada!', 'error');
        return back();
    }

    /**
     * Crop and save image
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crop(Request $request)
    {
        $destination = 'images/default/';
        $file = $request->file('configimage');
        $name_image = 'CutieAndSweet' . uniqid() . $file->getClientOriginalExtension();
        $move = $file->move(public_path($destination), $name_image);
        if(!$move) {
            return response()->json(['status' => 0, 'msg' => 'Imagem não pode ser enviada!']); 
        }
        if($move) {
            $config = DefaultConfiguration::find(1);
            $config_image = $config->image;
            if(!empty($config_image)) {
                unlink($destination . $config_image);
            }
            DefaultConfiguration::find(1)->update(['image' => $name_image]);
            return response()->json(['status' => 1, 'msg' => 'Imagem cadastrada com sucesso!!!']);
        }
    }
}
