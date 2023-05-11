<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitorRequest;
use App\Models\Visitor;

class VisitorController extends Controller
{
    public function index()
    {
        $visitors = Visitor::latest()->paginate(5);
        return view('visitors.index', compact('visitors'));
    }

    public function create()
    {
        $visitors = Visitor::latest()->paginate(5);
        return view('visitors.create')->with(compact('visitors'));
    }

    public function store(StoreVisitorRequest $request)
    {
        $visitor = Visitor::create($request->validated());
        return redirect()
            ->route('visitors.index')
            ->with([
                'status' => "¡El visitante \"$visitor->name\" fue añadido exitosamente!"
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

    public function edit(Visitor $visitor)
    {
        return view('visitors.edit', compact('visitor'));
    }

    public function update(StoreVisitorRequest $request, Visitor $visitor)
    {
        $visitor->update($request->validated());
        return redirect()
            ->route('visitors.index')
            ->with([
                'status' => "¡Los datos del visitante \"$visitor->name\" fueron editados exitosamente!"
            ]);
    }

    public function destroy(Visitor $visitor)
    {
        $visitor->delete();
        return redirect()
            ->route('visitors.index')
            ->with([
                'status' => "¡El visitante \"$visitor->name\" fue eliminado exitosamente!"
            ]);
    }
}
