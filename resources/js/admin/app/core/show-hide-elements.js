$(document).ready(function (){
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
        }
    });
});
