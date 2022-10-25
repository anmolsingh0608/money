<?php

namespace App\Http\Controllers;

use App\DataTables\QuestionsDataTable;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(QuestionsDataTable $dataTables)
    {
        return $dataTables->render('admin.question.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Question $question)
    {
        return view('admin.question.create', compact('question'));
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
        $options = [];
        // if($request->has('option'))
        // {
        //     foreach($request->option as $option)
        //     {
        //         $options[] = $option;
        //     }
        // }

        // echo "<pre>";print_r(($request->option));print_r($options);print_r(dd($request->answer));exit;
        $validated = $request->validate([
            'title' => 'required',
            'worth' => 'required|numeric',
            'type' => 'required',
            'que_image' => 'image|mimes:jpg,png,jpeg|max:2048',
        ]);
        // $v = json_encode($request->option);
        // dd(json_decode($v));
        $question = new Question();
        $question->title = $request->title;
        $question->worth = $request->worth;
        $question->type = $request->type;
        $question->description = $request->description;
        $question->url = $request->url;
        $question->options = json_encode($request->option);
        $question->answer = json_encode($request->answer);
        $question->rate = json_encode($request->rate);
        $question->save();

        if($request->type == 'grid') {
            $worth = $request->worth/count($request->sque);
            foreach($request->sque as $key => $que) {
                $ques = new Question();
                $ques->title = $que['title'];
                $ques->worth = $worth;
                $ques->type = $request->sque_type;
                $ques->options = json_encode($request->option);
                $ques->answer = json_encode($request->sque[$key]['answer']);
                $ques->parent_id = $question->id;
                // dd($que['title']);
                $ques->save();
            }
        }

        if($request->hasFile('que_image') && $request->file('que_image')->isValid()){
            $question->addMediaFromRequest('que_image')->toMediaCollection('question');
        }
        return redirect()->route('admin.questions.index')->with('success', 'Question added successfully!');
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
        $question = Question::find($id);
        $question->option = json_decode($question->options, true);
        if($question->type == 'text')
        {
            $question->answers = json_decode($question->answer, true);
        }
        $question->answer = json_decode($question->answer, true);

        return view('admin.question.edit', compact('question'));
        // dd('here');
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
        //dd($request->all());
        $validated = $request->validate([
            'title' => 'required',
            'worth' => 'required|numeric',
            'type' => 'required',
            'que_image' => 'image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // if($request->type == 'text')
        // {
        //     $answer = json_encode($request->answer);
        // }
        // else
        // {
        //     $answer = json_encode($request->answers);
        // }
        // dd($answer);
        $q = Question::find($id);
        $question = Question::where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
            'worth' => $request->worth,
            'type' => $request->type,
            'options' => json_encode($request->option),
            'answer' => json_encode($request->answer),
            'rate' => json_encode($request->rate),
        ]);

        if($request->type == 'grid') {
            $worth = $request->worth/count($request->sque);
            foreach($request->sque as $key => $que) {
                // dd($worth);
                if(array_key_exists('id', $que)){
                    Question::where('id', $que['id'])->update([
                        'title' => $que['title'],
                        'worth' => $worth,
                        'type' => $request->sque_type,
                        'options' => json_encode($request->option),
                        'answer' => json_encode($request->sque[$key]['answer']),
                    ]);
                } else {
                    $ques = new Question();
                    $ques->title = $que['title'];
                    $ques->worth = $worth;
                    $ques->type = $request->sque_type;
                    $ques->options = json_encode($request->option);
                    $ques->answer = json_encode($request->sque[$key]['answer']);
                    $ques->parent_id = $id;
                    // dd($que['title']);
                    $ques->save();
                }
            }
        }

        if($request->hasFile('que_image') && $request->file('que_image')->isValid()){
            $q->clearMediaCollection('question');
            $q->addMediaFromRequest('que_image')->toMediaCollection('question');
        }

        return redirect()->route('admin.questions.index')->with('success', 'Question updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quest = Question::find($id);
        $quest->delete();
        return redirect()->route('admin.questions.index')
        ->with('success','Question record has been successfully deleted!');
    }

    public function addQues(Request $request)
    {
        // dd('here');
        $index = $request->has("index") ? $request["index"] : 0;
        // $question = [
        //     'question' => '',
        //     'answer-type' => '',
        //     'option' => [],
        //     'order' => '',
        //     'media' => ''
        // ];
        // return view('admin.programs.video', compact('index'));
        return view('admin.exam.question', ['index' => $index]);
    }

    public function addOptions(Request $request)
    {
        // $index = $request->has("q_index") ? $request["q_index"] : 0;
        $o_index = $request->has("o_index") ? $request["o_index"] : 0;
        $option = '';
        $type = $request->type;

        return view('admin.exam.options', ['o_index' => $o_index, 'option' => $option, 'type' => $type]);
    }

    public function addAnswers(Request $request)
    {
        $index = $request->has("index") ? $request["index"] : 0;
        $answer = '';
        return view('admin.question.answer', ['index' => $index, 'answer' => $answer]);
    }

    public function addSubQues(Request $request)
    {
        $index = $request->has("index") ? $request["index"] : 0;
        // $answer = '';
        $quest = ['title' => '', 'options' => '', 'id' => ''];
        return view('admin.question.subques', ['index' => $index, 'quest' => $quest/*, 'answer' => $answer*/]);
    }

    public function addSubOpts(Request $request)
    {
        $index = $request->has("index") ? $request["index"] : 0;
        // $answer = '';
        $type = $request->type;
        // dd($type);
        $option = '';
        $answer = [];
        return view('admin.question.options', ['index' => $index, 'type' => $type, 'option' => $option, 'answers' => $answer ]);
    }

    public function addFeedbackOpts(Request $request)
    {
        $index = $request->has("index") ? $request['index'] : 0;

        $option = '';
        return view('admin.question.feedback-options', ['index' => $index, 'option' => $option]);
    }
}
