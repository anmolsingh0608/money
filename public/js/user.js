$(document).ready(function () {
    // console.log('user.js');
    // $('#reset-link').click(function(){
    //     $('#reset-password').submit(function(e) {
    //         e.preventDefault();
    //     });
    //     $('#reset-password').submit();
    // });
    $('#reset-link').on('click', function(){
        // console.log($('#e-mail'));
        let _token   = $('input[name="_token"]').first().val();
        $.ajax({
            url: '/admin/user/password_reset_link',
            type: 'post',
            data: {
                'email': $('#e-mail').val(),
                '_token': _token
            },
            success: function (response) {
                console.log(response)
                alert('Password reset link sent successfully!');
            },
            complete: function () {
            
            }
        })
    });
});