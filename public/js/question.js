$(document).ready(function () {
    function overallBindings(marker, markers, url) {
        let addMarker = $('#add-' + marker)
        console.log(addMarker);
        if (addMarker.length > 0) {
            addMarker.on("click", function () {
                let indexElem = $('#exam-questions-index');
                let elem_index = indexElem.val();
                console.log(indexElem);
                $.ajax({
                    url: url,
                    type: 'get',
                    data: {
                        'index': elem_index
                    },
                    beforeSend: function () {
                        $("." + marker + "-processing").show();
                    },
                    success: function (response) {
                        console.log(response);
                        $('.list-exam-questions').append(response);
                        elem_index++;
                        $('#exam-questions-index').val(elem_index);
                        // $('#options-index').val('0');
                        // var i = 0;
                        // $('.question-order').each(function () {
                        //     i++;
                        //     $(this).text('Question #' + i);
                        // });
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


    function overallBindings_options(marker, markers, url) {
        // let addMarker = $('#add-'+marker)
        // console.log(addMarker);
        // if(addMarker.length > 0) {
        $('.exam-options').on("click", ".add-" + marker, function () {
            // let indexElem = $(this).parents('.row').first().find('.question-exam-number');
            // let q_index = indexElem.val();
            // console.log(q_index);

            let o_index = $(this).parents('.row').first().find('.options-exam-count').val();
            let type = $('.exam-answer-type').val();
            console.log(type);
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    'type': type,
                    'o_index': o_index
                },
                beforeSend: function () {
                    $("." + marker + "-processing").show();
                },
                success: function (response) {
                    console.log(response);
                    $('.list-exam-options').append(response);
                    // let i = 0;
                    // $('.option-order').each(function(){
                    //     i++;
                    //     $(this).text('Option #'+i);
                    // });
                },
                complete: function () {
                    $("." + marker + "-processing").hide();
                }
            })
            o_index++;
            $(this).parents('.row').first().find('.options-exam-count').val(o_index);
        })

        $('.list-' + markers).on("click", ".delete-row", function () {
            if (confirm('Are you sure ?')) {
                $(this).parents(".row").first().remove();
            }
            return false;
        })
        // }
    }

    $('.select-type').on("change", ".exam-answer-type", function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue == 'text') {
                $(this).parents('.row').first().find('#add-exam-option').hide();
                $(this).parents('.row').first().find('.exam-options').hide();
                $(this).parents('.row').first().find('.option-exam').hide();
                $(this).parents('.row').first().find('.exam-answers').show();
                $(this).parents('.row').first().find('.list-exam-answers').show();
                $('#add-exam-answer').show();
                $('.list-exam-answers input').prop('required', true);
                $('.exam-options-container').hide();
                $('.exam-answer-container').show();
                $('.exam-rate').hide();
                $('.exam-rate input').prop('required', false);
                $('.exam-sub-question').hide();
                $('.list-sub-questions').empty();
                $('.exam-feedback').hide();
                $('.list-feedback-options').hide();
                $('.options-feedback-count').val('0');
                $('.exam-feedback-list').remove();
            } else if(optionValue == 'rate') {
                $(this).parents('.row').first().find('#add-exam-option').hide();
                $(this).parents('.row').first().find('.exam-options').hide();
                $(this).parents('.row').first().find('.option-exam').hide();
                $(this).parents('.row').first().find('.exam-answers').hide();
                $(this).parents('.row').first().find('.list-exam-answers').hide();
                $('.exam-rate').show();
                $('#add-exam-answer').hide();
                $('.list-exam-answers input').prop('required', false);
                $('.exam-rate input').prop('required', true);
                $('#add-exam-answer').hide();
                $('.list-exam-answers input').prop('required', false);
                $('.exam-options-container').hide();
                $('.exam-answer-container').hide();
                $('.exam-sub-question').hide();
                $('.list-sub-questions').empty();
                $('.exam-feedback').hide();
                $('.list-feedback-options').hide();
                $('.options-feedback-count').val('0');
                $('.exam-feedback-list').remove();
            } else if(optionValue == 'grid') {
                console.log('here');
                $(this).parents('.row').first().find('#add-exam-option').hide();
                $(this).parents('.row').first().find('.exam-options').hide();
                $(this).parents('.row').first().find('.option-exam').hide();
                $(this).parents('.row').first().find('.exam-answers').hide();
                $(this).parents('.row').first().find('.list-exam-answers').hide();
                $('.exam-rate').hide();
                $('.exam-rate input').prop('required', false);
                $('#add-exam-answer').hide();
                $('.list-exam-answers input').prop('required', false);
                $('.exam-rate input').prop('required', false);
                $('#add-exam-answer').hide();
                $('.list-exam-answers input').prop('required', false);
                $('.exam-options-container').hide();
                $('.exam-answer-container').hide();
                $('.exam-sub-question').show();
                $('.exam-feedback').hide();
                $('.list-feedback-options').hide();
                $('.options-feedback-count').val('0');
                $('.exam-feedback-list').remove();

            } else if(optionValue == 'feedback') {
                $(this).parents('.row').first().find('#add-exam-option').hide();
                $(this).parents('.row').first().find('.exam-options').hide();
                $(this).parents('.row').first().find('.option-exam').hide();
                $(this).parents('.row').first().find('.exam-answers').hide();
                $(this).parents('.row').first().find('.list-exam-answers').hide();
                $('.exam-rate').hide();
                $('#add-exam-answer').hide();
                $('.list-exam-answers input').prop('required', false);
                $('.exam-rate input').prop('required', false);
                $('#add-exam-answer').hide();
                $('.list-exam-answers input').prop('required', false);
                $('.exam-options-container').hide();
                $('.exam-answer-container').hide();
                $('.exam-sub-question').hide();
                $('.list-sub-questions').empty();
                $('.exam-feedback').show();
                $('.list-feedback-options').show();
            }
            else {
                $(this).parents('.row').first().find('#add-exam-option').show();
                $(this).parents('.row').first().find('.exam-options').show();
                $(this).parents('.row').first().find('.option-exam').show();
                $(this).parents('.row').first().find('.exam-answers').hide();
                $(this).parents('.row').first().find('.list-exam-answers').hide();
                $('#add-exam-answer').hide();
                $('.list-exam-answers input').prop('required', false);
                $('.exam-answers-list').remove();
                $('.answers-exam-count').val('0');
                $('.exam-options-container').show();
                $('.exam-rate').hide();
                $('.exam-rate input').prop('required', false);
                $('.exam-answer-container').hide();
                $('.exam-sub-question').hide();
                $('.list-sub-questions').empty();
                $('.exam-feedback').hide();
                $('.list-feedback-options').hide();
                $('.options-feedback-count').val('0');
                $('.exam-feedback-list').remove();
            }
            $('.exam-options-list').remove();
            $('.options-exam-count').val('0');
            $('.sub-question-count').val('0');
        });
    }).change();

    $('.list-exam-options').on("click", ".remove-exam-option", function(){
        if (confirm('Are you sure ?')) {
            $(this).parents(".row").first().remove();
        }
    });


    overallBindings("exam-question", "exam-questions", "/admin/questions/add-exam-question");
    overallBindings_options("exam-option", "exam-options", "/admin/questions/add-exam-options");

    function textAnswer(marker, markers, url) {
        let addMarker = $('#add-' + marker)
        console.log(addMarker);
        if (addMarker.length > 0) {
            addMarker.on("click", function () {
                let indexElem = $('.answers-exam-count');
                let elem_index = indexElem.val();
                console.log(elem_index);
                $.ajax({
                    url: url,
                    type: 'get',
                    data: {
                        'index': elem_index
                    },
                    beforeSend: function () {
                        $("." + marker + "-processing").show();
                    },
                    success: function (response) {
                        console.log(response);
                        $('.list-exam-answers').append(response);
                        elem_index++;
                        $('.answers-exam-count').val(elem_index);
                    },
                    complete: function () {
                        $("." + marker + "-processing").hide();
                    }
                })
            })

            $('.list-' + markers).on("click", ".remove-exam-answer", function () {
                if (confirm('Are you sure ?')) {
                    $(this).parents(".row").first().remove();
                }
                return false;
            })
        }
    }

    textAnswer("exam-answer", "exam-answers", "/admin/questions/add-exam-answer");


    function textAnswer(marker, markers, url) {
        let addMarker = $('#add-' + marker)
        console.log(addMarker);
        if (addMarker.length > 0) {
            addMarker.on("click", function () {
                let indexElem = $('.answers-exam-count');
                let elem_index = indexElem.val();
                console.log(elem_index);
                $.ajax({
                    url: url,
                    type: 'get',
                    data: {
                        'index': elem_index
                    },
                    beforeSend: function () {
                        $("." + marker + "-processing").show();
                    },
                    success: function (response) {
                        console.log(response);
                        $('.list-exam-answers').append(response);
                        elem_index++;
                        $('.answers-exam-count').val(elem_index);
                    },
                    complete: function () {
                        $("." + marker + "-processing").hide();
                    }
                })
            })

            $('.list-' + markers).on("click", ".remove-exam-answer", function () {
                if (confirm('Are you sure ?')) {
                    $(this).parents(".row").first().remove();
                }
                return false;
            })
        }
    }

    function gridQuestion(marker, markers, url) {
        let addMarker = $('#add-' + marker)
        console.log(addMarker);
        if (addMarker.length > 0) {
            addMarker.on("click", function () {
                let indexElem = $('.sub-question-count');
                let elem_index = indexElem.val();
                let realIndex = indexElem.val();
                console.log(elem_index);
                $.ajax({
                    url: url,
                    type: 'get',
                    data: {
                        'index': elem_index
                    },
                    beforeSend: function () {
                        $("." + marker + "-processing").show();
                    },
                    success: function (response) {
                        // console.log(response);
                        $('.list-'+markers).append(response);
                        elem_index++;
                        $('.sub-question-count').val(elem_index);
                    },
                    complete: function () {
                        // $("." + marker + "-processing").hide();
                        if(indexElem.val() > 1)
                        {
                            let val = $('.list-sub-options').first().find('input:checked').val();
                            if($('.list-sub-options').first().find('input:checked').length > 0)
                            {
                                let val = $('.list-sub-options').first().find('input:checked').val();
                                $('.list-sub-options').first().find('input[value = "'+ val +'"]').attr('checked');
                            }
                            var html = $('.list-sub-options').first().clone();

                            $('.sub-opt').last().html(html);
                            //disable inputs

                            var container = $('.sub-opt').last();
                            container.children('.list-sub-options').find('input[type="text"]').attr('disabled', 'disabled');
                            container.children('.list-sub-options').find('input[type="radio"]').attr('name', 'sque['+realIndex+'][answer]');
                            container.children('.list-sub-options').find('input[type="checkbox"]').attr('name', 'sque['+realIndex+'][answer][]');
                            $('.list-sub-options').first().find('input[type="text"]').keyup(function(){
                                let name = $(event.target).attr('name');
                                $('input[name="'+name+'"]').val($(event.target).val());
                            });
                            console.log($('.list-sub-options').first().find('input[value = "'+ val +'"]'));
                            $('.list-sub-options').first().find('input[value = "'+ val +'"]').prop('checked', true);
                        }
                    }
                })
            })

            $('.list-' + markers).on("click", ".remove", function () {
                if (confirm('Are you sure ?')) {
                    $(this).parents(".row").first().next().remove();
                    $(this).parents(".row").first().remove();
                }
                return false;
            })
        }
    }


    function subOptions(marker, markers, url) {
        let addMarker = $('#add-' + marker)
        console.log('here');
        if (addMarker.length > 0) {
            addMarker.on("click", function () {
                let indexElem = $('.sub-options-count');
                let elem_index = indexElem.val();
                console.log('elem_index');
                $.ajax({
                    url: url,
                    type: 'get',
                    data: {
                        'index': elem_index
                    },
                    beforeSend: function () {
                        $("." + marker + "-processing").show();
                    },
                    success: function (response) {
                        console.log(response);
                        $('.list-'+markers).append(response);
                        elem_index++;
                        $('.sub-options-count').val(elem_index);
                    },
                    complete: function () {
                        $("." + marker + "-processing").hide();
                    }
                })
            })

            // $('.list-' + markers).on("click", ".remove", function () {
            //     if (confirm('Are you sure ?')) {
            //         $(this).parents(".row").first().remove();
            //     }
            //     return false;
            // });
        }
    }

    function feedback_options(marker, markers, url) {
        let addMarker = $('#add-'+marker)
        // console.log(addMarker);
        if(addMarker.length > 0) {
            addMarker.on("click", function () {
            let indexElem = $('.options-feedback-count');
            let elem_index = indexElem.val();
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    'index': elem_index
                },
                beforeSend: function () {
                    $("." + marker + "-processing").show();
                },
                success: function (response) {
                    console.log(response);
                    $('.list-feedback-options').append(response);
                    elem_index++;
                    $('.options-feedback-count').val(elem_index);
                },
                complete: function () {
                    $("." + marker + "-processing").hide();
                }
            })
        })

        $('.list-' + markers).on("click", ".remove-exam-feedback", function () {
            if (confirm('Are you sure ?')) {
                $(this).parents(".row").first().remove();
            }
            return false;
        })
        }
    }


    feedback_options("exam-feedback", "feedback-options", "/admin/questions/add-feedback-option");


    gridQuestion("sub-question", "sub-questions", "/admin/questions/add-sub-question");
    // subOptions("sub-option", "sub-options", "/admin/questions/add-sub-option");

    $('.sub-question-type').change(function(){
        $('.list-sub-options').empty();
    });

    $('.list-sub-questions').on("click", ".remove-exam-option", function () {
        if (confirm('Are you sure ?')) {
            let name = $(this).parents(".row").first().find('input').first().attr('name');
            $('input[name="'+ name +'"]').parents(".exam-options-list").remove();
            // $(this).parents(".row").first().remove();
        }
        return false;
    });
});

$(window).bind("load", function() {
    var container = $('.sub-opt').slice(1);
    // console.log(container);
    container.children('.list-sub-options').find('input[type="text"]').attr('disabled', 'disabled');
    // container.children('.list-sub-options').find('input[type="radio"]').attr('name', 'sque['+elem_index+'][answer]');
    container.each(function(index,element){
        let count = $(element).parent().children('.hidden-index').val();
        $(element).children('.list-sub-options').find('input[type="radio"]').attr('name', 'sque['+count+'][answer]');
        $('.list-sub-options').first().find('input[type="text"]').keyup(function(){
            let name = $(event.target).attr('name');
            $('input[name="'+name+'"]').val($(event.target).val());
        });
    });

    $('.sub-opt').first().children('.list-sub-options').find('input[type="radio"]').attr('name', 'sque['+$('.sub-opt').first().parent().children('.hidden-index').val()+'][answer]');
});
