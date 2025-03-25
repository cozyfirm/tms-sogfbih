import { Notify } from './../../../style/layout/notify.ts';
import { Validator } from "../../../style/layout/validator.ts";

$("document").ready(function (){
    let fetchTrainerInfo = '/system/admin/trainings/submodules/trainers/fetch';
    /** Preview instance by ID */
    let instanceUri      = '/system/admin/trainings/instances/preview/';
    let instanceID = '';

    /**
     *  Save author
     */
    $(".fetch-trainer-info").click(function (){
        let id = $(this).attr('id');

        $.ajax({
            url: fetchTrainerInfo,
            method: "post",
            dataType: "json",
            data: {
                id: id
            },
            success: function success(response) {
                $(".loading").fadeOut();

                if(response['code'] === '0000'){
                    let data = response['data']['info'];

                    $(".fetch-trainer-info-desc").text('Angažovanost trenera na obuci "' + data['instance_rel']['training_rel']['title'] + '" u periodu ' + data['dateFrom'] + '-' + data['dateTo']);
                    console.log(data);

                    $(".fti_grade").val(data['grade']);
                    $(".fti_contract").val(data['contract']);
                    $(".fti_monitoring").val(data['monitoring']);

                    $(".fetch__trainer_info").removeClass('d-none');

                    instanceID = data['instance_id'];
                }else{
                    Notify.Me([response['message'], "warn"]);
                }
            }
        });
    });

    $(".fti-preview-instance").click(function (){
        window.open(instanceUri + instanceID, '_blank');
    });

    /**
     *  Open and close form
     */
    $(".close-fetch-trainer").click(function (){
        $(".fetch__trainer_info").addClass('d-none');
    });

    $(".fetch__trainer_info").click(function (event){
        if($(event.target).hasClass('fetch__trainer_info')){
            $(".fetch__trainer_info").addClass('d-none');
        }
    });
});
