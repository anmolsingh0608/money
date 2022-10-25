<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\AssessmentDataTable;
use App\Models\Assessment;
use App\Models\Program;
use App\Models\Exam;
use App\Models\Section;
use App\Models\ProgramType;
use Carbon\Carbon;
use Auth;

class AssessmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AssessmentDataTable $dataTables)
    {
        return $dataTables->render('admin.assessment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Assessment $assessment, $type)
    {
        // dd($type);
        $programs = Program::pluck('title', 'id');
        $exams = Exam::pluck('title', 'id');
        $obj_type = $type;
        $program_types = ProgramType::pluck('title', 'id');
        return view('admin.assessment.create', compact('assessment', 'programs', 'exams', 'obj_type', 'program_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            "obj_id" => "required",
            "exam" => "required",
            "name" => "required",

            // "max_attempts" => "required|numeric",
            "obj_type" => "required"
        ]);
        $date= Carbon::parse($request->released, Auth::user()->timezone)
                ->setTimezone('UTC');
        // dd(isset($request->max_attempts));
        $assessment = new Assessment();
        if($request->has('section')) {
            $assessment->obj_id = $request->section;
            $obj_id = $request->section;
        } else {
            $assessment->obj_id = $request->obj_id;
            $obj_id = $request->obj_id;
        }
        if($request->status == 'active')
        {
            Assessment::where('obj_id', $obj_id)->where('obj_type', $request->obj_type)->update(['status' => 'inactive']);
        }

        $assessment->exam_id = $request->exam;
        $assessment->obj_type = $request->obj_type;
        // $assessment->released = $request->released;
        if(isset($request->max_attempts)) {
            $assessment->max_attempts = $request->max_attempts;
        }

        $assessment->status = $request->status;
        $assessment->name = $request->name;
        $assessment->save();

        return redirect()->route('admin.assessments.index')->with('success', 'Assessment saved successfully');
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
        $assessment = Assessment::find($id);
        $programs = Program::pluck('title', 'id');
        $exams = Exam::pluck('title', 'id');
        $program_types = ProgramType::pluck('title', 'id');
        $sectionId = '';
        $programId = '';
        $sections = '';
        if($assessment->obj_type == "section")
        {
            $sectionId = $assessment->obj_id;
            $section = Section::find($sectionId);
            if(isset($section)) {
                $programId = $section->program_id;
                $sections = Section::where('program_id', $programId)->pluck('name', 'id');
            }
        }
        $exams = Exam::pluck('title', 'id');
        $program_types = ProgramType::pluck('title', 'id');
        return view('admin.assessment.edit', compact('assessment', 'programs', 'exams', 'program_types', 'sectionId', 'programId', 'sections'));
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
        // dd($request->all());
        $validated = $request->validate([
            "obj_id" => "required",
            "exam" => "required",
            "name" => "required",
            // "max_attempts" => "required|numeric",
            "obj_type" => "required"
        ]);

        if($request->has('section')) {
            $obj_id = $request->section;
        } else {
            $obj_id = $request->obj_id;
        }
        // dd($obj_id);
        if($request->status == 'active')
        {
            Assessment::where('obj_id', $obj_id)->where('obj_type', $request->obj_type)->update(['status' => 'inactive']);
        }

        if(isset($request->max_attempts))
        {
            $max_attempts = $request->max_attempts;
        }
        else
        {
            $max_attempts = '999';
        }
        // dd($max_attempts);

        Assessment::where('id', $id)->update([
            'obj_id' => $obj_id,
            'obj_type' => $request->obj_type,
            'exam_id' => $request->exam,
            // 'released' => $request->released,
            'max_attempts' => $max_attempts,
            'status' => $request->status,
            'name' => $request->name,
        ]);

        return redirect()->route('admin.assessments.index')->with('success', 'Assessment saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $assessment = Assessment::find($id);
        // $assessment->delete();
        // return redirect()->route('admin.assessments.index')
        // ->with('success','Assessment record has been successfully deleted!');
    }

    public function list()
    {
        return view('admin.assessment.list');
    }

    public function getSections($id)
    {
        $sections = Section::where('program_id', $id)->pluck('name', 'id');
        return response()->json($sections);
    }
}
