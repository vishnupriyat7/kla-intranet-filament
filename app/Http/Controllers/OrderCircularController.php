<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderCircular;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Section;

class OrderCircularController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $orders = OrderCircular::all()->sortByDesc('created_at');
            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('type', function ($data) {
                    if ($data->type == 'G') {
                        return 'Govt.Order';
                    } elseif ($data->type == 'O') {
                        return 'Office Order';
                    } elseif ($data->type == 'C') {
                        return 'Circular';
                    }
                })
                ->addColumn('go_type', function ($data) {
                    if ($data->go_type == 'M') {
                        return 'സ.ഉ.കയ്യെഴുത്തു (GO.Manuscript)';
                    } elseif ($data->go_type == 'R') {
                        return 'സ.ഉ.സാധാ (GO.Routine)';
                    } elseif ($data->go_type == 'P') {
                        return 'സ.ഉ.അച്ചടി (GO.Print)';
                    }
                })
                ->addColumn('serviceMember', function ($data) {
                    if ($data->sub_type == 'Service') {
                        return 'Service';
                    } elseif ($data->sub_type == 'Member') {
                        return 'Member';
                    }
                })
                ->addColumn('sub_sub_type', function ($data) {
                    return $data->sub_sub_type;
                })
                ->addColumn('number', function ($data) {
                    return $data->number;
                })
                ->addColumn('date', function ($data) {
                    return $data->date;
                })
                ->addColumn('title', function ($data) {
                    return $data->title;
                })
                ->addColumn('keywords', function ($data) {
                    return $data->keywords;
                })
                ->addColumn('created_at', function ($data) {
                    return $data->created_at ? $data->created_at->format('d-m-Y') : '-';
                })
                ->addColumn('file', function ($data) {
                    if ($data->path) {
                        return '<a href="#" class="btn btn-outline-info btn-sm text-black" data-bs-toggle="modal" data-bs-target="#pdfModal' . $data->id . '">
                                    <i class="ri-eye-fill"></i> PDF
                                </a>
                                <div class="modal fade" id="pdfModal' . $data->id . '" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">PDF Preview</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <iframe src="' . asset('storage/' . $data->path) . '" width="100%" height="500px" style="border: none;"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                    } else {
                        return '<span>No file available</span>';
                    }
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 0) {
                        return '<span class="badge bg-danger">Unpublished</span>';
                    } elseif ($data->status == 1) {
                        return '<span class="badge bg-success">Published</span>';
                    }
                })

                ->addColumn('action', function ($data) {
                    $button = '<a href="' . route('orders-circular.edit', $data->id) . '" class="btn btn-warning btn-sm"><i class="ri-edit-2-fill"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<form method="POST" action="' . route('orders-circular.delete', $data->id) . '" style="display:inline;">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">
                        <i class="ri-delete-bin-6-fill"></i>
                    </button>
                </form>';
                    return $button;
                })
                ->rawColumns(['file', 'status', 'action'])
                ->make(true);
        }
        return view('orders-circular.index');
    }
    public function create()
    {
        $sections = Section::get();
        return view('orders-circular.create', compact('sections'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'section' => 'nullable',
            'type' => 'required',
            'go_type' => 'nullable',
            'serviceMember' => 'nullable',
            'servc' => 'nullable',
            'servc_memb_catgry' => 'nullable',
            'no' => 'required',
            'date' => 'required|date',
            'title' => 'required',
            'keywords' => 'required',
            'path' => 'required|file|mimes:pdf|max:1048576',
            'status' => 'required',
        ]);
        // Extract Year from provided date
        $year = date('Y', strtotime($request->date));
        // dd($year);

        //determine the category folder based on the type
        $categoryFolder = match ($request->type) {
            'G' => 'GovtOrders',
            'O' => 'OfficeOrders',
            'C' => 'Circulars',
        };

        $filePath = $request->file('path')->store("uploads/orders-circlular/{$year}/{$categoryFolder}", 'public');

        // $filePath = $request->file('go_path')->store('uploads/orders-circular/', 'public');
        // $sub_sub_type = match ($request->serviceMember) {
        //     'Service' => $request->servc,
        //     'Member' => $request->memb,
        //     default => null,
        // };

        OrderCircular::create([
            'section_id' => $request->section,
            'type' => $request->type,
            'go_type' => $request->go_type ?? null,
            'sub_type' => $request->serviceMember ?? null,
            'sub_sub_type' => $request->servc_memb_catgry ?? null,
            'number' => $request->no,
            'date' => $request->date,
            'title' => $request->title,
            'keywords' => $request->keywords,
            'path' => $filePath,
            'status' => $request->status,

        ]);
        return redirect()->route('orders-circular.index')->with('success', 'Order / Circular added successfully');
    }

    public function edit(Request $request)
    {
        // dd($request->id);
        $order = OrderCircular::find($request->id);
        // dd($order);
        return view('orders-circular.edit', compact('order'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'section' => 'nullable',
            'type' => 'required',
            'go_type' => 'nullable',
            'serviceMember' => 'nullable',
            'servc_memb_cat' => 'nullable',
            'no' => 'required',
            'date' => 'required|date',
            'title' => 'required',
            'keywords' => 'required',
            'path' => 'nullable|file|mimes:pdf|max:1048576',
            'status' => 'required',
        ]);
        $order = OrderCircular::find($request->id);
        $year = date('Y', strtotime($request->date));
        $categoryFolder = match ($request->type) {
            'G' => 'GovtOrders',
            'O' => 'OfficeOrders',
            'C' => 'Circulars',
        };


        // Initialize $filePath with the existing value
        $filePath = $order->path;

        if ($request->hasFile('path')) {
            // Delete old file if exists
            if ($order->path && file_exists(storage_path('app/public/' . $order->path))) {
                unlink(storage_path('app/public/' . $order->path));
            }

            // Store new file and update $filePath
            $filePath = $request->file('path')->store("uploads/orders-circlular/{$year}/{$categoryFolder}", 'public');
        }

        // $sub_sub_type = match ($request->serviceMember) {
        //     'Service' => $request->servc,
        //     'Member' => $request->memb,
        //     default => null,
        // };

        $order->update([
            'section_id' => $request->section,
            'type' => $request->type,
            'go_type' => $request->go_type ?? null,
            'sub_type' => $request->serviceMember ?? null,
            'sub_sub_type' => $request->servc_memb_cat ?? null,
            'number' => $request->no,
            'date' => $request->date,
            'title' => $request->title,
            'keywords' => $request->keywords,
            'path' => $filePath,
            'status' => $request->status,
        ]);

        return redirect()->route('orders-circular.index')->with('success', 'Order / Circular updated successfully');
    }
    public function delete(Request $request)
    {
        $order = OrderCircular::findOrFail($request->id);
        if ($order->path) {
            unlink(storage_path('app/public/' . $order->path));
        }
        $order->delete();
        return redirect()->route('orders-circular.index')->with('success', 'Order / Circular deleted successfully');
    }
}
