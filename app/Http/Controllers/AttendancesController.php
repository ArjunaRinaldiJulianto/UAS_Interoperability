<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendancesController extends Controller
{
    public function index(Request $request)
    {
        $attendance = Attendance::OrderBy("id", "DESC")->paginate(10);
        $response = [
            "total_count" => $attendance->total(),
            "limit" => $attendance->perPage(),
            "pagination" => [
                "next_page" => $attendance->nextPageUrl(),
                "current_page" => $attendance->currentPage()
            ],
            "data" => $attendance->items(),
        ];
        return response()->json($attendance, 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'date' => 'required|date',
            'status' => 'required|in:present,absent',
            'employee_id' => 'required|int'
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $attendance = Attendance::create($input);

        return response()->json($attendance, 200);
    }
    public function show(Request $request, $id)
    {

        $attendance = Attendance::find($id);

        if (!$attendance) {
            abort(404);
        }
        return response()->json($attendance, 200);
    }
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $attendance = Attendance::find($id);

        if (!$attendance) {
            abort(404);
        }

        $validator = Validator::make($input, [
            'date' => 'required|date',
            'status' => 'required|in:present,absent',
            'employee_id' => 'required|int'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $attendance->fill($input);
        $attendance->save();

        return response()->json($attendance, 200);
    }

    public function destroy(Request $request, $id)
    {

        $attendance = Attendance::find($id);

        if (!$attendance) {
            abort(404);
        }

        $attendance->delete();

        $message = ['message' => 'Deleted successfully', 'attendance_id' => $id];

        return response()->json($message, 200);
    }
}
