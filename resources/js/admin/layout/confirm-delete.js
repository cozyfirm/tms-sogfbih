$("document").ready(function (){
    let uri = '';

    /**
     *  Open PopUp but, do nothing ...
     */
    $(".prevent-delete").click(function(e) {
        $(".confirm-delete").removeClass('d-none');
        uri = $(this).attr('href');

        /** Set title */
        $(".delete-desc").text($(this).attr('text'));

        e.preventDefault();
    });

    /**
     *  User reconfirmed, continue with deleting...
     */
    $(".confirm-delete-delete").click(function (){
        window.location = uri;
    });

    /**
     *  Close confirm delete
     */
    $(".close-confirm-delete, .confirm-delete-cancel").click(function (){
        $(".confirm-delete").addClass('d-none');
    });
    /** Close whenever you click */
    $(".confirm-delete").click(function (event){
        if($(event.target).hasClass('confirm-delete')){
            $(".confirm-delete").addClass('d-none');
        }
    });
});
