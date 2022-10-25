<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Assessment;
use App\Models\Section;
use App\Models\User;
use App\Models\Progress;
use App\Models\Exam;
use App\Models\Survey;
use App\Models\Attempt;
use Auth;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\SecondaryProgress;
use phpDocumentor\Reflection\Types\Null_;

class DashboardController extends Controller
{
    public function user(User $user)
    {
        $p_ids = [];
        $program = Program::select('*')
            ->where('status', '=', 'active')
            ->get();
        // dd($program);
        // $user= User::all();
        $userId = Auth::id();
        $progress = Progress::where('user_id', $userId)->get();
        foreach ($program as $key => $prog) {
            if (!$progress->isEmpty()) {
                foreach ($progress as $k => $p) {
                    if ($prog->id == $p->program_id) {
                        // $program[$key]->progress = round($p->percentage, 0);
                        $sectionIds = $p->section_id;
                        $savedSection = [];
                        $sectionArray = json_decode($sectionIds, true);
                        if(!is_array($sectionArray)) {
                            $savedSection[] = $sectionArray;
                        } else {
                            $savedSection = $sectionArray;
                        }
                        $total = Section::where('program_id', $prog->id)->where('is_bonus', 'no')->count();
                        // $done = Section::where('program_id', $prog->id)->where('id', '<=', $sectionId)->count();
                        $done = count($savedSection);
                        // dd($done);
                        $percentage = (100 / $total) * $done;
                        $program[$key]->progress = round($percentage, 0);
                    } else {
                        // $program[$key]->progress = 0;
                    }
                }
            } else {
                $program[$key]->progress = 0;
            }
            $p_ids[] = $prog->id;
        }
        // dd($p_ids);
        $userData = User::find($userId);
        $program_type = $userData->program;
        $program_count = Program::where('program_type', $program_type)->where('status', 'active')->count();
        $progress_count = Progress::where('user_id', $userId)->where('status', 'complete')->whereIn('program_id', $p_ids)->count();
        $per = Progress::select('*')
                ->where('user_id', '=', $userId)
                ->get();
        $a = 0;
        $c = count($per);
        foreach ($per as $key => $value) {
            $total = Section::where('program_id', $value['program_id'])->where('is_bonus', 'no')->count();
            $temp = [];
            $sectionData = json_decode($value['section_id'], true);
            if(!is_array($sectionData)) {
                $temp[] = $sectionData;
            } else {
                $temp = $sectionData;
            }
            $done = count($temp);
            $percentage = (100 / $total) * $done;
            $a += $percentage;
        }
        if($c == 0){
            $c = 1;
        }
        if($program_count > 0)
        {
            $final_per = ($a/$program_count);
        }
        else
        {
            $final_per = 0;
        }
        $exam = '';
        $assessment_id = 0;
        if ($program_count == $progress_count) {
            $exam_row = Assessment::where('obj_id', $program_type)->where('obj_type', 'program_type')->where('released', null)->where('status', 'active')->get();
            // dd($exam_row[0]->exam_id);
            if (!$exam_row->isEmpty()) {
                $exam = Exam::where('id', $exam_row[0]->exam_id)->get();
                // dd($exam[0]->question);
                $assessment_id = $exam_row[0]->id;
            }
        }

        if ($progress_count == '0' || $program_count == 0) {
            $progressMeter = 0;
        } else {
            $progressMeter = (100 / $program_count) * $progress_count;
        }
        // dd($progressMeter);
        $leftover = 100 - $progressMeter;

        $a_id = Assessment::where('obj_type', 'program_type')->where('obj_id', $program_type)->where('status', 'active')->get('id');
        if(count($a_id) == 0)
        {
            $attempts = 0;
        }
        else
        {
            $attempts = Attempt::where('user_id', $userId)->where('assessment_id', $a_id[0]->id)->count();
        }

        $secProgress = SecondaryProgress::select('*')
                ->where('user_id', '=', $userId)
                ->get();

        $secondary_programs = Program::where('program_type', '<>', Auth::user()->program)->where('status', '=', 'active')->get();
        $combined_ptg = $final_per;
        if (!$secProgress->isEmpty()) {
            $ptg = 0;
            foreach ($secProgress as $key => $value) {
                $ttl = Section::where('program_id', $value['program_id'])->where('is_bonus', 'no')->count();
                $tmp = [];
                $secData = json_decode($value['section_id'], true);
                if(!is_array($secData)) {
                    $tmp[] = $secData;
                } else {
                    $tmp = $secData;
                }
                $finished = count($tmp);

                $prcntage = (100 / $ttl) * $finished;
                $ptg += $prcntage;
            }
            $program_count = Program::where('program_type', '<>',$program_type)->where('status', 'active')->count();
            if($program_count > 0)
            {
                $final_ptg = ($ptg/$program_count);
            }
            else
            {
                $final_ptg = 0;
            }
            $combined_ptg = ($final_ptg + $final_per)/2;
        }

        foreach ($secondary_programs as $key => $prog) {
            if (!$secProgress->isEmpty()) {
                foreach ($secProgress as $k => $p) {
                    if ($prog->id == $p->program_id) {
                        // $program[$key]->progress = round($p->percentage, 0);
                        $sectionIds = $p->section_id;
                        $savedSection = [];
                        $sectionArray = json_decode($sectionIds, true);
                        if(!is_array($sectionArray)) {
                            $savedSection[] = $sectionArray;
                        } else {
                            $savedSection = $sectionArray;
                        }
                        $total = Section::where('program_id', $prog->id)->where('is_bonus', 'no')->count();
                        // $done = Section::where('program_id', $prog->id)->where('id', '<=', $sectionId)->count();
                        $done = count($savedSection);
                        $percentage = (100 / $total) * $done;
                        $secondary_programs[$key]->progress = round($percentage, 0);
                    } else {
                        // $program[$key]->progress = 0;
                    }
                }
            } else {
                $secondary_programs[$key]->progress = 0;
            }
            $p_ids[] = $prog->id;
        }
        return view('user.dashboard', compact('user', 'program', 'progress', 'exam', 'progressMeter', 'assessment_id', 'leftover', 'attempts', 'final_per', 'combined_ptg', 'secondary_programs'));
    }
    public function program($id)
    {
        $p_type = Auth::user()->program;
        $match = Program::where('id', '=', $id)->count();
        if ($match == 1) {
            $section = Section::select('*')
                ->where('program_id', '=', $id)
                ->get();

            $program = Program::find($id);
            if ($program->status == "active") {
                $userId = Auth::id();
                $progress = Progress::where('user_id', $userId)->where('program_id', $id)->get();
                if($program->program_type == $p_type) {
                    if ($progress->isEmpty()) {
                        $total = Section::where('program_id', $id)->where('is_bonus', 'no')->count();
                        $done = 0;
                        if ($total != 0) {
                            $percentage = (100 / $total) * $done;
                        } else {
                            $percentage = 0;
                        }
                    } else {
                        $sectionId = json_decode($progress[0]->section_id, true);
                        $total = Section::where('program_id', $id)->where('is_bonus', 'no')->count();
                        $temp = [];
                        if(!is_array($sectionId)) {
                            $temp[] = $sectionId;
                        } else {
                            $temp = $sectionId;
                        }
                        $done = count($temp);
                        $percentage = (100 / $total) * $done;
                    }
                } else {
                    $s_progress = SecondaryProgress::where('user_id', $userId)->where('program_id', $id)->get();
                    if ($s_progress->isEmpty()) {
                        $total = Section::where('program_id', $id)->where('is_bonus', 'no')->count();
                        $done = 0;
                        if ($total != 0) {
                            $percentage = (100 / $total) * $done;
                        } else {
                            $percentage = 0;
                        }
                    } else {
                        $sectionId = json_decode($s_progress[0]->section_id, true);
                        $total = Section::where('program_id', $id)->where('is_bonus', 'no')->count();
                        $temp = [];
                        if(!is_array($sectionId)) {
                            $temp[] = $sectionId;
                        } else {
                            $temp = $sectionId;
                        }
                        $done = count($temp);
                        $percentage = (100 / $total) * $done;
                    }
                }
                $percentage = round($percentage, 0);
                $section = Section::select('*')
                    ->where('program_id', '=', $id)
                    ->orderBy('sequence')->get();

                $program = Program::find($id);

                $userData = User::find($userId);

                $progress_count = Progress::where('user_id', $userId)->where('program_id', $id)->where('status', 'complete')->get();

                $exam = '';
                $assessment_id = 0;
                if (!$progress_count->isEmpty()) {
                    $exam_row = Assessment::where('obj_id', $id)->where('obj_type', 'program')->where('status', 'active')->get();
                    if (!$exam_row->isEmpty()) {
                        $exam = Exam::where('id', $exam_row[0]->exam_id)->get();
                        $assessment_id = $exam_row[0]->id;
                    }
                }

                return view('user.program', compact('program', 'section', 'total', 'done', 'percentage', 'exam', 'assessment_id','id', ));
            }
            else
            {
                return view('user.error');
            }
        }
        else {
            return view('user.error');
        }
    }
    public function section($p_id, $id)
    {
        $match = Section::where('id', '=', $id)->count();
        $program = Section::select('program_id')
            ->where('id', '=', $id)
            ->first();
        $programs = Program::find($p_id);
        // dd($programs->program_type);
        if(isset($programs->program_type))
        {
            $ptype = $programs->program_type;
        }
        else{
            $ptype = null;
        }
        // dd($ptype);
        // if (Auth::user()->program == $ptype)
        // {
        // dd($programs->program_type);

            if (($match == 1) && ($program->program_id == $p_id)) {
                $survey = Survey::select('*')
                    ->where('section_id', '=', $id)
                    ->where('user_id', '=', Auth::id())
                    ->get();
                $program = Section::select('program_id')
                    ->where('id', '=', $id)
                    ->first();
                $sections = Section::select('*')
                    ->where('program_id', '=', $program['program_id'])
                    ->get();
                $section = Section::find($id);
                $programw = \App\Models\Program::find($program['program_id']);
                $next = $programw->sections->sortBy("id")->where("id", ">", $id)->first();
                // $progress = new Progress();
                $userId = Auth::id();
                $programId = $program->program_id;
                // $progress->user_id = $userId;
                // $progress->program_id = $programId;
                // $progress->section_id = $id;
                // if ($next == null) {
                //     $status = 'complete';
                // } else {
                //     $status = 'inprogress';
                // }
                // $progress->save();
                $userId = Auth::id();
                $progress = Progress::where('user_id', $userId)->where('program_id', $programId)->get();
                if (!$progress->isEmpty()) {
                    $sectionId = $progress[0]->section_id;
                } else {
                    $sectionId = 0;
                }
                // if ($id <= $sectionId) {
                //     dd('dont do');
                // } else {
                    // $total = Section::where('program_id', $programId)->count();
                    // $done = Section::where('program_id', $programId)->where('id', '<=', $id)->count();
                    // $percentage = (100 / $total) * $done;
                    $program_type = Program ::find($programId);
                    $program_user_type = User ::find($userId);


                    if($program_user_type['program'] == $program_type['program_type']){
                        $sectionsArray = [];
                        $sectionsArray[] = (int)$id;
                        $sectionIds = '';
                        if(isset($progress[0]->status))
                        {
                            $check = $progress[0]->status;
                        }
                        else
                        {
                            $check = '';
                        }
                        $sectionIds = Progress::where('user_id', $userId)->where('program_id', $programId)->where('status', 'inprogress')->get('section_id');

                        if(!empty($sectionIds[0]))
                        {
                            $savedSection = json_decode($sectionIds[0]->getoriginal('section_id'), true);
                            if(!is_array($savedSection)) {
                                $savedSections[] = $savedSection;
                                foreach($savedSections as $s)
                                {
                                    if(!in_array($s, $sectionsArray))
                                    {
                                        $sectionsArray[] = $s;
                                    }
                                }
                            }
                            else{
                                foreach($savedSection as $s)
                                {
                                    if(!in_array($s, $sectionsArray))
                                    {
                                        $sectionsArray[] = $s;
                                    }
                                }
                            }
                        }
                        // dd(json_encode($sectionsArray));
                        $total = Section::where('program_id', $programId)->where('is_bonus', 'no')->count();
                        $done = count($sectionsArray);
                        $percentage = (100 / $total) * $done;
                        if ($percentage == '100') {
                            $status = 'complete';
                        } else {
                            $status = 'inprogress';
                        }
                        // dd($sectionsArray);
                        if($check != 'complete')
                        {
                            if($section->type == 'survey')
                            {
                                if($section->is_bonus == 'no')
                                {
                                    Progress::updateOrCreate(
                                        ['user_id' => $userId, 'program_id' => $programId, 'status' => 'inprogress'],
                                        ['user_id' => $userId, 'program_id' => $programId, 'section_id' => json_encode($sectionsArray), 'status' => $status, 'percentage' => $percentage]
                                    );
                                }
                            }
                        }
                    }
                    else {
                        $sProgress = SecondaryProgress::where('user_id', $userId)->where('program_id', $programId)->get();
                        if (!$sProgress->isEmpty()) {
                            $sectionId = $sProgress[0]->section_id;
                        } else {
                            $sectionId = 0;
                        }
                        $sectionsArray = [];
                        $sectionsArray[] = (int)$id;
                        $sectionIds = '';
                        if(isset($sProgress[0]->status))
                        {
                            $check = $sProgress[0]->status;
                        }
                        else
                        {
                            $check = '';
                        }
                        $sectionIds = SecondaryProgress::where('user_id', $userId)->where('program_id', $programId)->where('status', 'inprogress')->get('section_id');

                        if(!empty($sectionIds[0]))
                        {
                            $savedSection = json_decode($sectionIds[0]->getoriginal('section_id'), true);
                            if(!is_array($savedSection)) {
                                $savedSections[] = $savedSection;
                                foreach($savedSections as $s)
                                {
                                    if(!in_array($s, $sectionsArray))
                                    {
                                        $sectionsArray[] = $s;
                                    }
                                }
                            }
                            else{
                                foreach($savedSection as $s)
                                {
                                    if(!in_array($s, $sectionsArray))
                                    {
                                        $sectionsArray[] = $s;
                                    }
                                }
                            }
                        }
                        // dd(json_encode($sectionsArray));
                        $total = Section::where('program_id', $programId)->where('is_bonus', 'no')->count();
                        $done = count($sectionsArray);
                        $percentage = (100 / $total) * $done;
                        if ($percentage == '100') {
                            $status = 'complete';
                        } else {
                            $status = 'inprogress';
                        }
                        // dd($sectionsArray);
                        if($check != 'complete')
                        {
                            if($section->type == 'survey')
                            {
                                if($section->is_bonus == 'no')
                                {
                                    SecondaryProgress::updateOrCreate(
                                        ['user_id' => $userId, 'program_id' => $programId, 'status' => 'inprogress'],
                                        ['user_id' => $userId, 'program_id' => $programId, 'section_id' => json_encode($sectionsArray), 'status' => $status, 'percentage' => $percentage]
                                    );
                                }
                            }
                        }
                    }
                // }
                $exam = '';
                $assessment_id = 0;
                $exam_row = Assessment::where('obj_id', $id)->where('obj_type', 'section')->where('released', null)->where('status', 'active')->get();
                if (!$exam_row->isEmpty()) {
                    $exam = Exam::where('id', $exam_row[0]->exam_id)->get();
                    // dd($exam[0]->question);
                    $assessment_id = $exam_row[0]->id;
                }

                $p_ids = Program::where('status', 'active')->pluck('id')->toArray();
                $userData = User::find($userId);
                $program_type = $userData->program;
                $program_count = Program::where('program_type', $program_type)->where('status', 'active')->count();
                $progress_count = Progress::where('user_id', $userId)->where('status', 'complete')->whereIn('program_id', $p_ids)->count();

                $final_exam = '';
                $final_assessment_id = 0;
                if ($program_count == $progress_count) {
                    $final_exam_row = Assessment::where('obj_id', $program_type)->where('obj_type', 'program_type')->where('released', null)->where('status', 'active')->get();
                    if (!$final_exam_row->isEmpty()) {
                        $final_exam = Exam::where('id', $final_exam_row[0]->exam_id)->get();
                        $final_assessment_id = $final_exam_row[0]->id;
                    }
                }

                $videos = Video::where('user_id', $userId)
                    ->where('program_id', $p_id)
                    ->where('section_id', $id)
                    ->first();
                if(is_null($videos)){
                    $videosArr = [];
                } else {
                    $videosArr = json_decode($videos->videos);
                }
                return view('user.section', compact('section', 'sections', 'next', 'survey', 'exam', 'assessment_id', 'p_id', 'id', 'videosArr', 'final_exam', 'final_assessment_id'));
            }
            else {
                return view('user.error');
            }
        // }

        // else {
        //     return view('user.error');
        // }
    }
    public function thankyou($id)
    {
        $survey_count = Survey::where('section_id', '=', $id)->count();
        $section_count = Section::where('id', '=', $id)->count();

        // dd($section_count);
        if ($survey_count >= 1 && $section_count == 1 ) {
            $program = Section::select('program_id')
                ->where('id', '=', $id)
                ->first();
            $p_id = $program->program_id;
            $sections = Section::select('*')
                ->where('program_id', '=', $program['program_id'])
                ->get();
            $section = Section::find($id);
            $programw = \App\Models\Program::find($program['program_id']);
            $next = $programw->sections->sortBy("id")->where("id", ">", $id)->first();
            return view('user.thankyou', compact('sections', 'next', 'id','p_id'));
        } else {
            return view('user.error');
        }
    }
    public function needhelp(){
        return view('user.needhelp');
    }
    public function know(){
        return view('user.know');
    }

