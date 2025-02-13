import { Notify } from './../../../../style/layout/notify.ts';
import { Validator } from "../../../../style/layout/validator.ts";

$("document").ready(function () {
    let updatePresenceUri = '/system/admin/trainings/instances/submodules/presence/update-presence';

    $(".presence-check").change(function (){
        let id   = $(this).attr('id');
        let date = $(this).attr('date');
        let checked = ($(this).is(":checked"));

        $(".loading").fadeOut(1);

        $.ajax({
            url: updatePresenceUri,
            method: "post",
            dataType: "json",
            data: {
                id: id,
                date: date,
                checked: checked
            },
            success: function success(response) {
                $(".loading").fadeOut(0);

                if(response['code'] === '0000'){
                    Notify.Me([response['message'], "success"]);
                }else{
                    Notify.Me([response['message'], "warn"]);
                }
            }
        });
    });

});
