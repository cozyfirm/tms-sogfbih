import { Notify } from './../../../../style/layout/notify.ts';
import { Validator } from "../../../../style/layout/validator.ts";

$("document").ready(function () {
    let saveEventUri = '/system/admin/trainings/instances/apis/events/save';
    let fetchEventUri = '/system/admin/trainings/instances/apis/events/fetch';
    let deleteEventUri = '/system/admin/trainings/instances/apis/events/delete';

    let activeEvent = null;
    let repeated = false;

    $(".add-event").click(function (){
        /* Set active trainer ID as null */
        activeEvent = null;

        $(".add__agenda_wrapper").removeClass('d-none');

        /* Show repeat option */
        $(".ag_repeat_wrapper").removeClass('d-none');
        /* Hide delete button */
        $(".remove-event").addClass('d-none');

        /* Default values */
        $(".ag_location_id").val('0').trigger('change');
        $(".ag_tf").val('08:00').trigger('change');
        $(".ag_td").val('09:00').trigger('change');
        $(".ag_note").val('');
    });
    /**
     *  Open and close form
     */
    let closeIt = function (){
        $(".add__agenda_wrapper").addClass('d-none');

        if(repeated){
            /**
             *  If there was data entry, on finish reload page
             */
            location.reload();
        }
    }
    $(".close-add-agenda").click(function (){
        closeIt();
    });
    $(".add__agenda_wrapper").click(function (event){
        if($(event.target).hasClass('add__agenda_wrapper')){
            closeIt();
        }
    });

    /**
     *  Save trainer or update trainer
     */
    $(".save-event").click(function (){
        $(".loading").fadeIn(5);

        let type = $(".ag_type").val();
        let location = $(".ag_location_id");
        let date = $(".ag_date").val();
        let repeat = $("#ag_repeat");

        if(parseInt(location.val()) === 0){
            Notify.Me(["Molimo da odaberete lokaciju!", "warn"]);
            return;
        }

        if(!Validator.date(date) || date === ''){
            Notify.Me(["Format datuma nije validan!", "warn"]);
            return;
        }

        $.ajax({
            url: saveEventUri,
            method: "post",
            dataType: "json",
            data: {
                /** Model ID is used from file upload form */
                instance_id: $("#model_id").val(),
                /** Active trainer is ID in case of editing trainer */
                activeEvent: activeEvent,
                /** Data from form */
                type: type,
                location_id: location.val(),
                date: date,
                tf: $(".ag_tf").val(),
                td: $(".ag_td").val(),
                note: $(".ag_note").val(),
            },
            success: function success(response) {
                $(".loading").fadeOut(0);

                console.log(response);

                if(response['code'] === '0000'){
                    if(repeat.is(":checked")){
                        location.val(0).trigger('change');

                        $(".ag_tf").val($(".ag_td").val()).trigger('change');
                        $(".ag_note").val('');

                        repeated = true;
                    }else{
                        if(typeof response['message'] !== 'undefined') Notify.Me([response['message'], "success"]);

                        setTimeout(function (){
                            if(typeof response['url'] !== 'undefined') window.location = response['url'];
                        }, 2000);
                    }
                }else{
                    Notify.Me([response['message'], "warn"]);
                }
            }
        });
    });

    /**
     *  Fetch trainers info
     */
    $(".fetch-event").click(function (){
        let $this = $(this);

        $.ajax({
            url: fetchEventUri,
            method: "post",
            dataType: "json",
            data: {
                /** Model ID is used from file upload form */
                instance_id: $("#model_id").val(),
                id: $this.attr('event-id')
            },
            success: function success(response) {
                $(".loading").fadeOut(0);

                if(response['code'] === '0000'){
                    let event = response['data']['event'];

                    /** Set event as active */
                    activeEvent = event['id'];

                    $(".add__agenda_wrapper").removeClass('d-none');
                    $(".ag_type").val(event['type']).trigger('change');
                    $(".ag_location_id").val(event['location_id']).trigger('change');

                    $(".ag_date").val(event['_date']);
                    $(".ag_tf").val(event['tf']).trigger('change');
                    $(".ag_td").val(event['td']).trigger('change');
                    $(".ag_note").val(event['note']);

                    $(".ag_repeat_wrapper").addClass('d-none');
                    $(".remove-event").removeClass('d-none');
                }else{
                    Notify.Me([response['message'], "warn"]);
                }
            }
        });
    });

    /**
     *  Remove trainer data
     */
    $(".remove-event").click(function (){
        $.ajax({
            url: deleteEventUri,
            method: "post",
            dataType: "json",
            data: {
                /** Model ID is used from file upload form */
                instance_id: $("#model_id").val(),
                id: activeEvent
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
