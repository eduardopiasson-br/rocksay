<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notes;
use Illuminate\Http\Request;
use Mockery\Matcher\Not;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $notes = Notes::find(1);
        return view('admin.dashboard', compact('notes'));
    }

    
    /**
     * Create the notes
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store_notes(Request $request)
    {
        $notes = Notes::find(1);
        if($notes == NULL){
            Notes::create($request->all());
            toast('Anotações salvas com sucesso!123', 'success');
            return back();
        }
        if($notes != NULL){
            $notes->update($request->all());
            toast('Anotações salvas com sucesso!', 'success');
            return back();
        }
        toast('Anotações não puderam ser salvas!', 'error');
        return back();
    }
}
