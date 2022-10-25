<?php

namespace App\Http\Controllers;

use App\DataTables\SurveyDataTable;
use App\Models\Program;
use App\Models\Section;
use App\Models\Survey;
use Illuminate\Http\Request;
class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SurveyDataTable $dataTable)
    {
        return $dataTable->render('admin.survey.index');

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
    public function store(Request $request,$id)
    {
        $survey = Survey::select('user_id')
        ->where('section_id', '=', $id)
        ->where('user_id', '=', $request->user_id)
        ->get();

        if(isset($survey[0]['id']) != null || isset($survey[0]['user_id']) == $request->user_id)
        {
                $validated = $request->validate([

                    'section_id' => 'unique:surveys',

                ]);
        }

        $survey = new Survey
        ([
            'user_id'=>$request->user_id,
            'section_id'=>$request->section_id,
            'survey'=>json_encode($request->question),

        ]);
        $survey->save();

        $section = Section::find($id);

        $sections = Section::select('*')
        ->where('program_id', '=', $section->program_id)
        ->get();

        if($request->has('junior_survey')) {
            return redirect()->route('section', ['p_id' => $request->program_id, 'id' => $request->section_id]);
        } else {
            return redirect()->route('thankyou', ['id' => $id]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $survey = Survey::find($id);
        // $survey = ($surveys->survey);
        return view('admin.survey.show',compact('survey'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(Survey $survey)
    {
        // return "asldjasl";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Survey $survey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $survey = Survey::find($id);
        // $survey->delete();
        // return redirect()->route('admin.survey.index')
        // ->with('success','Survey record has been successfully deleted!');
    }
}
