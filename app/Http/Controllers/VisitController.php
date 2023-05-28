<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitRequest;
use App\Models\Visit;
use App\Models\Visitor;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $search = $request->input('subject');

        $visits = Visit::query()
            ->when($search, function ($query, $search) {
                return $query->where('subject', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('visits.index', compact('visits'));
    }

    public function create()
    {
        $visitors = Visitor::orderBy('name')->get();
        $entities = Visitor::$entities;
        return view('visits.create')->with(compact('visitors', 'entities'));
    }

    public function store(StoreVisitRequest $request)
    {
        $visit = Visit::create($request->validated());
        return redirect()->route('visits.index')->with(['status' => "¡La visita fue creada exitosamente!"]);
    }

    public function show($id)
    {
        //
    }

    public function edit(Visit $visit)
    {
        $statuses = Visit::$statuses;
        return view('visits.edit', compact('visit', 'statuses'));
    }

    public function update(StoreVisitRequest $request, Visit $visit)
    {
        $visit->update($request->validated());
        return redirect()->route('visits.index')->with(['status' => "¡La visita \"$visit->name\" fue editada exitosamente!"]);
    }

    public function updateStatus(Request $request): JsonResponse
    {
        try {
            $visit = Visit::findOrFail($request->input('id'));
            $visit->status = $request->input('status');
            $visit->save();

            return response()->json(['message' => 'The visit with an id of ' . $visit->id . ' was updated to ' . $visit->status], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Visit not found'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error updating status'], 500);
        }
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();
        return redirect()->route('visits.index')->with(['status' => "¡La visita \"$visit->name\" fue eliminada exitosamente!"]);
    }
}
