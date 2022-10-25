<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\DataTables\OrganizationDataTable;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrganizationDataTable $dataTable)
    {
        // $data= Organization::all();
        return $dataTable->render('admin.organization.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Organization $organization)
    {
        return view('admin.organization.add',compact('organization'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_name' => 'required',
            'address' => 'required',  
            'city' => 'required',            
            'state' => 'required',            
            'zip_code' => 'required|min:3|max:10',            
            'code' => 'required|numeric|unique:organizations',            
            'name' => 'required',            
            'contact' => 'required',            
            'gmail' => 'required|unique:organizations',            
            ],
            [
                'organization_name.required'=> ' Oragnization Name is Required', 
                'address.required'=> ' Address  is Required',
                'gmail.required'=> ' Email is Required', 
                'gmail.unique'=> 'This Email Already Exits', 
                'city.required'=> 'City is Required',
                'state.required'=> 'State is Required',
                'zip_code.required'=> 'Zip code is Required',
                'zip_code.min'=> ' Minimum 3 numbers ', 
                'zip_code.max'=> ' Maximum 10 numbers ', 
                // 'zip_code.numeric'=> 'Zip Code Should be a Number', 
                'code.numeric'=> ' Code Should be a Number', 
                'code.required'=> '  Code is Required',
                'contact.required'=> ' Contact is Required', 
            ]);
        $user = new Organization
        ([
            'organization_name'=>$request->organization_name,
            'address'=>$request->address,
            'city'=>$request->city,
            'state'=>$request->state,
            'zip_code'=>$request->zip_code,
            'code'=>$request->code,
            'name'=>$request->name,
            'contact'=>$request->contact,
            'gmail'=>$request->gmail
        ]);
        $user->save();
        return redirect()->route('admin.organizations.index')->with('success','Organization record has been successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $org=Organization::find($id);
        return view('admin.organization.edit',compact('org'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'organization_name' => 'required',
            'address' => 'required',  
            'city' => 'required',            
            'state' => 'required',            
            'zip_code' => 'required|min:3|max:10',                        
            'name' => 'required',            
            'contact' => 'required',            
            'gmail' => 'required|unique:organizations,gmail,'.$organization->id,            
            ],
            [
                'organization_name.required'=> ' Organization Name is Required', 
                'address.required'=> ' Address  is Required',
                'gmail.required'=> ' Email is Required', 
                'city.required'=> 'City is Required',
                'state.required'=> 'State is Required',
                'zip_code.required'=> 'Zip code is Required',
                'zip_code.min'=> ' Minimum 3 numbers ', 
                'zip_code.max'=> ' Maximum 10 numbers ', 
                // 'zip_code.numeric'=> 'Zip Code Should be a Number', 
                'contact.required'=> ' Contact is Required', 
            ]);           

       
        $organization->fill($request->only('organization_name','address','city','state','zip_code','name','contact','gmail'));
        
        $organization->save();
        return redirect()->route('admin.organizations.index')->with('success','Organization record has been successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return "delete";
        $org = Organization::find($id);
        $org->delete();
        return redirect()->route('admin.organizations.index')
        ->with('success','Organization record has been successfully deleted!');
    }
    public function show_org($id)
    {
        $org=Organization::find($id);
        return view('admin.organization.show_org',compact('org'));
    }
   
}
