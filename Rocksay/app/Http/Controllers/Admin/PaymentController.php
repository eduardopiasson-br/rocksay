<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentRequest;
use App\Models\Payments;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the Payments
     *
     * @param  \App\Models\Deliverys  $model
     * @return \Illuminate\View\View
     */
    public function index(Payments $model)
    {
        $payments = $model->orderBy('position', 'asc')->get();
        $max_position = $model->max('position') + 1;
        return view('admin.payments.index', ['payments' => $payments, 'max_position' => $max_position]);
    }

    /**
     * Create Payment
     *
     * @param  \App\Http\Requests\Admin\PaymentRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PaymentRequest $request)
    {
        if(Payments::create($request->validated())){
            toast('Pagamento cadastrado com sucesso!', 'success');
            return back();
        }
        toast('Pagamento não pode ser cadastrado!', 'error');
        return back();
    }

    /**
     * Show the form for editing the Payments
     * 
     * @param  \App\Models\Payments  $model
     * @return \Illuminate\View\View
     */
    public function edit(Payments $model, $payment_id)
    {
        $payments = $model->orderBy('position', 'asc')->get();
        $payment = $model->find($payment_id);
        $max_position = $payment->position;
        return view('admin.payments.index', ['payments' => $payments, 'max_position' => $max_position, 'payment' => $payment]);
    }

    /**
     * Update delivery
     *
     * @param  \App\Http\Requests\Admin\PaymentRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PaymentRequest $request)
    {
        $payment = Payments::find($request->input('id'));
        if(!$payment) {
            toast('Pagamento não encontrado!', 'error');
            return redirect()->route('pagamentos');
        }

        if($payment->update($request->validated())){
            toast('Pagamento atualizado com sucesso!', 'success');
            return redirect()->route('pagamentos');
        }

        toast('Pagamento não pode ser atualizado!', 'error');
        return redirect()->route('pagamentos');
    }

    /**
     * Toggle the status of the selected payment
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggle($id)
    {
        $payment = Payments::find($id);

        if(empty($payment)) {
            toast('Pagamento não encontrado!', 'error');
            return back();
        }

        $payment->status = !$payment->status;
        $payment->save();

        toast('Status de pagamento alterado!', 'success');
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
        $payments = Payments::all();

        foreach ($payments as $payment) {
            foreach ($request->order as $order) {
                if ($order['id'] == $payment->id) {
                    $payment->update(['position' => $order['position']]);
                }
            }
        }
        
        return toast('Pagamentos ordenados com sucesso!', 'success');
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
        $payment = Payments::find($id);
        if(empty($payment)) {
            toast('Pagamento não encontrado!', 'error');
            return redirect()->route('pagamentos');
        }

        if(!$payment->delete()) {
            toast('Pagamento não pode ser deletado!', 'error');
            return redirect()->route('pagamentos');
        }

        toast('Pagamento deletado com sucesso!', 'success');
        return redirect()->route('pagamentos');
    }
}
