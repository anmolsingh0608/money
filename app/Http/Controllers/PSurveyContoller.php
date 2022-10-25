<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\PSurveyDataTable;
use App\Models\PSurvey;

class PSurveyContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PSurveyDataTable $dataTable)
    {
        return $dataTable->render('admin.PSurvey.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PSurvey $psurvey)
    {
        return view('admin.PSurvey.create', compact('psurvey'));
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
            'title' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg|max:1024',
        ]);

        // dd($request->all());
        $psurvey = new PSurvey();
        $psurvey->title = $request->title;

        if ($request->has('question')) {
            $survey_data = [];
            $survey_data['attribute'] = [];
            $survey_data['data'] = $request->question;
            $i = 1;
            foreach ($survey_data['data'] as $key => $data) {
                $survey_data['data'][$key]['order'] = $i;
                $survey_data['data'][$key]['media'] = [];
                // $survey_data['data'][$key]["option"] =
                if(!isset($survey_data['data'][$key]["option"])){
                    $survey_data['data'][$key]["option"] = [];
                }
                $i++;
            }
        }

        // dd(json_encode($survey_data));
        // dd($request->all());
        if(isset($survey_data))
        {
            $survey = json_encode($survey_data);
        }
        else
        {
            $survey = '';
        }

        $psurvey->meta = $survey;
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $psurvey->addMediaFromRequest('image')->toMediaCollection('psurvey');
        }
        $psurvey->save();
        // $survey = json_decode($section->survey, true);

        return redirect()->route('admin.psurvey.index')->with('success', 'Survey saved successfully!');
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
        $psurvey = PSurvey::find($id);
        $survey = json_decode($psurvey->meta, true);

        return view('admin.PSurvey.edit', compact('survey', 'psurvey'));
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
        // dd($request->question);
        $validated = $request->validate([
            'title' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg|max:1024',
        ]);

        if ($request->has('question')) {
            $survey_data = [];
            $survey_data['attribute'] = [];
            $survey_data['data'] = $request->question;
            $i = 1;
            foreach ($survey_data['data'] as $key => $data) {
                $survey_data['data'][$key]['order'] = $i;
                $survey_data['data'][$key]['media'] = [];
                // $survey_data['data'][$key]["option"] =
                if(!isset($survey_data['data'][$key]["option"])){
                    $survey_data['data'][$key]["option"] = [];
                }
                $i++;
            }
        }

        // dd(json_encode($survey_data));
        // dd($request->all());
        if(isset($survey_data))
        {
            $survey = json_encode($survey_data);
        }
        else
        {
            $survey = '';
        }
        $p = PSurvey::find($id);
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $p->clearMediaCollection('psurvey');
            $p->addMediaFromRequest('image')->toMediaCollection('psurvey');
        }

        $psurvey = PSurvey::where('id', $id)->update([
            'title' => $request->title,
            'meta' => $survey
        ]);

        return redirect()->route('admin.psurvey.index')->with('success', 'Survey updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $psurvey = PSurvey::find($id);
        $psurvey->delete();
        return redirect()->route('admin.psurvey.index')->with('success','Survey record has been successfully deleted!');
    }

    public function addSubQues(Request $request)
    {
        $index = $request->has("index") ? $request["index"] : 0;
        $q_index = $request->has("q_index") ? $request["q_index"] : 0;
        // $answer = '';
        $quest = ['title' => '', 'options' => '', 'id' => ''];
        $options = '';
        return view('admin.PSurvey.subques', ['index' => $index, 'sque' => $quest, 'q_index' => $q_index, 'options' => $options/*, 'answer' => $answer*/]);
    }

    public function addSubOpts(Request $request)
    {
        $index = $request->has("index") ? $request["index"] : 0;
        $q_index = $request->has("q_index") ? $request["q_index"] : 0;
        // $answer = '';
        $type = $request->type;
        // dd($type);
        $option = '';
        $answer = [];
        return view('admin.PSurvey.subopt', ['index' => $index, 'type' => $type, 'option' => $option, 'q_index' => $q_index]);
    }
}
