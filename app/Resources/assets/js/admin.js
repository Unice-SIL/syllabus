import '../../../../web/bundles/tetranzselect2entity/js/select2entity';

$(document).ready(function () {

    function toggleCheckbox(checkbox)
    {
        if (checkbox.is(':checked')){
            checkbox.prop('checked', false);
            return;
        }
        checkbox.prop('checked', true);
    }

    $('.modal-initialized').modal();

    /* ================ Course info================ */
    $('.course-info-field-edit-ajax').click(function (event) {

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

    $('#courseInfoDuplicationModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) ;
        var id = button.data('id') ;
        //add the from course info id to ajax request
        var s2 = $(this).find('.select2entity');
        s2.data()['ajax-Url'] = s2.data()['ajax-Url'] + '&fromId=' + id;
        s2.select2entity();

        $('#appbundle_duplicate_course_info_from').val(id);
    });

    /* ================End Course info================ */

    //Trigger submit of a filter form when a select is changed
    $('.filter-form').find('select').change(function () {
        $('.filter-form').submit();
    });

    //Autocomplete
    function initAutocomplete() {
        $('.autocomplete-input').each(function () {
            //todo: regenerate when resizing window
            //var width = $(this).outerWidth();

            $(this).autocomplete({
                serviceUrl: $(this).data('autocomplete-path'),
                //width: width,
            }).enable();
        });
    }
    initAutocomplete();

});

