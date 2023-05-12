<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSecretaryRequest;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\Request;

class SecretaryController extends Controller
{
    public function index()
    {
        $secretaries = User::latest()->paginate(5);
        return view('secretaries.index', compact('secretaries'));
    }

    public function create()
    {
        return view('secretaries.create');
    }

    public function store(StoreSecretaryRequest $request)
    {
        $secretary = User::create($request->validated());
        return redirect()
        ->route('secretaries.index')
        ->with([
            'status' => "¡La secretaria \"$secretary->name\" fue añadida exitosamente!"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit(User $secretary)
    {
        return view('secretaries.edit', compact('secretary'));
    }

    public function update(StoreSecretaryRequest $request, User $secretary)
    {
        $secretary->update($request->validated());
        return redirect()
        ->route('secretaries.index')
        ->with([
            'status' => "¡Los datos de la secretaria \"$secretary->name\" fueron editados exitosamente!"
        ]);
    }

    public function destroy(User $secretary)
    {
        $secretary->delete();
        return redirect()->route('secretaries.index')
        ->with([
            'status' => "¡Los datos de la secretaria \"$secretary->name\" fueron eliminados exitosamente!"
        ]);
    }
}
