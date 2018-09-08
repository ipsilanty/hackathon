//preview a file (image) before uploaded
function readURL(input, preview) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('.'+preview).css('background-image', 'url(' + e.target.result + ')');
            $('.drop').find('label').hide();
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$("#photo").change(function() {
    readURL(this,"previews");
});

// Parsley frontend validation
// -------------------------------------------------------------------------------------------------------------
var parsleyFactory = function($form, $button) {
    var $parsley = $form.parsley();

    $button.on('click', function(evt) {

        if ($parsley.isValid()) {

            $parsley.destroy();
            $form.submit();
            $(this).button('loading');
        }else{
            $(this).button("reset");
        }
    });
};

// Parsley generic form
$(".js-parsley").each(function(i, obj) {
    var $form = $(this);
    if ($form.length) {
        parsleyFactory( $form, $("." + $form.data('parsley-submit')) );
    }
});
// ---

// custom validation rules with AJAX
window.Parsley.addAsyncValidator('parsley_is_db_cell_available', function (xhr) {
    var response = xhr.responseText;
    var t = this.$element.attr('name');
    if (response === 'valid') {
        return true;
    } else {
        return false;
    }
}, 'ParsleyValidation/parsley_is_db_cell_available');
