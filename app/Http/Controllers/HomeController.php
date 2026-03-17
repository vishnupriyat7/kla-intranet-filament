<?php

namespace App\Http\Controllers;

use App\Models\Periodical;
use App\Models\NewsUpdate;
use App\Models\OrderCircular;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\OfficeLocation;

class HomeController extends Controller
{
    public function index()
    {

        $locations = OfficeLocation::with('office')->get();

        //want to show all distinct periodicals with latest periodical by status published(1) on home page in alphabetical order of periodical name
        $periodicals = Periodical::with('periodicalMaster')
            ->where('status', 1)
            ->join('periodical_masters', 'periodicals.periodical_master_id', '=', 'periodical_masters.id')
            ->select('periodicals.*')
            ->orderBy('periodical_masters.name', 'asc')
            ->get();
        $newsupdates = NewsUpdate::where('status', '1')
            ->orderBy('date', 'desc')
            ->limit(6)
            ->get();
        $goms = OrderCircular::where('type', 'G')
            ->where('go_type', 'M')
            ->where('status', '1')
            ->orderBy('date', 'desc')
            ->orderByRaw("CAST(SUBSTRING_INDEX(number, '/', 1) AS UNSIGNED) DESC")
            ->limit(6)
            ->get();
        $gort = OrderCircular::where('type', 'G')
            ->where('go_type', 'R')
            ->where('status', '1') // Fetch records in range
            ->orderBy('date', 'desc')
            ->orderByRaw("CAST(SUBSTRING_INDEX(number, '/', 1) AS UNSIGNED) DESC")
            ->limit(6)
            ->get();
        $gop = OrderCircular::where('type', 'G')
            ->where('go_type', 'P')
            ->where('status', '1') // Fetch records in range
            ->orderBy('date', 'desc')
            ->orderByRaw("CAST(SUBSTRING_INDEX(number, '/', 1) AS UNSIGNED) DESC")
            ->limit(6)
            ->get();
        $oos = OrderCircular::where('type', 'O')
            ->where('status', '1')
            ->orderBy('date', 'desc')
            ->orderByRaw("CAST(SUBSTRING_INDEX(number, '/', 1) AS UNSIGNED) DESC")
            ->limit(6)
            ->get();
        $crcls = OrderCircular::where('type', 'C')
            ->where('status', '1')
            ->orderBy('date', 'desc')
            ->orderByRaw("CAST(SUBSTRING_INDEX(number, '/', 1) AS UNSIGNED) DESC")
            ->limit(6)
            ->get();
        $goCount = OrderCircular::where('type', 'G')
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->where('status', '1')
            ->count();
        $ooCount = OrderCircular::where('type', 'O')
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->where('status', '1')
            ->count();
        $clrCount = OrderCircular::where('type', 'C')
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->where('status', '1')
            ->count();
        return view('home', compact('periodicals', 'newsupdates', 'goms', 'gort', 'gop', 'oos', 'crcls', 'goCount', 'ooCount', 'clrCount', 'locations'));
    }


    public function updatesMore()
    {
        $newsupdates = NewsUpdate::where('status', '1')
            ->orderBy('date', 'desc')


            ->get();
        $periodicals = Periodical::with('periodicalMaster')
            ->where('status', 1)
            ->join('periodical_masters', 'periodicals.periodical_master_id', '=', 'periodical_masters.id')
            ->select('periodicals.*')
            ->orderBy('periodical_masters.name', 'asc')
            ->get();
        return view('newsupdates.viewmore', compact('newsupdates', 'periodicals'));
    }

