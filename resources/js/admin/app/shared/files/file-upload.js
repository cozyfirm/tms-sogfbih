import { Notify } from './../../../../style/layout/notify.ts';

$(document).ready(function(){
    let filesArray = [];

    /**
     * Upload file by file
     *
     * @param file
     * @param index
     */
    function uploadFile(file, index){
        let fileName = file.name;
        // Find the position of the last dot in the file name
        let dotIndex = fileName.lastIndexOf('.');
        // Extract the extension if there is a dot, otherwise set it to an empty string
        let extension = dotIndex !== -1 ? fileName.substring(dotIndex + 1) : '';
        // Get the file size in megabytes
        let sizeInMB = (file.size / (1024 * 1024)).toFixed(2);

        // Log the file name and its extension
        // console.log("File " + (index+1) + ": " + fileName + " | Extension: " + extension + " | Size: " + sizeInMB);

        /**
         *  Create element and append to wrapper
         */
        $(".uploaded__files__wrapper").append(function (){
            return $("<div>").attr('class', 'uploaded__file').attr('file-index', 'file-index-' + index).attr('index', index)
                .append(function (){
                    return $("<div>").attr('class', 'file__header')
                        .append(function (){
                            return $("<div>").attr('class', 'icon__wrapper')
                                .append(function (){
                                    return $("<img>").attr('src', '/files/images/icons/ext/' + extension + '.png').attr('alt', 'Icon')
                                })
                        })
                        .append(function (){
                            return $("<div>").attr('class', 'content__wrapper')
                                .append(function (){
                                    return $("<h6>").text(fileName);
                                })
                                .append(function (){
                                    return $("<p>").text(sizeInMB + " MB");
                                })
                        })
                        .append(function (){
                            return $("<div>").attr('class', 'content__remove').attr('title', 'Obrišite ovaj dokument')
                                .append(function (){
                                    return $("<img>").attr('src', '/files/images/icons/cross-small.svg').attr('alt', 'Remove Icon').attr('file-index', "file-" + index)
                                })
                        });
                })
                .append(function (){
                    return $("<div>").attr('class', 'upload__progress_wrapper')
                        .append(function (){
                            return $("<div>").attr('class', 'upload__line')
                                .append(function (){
                                    return $("<div>").attr('class', 'upload__line_fill width-0 upload-line-index-' + index);
                                })
                        })
                        .append(function (){
                            return $("<p>").attr('class', 'upload-percentage-index-' + index).text("0%");
                        });
                });
        });

        let formData = new FormData();
        formData.append('file', file);

        $.ajax({
            url: '/system/admin/core/file-upload', // Laravel route handling the upload
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function () {
                let xhr = new window.XMLHttpRequest();
                // Listen to the progress event of the upload
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        let percentage =  Math.round((evt.loaded / evt.total) * 100);

                        $(".upload-line-index-" + index).addClass('width-' + percentage);
                        $(".upload-percentage-index-" + index).text(percentage + "%");
                    }
                }, false);
                return xhr;
            },
            success: function (response) {
                if(response['code'] === '0000'){
                    filesArray.push({
                        index: parseInt(index),
                        fileID: response['data']['file']['id'],
                        fileName: response['data']['file']['file'],
                        fileExt: response['data']['file']['ext']
                    });

                }else{
                    Notify.Me(["Greška. Molimo kontaktirajte administratora!", "warn"]);
                }

            },
            error: function (xhr, status, error) {
                // progressBar.text('Error');
            }
        });
    }

    /**
     *  On input change, append and upload files !?
     */
    $('#files').on('change', function () {
        // Get selected files
        let files = this.files;
        // Clear previous progress bars if any
        $('.uploaded__files__wrapper').empty();

        // Empty files array
        filesArray = [];

        // Loop through each selected file and upload them individually
        for (let i = 0; i < files.length; i++) {
            uploadFile(files[i], i);
        }
    });

    /**
     *  Remove specific file from array and remove from GUI
     */
    $("body").on('click', '.content__remove', function (){
        let parent = $(this).parent().parent();

        filesArray = filesArray.filter(function(file) {
            return file.index !== parseInt(parent.attr('index'));
        });

        $('div.uploaded__file[index="'+parent.attr('index')+'"]').remove();
    });

    /**
     *  Open wrapper
     */
    $(".upload-files").click(function (){
        $(".file__upload__wrapper").removeClass('d-none');
    });

    /**
     *  Save files as relationship
     */
    $(".fu-save-files").click(function (){
        $(".loading").fadeOut(0);

        $.ajax({
            url: $(".upload_route").val(),
            method: "post",
            dataType: "json",
            data: {
                model_id: $(".model_id").val(),
                filesArray: filesArray
            },
            success: function success(response) {
                $(".loading").fadeOut(0);

                let code = response['code'];

                if(code === '0000'){
                    if(typeof response['message'] !== 'undefined') Notify.Me([response['message'], "success"]);

                    setTimeout(function (){
                        if(typeof response['url'] !== 'undefined') window.location = response['url'];
                    }, 2000);
                }else{
                    Notify.Me([response['message'], "warn"]);
                }
            }
        });
    });

    /**
     *  On "Cancel btn"
     */
    $(".fu-remove-files, .close-file-upload").click(function (){
        /* Reset input */
        $("#files").val('');
        // Clear previous progress bars if any
        $('.uploaded__files__wrapper').empty();
        // Empty files array
        filesArray = [];

        $(".file__upload__wrapper").addClass('d-none');
    });

    $(".file__upload__wrapper").click(function (event){
        if($(event.target).hasClass('file__upload__wrapper')){
            $(".file__upload__wrapper").addClass('d-none');
        }
    });
});
