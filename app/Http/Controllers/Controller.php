<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\ProgramType;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\DB;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function sign_up()
    {
        $user = Organization::all();
        return view('signup',compact('user'));
    }
    public function save(Request $request)
    {
       
        $validated = $request->validate([
            'fname' => 'required',
            'lname' => 'required',  
            'email' => 'required|unique:users',            
            'password' => 'required|min:8',            
            'zcode' => 'required|min:3|max:10',            
                      
            'age' => 'required',            
            'grade' => 'required', 
            'program' => 'required', 
            'check' =>' required',           
          ],
          [
            'fname.required' => ' First Name is Required', 
            'lname.required' => ' Last Name is Required',
            'email.required' => ' Email is Required', 
            'email.unique' => 'This Email Already Exits', 
            'password.required' => 'Password is Required',
            'password.min' => 'Password At Least 8 Character',
            'zcode.required' => ' Zip Code is Required', 
            'zcode.min' => ' Minimum 3 numbers ', 
            'zcode.max' => ' Maximum 10 numbers ', 
            
            'age.required' => ' Age is Required', 
            'grade.required' => ' Grade is Required', 
            'program.required' => ' Program is Required',
            'check.required' => ' Please agree with terms and condition',
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
                       
                      
                    
                    $user = new User
                                    ([
                                        'name' => $request->fname." ". $request->lname,
                                        'first_name' => $request->fname,
                                        'last_name' => $request->lname,   
                                        'org_code' => $code,
                                        'zip_code' => $request->zcode,
                                        'age' => $request->age,
                                        'grade' => $request->grade,
                                        'program' => $request->program,
                                        'email' => $request->email,
                                        'password' => Hash::make($request->password),
                                        'role_type' => 'student',
                                    ]);
                                // dd($user);    
                                $user->save();  
                                return redirect()->route('login')->with('success','Registration successful !');
                // }
                // else
                // {
                //     return back()->withErrors(['msg' => 'Enter a valid  code']);
                // }

      
                
         
    }

    
}