    public function orderCircular(Request $request)
    {
        $startDate = Carbon::now()->subMonths(5)->startOfMonth(); // 5 months ago (1st day)
        $endDate = Carbon::now()->endOfMonth(); // Last day of the current month
        $typeKey = $request->type;

        // Fetch orders based on type
        if ($request->type == 'go') {
            $orders = OrderCircular::where('type', 'G')
                ->where('status', '1')
                ->whereBetween('date', [$startDate, $endDate]) // Fetch records in range
                ->orderBy('date', 'desc')
                ->get();
            $orderType = 'Government Order';

            // Check for print orders (go_type = 'P') within the last 6 months
            $hasPrintOrders = $orders->filter(function ($order) {
                return $order->go_type == 'P';
            })->isNotEmpty();
        } elseif ($request->type == 'oo') {
            $orders = OrderCircular::where('type', 'O')
                ->where('status', '1')
                ->whereBetween('date', [$startDate, $endDate]) // Fetch records in range
                ->orderBy('date', 'desc')
                ->get();
            $orderType = 'Office Order';
            $hasPrintOrders = false; // No print orders for Office Order
        } elseif ($request->type == 'cr') {
            $orders = OrderCircular::where('type', 'C')
                ->where('status', '1')
                ->whereBetween('date', [$startDate, $endDate]) // Fetch records in range
                ->orderBy('date', 'desc')
                ->get();
            $orderType = 'Circular';
            $hasPrintOrders = false; // No print orders for Circular
        }
        // Generate months for the last 6 months
        $base = now()->startOfMonth();
        $months = collect(range(5, 0))->map(function ($i) use ($base) {
            $date = $base->copy()->subMonths($i);
            return [
                'no' => $date->format('m'),
                'year' => $date->format('Y'),
                'name' => $date->format('F Y'),
            ];
        })->values();
        // Check if the request is an Ajax call
        if ($request->ajax()) {
            $month = $request->get('month');
            $go_type = $request->get('go_type');
            $orders = OrderCircular::where('status', '1')
                ->whereBetween('date', [$startDate, $endDate])
                ->when($request->has('go_type'), function ($query) use ($request) {
                    return $query->where('go_type', $request->input('go_type'));
                })
                ->when($request->type == 'go', function ($query) {
                    return $query->where('type', 'G');
                })
                ->when($request->type == 'oo', function ($query) {
                    return $query->where('type', 'O');
                })
                ->when($request->type == 'cr', function ($query) {
                    return $query->where('type', 'C');
                })
                ->orderBy('date', 'desc')

                ->get();
            $orders = $orders->filter(function ($order) use ($month) {
                return \Carbon\Carbon::parse($order->date)->format('m') == str_pad($month, 2, '0', STR_PAD_LEFT);
            });
            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('number', function ($order) {
                    // if ($order->type == 'G') {
                    //     if ($order->go_type == 'M') {
                    //         return 'G.' . 'O.' . ('(Ms).') . 'No.' . $order->number ?: '-';
                    //     } else {
                    //         return 'G.' . 'O.' . ('(Rt).') . 'No.' . $order->number ?: '-';
                    //     }
                    // } elseif ($order->type == 'O') {
                    //     return 'O.O.' . 'No.' . $order->number ?: '-';
                    // } elseif ($order->type == 'C') {
                    //     return 'Cir.' . 'No.' . $order->number ?: '-';
                    // }
                    // return '-';
                    if ($order->type == 'G') {
                        if ($order->go_type == 'M') {
                            return 'G.O.(Ms).No.' . $order->number ?: '-';
                        } elseif ($order->go_type == 'R') {
                            return 'G.O.(Rt).No.' . $order->number ?: '-';
                        } elseif ($order->go_type == 'P') {
                            return 'G.O.(P).No.' . $order->number ?: '-';
                        }
                    } elseif ($order->type == 'O') {
                        return 'O.O.No.' . $order->number ?: '-';
                    } elseif ($order->type == 'C') {
                        return 'Cir.No.' . $order->number ?: '-';
                    }
                    return '-';
                })
                ->addColumn('date', function ($order) {
                    return \Carbon\Carbon::parse($order->date)->format('d-m-Y'); // Match screenshot format
                })
                ->addColumn('title', function ($order) {
                    return $order->title;
                })
                ->addColumn('link', function ($order) {
                    return $order->link;  // send raw link
                })
                // ->addColumn('view', function ($order) {
                //     return $order->path
                //         ? '<a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal" data-pdf="' . asset('storage/' . $order->path) . '" data-title="' . e($order->title) . '" title="View in Modal"><i class="fas fa-eye text-primary"></i></a>' .
                //         '<a href="' . asset('storage/' . $order->path) . '" target="_blank" class="ms-3" title="Open in New Tab"><i class="fas fa-external-link-alt text-success"></i></a>'
                //         : '<i class="fas fa-ban text-danger" title="Not uploaded"></i>';
                // })
                // ->rawColumns(['title', 'view'])
                ->addColumn('view', function ($order) {

                    $files = is_array($order->path) ? $order->path : [];

                    // No file
                    if (count($files) === 0) {
                        return '<i class="fas fa-ban text-danger" title="Not uploaded"></i>';
                    }

                    // Single PDF
                    if (count($files) === 1) {
                        $url = asset('storage/' . $files[0]);

                        return '
            <a href="#"
               data-bs-toggle="modal"
               data-bs-target="#pdfModal"
               data-pdf="' . $url . '"
               data-title="' . e($order->title) . '"
               title="View">
                <i class="fas fa-eye text-primary"></i>
            </a>

            <a href="' . $url . '" target="_blank" class="ms-3" title="Open in New Tab">
                <i class="fas fa-external-link-alt text-success"></i>
            </a>
        ';
                    }

                    // Multiple PDFs
                    $html = '';
                    foreach ($files as $i => $file) {
                        $url = asset('storage/' . $file);
                        $html .= '
            <a href="#"
               class="badge bg-primary me-1"
               data-bs-toggle="modal"
               data-bs-target="#pdfModal"
               data-pdf="' . $url . '"
               data-title="' . e($order->title) . ' (Attachment ' . ($i + 1) . ')">
               📎 ' . ($i + 1) . '
            </a>
        ';
                    }

                    return $html;
                })
                ->rawColumns(['title', 'view'])

                ->make(true);
        }
        $periodicals = Periodical::with('periodicalMaster')
            ->where('status', 1)
            ->join('periodical_masters', 'periodicals.periodical_master_id', '=', 'periodical_masters.id')
            ->select('periodicals.*')
            ->orderBy('periodical_masters.name', 'asc')
            ->get();
        return view('orders-circular.order_circular_recent', compact('orders', 'months', 'orderType', 'periodicals', 'hasPrintOrders'))
            ->with('orderTypeKey', $request->type);
    }

