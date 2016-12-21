// Refresh thumbnails :
function readURL(input, $img) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $img.show();
            $img.attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function refreshThumbnail(){
    $(".form-with-image .form-image input[type=file]").change(function(){
        readURL(this, $(this).closest('.row').find('.js-img'));
    });
}

refreshThumbnail();

$(function(){

    function updateImageFromPath($pacImage) {
        var val = $pacImage.find('.arkounay-image-path').val();
        if (val !== '') {
            $pacImage.find('img').attr('src', val);
        }
    }

    function submitFile(file, $image) {
        var formData = new FormData();
        formData.append('file', file);

        var $progress = $image.find('progress');

        $.ajax({
            url: url,
            type: 'POST',
            xhr: function () {
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', function (e) {
                        if (e.lengthComputable) {
                            $progress.show();
                            $progress.attr({value: e.loaded, max: e.total});
                        } else {
                            $progress.hide();
                        }
                    }, false);
                }
                return xhr;
            },
            success: function (res) {
                if (res[0] !== false) {
                    $image.find('.arkounay-image-path').val(res[0]);
                    updateImageFromPath($image);
                } else {
                    alert("Le fichier spécifié (" + file.name + ") n'a pas pu être envoyé sur le serveur.\n\nSeules les images sont autorisés.");
                }
                $progress.hide();
            },
            error: function() {
                alert("Une erreur est survenue lors de l'envoi du fichier " + file.name + ".");
                $progress.hide();
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
    }


    function applyDragAndDrop() {
        var $pacImages = $('.arkounay-image');
        $pacImages.on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
        })
            .on('dragover dragenter', function() {
                $(this).addClass('is-dragover');
            })
            .on('dragleave dragend drop', function() {
                $(this).removeClass('is-dragover');
            })
            .on('drop', function(e) {
                submitFile(e.originalEvent.dataTransfer.files[0],  $(this))
            });

        $pacImages.find('.arkounay-image-path').change(function () {
            updateImageFromPath($(this).closest('.arkounay-image'));
        })
    }
    applyDragAndDrop();

    $('.arkounay-image-button-upload').click(function (e) {
        e.preventDefault();
        $(this).parent().find('.arkounay-image-file-input').click();
    });

    $('.arkounay-image-file-input').change(function () {
        var file = this.files[0];
        submitFile(file, $(this).closest('.arkounay-image'));
    });

    $.each($('.arkounay-image'), function(i, el) {
        updateImageFromPath($(el));
    });

    /*$('.js-arkounay-image-add').click(function(e){
     e.preventDefault();
     var $el = $(this).parent().parent().find('.arkounay-image-collection');
     var html = $el.data('prototype');
     $el.append($("<textarea/>").html(html).text());
     });*/

    $('.arkounay-image-collection').collection({
        up: '<a href="#">&#x25B2;</a>',
        down: '<a href="#">&#x25BC;</a>',
        add: '<a href="#" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> ' + addStr + '</a>',
        remove: '<a href="#" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span> Supprimer</a>',
        duplicate: '<a href="#">[ # ]</a>',
        add_at_the_end: true,
        after_add: function(element) {
            applyDragAndDrop();
        }
    });

});