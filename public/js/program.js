$(document).ready(function () {

    function overallBindings(marker, markers, url) {
        let addMarker = $('#add-' + marker)
        console.log(addMarker);
        if (addMarker.length > 0) {
            addMarker.on("click", function () {
                $('#section-type').hide();
                let indexElem = $('#section-index')
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
                        $('.list-sections').append(response);
                        elem_index++;
                        $('#section-index').val(elem_index);
                        // var i = 0;
                        // $('.section-order').each(function(){
                        //     i++;
                        //     $(this).text('Section #'+i);
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



    overallBindings("video", "videos", "/admin/programs/add-video-url");
    overallBindings("survey", "surveys", "/admin/programs/add-survey");

    $('#add-section').click(
        function () {
            $('#section-type').show();
        }
    );

    $('.delete-section').click(function () {
        if (confirm('Are you sure ?')) {
            var id = $(this).parents('.row').children('.section-id').val();
            $(this).parents('.row').children('.delete-id').attr('value', id);
            $(this).parents('.row').children('.delete-id').attr('name', 'delete_id[]');
            $(this).parents('.row').first().hide();
        }
    });

    $(document).mouseup(function (e) {
        var container = $("#section-type");

        // If the target of the click isn't the container
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.hide();
        }
    });

    $('.btn-close').click(function () {
        $('#section-type').hide();
    });

    $('.list-sections').on("click", ".delete-row", function () {
        if (confirm('Are you sure ?')) {
            $(this).parents(".row").first().remove();
            let indexElem = $('#section-index');
            let elem_index = indexElem.val();
            elem_index--;
            $('#section-index').val(elem_index);
            var i = 0;
            $('.section-order').each(function(){
                i++;
                $(this).text('Section #'+i);
            });
        }
        return false;
    })

    $('.list-questions').on("click", ".remove-question", function(){
        if (confirm('Are you sure ?')) {
            $(this).parents(".row").first().remove();
            var i = 0;
            $('.question-order').each(function(){
                i++;
                $(this).text('Question #'+i);
            });
        }
    });

    $('.sections-container-list').sortable({
        cursor: 'move',
        opacity: 0.6,
        update: function() {
            sendOrderToServer();
        }
    });

    function sendOrderToServer() {
        var order = [];
        $('.sections-container-list .row').each(function(index, element) {
            $(this).children('.section-sequence').val(index+1);
        });
    }

});
