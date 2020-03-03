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
        var form = $(checkbox.data('target'));
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
        var codeYear = button.data('code-year') ;

        //add the from course info codeYear to ajax request
        var s2 = $(this).find('.select2entity');
        s2.data()['ajax-Url'] = s2.data()['ajax-Url'] + '&fromCodeYear=' + codeYear;
        s2.select2entity();

        $('#appbundle_duplicate_course_info_from').val(codeYear);
    });

    $('#warningDeleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) ;
        var form = button.closest('form').clone() ;
        form.find('.warning-delete').attr('type', 'submit');
        $(this).find('.modal-body').empty().append(form);
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

    //manage label changing on file type when a file is selected
    $('.custom-file-input').change(function(e){
        var fileName = e.target.files[0].name;//get selected file name
        var container = $(this).closest('.custom-file');//get file-container
        container.find('.custom-file-label').html(fileName);//add selected file name as placeholder to input file
    });

});

