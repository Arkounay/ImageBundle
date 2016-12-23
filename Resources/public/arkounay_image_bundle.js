$(function(){

    function updateImageFromPath($pacImage) {
        var val = $pacImage.find('.arkounay-image-path').val();
        $pacImage.find('img').attr('src', val);
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
                            $progress.fadeIn('fast');
                            $progress.attr({value: e.loaded, max: e.total});
                        } else {
                            $progress.fadeOut('fast');
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
                $progress.fadeOut('fast');
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


    var arkounayImageSel = '.arkounay-image';
    var $document = $(document);

    $document.on('click', '.arkounay-image-button-upload', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).closest('.arkounay-image').find('.arkounay-image-file-input').click();
    });

    $document.on('click', '.arkounay-image-button-erase', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $imagePath = $(this).closest('.arkounay-image').find('.arkounay-image-path');
        $imagePath.val('');
        $imagePath.change();
    });

    $document.on('change', '.arkounay-image-file-input', function () {
        var file = this.files[0];
        submitFile(file, $(this).closest('.arkounay-image'));
    });

    // dragon & drop
    $document.on('drag dragstart dragend dragover dragenter dragleave drop', arkounayImageSel, function(e) {
        e.preventDefault();
        e.stopPropagation();
    })
    .on('dragover dragenter', arkounayImageSel, function() {
        $(this).addClass('is-dragover');
    })
    .on('dragleave dragend drop', arkounayImageSel, function() {
        $(this).removeClass('is-dragover');
    })
    .on('drop', arkounayImageSel, function(e) {
        submitFile(e.originalEvent.dataTransfer.files[0],  $(this))
    });

    var addImageSel = '.arkounay-image-list .images-add';
    $document.on('drag dragstart dragend dragover dragenter dragleave drop', addImageSel, function(e) {
        e.preventDefault();
        e.stopPropagation();
    })
    .on('dragover dragenter', addImageSel, function() {
        $(this).addClass('is-dragover');
    })
    .on('dragleave dragend drop', addImageSel, function() {
        $(this).removeClass('is-dragover');
    })
    .on('drop', addImageSel, function(e) {
        var previousIds = [];
        $(this).closest('.arkounay-image-list').children().each(function(){
            previousIds.push($(this).attr('id'));
        });
        $(this).find('a').click();
        var newIds = [];
        $(this).closest('.arkounay-image-list').children().each(function(){
            newIds.push($(this).attr('id'));
        });

        var id;
        $.grep(newIds, function(el) {
            if (el !== undefined && $.inArray(el, previousIds) == -1 && !$('#' + el).hasClass('images-add')) {
                id = el;
            }
        });

        if (id !== undefined) {
            submitFile(e.originalEvent.dataTransfer.files[0],  $('#' + id).closest('.arkounay-image'));
        }
    });

    $document.on('change', '.arkounay-image-path', function () {
        updateImageFromPath($(this).closest('.arkounay-image'));
    });


    $.each($(arkounayImageSel), function(i, el) {
        updateImageFromPath($(el));
    });

    $('.arkounay-image-collection').each(function(){
        var $this = $(this);
        $this.collection({
            max: $this.data('max'),
            min: $this.data('min'),
            init_with_n_elements: $this.data('init-with-n-elements'),
            // up: false,
            // down: false,
            add: '<span class="images-add"><a href="#" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> ' + addStr + '</a></span>',
            // remove: false,
            duplicate: '<a href="#">[ # ]</a>',
            add_at_the_end: $this.data('add-at-the-end')
        });
    });

});