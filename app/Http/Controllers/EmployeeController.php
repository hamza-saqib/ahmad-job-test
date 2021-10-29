<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Mail\NewCompanyMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use Mail;


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
        $rules = array(
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|max:50|unique:employees',
            'phone' => 'required|max:50',
            'company_id' => 'required|exists:companies,id',
        );

        $attributeNames = [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'company_id' => 'Company',
        ];

        $messages = array(
            
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        } 
        else 
        {
            $employee = new Employee([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'company_id' => $request->input('company_id'),
            ]);
            $employee->save();
            return response()->json([
                'success' => true,
                'message' => "Employee Created",
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Employee::with('Company')->paginate(10);

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
        $request = $request->data;
        $rules = array(
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|max:50',
            'phone' => 'required|max:50',
            'company_id' => 'required|exists:companies,id',
        );

        $attributeNames = [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'company_id' => 'Company',
        ];

        $messages = array(
            
        );
        $validator = Validator::make($request, $rules, $messages);

        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        } 
        else 
        {
            $employee = Employee::find($request['id']);
            $employee->first_name = $request['first_name'];
            $employee->last_name = $request['last_name'];
            $employee->email = $request['email'];
            $employee->phone = $request['phone'];
            $employee->company_id = $request['company_id'];
            $employee->update();
            return response()->json([
                'success' => true,
                'message' => "Employee Updated",
            ]);
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
            return response()->json([
                'success' => true,
                'message' => "Employee Deleted",
            ]);
        }
        else{
            return response()->json([
                'success' => true,
                'message' => "Employee Not FOund",
            ]);
        }
    }

    public function getCompanies()
    {
        return Company::all();
    }

    public function edit($id)
    {
        return Employee::where('id', $id)->first();
    }
}
