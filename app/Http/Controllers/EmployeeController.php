<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
                    ->addColumn('action', function ($row) {
                        return '<button class="btn btn-md view-employee" data-id="' . $row['attendanceId'] . '"><i class="fas fa-eye text-primary"></i></button>';
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
                // return $filteredEmployee;
                return view('employees.show', compact('filteredEmployee'));
            }
            return view('employees.show', ['error' => 'Employee not found']);
        } catch (\Exception $e) {
            return view('employees.show', ['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
}
