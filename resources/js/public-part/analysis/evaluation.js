import { Notify } from './../../style/layout/notify.ts';
import { Validator } from "./../../style/layout/validator.ts";

$(document).ready(function (){
    let submitUri = '/public-data/analysis/submit';
    let saveUri = '/public-data/analysis/save';

    /**
     *  Radio buttons
     */
    $(".public_question__radio").change(function (){
        let value = $(this).val();
        let id    = $(this).attr('id');
        let evaluation_id = $("#evaluation_id").val();

        /** If submitted, do nothing */
        if($("#submission_status").val() === 'submitted') return;

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
    $(".public_question__answer").blur(function (){
        let value = $(this).val();
        let id    = $(this).attr('id');
        let evaluation_id = $("#evaluation_id").val();

        /** If submitted, do nothing */
        if($("#submission_status").val() === 'submitted') return;

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
    $("#save-public-evaluation").click(function (){
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
