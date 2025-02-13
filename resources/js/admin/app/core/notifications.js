$(document).ready(function (){
    /**
     *  Mark notification as read
     */

    $(".mark-as-read").click(function (){
        let id = $(this).attr('id');

        $.ajax({
            url: '/system/common-routes/notifications/mark-as-read',
            method: "post",
            dataType: "json",
            data: {id: id},
            success: function success(response) {
                if(response['code'] === '0000'){

                }
            }
        });
    });
});
