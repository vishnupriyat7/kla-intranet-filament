<?php

namespace App\Http\Controllers;

use App\Models\PeriodicalMaster;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PeriodicalMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $periodicalMasters = PeriodicalMaster::all();
        // return view('periodicalMasters.index', compact('periodicalMasters'));

        // Use Yajra tables to display the Periodical Masters in a table format

        if (request()->ajax()) {
            $periodicalMasters = PeriodicalMaster::latest()->get();

            return DataTables::of($periodicalMasters)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    return $data->name;
                })

                ->addColumn('img', function ($data) {
                    return '<img src="' . asset('storage/' . $data->img) . '" width="100px" height="100px">';
                })
                ->addColumn('action', function ($data) {
                    $button = '<a href="' . route('periodical-masters.edit', $data->id) . '" class="btn btn-warning btn-sm"><i class="ri-edit-2-fill"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="ri-delete-bin-6-fill"></i></button>';
                    return $button;
                })
                ->rawColumns(['action', 'img'])
                ->make(true);
        }
        return view('periodicalMasters.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('periodicalMasters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'img' => 'required|file|mimes:jpg,jpeg,png|max:51200',
        ]);


        $filePath = $request->file('img')->store('uploads/periodicals', 'public');

        PeriodicalMaster::create([
            'name' => $request->name,
            'img' => $filePath,
        ]);

        return redirect()->route('periodicalMasters.index')->with('success', 'Periodical Master created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PeriodicalMaster $periodicalMaster)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $periodicalMaster = PeriodicalMaster::findOrFail($request->id);
        return view('periodicalMasters.edit', compact('periodicalMaster'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $periodicalMaster = PeriodicalMaster::findOrFail($request->id);
        $request->validate([
            'name' => 'required|string|max:255',
            'img' => 'nullable|file|mimes:jpg,jpeg,png|max:51200',
        ]);


        //check if new file is uploaded

        if ($request->hasFile('img')) {
            //if imge already exists, delete it
            if ($periodicalMaster->img) {
                unlink(storage_path('app/public/' . $periodicalMaster->img));
            }
            $filePath = $request->file('img')->store('uploads/periodicals', 'public');

            $periodicalMaster->update([
                'name' => $request->name,
                'img' => $filePath,
            ]);
        } else {
            $periodicalMaster->update([
                'name' => $request->name,
            ]);
        }

        return redirect()->route('periodical-masters.index')->with('success', 'Periodical Master updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        //provide an alert for Integrity constraint violation: 1451 Cannot delete or update a parent row: a foreign key constraint fails

        $periodicalMaster = PeriodicalMaster::findOrFail($request->id);

        if ($periodicalMaster->periodicals->count() > 0) {
            return redirect()->route('periodical-masters.index')->with('error', 'Cannot delete Periodical Master as it has associated Periodicals!');
        }

        $periodicalMaster->delete();
        return redirect()->route('periodical-masters.index')->with('success', 'Periodical Master deleted successfully!');
    }
}
