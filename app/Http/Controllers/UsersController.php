<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\DataTables\UsersDataTable;
use App\Models\Organization;
use App\Models\ProgramType;
use Hash;
use Illuminate\Support\Facades\Password;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('admin.user.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
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
            'first_name' => 'required',
            'lname' => 'required',  
            'email' => 'required|unique:users',            
            'password' => 'required|min:8',            
            'zcode' => 'required|min:3|max:10',            
                      
            'age' => 'required',            
            'grade' => 'required', 
            'program' => 'required',
            'role_type' =>' required',           
          ],
          [
            'first_name.required' => ' First Name is Required', 
            'lname.required' => ' Last Name is Required',
            'email.required' => ' Email is Required', 
            'program.required' => ' Program is Required', 
            'email.unique' => 'This Email is Already Exits', 
            'password.required' => 'Password is Required',
            'password.min' => 'Password At Least 8 Character',
            'zcode.required' => ' Zip Code is Required', 
            'zcode.min' => ' Minimum 3 numbers ', 
            'zcode.max' => ' Maximum 10 numbers ', 
            
            'age.required' => ' Age is Required', 
            'grade.required' => ' Grade is Required', 
            
            'role_type.required' => ' Role type is Required',
           ]);
            $new_code = $request->ocode;
           
            
                    if(($request->age) <= 13)
                        {
                            
                            $id = ProgramType::where('title', 'Junior program')->pluck('id');
                           
                            $program = $id[0];
                        }
                    else
                        {
                            
                            $id = ProgramType::where('title', 'Highschool program')->pluck('id');
                           
                            $program = $id[0];
                        }                    
                          
                     if(Organization::where("code", "=", $request->ocode)->exists()){
                        $code = $request->ocode;
                     }
                     else{
                        $code = NULL;
                     }
                       
                    // dd($request->first_name);  
                    
                    $user = new User
                                    ([
                                        'name' => $request->first_name." ". $request->lname,
                                        'first_name' => $request->first_name,
                                        'last_name' => $request->lname,   
                                        'org_code' => $code,
                                        'zip_code' => $request->zcode,
                                        'age' => $request->age,
                                        'grade' => $request->grade,
                                        'program' => $request->program,
                                        'email' => $request->email,
                                        'password' => Hash::make($request->password),
                                        'role_type' => $request->role_type,
                                    ]);
                                // dd($user);
                                $user->save();  
                                return redirect()->route('admin.users.index')->with('success', 'User Created successfully!');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
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
        $validated = $request->validate([
            'first_name' => 'required', 
            'last_name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
        ]);

        User::where('id', $id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role_type' => $request->role_type,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $user = User::find($id);
        // $user->delete();
        // return redirect()->route('admin.users.index')
        // ->with('success','User record has been successfully deleted!');
    }

    public function sendEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $token = Password::getRepository()->create($user);
        $user->sendPasswordResetNotification($token);
    }
 
}
