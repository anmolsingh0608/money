<?php

namespace App\Http\Controllers;

use App\DataTables\ExamsDataTable;
use App\Models\Assessment;
use App\Models\Attempt;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use PDF;
use phpDocumentor\Reflection\Types\Null_;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExamsDataTable $dataTables)
    {
        return $dataTables->render('admin.exam.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Exam $exam)
    {
        return view('admin.exam.add', compact('exam'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required',
            'total_score' => 'required',
            'passing_score' => 'required',
        ]);
        // dd($request->all());
        if(($request->total_score) < ($request->passing_score)){
            return redirect()->back()->with('error', 'Passing mark should less than total score...');
        }
        else{
        $exam = new Exam($request->only('title', 'description', 'total_score', 'passing_score'));
        $exam->save();
        foreach($request->question as $key=>$value){
            $exam->question()->attach($value['id'], ['sequence' => $value['sequence']]);
        }

        return redirect()->route('admin.exams.index')->with('success', 'Exam added successfully!');
        }
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
        $exam = Exam::find($id);
        $examQuestions = $exam->question()->orderBy('sequence')->get();
        $questions = Question::where('parent_id', null)->get();
        $ids = [];
        foreach ($exam->question as $key => $question) {
            $ids[] = $question->id;
        }
        return view('admin.exam.edit', compact('exam', 'questions', 'ids', 'examQuestions'));
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
            'title' => 'required',
            'total_score' => 'required',
            'passing_score' => 'required',
        ]);
        // dd($request->all());
        // $exam = new Exam($request->only('title', 'description', 'total_score', 'passing_score'));
        // $exam->save();
        if(($request->total_score) < ($request->passing_score)){
            return redirect()->back()->with('error', 'Passing mark should less than total score...');
        }
        else{
            $e = Exam::where('id', $id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'total_score' => $request->total_score,
                'passing_score' => $request->passing_score,
            ]);

            $exam = Exam::find($id);
            $question = array();
            foreach($request->question as $key=>$value){
                $question[$value['id']] = ['sequence' => $value['sequence']];
            }
            // print_r($question);exit;
            $exam->question()->sync($question);
            return redirect()->route('admin.exams.index')->with('success', 'Exam updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exam = Exam::find($id);
        $assessment =  Assessment::select('id')
        ->where('exam_id', '=', $id)
        ->get();
        // dd(count($assessment));
        foreach($assessment as $b){
            // $assess = $b['id'];
            $assess = Assessment::find($b['id']);
            $assess->update([
                'status'  => 'inactive',
                'exam_id' =>  0,
            ]);
        }
        // dd($assessment[0]['id']);
        $exam->delete();
        return redirect()->route('admin.exams.index')
        ->with('success','Exam record has been successfully deleted!');
    }
    public function addquest(Request $request)
    {
        $exam = Exam::find($request['id']);
        // dd($request['id']);
        $index = $request->has("index") ? $request["index"] : 0;
        $questions = Question::where('parent_id', null)->where('type', '<>', 'feedback')->get();
        // dd($questions);
        return view('admin.exam.questions-list', ['index' => $index, 'questions' => $questions ]);
    }
    public function addFeedBack(Request $request)
    {
        $exam = Exam::find($request['id']);
        // dd($request['id']);
        $index = $request->has("index") ? $request["index"] : 0;
        $questions = Question::where('parent_id', null)->where('type', 'feedback')->get();
        // dd($questions);
        return view('admin.exam.questions-list', ['index' => $index, 'questions' => $questions ]);
    }

    public function showExam($ass_id, $id)
    {
        // dd($ass_id);
        $exam = Exam::find($id);
        $examQuestions = $exam->question()->orderBy('sequence')->get();
        if($exam == null)
        {
            return redirect()->route('user');
        }
        $assessment = Assessment::find($ass_id);
        if($assessment == null)
        {
            return redirect()->route('user');
        }
        $max_attempts = $assessment->max_attempts;
        $attempts = Attempt::where('user_id', Auth::id())->where('assessment_id', $ass_id)->count();
        // dd($attempts);
        return view('user.exam', compact('exam', 'ass_id', 'attempts', 'max_attempts', 'examQuestions'));
    }

    public function saveExam(Request $request)
    {
        // dd($request->all());
        // $validated = $request->validate([
        //     ''
        // ]);
        $attempt = new Attempt();
        $attempt->user_id = Auth::id();
        $attempt->assessment_id = $request->ass_id;
        $attempt->attempt = ( $request->attempt + 1 );
        $attempt->attempt_date = now();
        $attempt->meta = json_encode($request->question);

        $assessment = Assessment::find($request->ass_id);
        // dd($assessment->exam_id);
        $exam = Exam::find($assessment->exam_id);
        // dd($exam);
        // echo "<pre>";
        // dd($exam->question);
        // print_r($request->question);
        $total_marks = 0;
        // dd($request->question);
        $wrong = [];

        foreach($request->question as $question)
        {
            $id = $question['id'];

            $title = $question['question'];
            if(isset($question['answer']))
            {
                $answer = $question['answer'];
            }
            else
            {
                $answer = [];
            }
            $type = $question['type'];

            // dd($answer);
            foreach($exam->question as $key => $q)
            {
                if($id == $q->id)
                {
                    // dd($answer);
                    // dd(json_decode($q->answer));
                    $options = json_decode($q->options);

                    if($type == 'single')
                    {
                        $q_answer = $options[json_decode($q->answer)];
                        if($answer == $q_answer)
                        {

                            $marks = $q->worth;
                            $total_marks = $total_marks + $marks;
                        }
                        else
                        {
                            $marks = 0;
                            $total_marks = $total_marks + $marks;
                        }
                        $wrong[$key] = $q;
                    }
                    elseif($type == 'multi')
                    {
                        $diff1 = array_diff(json_decode($q->answer), $answer);
                        $diff2 = array_diff($answer, json_decode($q->answer));
                        $diff = array_merge($diff1, $diff2);

                        if(empty($diff))
                        {
                            // dd('right');
                            $marks = $q->worth;
                            $total_marks = $total_marks + $marks;
                        }
                        else
                        {
                            // dd('wrong');
                            $marks = 0;
                            $total_marks = $total_marks + $marks;
                        }
                        $wrong[$key] =  $q;
                    }
                    elseif($type == 'text')
                    {
                        $text_answers = json_decode($q->answer);
                        $match = in_array($answer, $text_answers);
                        // dd($match);
                        if($match)
                        {
                            // dd('right');
                            $marks = $q->worth;
                            $total_marks = $total_marks + $marks;
                        }
                        else
                        {
                            $marks = 0;
                            $total_marks = $total_marks + $marks;
                        }
                        $wrong[$key] =  $q;
                    }
                    elseif($type == 'grid')
                    {
                        // dd($request->all());
                        foreach($question['sque'] as $sKey=> $sQue)
                        {

                            if($sQue['type'] == 'single')
                            {

                                $q_answer = $options[json_decode($q->sub_question[$sKey]->answer)];
                                // if(!isset($sQue['answer'])){ $sQue['answer'] == ''; }

                                if(isset($sQue['answer']) && ($sQue['answer'] == $q_answer))
                                {
                                    $marks = $q->sub_question[$sKey]->worth;
                                    $total_marks = $total_marks + $marks;
                                }
                                else
                                {
                                    $marks = 0;
                                    $total_marks = $total_marks + $marks;
                                }
                                $q['answer'] = $q->sub_question;
                                $wrong[$key]  = $q;
                            }
                            elseif($sQue['type'] == 'multi')
                            {
                                if(!isset($sQue['answer'])){$sQue['answer'] = [];}
                                $diff1 = array_diff(json_decode($q->sub_question[$sKey]->answer), $sQue['answer']);
                                $diff2 = array_diff($sQue['answer'], json_decode($q->sub_question[$sKey]->answer));
                                $diff = array_merge($diff1, $diff2);
                                // dd($sQue);
                                // dd(json_decode($q->sub_question[$sKey]->answer), $sQue['answer']);
                                if(empty($diff))
                                {
                                    // dd('right');
                                    $marks = $q->sub_question[$sKey]->worth;
                                    $total_marks = $total_marks + $marks;
                                }
                                else
                                {
                                    // dd('wrong');
                                    $marks = 0;
                                    $total_marks = $total_marks + $marks;
                                }
                                $q['answer'] = $q->sub_question;
                                $wrong[$key] =   $q;
                            }

                        }

                        // dd($total_marks);
                        // dd($sQue['answer']);
                        // dd($options[json_decode($q->sub_question[$sKey]->answer)]);
                        // dd('here');
                    }
                    elseif($type == 'rate')
                    {
                        $marks = $q->worth;
                        $total_marks = $total_marks + $marks;
                    }
                }

            }

        }

        // dd($wrong);
        // exit;

        $attempt->marks = $total_marks;
        // dd(json_encode($wrong));
        $wrong_ans = json_encode($wrong);
        $attempt->save();
        return redirect()->route('thanks')->with( ['total_marks' => $total_marks, 'wrong' => $wrong_ans, 'assessment' => $assessment]);
    }

    public function pdf()
    {
        $userId = Auth::id();
        $user = Auth::user();
        // dd($user->program);
        $assessment_id = Assessment::where('obj_type', 'program_type')->where('obj_id', $user->program)->where('status', 'active')->get('id');
        // dd($assessment_id[0]->id);
        if(count($assessment_id) == 0)
        {
            $attempts = 0;
        }
        else
        {
            $attempts = Attempt::where('user_id', $userId)->where('assessment_id', $assessment_id[0]->id)->count();
        }
        // dd($attempts);
        if($attempts > 0)
        {
            $data = array(
                'user' => $user,
            );
            $pdf = PDF::loadView('user.certificate', $data);
            User::where('id', $userId)->update([
                'certified' => 'yes'
            ]);
            return $pdf->download('FitMoney.pdf');
        }
        else
        {
            return redirect()->route('user');
        }

    }
}
