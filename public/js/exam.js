$(document).ready(function () {

    function overallBindings(marker, markers, url) {
        let addMarker = $('#add-' + marker)
        console.log(addMarker);
        if (addMarker.length > 0) {
            addMarker.on("click", function () {
                let indexElem = $('#add-questions-index');
                let elem_index = indexElem.val();
                let id = $('#id').val();
                console.log(indexElem);
                $.ajax({
                    url: url,
                    type: 'get',
                    data: {
                        'index': elem_index,
                        'id': id
                    },
                    beforeSend: function () {
                        let max = $('#max_que').val();
                        console.log(max);
                        if(max == elem_index)
                        {
                            alert('All questions are already added.');
                            return false;
                        }
                        $("." + marker + "-processing").show();
                    },
                    success: function (response) {
                        // console.log(response);
                        $('.questions-list-container').append(response);
                        // console.log(response);
                        elem_index++;
                        $('#add-questions-index').val(elem_index);
                    },
                    complete: function () {
                        $("." + marker + "-processing").hide();
                    }
                })
            })

            $('.list-' + markers).on("click", ".delete-row", function () {
                if (confirm('Are you sure ?')) {
                    $(this).parents(".row").first().remove();
                }
                return false;
            })
        }
    }

    overallBindings("question-list", "questions-list", "/admin/exams/add-questions-list");
    overallBindings("feedback-list", "feedbacks-list", "/admin/exams/add-feedbacks-list");

    $('.questions-list-container').on("click", ".remove-question-row", function () {
        if (confirm('Are you sure ?')) {
            let indexElem = $('#add-questions-index');
            let elem_index = indexElem.val();
            elem_index--;
            $('#add-questions-index').val(elem_index);
            $(this).parents(".row").first().remove();
        }
    });
});
