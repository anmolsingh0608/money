$(function () {
    domSelector();
    domAcc();
    revealPassword();
});

(function () { })();

$(window).on('load', function () { });

$(window).on('resize', function () { });

function domSelector() {
    if ($('.cta').length > 0) {
        $('.cta').addClass('d-flex justify-content-center')
        $('.cta').find('.icon').addClass('d-flex align-items-center justify-content-center');

    }
    if ($('.card-meta').length > 0) {
        $('.card-meta').find('.box').addClass('bg-white d-flex flex-column shadow-sm text-decoration-none');
        $('.card-meta').find('.badge').addClass('d-flex align-items-center justify-content-center');
    }
    if ($('.acc-box').length > 0) {
        $('.acc-box').find('.acc-head').addClass('shadow-sm bg-white d-flex align-items-center');
        $('.acc-box').find('.acc-content').addClass('shadow-sm bg-white');
    }
}

function domAcc() {
    $('.acc-box .acc-head').on('click', function () {
        if ($(this).parent().hasClass('clicked')) {
            $(this).parent().removeClass('clicked');
            $(this).next().slideUp();
        } else {
            $('.acc-box').removeClass('clicked');
            $('.acc-box .acc-content').slideUp();
            $(this).parent().addClass('clicked');
            $(this).next().slideDown();
        }
    });
}

function revealPassword() {
    $('#revealpass').on('mouseup', function (event) {
        if ($('#password').attr('type') == 'password') {

            $('#password').attr('type', 'text');
            return;
        }
        if ($('#password').attr('type') == 'text') {

            $('#password').attr('type', 'password');
            return;
        }
        event.stopPropagation();
    });
}
checkvalidate = (event) => {
    if ($('div.checkbox-group.required :checkbox').length > 0) {

        if (!$('div.checkbox-group.required :checkbox:checked').length > 0) {
            $('div.checkbox-group.required').addClass('show-err');
            setTimeout(() => {
                $('div.checkbox-group.required').removeClass('show-err');
            }, 5000);
            event.preventDefault();
        }
    }
}

checkans = (event) => {
    if($('.exam-answer-type').val() == 'grid')
    {
        if($('.list-sub-options').is(':empty')) {
            alert('Please add options for the questions.');
            event.preventDefault();
        }

        $('.checkbox').each(function(index,element){ if($('input[name = "'+ $(element).attr('name') +'"]:checked ').length == 0){ alert('Please select all checkbox(s) to select an option as an answer.');
        event.preventDefault(); return false; } });
    }
    if($('.checkbox').length != 0)
    {
        if($('.checkbox:checked').length == 0)
        {
            alert('Please select any checkbox(s) to select an option as an answer.');
            event.preventDefault();
        }
    }
}
function checkFun(e) {
    var type= $('#exam-answer-type').val();
    let count = 0;
    let errMsg='';
    if (type == 'multi' || type == 'single') {
        count = $('.exam-options-list').length;
        errMsg = "option(s)"
    }
    if (type =="text") {
        errMsg = "answer(s)";
        count = $('.exam-answers-list').length;
    }
    if (type == "rate" || type == "grid" || type == "feedback") {
        return true;
    }
    if (count > 0) {
        // $('form').submit();
        return;
    }
    e.preventDefault();
    alert(`Please add an ${errMsg} before create a question.`);
}

checkdupl = (event) => {
    let ques = [];
    $('.worth').each(function(index, element){ ques.push($(element).val()); });
    var recipientsArray = ques.sort();

    var reportRecipientsDuplicate = [];
    for (var i = 0; i < recipientsArray.length - 1; i++) {
        if (recipientsArray[i + 1] == recipientsArray[i]) {
            reportRecipientsDuplicate.push(recipientsArray[i]);
        }
    }
    if(reportRecipientsDuplicate.length !== 0)
    {
        alert('You have selected same questions multiple times');
        event.preventDefault();
    }
}

/**
 *
 * @param {string} message
 * @param {number} time
 *
 * displays a given error message for given time.
 */
function showToast(message, time = 3000) {
    $('#toast').addClass('show');
    $('#toastMessage').text(message);
    setTimeout(() => {
        $('#toast').removeClass('show');
    }, time);
}
