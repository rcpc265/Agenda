<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitRequest;
use App\Models\Visit;

class VisitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $visits = Visit::latest()->paginate(5);
        return view('visits.index', compact('visits'));
    }

    public function create()
    {
        $statuses = Visit::$statusTranslations;
        return view('visits.create')->with(compact('statuses'));
    }

    public function store(StoreVisitRequest $request)
    {
        $visit = Visit::create($request->validated());
        return redirect()->route('visits.index')->with(['status' => "¡La visita \"$visit->name\" fue creada exitosamente!"]);
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

    public function edit(Visit $visit)
    {
        $statuses = Visit::$statusTranslations;
        return view('visits.edit', compact('visit', 'statuses'));
    }

    public function update(StoreVisitRequest $request, Visit $visit)
    {
        $visit->update($request->validated());
        return redirect()->route('visits.index')->with(['status' => "¡La visita \"$visit->name\" fue editada exitosamente!"]);
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();
        return redirect()->route('visits.index')->with(['status' => "¡La visita \"$visit->name\" fue eliminada exitosamente!"]);
    }
}
