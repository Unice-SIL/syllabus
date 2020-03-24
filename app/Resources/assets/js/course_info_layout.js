import Syllabus from './syllabus';

$(document).ready(function () {

    $('.card-syllabus').each(function () {
        let $card = $(this);
        let $cardBody = $card.find('.card-body');
        let url = $card.data('view-url');
        $.get(url, {
            beforeSend: function () {
                $cardBody.html('<div class="progress mx-auto" style="max-width: 95%"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div>')
            }
        }).done(function (response) {
            if (Syllabus.handleAjaxResponseModal(response)) {
                $cardBody.html(response["content"]);
            }
        });
    });

    $(document).on('click', '.card-syllabus .edit-button', function () {
        let $button = $(this);
        let $card = $button.closest('.card-syllabus');
        let $cardBody = $card.find('.card-body');
        let url = $card.data("form-url");
        $.get(url, {
            beforeSend: function () {
                $button.attr("disabled", true).html('<i class="fas fa-spinner fa-spin"></i>');
                $card.addClass('active');
                $('#app').addClass('hasActiveChild');
            }
        }).done(function (response) {
            if (Syllabus.handleAjaxResponseModal(response)) {
                $button.hide();
                $cardBody.html(response["content"]);
            }
        });
    });

    $(document).on('form-focus-pre-submit', '#form-focus-teaching', function () {

        let mode = $(this).find('input[name="teaching_mode[teachingMode]"]:checked').val();

        if (mode === $('#teaching-mode-container').data('type-hybrid')) {
            return;
        }
        let teachingItemCollection = $(this).find('.teaching-item-collection');

        teachingItemCollection.each(function () {

            if ($(this).find('.teaching-type-mode-input').val() !== mode) {
                $(this).remove();
            }
        });
    });

    //$(document).on('click', '.card-syllabus .submit-button', function () {
    $(document).on('submit', '.form-focus', function(e){
        e.preventDefault();
        //let $button = $(this);
        let $button = $($(this).find('button[type="submit"]').get(0));
        let $card = $button.closest('.card-syllabus');
        let $cardBody = $card.find('.card-body');
        let $editButton = $card.find('.edit-button');
        let forms = $card.find('form');
        let url = $card.data('form-url');

        $(this).trigger('form-focus-pre-submit');

        $.ajax({
            url: url,
            enctype: 'multipart/form-data',
            processData: false, // Preventing default serialization.
            contentType: false, // No auto “contentType” header.
            data: new FormData(forms[0]),
            method: "POST",
            dataType: "json",
            beforeSend: function () {
                $button.attr("disabled", true).html('<i class="fas fa-spinner fa-spin"></i>');
            }
        }).done(function (response) {
            $cardBody.html(response["content"]);
            $editButton.attr("disabled", false).html('Mettre à jour');
            $editButton.show();
            $card.removeClass('active');
            $('#app').removeClass('hasActiveChild');
        });
    });

    $(document).on('click', '.card-syllabus .cancel-button', function () {
        let $button = $(this);
        let $card = $button.closest('.card-syllabus');
        let $cardBody = $card.find('.card-body');
        let $editButton = $card.find('.edit-button');
        let url = $card.data('view-url');
        $.get(url, {
            beforeSend: function () {
                $button.attr("disabled", true).html('<i class="fas fa-spinner fa-spin"></i>');
            }
        }).done(function (response) {
            if (Syllabus.handleAjaxResponseModal(response)) {
                $cardBody.html(response["content"]);
            }
        }).always(function () {
            $editButton.attr("disabled", false).html('Mettre à jour');
            $editButton.show();
            $card.removeClass('active');
            $('#app').removeClass('hasActiveChild');
        });
    });
});