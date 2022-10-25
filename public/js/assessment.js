$(document).ready(function () {
    $('select[name="obj_id"]').on('change', function() {
        var program_id = $(this).val();
        if (program_id) {
            $.ajax({
                url: '/admin/getSections/' + program_id,
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    //$('#loader').css("visibility", "visible");
                    $('select[name="section"]').empty();
                },
                success: function(data) {
                    $('select[name="section"]').empty();
                    $('select[name="section"]').append("<option value=''>None</option>");
                    $.each(data, function(key, value) {
                        $('select[name="section"]').append('<option value="' + key + '">' + value + '</option>');
                    });
                },
                complete: function() {
                    //$('#loader').css("visibility", "hidden");
                }
            });
        }
    });
});