$(document).ready(function (){
    let notificationOpen = false;

    $(document).on('click', function (event) {
        /** Notifications wrapper */
        const notificationsWrapper = $('.notifications__wrapper');
        const notificationBtn = $(".m-show-notifications");
        const notificationBtnIcon = $(".m-show-notifications-icon");

        if ((!notificationsWrapper.is(event.target) && notificationsWrapper.has(event.target).length === 0) && (!notificationBtn.is(event.target) && notificationBtn.has(event.target).length === 0) && (!notificationBtnIcon.is(event.target) && notificationBtnIcon.has(event.target).length === 0)) {
            notificationsWrapper.addClass('d-none');
        }
        if((notificationBtn.is(event.target) && notificationBtn.has(event.target).length === 0) || (notificationBtnIcon.is(event.target) && notificationBtnIcon.has(event.target).length === 0)){
            notificationsWrapper.toggleClass('d-none');

            if(notificationOpen) notificationOpen = false;
            else{
                notificationOpen = true;

                /**
                 *  Create HTTP to reset number of notifications
                 */

                $.ajax({
                    url: '/system/common-routes/notifications/reset',
                    method: "post",
                    dataType: "json",
                    data: {},
                    success: function success(response) {
                        if(response['code'] === '0000'){
                            let data = response['data'];

                            $("#no-unread-notifications").text(data['total']);
                            if(parseInt(data['total']) === 0){
                                $(".number-of-not").addClass('d-none');
                            }else{
                                $(".number-of-not").removeClass('d-none');
                            }
                            console.log(data['total']);
                        }
                    }
                });
            }
        }
    });
});
