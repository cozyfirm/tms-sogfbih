$(document).ready(function (){
    let index = 1;
    let total = parseInt($(".total-images").text());

    let setImageByIndex = function (index){
        console.log("Index: " + index);

        /** Hide all images */
        $(".gallery-huge-image").removeClass('active');
        /* Show only one */
        $('.gallery-huge-image[index="' + index + '"]').addClass('active');

        /** Mark as inactive */
        $(".image__wrapper").removeClass('active');
        /* Set yellow border */
        $('.image__wrapper[index="' + index + '"]').addClass('active');

        $(".current-index").text(index);
    };

    $(".previous-img").click(function (){
        if(index > 1) index--;
        else index = total;

        setImageByIndex(index);
    });
    $(".next-img").click(function (){
        if(index < total) index++;
        else index = 1;

        setImageByIndex(index);
    });
    $(".image__wrapper").click(function (){
        index = parseInt($(this).attr('index'));
        setImageByIndex(index);
    });

    /* Open gallery */
    $(".iw__open_image").click(function (){
        index = parseInt($(this).attr('index'));
        setImageByIndex(index);

        $(".preview__gallery").removeClass('d-none');
    });

    /**
     *  Open and close gallery
     */
    let closeGallery = function (){ $(".preview__gallery").addClass('d-none'); }
    $(".close-preview-gallery").click(function (){ closeGallery(); });
});
