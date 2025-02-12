import { Notify } from './../../../../style/layout/notify.ts';
import { Validator } from "../../../../style/layout/validator.ts";

$("document").ready(function () {
    let saveTrainerUri = '/system/admin/trainings/instances/apis/trainers/save';
    let fetchTrainerUri = '/system/admin/trainings/instances/apis/trainers/fetch';
    let deleteTrainerUri = '/system/admin/trainings/instances/apis/trainers/delete';

    let activeTrainer = null;

    $(".instances-add-trainer").click(function (){
        /* Set active trainer ID as null */
        activeTrainer = null;

        $(".add__trainer_wrapper").removeClass('d-none');

        /* Set it as enabled */
        $(".at_trainer_id").prop('disabled', false);

        /* Set as default values */
        $(".at_grade").val('');
        $(".at_monitoring").val('');

        /* Hide delete button */
        $(".remove-trainer").addClass('d-none');
    });
    /**
     *  Open and close form
     */
    $(".close-add-trainer").click(function (){
        $(".add__trainer_wrapper").addClass('d-none');
    });
    $(".add__trainer_wrapper").click(function (event){
        if($(event.target).hasClass('add__trainer_wrapper')){
            $(".add__trainer_wrapper").addClass('d-none');
        }
    });

    /**
     *  Save trainer or update trainer
     */
    $(".save-trainer").click(function (){
        $(".loading").fadeIn(5);

        let trainerID = $(".at_trainer_id").val();
        if(parseInt(trainerID) === 0){
            Notify.Me(["Molimo da odaberete trenera!", "warn"]);
            return;
        }

        $.ajax({
            url: saveTrainerUri,
            method: "post",
            dataType: "json",
            data: {
                /** Model ID is used from file upload form */
                instance_id: $("#model_id").val(),
                /** Active trainer is ID in case of editing trainer */
                activeTrainer: activeTrainer,
                /** Data from form */
                trainer_id: trainerID,
                grade: $(".at_grade").val(),
                monitoring: $(".at_monitoring").val()
            },
            success: function success(response) {
                $(".loading").fadeOut(0);

                if(response['code'] === '0000'){
                    if(activeTrainer === null){
                        if(typeof response['message'] !== 'undefined') Notify.Me([response['message'], "success"]);

                        setTimeout(function (){
                            if(typeof response['url'] !== 'undefined') window.location = response['url'];
                        }, 2000);
                    }else{
                        $(".add__trainer_wrapper").addClass('d-none');
                    }

                    $(".remove-trainer").addClass('d-none');
                }else{
                    Notify.Me([response['message'], "warn"]);
                }
            }
        });
    });

    /**
     *  Fetch trainers info
     */
    $(".trainer__w_get_info").click(function (){
        let $this = $(this);

        $.ajax({
            url: fetchTrainerUri,
            method: "post",
            dataType: "json",
            data: {
                /** Model ID is used from file upload form */
                instance_id: $("#model_id").val(),
                trainer_id: $this.attr('rel-id')
            },
            success: function success(response) {
                $(".loading").fadeOut(0);

                if(response['code'] === '0000'){
                    $(".add__trainer_wrapper").removeClass('d-none');
                    $(".at_trainer_id").val(response['data']['rel']['trainer_id']).trigger('change').prop('disabled', true);
                    $(".at_grade").val(response['data']['rel']['grade']);
                    $(".at_monitoring").val(response['data']['rel']['monitoring']);

                    activeTrainer = response['data']['rel']['trainer_id'];

                    /* Show delete button */
                    $(".remove-trainer").removeClass('d-none');
                }else{
                    Notify.Me([response['message'], "warn"]);
                }
            }
        });
    });

    /**
     *  Remove trainer data
     */
    $(".remove-trainer").click(function (){
        console.log("ID: " + activeTrainer);

        $.ajax({
            url: deleteTrainerUri,
            method: "post",
            dataType: "json",
            data: {
                /** Model ID is used from file upload form */
                instance_id: $("#model_id").val(),
                trainer_id: activeTrainer
            },
            success: function success(response) {
                $(".loading").fadeOut(0);

                if(response['code'] === '0000'){
                    if(typeof response['message'] !== 'undefined') Notify.Me([response['message'], "success"]);

                    setTimeout(function (){
                        if(typeof response['url'] !== 'undefined') window.location = response['url'];
                    }, 2000);
                }else{
                    Notify.Me([response['message'], "warn"]);
                }
            }
        });
    })
});
