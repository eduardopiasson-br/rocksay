<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliverysRequest;
use App\Models\Deliverys;
use Illuminate\Http\Request;

class DeliverysController extends Controller
{
    /**
     * Display a listing of the Deliverys
     *
     * @param  \App\Models\Deliverys  $model
     * @return \Illuminate\View\View
     */
    public function index(Deliverys $model)
    {
        $deliverys = $model->orderBy('position', 'asc')->get();
        $max_position = $model->max('position') + 1;
        return view('admin.deliverys.index', ['deliverys' => $deliverys, 'max_position' => $max_position]);
    }

    /**
     * Create Delivery
     *
     * @param  \App\Http\Requests\Admin\DeliverysRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DeliverysRequest $request)
    {
        if(Deliverys::create($request->validated())){
            toast('Entrega cadastrada com sucesso!', 'success');
            return back();
        }
        toast('Entrega não pode ser cadastrada!', 'error');
        return back();
    }

    /**
     * Show the form for editing the Delivery
     * 
     * @param  \App\Models\Deliverys  $model
     * @return \Illuminate\View\View
     */
    public function edit(Deliverys $model, $delivery_id)
    {
        $deliverys = $model->orderBy('position', 'asc')->get();
        $delivery = $model->find($delivery_id);
        $max_position = $delivery->position;
        return view('admin.deliverys.index', ['deliverys' => $deliverys, 'max_position' => $max_position, 'delivery' => $delivery]);
    }

    /**
     * Update delivery
     *
     * @param  \App\Http\Requests\Admin\DeliverysRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DeliverysRequest $request)
    {
        $delivery = Deliverys::find($request->input('id'));
        if(!$delivery) {
            toast('Entrega não encontrada!', 'error');
            return redirect()->route('entregas');
        }

        if($delivery->update($request->validated())){
            toast('Entrega atualizada com sucesso!', 'success');
            return redirect()->route('entregas');
        }

        toast('Entrega não pode ser atualizada!', 'error');
        return redirect()->route('entregas');
    }

    /**
     * Toggle the status of the selected delivery
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggle($id)
    {
        $delivery = Deliverys::find($id);

        if(empty($delivery)) {
            toast('Entrega não encontrada!', 'error');
            return back();
        }

        $delivery->status = !$delivery->status;
        $delivery->save();

        toast('Status de Entrega alterado!', 'success');
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
        $deliverys = Deliverys::all();

        foreach ($deliverys as $delivery) {
            foreach ($request->order as $order) {
                if ($order['id'] == $delivery->id) {
                    $delivery->update(['position' => $order['position']]);
                }
            }
        }
        
        return toast('Entregas ordenadas com sucesso!', 'success');
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
        $delivery = Deliverys::find($id);
        if(empty($delivery)) {
            toast('Entrega não encontrada!', 'error');
            return redirect()->route('entregas');
        }

        if(!$delivery->delete()) {
            toast('Entrega não pode ser deletada!', 'error');
            return redirect()->route('entregas');
        }

        toast('Entrega deletada com sucesso!', 'success');
        return redirect()->route('entregas');
    }
}
