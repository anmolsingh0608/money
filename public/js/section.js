$(document).ready(function () {

    function overallBindings(marker, markers, url) {
        let addMarker = $('#add-' + marker)
        console.log(addMarker);
        if (addMarker.length > 0) {
            addMarker.on("click", function () {
                let indexElem = $('#questions-index');
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
                        $('.list-questions').append(response);
                        elem_index++;
                        $('#questions-index').val(elem_index);
                        $('#options-index').val('0');
                        var i = 0;
                        $('.question-order').each(function () {
                            i++;
                            $(this).text('Question #' + i);
                        });
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
        $('.list-questions').on("click", ".add-" + marker, function () {
            let indexElem = $(this).parents('.row').first().find('.question-number');
            let q_index = indexElem.val();
            console.log(q_index);

            let o_index = $(this).parents('.row').first().find('.options-count').val();
            console.log(o_index);
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    'q_index': q_index,
                    'o_index': o_index
                },
                beforeSend: function () {
                    $("." + marker + "-processing").show();
                },
                success: function (response) {
                    $('.list-options-Q' + q_index).append(response);
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
            $(this).parents('.row').first().find('.options-count').val(o_index);
        })

        $('.list-' + markers).on("click", ".delete-row", function () {
            if (confirm('Are you sure ?')) {
                $(this).parents(".row").first().remove();
            }
            return false;
        })
        // }
    }

    function addLinks(marker, markers, url)
    {
        let addMarker = $('#add-' + marker)
        console.log(addMarker);
        if (addMarker.length > 0) {
            addMarker.on("click", function () {
                let indexElem = $('#' + markers + '-index');
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
                        $('.list-' + markers).append(response);
                        elem_index++;
                        $('#'+ markers + '-index').val(elem_index);

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
        }
        $('.list-' + markers).on("click", ".remove-link", function () {
            if (confirm('Are you sure ?')) {
                $(this).parents(".main-row").first().remove();
            }
            return false;
        })
    }


    addLinks("video", "links", '/admin/sections/add-links');
    overallBindings("question", "questions", "/admin/sections/add-questions");
    overallBindings_options("option", "options", "/admin/sections/add-options");
    overallBindings_sub_que("sub-que", "sub-ques", "/admin/sections/add-sub-question");
    function overallBindings_sub_que(marker, markers, url) {
        let addMarker = $('.add-' + marker);
        console.log(addMarker);
        // if (addMarker.length > 0) {
            $('.list-questions').on("click", ".add-" + marker, function () {
                let indexElem = $(this).parent().parent().parent().find('.sub-question-count');
                let elem_index = indexElem.val();
                let realIndex = indexElem.val();
                let q_index = $(this).parent().parent().parent().find('.question-number').val();
                let container = $(this).parent().parent().parent().find('.list-'+markers);
                $.ajax({
                    url: url,
                    type: 'get',
                    data: {
                        'index': elem_index,
                        'q_index': q_index,
                    },
                    beforeSend: function () {
                        $("." + marker + "-processing").show();
                    },
                    success: function (response) {
                        container.append(response);
                        elem_index++;
                        container.parent().find('.sub-question-count').val(elem_index);
                    },
                    complete: function () {
                        // $("." + marker + "-processing").hide();
                        if(indexElem.val() > 1)
                        {
                            var html = container.find('.list-sub-options').first().clone();

                            container.find('.sub-opt').last().html(html);
                            //disable inputs

                            var containe = container.find('.sub-opt').last();
                            containe.children('.list-sub-options').find('input[type="text"]').attr('disabled', 'disabled');
                            containe.children('.list-sub-options').find('input[type="radio"]').attr('name', 'sque['+realIndex+'][answer]');
                            containe.children('.list-sub-options').find('input[type="checkbox"]').attr('name', 'sque['+realIndex+'][answer][]');
                            container.find('.list-sub-options').first().find('input[type="text"]').keyup(function(){
                                let name = $(event.target).attr('name');
                                $('input[name="'+name+'"]').val($(event.target).val());
                            });
                            // console.log($('.list-sub-options').first().find('input[value = "'+ val +'"]'));
                            // container.find('.list-sub-options').first().find('input[value = "'+ val +'"]').prop('checked', true);
                        }
                    }
                })
            })

            $('.list-sub-ques').on("click", ".remove", function () {
                if (confirm('Are you sure ?')) {
                    // $(this).parents(".row").first().next().remove();
                    let name = $(this).parents(".row").first().find('input').attr('name');
                    $('input[name="'+ name +'"]').parents('.row.mt-2.exam-options-list').remove();
                }
                return false;
            });

            $('.list-sub-ques').on("click", ".remove-sque", function () {
                if (confirm('Are you sure ?')) {
                    $(this).parents('.row').first().next().remove();
                    $(this).parents('.row').first().remove();
                }
                return false;
            });
        // }
    }

    $('.list-questions').on("change", ".answer-type", function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue == 'text') {
                $(this).parents('.row').first().find('#add-option').hide();
                $(this).parents('.row').first().find('.options').hide();
                $(this).parents('.row').first().find('.options input').attr('required', false);
                $(this).parents('.row').first().find('.captions').remove();
                $(this).parents('.row').first().find('#add-sub-que').hide();
                $(this).parents('.row').first().find('.list-sub-ques').empty();
            } else if(optionValue == 'rating') {
                $(this).parents('.row').first().find('#add-option').hide();
                $(this).parents('.row').first().find('.options').hide();
                $(this).parents('.row').first().find('.options input').attr('required', false);
                $(this).parents('.row').first().find('#add-sub-que').hide();
                $(this).parents('.row').first().find('.list-sub-ques').empty();
                let number = $(this).parents('.row').first().find('.question-number').val();
                let inputs = '<div class="form-group captions"><div class="row"><div class="col-12 col-sm-5"><label>Starting Caption <span>*</span></label><input type="text" name="question['+ number +'][caption][0]" class="form-control" required></div><div class="col-12 col-sm-5"><label>Ending Caption <span>*</span></label><input type="text" name="question['+ number +'][caption][1]" class="form-control" required></div></div></div>';
                if($(this).parents('.row').first().find('.captions').length < 1) {
                    $(this).parents('.row').first().find('.question-opts').append(inputs);
                }
            } else if(optionValue == 'grid') {
                $(this).parents('.row').first().find('#add-option').hide();
                $(this).parents('.row').first().find('.options').hide();
                $(this).parents('.row').first().find('.options input').attr('required', false);
                $(this).parents('.row').first().find('.captions').remove();
                $(this).parents('.row').first().find('#add-sub-que').show();
            } else {
                $(this).parents('.row').first().find('#add-option').show();
                $(this).parents('.row').first().find('.options').show();
                $(this).parents('.row').first().find('.options input').attr('required', true);
                $(this).parents('.row').first().find('.captions').remove();
                $(this).parents('.row').first().find('#add-sub-que').hide();
                $(this).parents('.row').first().find('.list-sub-ques').empty();
            }
        });
    }).change();

    $('.list-questions').on("click", ".remove-option", function () {
        if (confirm('Are you sure ?')) {
            $(this).parents(".row").first().remove();
            var i = 0;
            $('.option-order').each(function () {
                i++;
                $(this).text('Option #' + i);
            });
        }
    });

    $('.user-copy').on("change", "#change-type", function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue == 'video') {
                $('.vid').show();
                $('.vid input').prop('required', true);
                $('.survey-div').hide();
                $('select[name="psurvey"]').prop('required', false);
            } else {
                $('.survey-div').show();
                $('.vid input').prop('required', false);
                $('.vid').hide();
                $('select[name="psurvey"]').prop('required', true);
            }
        });
    }).change();
});
