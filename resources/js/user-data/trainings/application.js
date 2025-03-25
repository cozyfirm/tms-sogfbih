import { Notify } from './../../style/layout/notify.ts';
import { Validator } from "./../../style/layout/validator.ts";

$(document).ready(function (){
    let signUpUri = '/system/user-data/trainings/apis/application/sign-up';

    $(".rm-sign-up").click(function (){
        let instanceID = $(this).attr('instance-id');
        $(".loading").fadeIn(1);

        $.ajax({
            url: signUpUri,
            method: "post",
            dataType: "json",
            data: {
                instanceID: instanceID
            },
            success: function success(response) {
                $(".loading").fadeOut(0);

                if(response['code'] === '0000'){
                    Notify.Me([response['message'], "success"]);
                    let data = response['data'];

                    if(data['subcode'] === '0000-1'){
                        /** User applied for training */
                        $(".rm-sign-up-inner").empty().append(function (){
                            return $("<h5>").text('Odjavite se sa obuke')
                        })
                    }else if(data['subcode'] === '0000-2'){
                        /** User applied for training */
                        $(".rm-sign-up-inner").empty()
                            .append(function (){
                                return $("<h5>").text('Prijavite se na obuku')
                            })
                            .append(function (){
                                return $("<i>").attr('class', 'fa-solid fa-arrow-right-long')
                            })
                    }

                    /* Change number of applications */
                    $(".ud-t-no-of-apps").text(data['total']);
                }else{
                    Notify.Me([response['message'], "warn"]);
                }
            }
        });
    });
});