    public function progressSave(Request $request)
    {
        $userId = Auth::id();

        $program = Section::select('program_id')
            ->where('id', '=', $request->s_id)
            ->first();
        $section = Section::find($request->s_id);
        $programId = $program->program_id;

        $progress = Progress::where('user_id', $userId)->where('program_id', $programId)->get();
        if (!$progress->isEmpty()) {
            $sectionId = $progress[0]->section_id;
        } else {
            $sectionId = 0;
        }

        $program_type = Program::find($request->p_id);
        $program_user_type = User::find($userId);

        if($program_user_type['program'] == $program_type['program_type']){
            $sectionsArray = [];
            $sectionsArray[] = (int)$request->s_id;
            $sectionIds = '';
            if(isset($progress[0]->status))
            {
                $check = $progress[0]->status;
            }
            else
            {
                $check = '';
            }
            $sectionIds = Progress::where('user_id', $userId)->where('program_id', $programId)->where('status', 'inprogress')->get('section_id');

            if(!empty($sectionIds[0]))
            {
                $savedSection = json_decode($sectionIds[0]->getoriginal('section_id'), true);
                if(!is_array($savedSection)) {
                    $savedSections[] = $savedSection;
                    foreach($savedSections as $s)
                    {
                        if(!in_array($s, $sectionsArray))
                        {
                            $sectionsArray[] = $s;
                        }
                    }
                }
                else{
                    foreach($savedSection as $s)
                    {
                        if(!in_array($s, $sectionsArray))
                        {
                            $sectionsArray[] = $s;
                        }
                    }
                }
            }
            // dd(json_encode($sectionsArray));
            $total = Section::where('program_id', $programId)->where('is_bonus', 'no')->count();
            $done = count($sectionsArray);
            $percentage = (100 / $total) * $done;
            if ($percentage == '100') {
                $status = 'complete';
            } else {
                $status = 'inprogress';
            }
            // dd($sectionsArray);
            if($check != 'complete')
            {
                if($section->is_bonus == 'no')
                {
                    Progress::updateOrCreate(
                        ['user_id' => $userId, 'program_id' => $programId, 'status' => 'inprogress'],
                        ['user_id' => $userId, 'program_id' => $programId, 'section_id' => json_encode($sectionsArray), 'status' => $status, 'percentage' => $percentage]
                    );
                }
            }
        }
        else {
            $s_progress = SecondaryProgress::where('user_id', $userId)->where('program_id', $programId)->get();
            $sectionsArray = [];
            $sectionsArray[] = (int)$request->s_id;
            $sectionIds = '';
            if(isset($s_progress[0]->status))
            {
                $check = $s_progress[0]->status;
            }
            else
            {
                $check = '';
            }
            $sectionIds = SecondaryProgress::where('user_id', $userId)->where('program_id', $programId)->where('status', 'inprogress')->get('section_id');

            if(!empty($sectionIds[0]))
            {
                $savedSection = json_decode($sectionIds[0]->getoriginal('section_id'), true);
                if(!is_array($savedSection)) {
                    $savedSections[] = $savedSection;
                    foreach($savedSections as $s)
                    {
                        if(!in_array($s, $sectionsArray))
                        {
                            $sectionsArray[] = $s;
                        }
                    }
                }
                else{
                    foreach($savedSection as $s)
                    {
                        if(!in_array($s, $sectionsArray))
                        {
                            $sectionsArray[] = $s;
                        }
                    }
                }
            }
            $total = Section::where('program_id', $programId)->where('is_bonus', 'no')->count();
            $done = count($sectionsArray);
            $percentage = (100 / $total) * $done;
            if ($percentage == '100') {
                $status = 'complete';
            } else {
                $status = 'inprogress';
            }
            // dd($sectionsArray);
            if($check != 'complete')
            {
                if($section->is_bonus == 'no')
                {
                    SecondaryProgress::updateOrCreate(
                        ['user_id' => $userId, 'program_id' => $programId, 'status' => 'inprogress'],
                        ['user_id' => $userId, 'program_id' => $programId, 'section_id' => json_encode($sectionsArray), 'status' => $status, 'percentage' => $percentage]
                    );
                }
            }
        }
        return response()->json(['success'=>$section->is_bonus]);
    }

    public function videoStatus(Request $request){
        $userId = Auth::id();
        $programId = $request->p_id;
        $sectionId = $request->s_id;
        $videoKey = $request->v_id;

        $videos = Video::where('user_id', $userId)
            ->where('program_id', $programId)
            ->where('section_id', $sectionId)
            ->first();

        if(is_null($videos)){
            $vid = new Video();
            $vid->user_id = $userId;
            $vid->program_id = $programId;
            $vid->section_id = $sectionId;
            $videoArray[] = $videoKey;
            $vid->videos = json_encode($videoArray);
            $vid->save();
        } else {
            $videoArr = json_decode($videos->videos);
            if(!in_array($videoKey ,$videoArr)) {
                $videoArr[] = $videoKey;
                $videos->update(['videos' => json_encode($videoArr)]);
            }
        }

        return response()->json(['success'=>$videos]);
    }
}
