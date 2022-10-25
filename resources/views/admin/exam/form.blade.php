<form method="POST" action="{{ route('admin.exams.store') }}" class="" onsubmit="checkdupl(event)" enctype="multipart/form-data">
    @csrf
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <input type="hidden" id="id" value="{{ $exam->id }}">
    <div class="form-group">
        <label for="">Title <span>*</span></label>
        <input type="text" name="title" id="" class="form form-control" value="{{ old('title', $exam->title) }}"
            required />
    </div>
    <div class="form-group">
        <label for="">Description </label>
        <textarea class="ckeditor form-control" name="description">{{ old('description', $exam->description) }} </textarea>
    </div>
    <div class="form-group">
        <label for="">Total score <span>*</span></label>
        <input id="total" type="number" name="total_score" class="form form-control"
            value="{{ old('total_score', $exam->total_score) }}" min="1" required />
    </div>
    <div class="form-group">
        <label for="">Passing score <span>*</span></label>
        <input id="passing" type="number" name="passing_score" id="" class="form form-control"
            value="{{ old('passing_score', $exam->passing_score) }}" required />
    </div>
    <input type="hidden" value="0" id="add-questions-index">
    <div class="form-group">
        <button type="button" class="btn btn-secondary mt-3" id="add-question-list">Add
            Question
        </button>
        <button type="button" class="btn btn-secondary mt-3" id="add-feedback-list">Add
            FeedBack Question
        </button>
        <div>Worth left = <span id="marks-left">0</span></div>
    </div>
    <div class="form-group">
        <div class="questions-list-container">

        </div>
    </div>
    <div class="form-group">
        <button id="submitBtn" type="submit" class="btn btn-secondary mt-3" disabled="true">Create</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('#total').on('change', function() {
            let totalMarks3 = 0;
            $.each($(".worth option:selected"), function() {
                totalMarks3 += Number($(this).attr("data-marks"));
            });
            let marks3 = Number($('#total').val());
            let marksLeft = marks3 - totalMarks3;
            $('#marks-left').html(marksLeft);
            if (marks3 <= totalMarks3) {
                $('#add-question-list').attr('disabled', marks3 <= totalMarks3);
                $('#submitBtn').attr('disabled', marksLeft !== 0);

                return;
            }
            $('#add-question-list').attr('disabled', false);
            $('#submitBtn').attr('disabled', marksLeft !== 0);

        });


        $('.questions-list-container').on('DOMSubtreeModified', function() {
            let totalMarks = 0;
            $.each($(".worth option:selected"), function() {
                totalMarks += Number($(this).attr("data-marks"));
            });
            let marks1 = Number($('#total').val());
            let marksLeft1 = marks1 - totalMarks;
            $('#marks-left').html(marksLeft1);
            if (marks1 <= totalMarks) {
                $('#add-question-list').attr('disabled', true);
                $('#submitBtn').attr('disabled', marksLeft1 !== 0);

                return;
            }
            $('#add-question-list').attr('disabled', false);
            $('#submitBtn').attr('disabled', marksLeft1 !== 0);


            console.log('adding-onchange');


        });

        $('.questions-list-container').on('change', '.worth', function() {
            console.log('onchange');
            let totalMarks2 = 0;
            $.each($(".worth option:selected"), function() {
                totalMarks2 += Number($(this).attr("data-marks"));

            });
            let marks2 = Number($('#total').val());
            let marksLeft2 = marks2 - totalMarks2;
            $('#marks-left').html(marksLeft2);
            if (marks2 <= totalMarks2) {
                $('#add-question-list').attr('disabled', true);
                $('#submitBtn').attr('disabled', marksLeft2 !== 0);

                return;
            }
            $('#add-question-list').attr('disabled', false);
            $('#submitBtn').attr('disabled', marksLeft2 !== 0);


        });
    });

    function questionListChecker() {

    }
</script>
