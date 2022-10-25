<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\DataTables\SectionsDataTable;
use App\Models\User;
use App\Models\PSurvey;
use Illuminate\Support\Facades\Redis;
use PhpOption\Option;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $dataTable = new SectionsDataTable;
        return $dataTable->with('id', $id)
            ->render('admin.program.section.index');
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
        $section = Section::with('psurvey')->find($id);
        $psurvey = PSurvey::all();
        $survey = json_decode($section->survey, true);
        $video = json_decode($section->url, true);
        if ($video == null && $section->url != null) {
            $video[] = $section->url;
        }
        if($video != null)
        {
            foreach($video as $key => $vid)
            {
                if(!is_array($video[$key]))
                {
                    $video[$key] = [];
                    $video[$key]['name'] = '';
                    $video[$key]['description'] = '';
                    $video[$key]['url'] = $vid;
                }
                elseif(!array_key_exists('name', $video[$key]))
                {
                    $video[$key] = [];
                    $video[$key]['name'] = '';
                    $video[$key]['description'] = '';
                    $video[$key]['url'] = $vid;
                }
            }
        }
        // if(empty($survey)) {
        //     $survey = [
        //         'data' => []
        //     ];
        // }
        return view('admin.program.section.edit', compact('section', 'survey', 'video', 'psurvey'));
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
            'name' => 'required',
            'section_image' => 'image|mimes:jpg,png,jpeg|max:4024',
            // 'url' => 'required',
        ]);

        $urlData = $request->url;
        $urlClonnedData = $urlData;
        if( isset($urlData) )
        {
            foreach($urlData as $key=>$fileData)
            {
                if(isset($urlData[$key]['image'])){
                    $file = $fileData['image'];
                    $name = uniqid().'.'.$file->extension();
                    $file->move(public_path().'/images/uploads', $name);
                    $urlClonnedData[$key]["image"] = $name;
                }
                else{
                    if(isset($urlData[$key]['img'])){
                        $name = $urlData[$key]['img'];
                        $urlClonnedData[$key]["image"] = $name;
                    }
                }
                unset($urlClonnedData[$key]["img"]);
            }
        }

        if($request->type == 'video') {
            $url = json_encode($urlClonnedData);
            $survey = null;
        }


        if($request->type == 'survey') {
            $url = null;
        }
        $s = Section::find($id);
        $section = Section::where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'url' => $url,
            'is_bonus' => $request->is_bonus,
            // 'survey' => $survey,
            'type' => $request->type,
        ]);

        if($request->type == 'survey') {
            $s->psurvey()->sync([$request->psurvey => ['on_completion' => 'no']]);
        } else {
            if(isset($request->onCsurvey)){
                $s->psurvey()->sync([$request->onCsurvey => ['on_completion' => 'yes']]);
            }
            else{
                $s->psurvey()->detach();
            }
        }
        if($request->hasFile('section_image') && $request->file('section_image')->isValid()){
            $s->clearMediaCollection('section');
            $s->addMediaFromRequest('section_image')->toMediaCollection('section');
        }

        return redirect($request->input('pre_path'))
            ->with('success', 'Section updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $sec = Section::find($id);
        // $sec->delete();
        // return redirect()->route('admin.programs.index')
        // ->with('success','Section record has been successfully deleted!');
    }

    public function addQues(Request $request)
    {
        // dd('here');
        $index = $request->has("index") ? $request["index"] : 0;
        $question = [
            'question' => '',
            'answer-type' => '',
            'option' => [],
            'order' => '',
            'media' => ''
        ];
        // return view('admin.programs.video', compact('index'));
        return view('admin.program.section.question', ['index' => $index, 'question' => $question]);
    }

    public function addOptions(Request $request)
    {
        $index = $request->has("q_index") ? $request["q_index"] : 0;
        $o_index = $request->has("o_index") ? $request["o_index"] : 0;
        $option = '';

        return view('admin.program.section.options', ['index' => $index, 'o_index' => $o_index, 'option' => $option]);
    }

    public function addLinks(Request $request)
    {
        $index = $request->has("index") ? $request["index"] : 0;
        $psurvey = PSurvey::all();
        $video['name'] = '';
        $video['description'] = '';
        $video['url'] = '';
        return view('admin.program.section.video', ['index' => $index, 'video' => $video, 'psurvey'=> $psurvey]);
    }

}
