<?php

namespace App\Http\Controllers;

use App\Models\NewsUpdate;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NewsUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (request()->ajax()) {
            $newsupdates = NewsUpdate::all();

            return DataTables::of($newsupdates)
                ->addIndexColumn()

                ->addColumn('title', function ($row) {
                    return $row->title;
                })

                ->addColumn('date', function ($row) {
                    return date('d-m-Y', strtotime($row->date));
                })
                ->addColumn('status', function ($row) {
                    return $row->status == '0' ? '<span class="badge bg-danger">Unpublished</span>' : '<span class="badge bg-success">Published</span>';
                })


                ->addColumn('action', function ($row) {
                    $action = '';
                    if ($row->path) {
                        $action .= '<a href="#" class="btn btn-outline-info btn-sm text-black" data-bs-toggle="modal" data-bs-target="#pdfModal' . $row->id . '">
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
                        $action .= '<span>No file available</span>';
                    }
                    $action .= '<a href="' . route('news-updates.edit', $row->id) . '" class="btn btn-warning btn-sm"><i class="ri-edit-2-fill"></i></a>

                    <form method="POST" action="' . route('news-updates.destroy', $row->id) . '" style="display:inline;">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">
                        <i class="ri-delete-bin-6-fill"></i>
                    </button>
                </form>';
                    return $action;
                })
                ->rawColumns(['file', 'status', 'action'])
                ->make(true);
        }
        return view('newsupdates.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('newsupdates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'path' => 'required|file|mimes:pdf|max:100000',
            'date' => 'required|date',
            'status' => 'required|string|max:1',
        ]);

        $filePath = $request->file('path')->store('uploads/news', 'public');
        // dd(request()->file('path')->getSize());
        NewsUpdate::create([
            'title' => $request->title,
            'date' => $request->date,
            'path' => $filePath,
            'status' => $request->status,
        ]);

        return redirect()->route('news-updates.index')->with('success', 'News created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $newsupdate = NewsUpdate::findOrFail($request->id);
        return view('newsupdates.edit', compact('newsupdate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $newsupdate = NewsUpdate::findOrFail($request->id);
        $request->validate([
            'title' => 'required|string|max:255',
            'path' => 'nullable|file|mimes:pdf|max:100000',
            'date' => 'required|date',
            'status' => 'required|string|max:1',
        ]);
        if ($request->hasFile('path')) {
            $oldFile = $newsupdate->path;
            if ($oldFile) {
                unlink(storage_path('app/public/' . $oldFile));
            }
            $filePath = $request->file('path')->store('uploads/news', 'public');
            $newsupdate->update([
                'title' => $request->title,
                'date' => $request->date,
                'path' => $filePath,
                'status' => $request->status,
            ]);
        } else {
            $newsupdate->update([
                'title' => $request->title,
                'date' => $request->date,
                'status' => $request->status,
            ]);
        }
        return redirect()->route('news-updates.index')->with('success', 'News updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $newsupdate = NewsUpdate::findOrFail($request->id);

        if ($newsupdate->path) {
            unlink(storage_path('app/public/' . $newsupdate->path));
        }
        $newsupdate->delete();
        return redirect()->route('news-updates.index')->with('success', 'News deleted successfully!');
    }
}
