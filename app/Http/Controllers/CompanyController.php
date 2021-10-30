<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Mail\NewCompanyMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use Mail;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $companies = Company::all();
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
            'name' => 'required|max:50',
            'logo' => 'dimensions:min_width=100',
        );

        $attributeNames = [
            'name' => 'Company Name',
            'email' => 'Email',
            'website' => 'Website',
            'logo' => 'Logo',
        ];

        $messages = array(
            'name.required' => 'name is required',
            'email.unique_with' => 'Account No. Already Exist!',
            'logo.dimensions' => 'Image size should be Max Width 100 and Min Width 100 size',
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
            if($request->hasfile('logo'))
            {
                $logo = $request->logo;
                $logo_file_name = time() . '_'. $request->name . '.'. $logo->getClientOriginalExtension();
                $logo->move('images/', $logo_file_name);

            }

            $company = new Company([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'logo' => $logo_file_name,
                'website' => $request->input('website'),
            ]);
            $company->save();
            Mail::to($company->email)->send(new NewCompanyMail($company));
            return response()->json([
                'success' => true,
                'message' => "Company Created",
            ]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return Company::paginate(10);
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
        // return $request;
        $request = $request->data;
        $rules = array(
            'name' => 'required|max:50',
            'email' => 'required|max:50',
            'website' => 'required|max:50',
        );

        $attributeNames = [
            'name' => 'Company Name',
            'email' => 'Email',
            'website' => 'Website',
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
            $company = Company::find($request['id']);
            $company->name = $request['name'];
            $company->email = $request['email'];
            $company->website = $request['website'];
            $company->update();

            return response()->json([
                'success' => true,
                'message' => "Company Updated",
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
        $company = Company::find($id);
        if($company){
            $company = Company::find($id)->delete();
            return response()->json([
                'success' => true,
                'message' => "Company Deleted!",
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => "Company Not Found",
            ]);
        }
    }

    public function edit($id)
    {
        return Company::find($id);
    }

}