    public function search(Request $request)
    {
        $results = collect();
        if ($request->has('anysearch')) {
            $search = $request->anysearch;
            // Get all table names from the database, excluding system tables
            $tables = DB::select("SHOW TABLES");
            $excludedTables = [
                'cache',
                'cache_locks',
                'failed_jobs',
                'job_batches',
                'jobs',
                'migrations',
                'password_reset_tokens',
                'sessions',
                'users',
                'periodical_masters',
                'periodicals'
            ];

            foreach ($tables as $table) {
                $tableName = array_values((array) $table)[0];
                // Skip system tables
                if (in_array($tableName, $excludedTables)) {
                    continue;
                }
                // Get all column names from the current table
                $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
                // Build the query for the current table
                $query = DB::table($tableName);
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', "%{$search}%");
                }
                // Merge the results with the previous ones
                $tableResults = $query->get();
                $results = $results->merge($tableResults);
            }
        }
        $periodicals = Periodical::with('periodicalMaster')
            ->where('status', 1)
            ->join('periodical_masters', 'periodicals.periodical_master_id', '=', 'periodical_masters.id')
            ->select('periodicals.*')
            ->orderBy('periodical_masters.name', 'asc')
            ->get();
        return view('partials.search', compact('results', 'periodicals'));
    }

    public function uploadRequest(Request $request)
    {
        $periodicals = Periodical::with('periodicalMaster')
            ->where('status', 1)
            ->join('periodical_masters', 'periodicals.periodical_master_id', '=', 'periodical_masters.id')
            ->select('periodicals.*')
            ->orderBy('periodical_masters.name', 'asc')
            ->get();
        $sections = Section::where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
        $categories = Category::get();
        $subcategories = SubCategory::get();
        $save_request = '';
        return view('orders-circular.upload_request', compact('periodicals', 'save_request', 'sections', 'categories', 'subcategories'));
    }

    public function storeUploadRequest(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'go_type' => 'nullable',
            'serviceMember' => 'nullable',
            'category' => 'nullable',
            'memb' => 'nullable',
            'no' => 'required',
            'date' => 'required|date',
            'title' => 'required',
            'keywords' => 'nullable',
            'section' => 'required|exists:sections,id',
            'path' => 'required|file|mimes:pdf|max:1048576',
        ]);
        $year = date('Y', strtotime($request->date));
        $categoryFolder = match ($request->type) {
            'G' => 'GovtOrders',
            'O' => 'OfficeOrders',
            'C' => 'Circulars',
        };
        $filePath = $request->file('path')->store("uploads/orders-circlular/{$year}/{$categoryFolder}", 'public');
        OrderCircular::create([
            'type' => $request->type,
            'go_type' => $request->go_type ?? null,
            'sub_type' => $request->serviceMember ?? null,
            'sub_sub_type' => $request->category ?? null,
            'number' => $request->no,
            'date' => $request->date,
            'title' => $request->title,
            'keywords' => $request->keywords,
            'path' => [$filePath],
            'status' => 0,
            'section_id' => $request->section
        ]);
        return redirect()->route('home.upload-request')->with('success', 'Your request has been saved successfully.');
    }
    public function advancedSearch(Request $request)
    {
        $orderResults = collect();
        $error = null;

        // Log request parameters for debugging
        // \Log::info('Advanced Search Request Parameters:', $request->all());

        // Validate if month is selected but year is not
        if ($request->filled('month') && !$request->filled('year')) {
            $error = 'Please select a Year while choosing a month.';
            return view('partials.advanced-search-results', compact('error'));
        }

        // Validate if to_date is provided without from_date
        if ($request->filled('to_date') && !$request->filled('from_date')) {
            $error = 'Please select a From Date when choosing a To Date.';
            return view('partials.advanced-search-results', compact('error'));
        }

        // Check if any filter is provided
        $hasFilters = $request->filled('order_type') ||
            $request->filled('go_type') ||
            $request->filled('year') ||
            $request->filled('month') ||
            $request->filled('from_date') ||
            $request->filled('to_date') ||
            $request->filled('section') ||
            $request->filled('keyword');

        // Initialize results
        $results = null;
        $orderType = $request->order_type;

        if ($hasFilters) {
            // Initialize the query
            $query = OrderCircular::with('section')->where('status', '1');

            // Filter by Order Type
            if ($request->filled('order_type')) {
                $query->where('type', $request->order_type);

                // Filter by GO Subtype (only for order_type = 'G')
                if ($request->filled('go_type') && $request->order_type == 'G') {
                    $query->where('go_type', $request->go_type);
                }
            }

            // Filter by Year
            if ($request->filled('year')) {
                $query->whereYear('date', '=', $request->year);
            }

            // Filter by Month
            if ($request->filled('month')) {
                $query->whereMonth('date', '=', $request->month);
            }

            // Filter by Date Range
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween('date', [$request->from_date, $request->to_date]);
            } elseif ($request->filled('from_date')) {
                $query->whereDate('date', '>=', $request->from_date);
            }

            // Filter by Section
            if ($request->filled('section')) {
                $query->where('section_id', '=', $request->section);
            }

            // Filter by Keyword
            if ($request->filled('keyword')) {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'LIKE', "%{$request->keyword}%")
                        ->orWhere('keywords', 'LIKE', "%{$request->keyword}%")
                        ->orWhere('number', 'LIKE', "%{$request->keyword}%")
                        ->orWhereHas('section', function ($q2) use ($request) {
                            $q2->where('name', 'LIKE', "%{$request->keyword}%");
                        });
                });
            }

            // Log the query for debugging
            // \Log::info('Advanced Search Query: ' . $query->toSql(), $query->getBindings());

            // Execute the query
            $orderResults = $query->orderBy('date', 'desc')->get();

            // Log the results for debugging
            // \Log::info('Advanced Search Results Count: ' . $orderResults->count());
            // \Log::info('Advanced Search Results Types: ', $orderResults->pluck('type')->unique()->toArray());

            $results = $orderResults;
        }

        // Fetch periodicals and sections for the view
        $periodicals = Periodical::with('periodicalMaster')
            ->where('status', 1)
            ->join('periodical_masters', 'periodicals.periodical_master_id', '=', 'periodical_masters.id')
            ->select('periodicals.*')
            ->orderBy('periodical_masters.name', 'asc')
            ->get();

        $sections = Section::where('status', 1)
            ->orderBy('name', 'asc')
            ->get();

        // Return appropriate view based on request type
        if ($request->ajax()) {
            return view('partials.advanced-search-results', compact('results', 'orderType', 'sections', 'error'));
        }

        return view('partials.advanced-search', compact('results', 'periodicals', 'orderType', 'sections', 'error'));
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'section_status' => 'required',
        ]);
        $order_pendings = OrderCircular::where('section_id', $request->section_status)
            ->where('status', 0)
            ->orderBy('date', 'desc')
            ->get();
        return view('orders-circular.upload_request_pending', compact('order_pendings'));
    }
}
