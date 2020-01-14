$(document).ready(function () {

    function toggleCheckbox(checkbox)
    {
        if (checkbox.is(':checked')){
            checkbox.prop('checked', false);
            return;
        }
        checkbox.prop('checked', true);
    }

    /* ================SyllabusDuplicationDField================ */
    $('.syllabus-duplication-field-edit-ajax').click(function (event) {

        var checkbox = $(this);
        var form = checkbox.closest('form');
        event.preventDefault();

        $.post( form.data('url'), form.serialize())
            .done(function(data) {
                if (data.success) {
                    toggleCheckbox(checkbox);
                }
            });
    });

    /* ================End SyllabusDuplicationDField================ */

});

