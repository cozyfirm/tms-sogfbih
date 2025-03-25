import $ from 'jquery';
// @ts-ignore
window.jQuery = window.$ = $;

export class TrainingApp {
    data: any = '';
    uri: any = '';

    static parseMessage(message: any) : void {
        console.log(message['id']);

        // @ts-ignore
        $(".notifications__body").prepend(function (){
            return $("<div>").attr('class', 'not__row_wrapper go-to mark-as-read')
                .attr('id', message['id'])
                .attr('link', message['uri'])
                .attr('title', message['description'])
                .append(function (){
                    return $("<div>").attr('class', 'icon__wrapper ps-12')
                        .append(function (){
                            return $("<p>").text(message['from']['initials'])
                        });
                })
                .append(function (){
                    return $("<div>").attr('class', 'text__wrapper')
                        .append(function (){
                            return $("<div>").attr('class', 'text__data')
                                .append(function (){
                                    return $("<p>").text(message['text'])
                                })
                                .append(function (){
                                    return $("<span>").text(message['createdAt'])
                                })
                        })
                        .append(function (){
                            return $("<div>").attr('class', 'dots__data')
                                .append(function (){
                                    return $("<i>").attr('class', 'fa-solid fa-ellipsis-vertical')
                                })
                        })
                })
        });

        /**
         *  Show number of unread notifications
         */
        $(".number-of-not").removeClass('d-none');
        $("#no-unread-notifications").text(message['unreadNotifications']);
    }
}
