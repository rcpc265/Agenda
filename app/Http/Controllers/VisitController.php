<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitRequest;
use App\Models\Visit;
use App\Models\Visitor;
use Carbon\Carbon;
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
        $search = $request->input('visitor');

        $visits = Visit::query()
            ->when($search, function ($query, $search) {
                return $query->whereHas('visitor', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('visits.index', compact('visits'));
    }

    public function show()
    {
        // return view('visits.show');
    }

    public function create()
    {
        $legalVisitors = Visitor::where('entity', 'Persona Jurídica')->orderBy('name')->get();
        $naturalVisitors = Visitor::where('entity', 'Persona Natural')->orderBy('name')->get();
        $entities = Visitor::$entities;
        return view('visits.create')->with(compact('legalVisitors', 'naturalVisitors', 'entities'));
    }

    public function store(StoreVisitRequest $request)
    {
        $date = $request->get('date');
        $start_hour = $request->get('start_hour');
        $start_date = Carbon::createFromFormat('d/m/Y H:i', $date . ' ' . $start_hour);
        $end_date = $start_date->copy()->addHour();

        // Save the data
        $visit = Visit::create([
            'subject' => $request->get('subject'),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'visitor_id' => $request->get('visitor_id'),
            'user_id' => $request->get('user_id'),
        ]);

        return redirect()->route('visits.index')->with(['status' => "¡La visita fue creada exitosamente!"]);
    }

    public function edit(Visit $visit)
    {
        $visitors = Visitor::orderBy('name')->get();
        $entities = Visitor::$entities;
        $statuses = Visit::$statuses;
        return view('visits.edit', compact('visit', 'statuses', 'visitors', 'entities'));
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
        return redirect()->route('visits.index')->with(['status' => "¡La visita fue eliminada exitosamente!"]);
    }

    public function getVisits(Request $request)
    {
        $date = Carbon::createFromFormat('d/m/Y', $request->get('date'));
        $startDate = $date->copy()->startOfDay();
        $endDate = $date->copy()->endOfDay();

        $visits = Visit::query()
            ->whereBetween('start_date', [$startDate, $endDate])
            ->orderBy('start_date')
            // ->get();
            ->get(['start_date', 'subject']);

        return response()->json(['visits' => $visits], 200);
    }
}
