<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FeedbackRequest;
use App\Models\Feedbacks;
use Illuminate\Http\Request;

class FeedbacksController extends Controller
{
    /**
     * Display a listing of the feedbacks
     *
     * @param  \App\Models\Feedbacks  $model
     * @return \Illuminate\View\View
     */
    public function index(Feedbacks $model)
    {
        $item_id = 1;
        $feed = (object) array('id' => 1);
        $feedback = $model->orderBy('position', 'asc')->get();
        $max_position = $model->max('position') + 1;
        return view('admin.feedback.index', ['feedback' => $feedback, 'max_position' => $max_position, 'feed' => $feed, 'item_id' => $item_id]);
    }

    /**
     * Create feedback
     *
     * @param  \App\Http\Requests\Admin\FeedbackRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FeedbackRequest $request)
    {
        if(Feedbacks::create($request->validated())){
            toast('Feedback cadastrado com sucesso!', 'success');
            return back();
        }
        toast('Feedback não pode ser cadastrado!', 'error');
        return back();
    }

    /**
     * Show the form for editing the feedback
     * 
     * @param  \App\Models\Feedbacks  $model
     * @return \Illuminate\View\View
     */
    public function edit(Feedbacks $model, $feedback_id)
    {
        $feedback = $model->orderBy('position', 'asc')->get();
        $feed = $model->find($feedback_id);
        $item_id = $feed->id;
        $max_position = $feed->position;
        return view('admin.feedback.index', ['feedback' => $feedback, 'max_position' => $max_position, 'feed' => $feed, 'item_id' => $item_id]);
    }

    /**
     * Update the feedback
     *
     * @param  \App\Http\Requests\Admin\FeedbackRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FeedbackRequest $request)
    {
        $feed = Feedbacks::find($request->input('id'));
        if(!$feed) {
            toast('Feedback não encontrado!', 'error');
            return redirect()->route('feedback');
        }

        if($feed->update($request->validated())){
            toast('Feedback atualizado com sucesso!', 'success');
            return redirect()->route('feedback');
        }

        toast('Feedback não pode ser atualizado!', 'error');
        return redirect()->route('feedback');
    }

    /**
     * Toggle the status of the selected feedback
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggle($id)
    {
        $feedback = Feedbacks::find($id);

        if(empty($feedback)) {
            toast('Feedback não encontrado!', 'error');
            return back();
        }

        $feedback->status = !$feedback->status;
        $feedback->save();

        toast('Status de Feedback alterado!', 'success');
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
        $feedback = Feedbacks::all();

        foreach ($feedback as $feed) {
            foreach ($request->order as $order) {
                if ($order['id'] == $feed->id) {
                    $feed->update(['position' => $order['position']]);
                }
            }
        }
        
        return toast('Feedback ordenado com sucesso!', 'success');
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
        $feedback = Feedbacks::find($id);
        if(empty($feedback)) {
            toast('Feedback não encontrado!', 'error');
            return redirect()->route('feedback');
        }

        if(!$feedback->delete()) {
            toast('Feedback não pode ser deletado!', 'error');
            return redirect()->route('feedback');
        }

        $config_image = $feedback->image;
        if(!empty($config_image)) {
            unlink('images/feedback/' . $config_image);
        }
        toast('Feedback deletado com sucesso!', 'success');
        return redirect()->route('feedback');
    }

    /**
     * Crop and save image
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crop(Request $request, $id)
    {
        $destination = 'images/feedback/';
        if(!$file = $request->file('feedbackimage')){
            return response()->json(['status' => 0, 'msg' => 'Imagem não enviada!']); 
        }
        $name_image = 'Feedback' . uniqid() . $file->getClientOriginalExtension();
        $move = $file->move(public_path($destination), $name_image);
        if(!$move) {
            return response()->json(['status' => 0, 'msg' => 'Imagem não pode ser enviada!']); 
        }
        if($move) {
            $config = Feedbacks::find($id);
            $config_image = $config->image;
            if(!empty($config_image)) {
                unlink($destination . $config_image);
            }
            Feedbacks::find($id)->update(['image' => $name_image]);
            return response()->json(['status' => 1, 'msg' => 'Imagem cadastrada com sucesso!!!']);
        }
        return response()->json(['status' => 0, 'msg' => 'Erro!!!']);
    }
}
