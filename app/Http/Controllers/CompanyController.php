<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all()->toArray();
        return array_reverse($companies);
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
            'name' => 'required',
            'logo' => '100x100',
        ]);

        if($request->hasfile('logo'))
        {
            $logo = $request->logo;
            $logo_file_name = time() . '_'. $request->name . '.'. $logo->getClientOriginalExtension();
            $logo->move('/storage/app/public/', $logo_file_name);

        }

        $company = new Company([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'logo' => $logo_file_name,
            'website' => $request->input('website'),
        ]);
        $company->save();

        return response()->json('Company created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);
        if($company){
            return response()->json($company);
        }
        else{
            return response()->json('Company not found.');
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
            'name' => 'required',
            'logo' => '100x100',
        ]);

        if($request->hasfile('logo'))
        {
            $logo = $request->logo;
            $logo_file_name = time() . '_'. $request->name . '.'. $logo->getClientOriginalExtension();
            $logo->move('/storage/app/public/', $logo_file_name);

        }
        
        $company = Company::find($id);
        if($company){
            $company->update($request->all());
            return response()->json('Company updated!');
        }
        else{
            return response()->json('Company not found.');
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
        $company = Company::find($id);
        if($company){
            $company->delete();
            return response()->json('Company delted!');
        }
        else{
            return response()->json('Company not found.');
        }
    }
}
