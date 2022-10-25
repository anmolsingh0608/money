<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Section;
use App\DataTables\ProgramsDataTable;
use App\Models\ProgramType;
use App\Models\Progress;
use Session;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProgramsDataTable $dataTable)
    {
        // $programs = Program::withCount(['sections'])->get();
        return $dataTable->render('admin.program.index');
        // return view('admin.program.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Program $program)
    {
        $programTypes = ProgramType::pluck('title', 'id');
        return view('admin.program.add', compact('program', 'programTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->section);
        $validated = $request->validate([
            'title' => 'required',
            'status' => 'required',
            'prog_image' => 'image|mimes:jpg,png,jpeg|max:10240',
        ]);

        $program = new Program($request->only('title', 'description', 'status', 'program_type',));
        $program->save();

        if($request->hasFile('prog_image') && $request->file('prog_image')->isValid()){
            $program->addMediaFromRequest('prog_image')->toMediaCollection('program');
        }

        if($request->has('section')) {
            foreach($request->section as $section) {
                $_section = new Section();
                $_section->name = $section['name'];
                $_section->description = $section['description'];
                $_section->type = $section['type'];
                $_section->program_id = $program->id;
                $_section->save();
            }
        }
        // dd($program);
        return redirect()->route('admin.programs.edit', ['program' => $program->id])->with('success', 'Program added successfully!');
        // return redirect()->route('admin.programs.index')->with('success', 'Program added successfully!');
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
        $program = Program::find($id);
        $sections = $program->sections()->orderBy('sequence')->get();
        $programTypes = ProgramType::pluck('title', 'id');
        return view('admin.program.edit', compact('program', 'programTypes', 'sections'));
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
            'title' => 'required',
            'status' => 'required',
            'prog_image' => 'image|mimes:jpg,png,jpeg|max:10240',
        ]);
        $p = Program::find($id);
        $program = Program::where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            // 'program_type' => $request->program_type,

        ]);

        if($request->hasFile('prog_image') && $request->file('prog_image')->isValid()){
            $p->clearMediaCollection('program');
            $p->addMediaFromRequest('prog_image')->toMediaCollection('program');
        }

        if($request->has('delete_id')) {
            $progresses = Progress::where('program_id', $id)->get();
            foreach($progresses as $progress)
            {
                foreach($request->delete_id as $delete_id)
                {
                    if($delete_id >= $progress->section_id)
                    {
                        $count = Section::where('id', '>', $progress->section_id)->where('id', '<', $delete_id)->where('program_id', $id)->count();
                        // dd($count);
                        if($count == 0)
                        {
                            if($delete_id == $progress->section_id)
                            {
                                $previous = Section::where('id', '<', $delete_id)->orderBy('id','desc')->first();
                                Progress::where('id', $progress->id)->update(['section_id' => $previous->id]);
                                // Progress::where('id', $progress->id)->update(['status' => 'complete']);
                            }
                            Progress::where('id', $progress->id)->update(['status' => 'complete']);
                        }
                        else
                        {
                            Progress::where('id', $progress->id)->update(['status' => 'inprogress']);
                        }
                    }
                }
            }
            $ids = $request->delete_id;
            Section::destroy($ids);
        }

        if($request->has('sections')) {
            foreach($request->sections as $s) {
                Section::where('id', $s['id'])->update(['sequence' => $s['sequence']]);
            }
        }

        if($request->has('section')) {
            foreach($request->section as $section) {
                $_section = new Section();
                $_section->name = $section['name'];
                $_section->description = $section['description'];
                $_section->type = $section['type'];
                $_section->program_id = $id;
                $_section->sequence = $section['sequence'];
                $_section->save();
            }
            // $total = Section::where('program_id', $id)->count();
            // $done = Section::where('program_id', $id)->where('id', '<=', $id)->count();
            // $percentage = (100 / $total) * $done;
            Progress::where('program_id', $id)->update(['status' => 'inprogress']);
        }
        return redirect()->route('admin.programs.index')->with('success', 'Program updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         //     $program = Program::find($id);
    //     $section = Section::where('program_id', '=' , $id)->get();
    //     // $section->delete();
    //     $i = 0;
    //     $t = $section->count();
    //     // dd($t);
    //     for($i=0; $i<$t; $i++){
    //        $ids = $section[$i]['id'];
    //        $sec = Section::find($ids);
    //        $sec->delete();
    //     }
    //     $progress = Progress::where('program_id', '=' , $id)->get();
    // //    dd($progress[0]['id']);
    //     $k = $progress->count();
    //     // dd($t);
    //     for($j=0; $j<$k; $j++){
    //        $idp = $progress[$j]['id'];
    //        $progress = Progress::find($idp);
    //        $progress->delete();
    //     }
    //     $program->delete();
    //     return redirect()->route('admin.programs.index')
    //     ->with('success','Program record has been successfully deleted!');
    }

    public function addVideoUrl(Request $request) {
        $index = $request->has("index") ? $request["index"] : 0;
        // return view('admin.programs.video', compact('index'));
        return view('admin.program.video', ['index' => $index]);
    }

    public function addSurvey(Request $request) {
        $index = $request->has("index") ? $request["index"] : 0;
        // return view('admin.programs.video', compact('index'));
        return view('admin.program.survey', ['index' => $index]);
    }

    // public function showSections($id)
    // {
    //     $sections = Section::where('program_id', $id)->get();
    //     return view('admin.program.index_section', compact('sections'));
    // }

    public function editSections($id)
    {
        $section = Section::where('program_id', $id)->get();
        return view('admin.program.edit_section', compact('section'));
    }
}
