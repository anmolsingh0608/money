<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $count = DB::table('organizations')->count();
        $all_user = User::where('role_type', '=', 'student')->count();
        $high_user = User::where('program', '=', '2')->where('role_type', '=', 'student')->count();
        $junior_user = User::where('program', '=', '1')->where('role_type', '=', 'student')->count();
        $high_spanish_user = User::where('program', '=', '3')->where('role_type', '=', 'student')->count();

        $org_user = User::where('org_code', '!=', '')->where('role_type', '=', 'student')->where('role_type', '=', 'student')->count();
        $high_org = User::where('org_code', '!=', '')->where('role_type', '=', 'student')->where('program', '=', '2')->count();
        $junior_org = User::where('org_code', '!=', '')->where('role_type', '=', 'student')->where('program', '=', '1')->count();
        $high_spanish_org = User::where('org_code', '!=', '')->where('role_type', '=', 'student')->where('program', '=', '3')->count();

        $no_org_user = User::whereNull("org_code")->where('role_type', '=', 'student')->where('role_type', '=', 'student')->count();
        $high_no_org = User::whereNull("org_code")->where('role_type', '=', 'student')->where('program', '=', '2')->count();
        $junior_no_org = User::whereNull("org_code")->where('role_type', '=', 'student')->where('program', '=', '1')->count();
        $high_spanish_no_org = User::whereNull("org_code")->where('role_type', '=', 'student')->where('program', '=', '3')->count();

        $certified_user = User::where('certified', '=', 'yes')->where('role_type', '=', 'student')->count();
        $certified_user_junior = User::where('certified', '=', 'yes')->where('role_type', '=', 'student')->where('program', '=', '1')->count();
        $certified_user_high = User::where('certified', '=', 'yes')->where('role_type', '=', 'student')->where('program', '=', '2')->count();
        $certified_user_high_spanish = User::where('certified', '=', 'yes')->where('role_type', '=', 'student')->where('program', '=', '3')->count();


        // $org->count();
        // dd($org);
        return view('admin.report.index', compact(
            'all_user',
            'high_user',
            'junior_user',
            'high_spanish_user',
            

            'org_user',
            'high_org',
            'junior_org',
            'high_spanish_org',

            'no_org_user',
            'high_no_org',
            'junior_no_org',
            'high_spanish_no_org',

            'certified_user',
            'certified_user_junior',
            'certified_user_high',
            'certified_user_high_spanish',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
