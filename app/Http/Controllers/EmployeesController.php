<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeesController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::OrderBy("id", "DESC")->paginate(10);
        $response = [
            "total_count" => $employees->total(),
            "limit" => $employees->perPage(),
            "pagination" => [
                "next_page" => $employees->nextPageUrl(),
                "current_page" => $employees->currentPage()
            ],
            "data" => $employees->items(),
        ];

        return response()->json($employees, 200);
    }
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'user_id' => 'required|numeric'
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $employees = Employee::create($input);

        return response()->json($employees, 200);
    }
    public function show(Request $request, $id)
    {

        $employees = Employee::find($id);

        if (!$employees) {
            abort(404);
        }

        return response()->json($employees, 200);
    }
    public function update(Request $request, $id)
    {

        $input = $request->all();

        $employees = Employee::find($id);

        if (!$employees) {
            abort(404);
        }
        $validator = Validator::make($input, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'user_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $employees->fill($input);
        $employees->save();

        return response()->json($employees, 200);
    }
    public function destroy(Request $request, $id)
    {
        $employees = Employee::find($id);

        if (!$employees) {
            abort(404);
        }
        $employees->delete();
        $message = ['message' => 'Deleted successfully', 'employee_id' => $id];

        return response()->json($message, 200);
    }
}
