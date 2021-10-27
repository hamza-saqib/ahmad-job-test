<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all()->toArray();
        return array_reverse($employees);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'company_id' => 'required|exists:companies,id'
        ]);

        $employee = new Employee([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'company_id' => $request->input('company_id'),
        ]);
        $employee->save();

        return response()->json('Employee created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        if($employee){
            return response()->json($employee);
        }
        else{
            return response()->json('Employee not found.');
        }

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'company_id' => 'required|exists:companies,id'
        ]);

        $employee = Employee::find($id);
        if($employee){
            $employee->update($request->all());
            return response()->json('Employee updated!');
        }
        else{
            return response()->json('Employee not found.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        if($employee){
            $employee->delete();
            return response()->json('Employee delted!');
        }
        else{
            return response()->json('Employee not found.');
        }
    }
}
