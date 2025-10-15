<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use App\Models\RetiredStaff;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employees.index');
    }

    public function getEmployees(Request $request)
    {
        $apiUrl = env('EMPLOYEE_API_URL');
        try {
            $response = Http::get($apiUrl);
            if ($response->successful()) {
                $employees = $response->json();
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
        $apiUrl = env('EMPLOYEE_API_URL');
        try {
            $response = Http::get($apiUrl);
            $employees = $response->json();
            $filteredEmployee = collect($employees)->firstWhere('attendanceId', $attendanceId);
            if ($response->successful()) {
                return view('employees.show', compact('filteredEmployee'));
            }
            return view('employees.show', ['error' => 'Employee not found']);
        } catch (\Exception $e) {
            return view('employees.show', ['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

     public function retiredStaff()
    {
        return view('employees.retired-staff');
    }

    public function getRetiredEmployees(Request $request)
    {
        try {
            $retiredStaff = RetiredStaff::query()->orderBy('name_eng', 'asc');;

            return DataTables::of($retiredStaff)
                ->addIndexColumn()
                ->editColumn('name_eng', function ($row) {
                    return $row->name_eng ?? 'N/A';
                })
                ->editColumn('district', function ($row) {
                    return $row->district ?? 'N/A';
                })
                ->editColumn('address', function ($row) {
                    return $row->address ?? 'N/A';
                })
                ->make(true);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Exception occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function retiredStaffShow($id)
    {
        try {
            $retiredStaff = RetiredStaff::findOrFail($id);
            return view('employees.retired-staff-show', compact('retiredStaff'));
        } catch (\Exception $e) {
            return view('employees.retired-staff-show', ['error' => 'Retired staff not found: ' . $e->getMessage()]);
        }
    }
}
