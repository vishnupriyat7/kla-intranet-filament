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
use Illuminate\Support\Facades\Http;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employees.index');
    }

    public function getEmployees(Request $request)
    {
        try {
            $response = Http::get('http://localhost:8000/api/v1/employee-data');

            if ($response->successful()) {
                $employees = $response->json(); // ✅ FIXED HERE

                return DataTables::of($employees)
                    ->addIndexColumn()
                    ->editColumn('avatar', function ($row) {
                        $url = asset('http://localhost:8000/storage/avatars/' . $row['avatar']);
                        return '<img src="' . $url . '" width="300" height="400" class="img-thumbnail" />';
                    })
                    ->addColumn('action', function ($row) {
                        $viewUrl = route('employees.show', $row['attendanceId']); // Adjust route name as needed
                        return '<a href="' . $viewUrl . '" class="btn btn-sm btn-primary">View</a>';
                    })
                    ->rawColumns(['action', 'avatar'])
                    ->make(true);
            }

            return response()->json(['error' => 'Failed to fetch employees'], 500);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Exception occurred: ' . $e->getMessage()
            ], 500);
        }
    }
    public function employeeShow($attendanceId)
    {
        try {
            $response = Http::get("http://localhost:8000/api/v1/employee-data");
            $employees = $response->json();
            $filteredEmployee = collect($employees)->firstWhere('attendanceId', $attendanceId);
            if ($response->successful()) {
                $employee = $response->json();
                return view('employees.show', compact('filteredEmployee'));
            }
            return view('employees.show', ['error' => 'Employee not found']);
        } catch (\Exception $e) {
            return view('employees.show', ['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
}
