import { Notify } from './../../../../style/layout/notify.ts';
import { Validator } from "../../../../style/layout/validator.ts";

$("document").ready(function () {
    let changeAppStatusUri = '/system/admin/trainings/instances/submodules/applications/update-status';

    $(".app_status__change").change(function (){
        let status = $(this).val();
        let ID     = $(this).attr('id');

        $(".loading").fadeOut(1);

        $.ajax({
            url: changeAppStatusUri,
            method: "post",
            dataType: "json",
            data: {
                status: status,
                id: ID
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
