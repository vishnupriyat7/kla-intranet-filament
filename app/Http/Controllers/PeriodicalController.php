<?php

namespace App\Http\Controllers;

use App\Models\Periodical;

use App\Models\PeriodicalMaster;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PeriodicalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $periodicals = Periodical::with('periodicalMaster')->orderBy('created_at', 'desc');
            $periodicals = Periodical::leftJoin('periodical_masters', 'periodicals.periodical_master_id', '=', 'periodical_masters.id')
                ->select('periodicals.*', 'periodical_masters.name as periodical_name');

            return DataTables::of($periodicals)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->periodicalMaster->name ?? 'N/A';
                })
                ->addColumn('path', function ($row) {
                    return $row->path;
                })

                ->addColumn('date', function ($row) {
                    return date('d-m-Y', strtotime($row->date));
                })
                ->addColumn('keywords', function ($row) {
                    return $row->keywords;
                })
                ->addColumn('status', function ($row) {
                    return $row->status == '0' ? '<span class="badge bg-danger">Unpublished</span>' : '<span class="badge bg-success">Published</span>';
                })
                ->addColumn('file', function ($row) {
                    if ($row->path) {
                        return '<a href="#" class="btn btn-outline-info btn-sm text-black" data-bs-toggle="modal" data-bs-target="#pdfModal' . $row->id . '">
                                    <i class="ri-eye-fill"></i> PDF
                                </a>
                                <div class="modal fade" id="pdfModal' . $row->id . '" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">PDF Preview</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <iframe src="' . asset('storage/' . $row->path) . '" width="100%" height="500px" style="border: none;"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                    } else {
                        return '<span>No file available</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('periodicals.show', $row->id) . '" class="btn btn-info btn-sm"><i class="ri-eye-fill"></i></a>
                            <a href="' . route('periodicals.edit', $row->id) . '" class="btn btn-warning btn-sm"><i class="ri-edit-2-fill"></i></a>';
                })
                ->rawColumns(['file', 'status', 'action'])
                ->make(true);
        }

        return view('periodicals.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()

    {

        $periodicalMasters = PeriodicalMaster::all();
        return view('periodicals.create', compact('periodicalMasters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_eng' => 'required|exists:periodical_masters,id',
            'path' => 'required|file|mimes:pdf|max:1048576',
            'date' => 'required|date',
            'keywords' => 'nullable',
            'status' => 'required',
        ]);

        $filePath = $request->file('path')->store('uploads/periodicals/pdf', 'public');

        if ($request->status == 1) {
            $periodical = Periodical::where('periodical_master_id', $request->name_eng)->update(['status' => '0']);
        }
        Periodical::create([
            'periodical_master_id' => $request->name_eng,
            'date' => $request->date,
            'keywords' => $request->keywords,
            'path' => $filePath,
            'status' => $request->status,
        ]);
        return redirect()->route('periodicals.index')->with('success', 'Periodical created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Periodical $periodical)
    {
        $periodical = Periodical::with('periodicalMaster')->findOrFail($request->id);
        return view('periodicals.show', compact('periodical'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Periodical $periodical)
    {
        $periodical = Periodical::with('periodicalMaster')->findOrFail($request->id);

        $periodicalMasters = PeriodicalMaster::all();

        return view('periodicals.edit', compact('periodical', 'periodicalMasters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $request->validate([
            'name_eng' => 'required|exists:periodical_masters,id',
            'date' => 'required|date',
            'path' => 'nullable|file|mimes:pdf|max:2000000',
            'keywords' => 'nullable',
            'status' => 'required',

        ]);
        $periodical = Periodical::findOrFail($request->id);

        $filePath = $periodical->path;


        if ($request->hasFile('path')) {
            //Delete existing File from storage

            if ($periodical->path && file_exists(storage_path('app/public/' . $periodical->path))) {
                unlink(storage_path('app/public/' . $periodical->path));
            }
            $filePath = $request->file('path')->store('uploads/periodicals/pdf', 'public');
        }

        $periodical->update([
            'periodical_master_id' => $request->name_eng,
            'date' => $request->date,
            'keywords' => $request->keywords,
            'path' => $filePath,
            'status' => $request->status,
        ]);

        return redirect()->route('periodicals.index')->with('success', 'Periodical updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Periodical $periodical)
    {
        //
    }
}
