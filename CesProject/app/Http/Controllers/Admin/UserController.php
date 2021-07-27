<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UsersRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('admin.users.index', ['users' => $model->paginate(5)]);
    }

    /**
     * Create the profile
     *
     * @param  \App\Http\Requests\Admin\UsersRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UsersRequest $request)
    {
        if(User::create($request->validated())){
            toast('Usuário cadastrado com sucesso!', 'success');
            return back();
        }
        toast('Usuário não pode ser cadastrado!', 'error');
        return back();
    }

    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit(User $model, $user_id)
    {
        $user = $model->find($user_id);

        return view('admin.users.index', ['users' => $model->paginate(5), 'user' => $user]);
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\Admin\UsersRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UsersRequest $request)
    {
        $user = User::find($request->input('id'));
        if(!$user) {
            toast('Usuário não encontrado!', 'error');
            return back();
        }

        if($user->update($request->validated())){
            toast('Usuário atualizado com sucesso!', 'success');
            return back();
        }

        toast('Usuário não pode ser atualizado!', 'error');
        return back();
    }

    /**
     * Toggle the status of the selected user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggle($id)
    {
        $user = User::find($id);

        if(empty($user)) {
            toast('Usuário não encontrado!', 'error');
            return back();
        }

        $user->status = !$user->status;
        $user->save();

        toast('Status do usuário alterado!', 'success');
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
        $user = User::find($id);
        if(empty($user)) {
            toast('Usuário não encontrado!', 'error');
            return back();
        }

        // Apagar dependências do cliente assim que estas forem desenvolvidas.

        if(!$user->delete()) {
            toast('Usuário não pode ser deletado!', 'error');
            return back();
        }

        toast('Usuário deletado com sucesso!', 'success');
        return back();
    }
}
