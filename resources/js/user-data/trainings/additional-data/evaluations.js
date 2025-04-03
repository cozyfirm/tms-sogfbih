import { Notify } from './../../../style/layout/notify.ts';
import { Validator } from "./../../../style/layout/validator.ts";

$(document).ready(function (){
    let submitUri = '/system/user-data/trainings/apis/evaluations/submit';
    let saveUri = '/system/user-data/trainings/apis/evaluations/save';

    $(".show-evaluation").click(function (){
        $(".questionnaire__wrapper").addClass('d-flex');
    });

    $(".questionnaire__wrapper").click(function (event){
        if($(event.target).hasClass('questionnaire__wrapper')){
            $(".questionnaire__wrapper").removeClass('d-flex');
        }
    });

    /**
     *  Radio buttons
     */
    $(".question__radio").change(function (){
        let value = $(this).val();
        let id    = $(this).attr('id');
        let evaluation_id = $("#evaluation_id").val();

        /** If submitted, do nothing */
        if($("#evaluation_status").val() === 'submitted') return;

        $.ajax({
            url: submitUri,
            method: "post",
            dataType: "json",
            data: {
                evaluation_id: evaluation_id,
                option_id : id,
                answer: value
            },
            success: function success(response) {
                if(response['code'] === '0000'){

                }else{
                    Notify.Me([response['message'], "warn"]);
                }
            }
        });
    })

    /**
     *  Answer
     */
    $(".question__answer").blur(function (){
        let value = $(this).val();
        let id    = $(this).attr('id');
        let evaluation_id = $("#evaluation_id").val();

        /** If submitted, do nothing */
        if($("#evaluation_status").val() === 'submitted') return;

        $.ajax({
            url: submitUri,
            method: "post",
            dataType: "json",
            data: {
                evaluation_id: evaluation_id,
                option_id : id,
                answer: value
            },
            success: function success(response) {
                if(response['code'] === '0000'){

                }else{
                    Notify.Me([response['message'], "warn"]);
                }
            }
        });
    })

    /**
     *  Save evaluation
     */
    $("#save-evaluation").click(function (){
        let evaluation_id = $("#evaluation_id").val();

        $.ajax({
            url: saveUri,
            method: "post",
            dataType: "json",
            data: {
                evaluation_id: evaluation_id,
            },
            success: function success(response) {
                if(response['code'] === '0000'){
                    Notify.Me([response['message'], "success"]);

                    setTimeout(function (){
                        location.reload();
                    }, 2000);
                }else{
                    Notify.Me([response['message'], "warn"]);
                }
            }
        });
    })
});
