import $ from 'jquery';
// @ts-ignore
window.jQuery = window.$ = $;

export class SystemAccess {
    data: any = '';
    uri: any = '';

    static parseMessage(message: any) : void {
        let counter = 0;
        $(".sa__row_wrapper").each(function (){
            counter++;

            if(counter >= 5) $(this).remove();
        });

        // @ts-ignore
        $(".home-right-system-access").prepend(function (){
            return $("<div>").attr('class', 'sa__row_wrapper go-to')
                .attr('link', '/system/admin/users/preview/' + message['data']['username'])
                .attr('title', message['data']['name'])
                .append(function (){
                    return $("<div>").attr('class', 'icon__wrapper ps-12')
                        .append(function (){
                            return $("<p>").text(message['data']['initials'])
                        })
                })
                .append(function (){
                    return $("<div>").attr('class', 'text__wrapper')
                        .append(function (){
                            return $("<div>").attr('class', 'text__data')
                                .append(function (){
                                    return $("<p>").text(message['data']['description'])
                                })
                                .append(function (){
                                    return $("<span>").text(message['data']['date'])
                                })
                        })
                        .append(function (){
                            return $("<div>").attr('class', 'icons__data')
                                .append(function (){
                                    return $("<i>").attr('class', 'fa-solid ' + message['data']['classname'])
                                })
                        })
                })
        });
    }
}
