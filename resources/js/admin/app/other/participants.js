import { Notify } from './../../../style/layout/notify.ts';
import { Validator } from "../../../style/layout/validator.ts";

$("document").ready(function (){
    let saveParticipantUri   = '/system/admin/other/shared/participants/save';
    let fetchParticipantUri  = '/system/admin/other/shared/participants/fetch';
    let updateParticipantUri = '/system/admin/other/shared/participants/update';
    let deleteParticipantUri = '/system/admin/other/shared/participants/delete';

    let type = 'ie';

    /**
     *  Global vars
     */
    let participantGlobalID = 0;
    let updateParticipant = false;

    /**
     *  Save author
     */
    $(".save-participant").click(function (){
        let model_id = $("#model_id").val();
        let name = $("#participant_name").val();
        let checked = $('#pr__checkbox').is(":checked");

        if(name === ''){
            Notify.Me(["Molimo da unesete ime i prezime učesnika", "warn"]);
            return;
        }

        if(updateParticipant){
            /** Update participant */
            $.ajax({
                url: updateParticipantUri,
                method: "post",
                dataType: "json",
                data: {
                    id: participantGlobalID,
                    name: name
                },
                success: function success(response) {
                    $(".loading").fadeOut();

                    let code = response['code'];

                    if(code === '0000'){
                        let participant = response['data']['participant'];

                        $('.participant_w[model-id="' + participantGlobalID + '"]').find('p').text(participant['name']);

                        $("#participant_name").val("");
                        $(".participants").addClass('d-none');
                    }else{
                        Notify.Me([response['message'], "warn"]);
                    }
                }
            });
        }else{
            /** Create new participant */
            $.ajax({
                url: saveParticipantUri,
                method: "post",
                dataType: "json",
                data: {
                    type: type,
                    model_id: model_id,
                    name: name,
                    checked: checked
                },
                success: function success(response) {
                    $(".loading").fadeOut();

                    let code = response['code'];

                    if(code === '0000'){
                        updateParticipant = false;

                        let participant = response['data']['participant'];

                        $(".shared_participants").removeClass('d-none');
                        $(".sp__wrapper").append(function (){
                            return $("<div>").attr('class', 'participant_w participant__w_get_info')
                                .attr('model-id', participant['id'])
                                .attr('title', 'Više informacija')
                                .append(function (){
                                    return $("<p>").text(participant['name']);
                                });
                        });

                        if(checked){
                            $("#participant_name").val("");
                        }else{
                            /** Set checked to false */
                            $("#pr__checkbox").prop('checked', false);
                            /** Close wrapper */
                            $(".participants").addClass('d-none');
                        }

                        $(".total-participants").text(response['data']['total']);
                    }else{
                        Notify.Me([response['message'], "warn"]);
                    }
                }
            });
        }
    });

    /**
     *  Fetch author and set it
     */
    $("body").on('click', '.participant__w_get_info', function (){
        let id = $(this).attr('model-id');

        $.ajax({
            url: fetchParticipantUri,
            method: "post",
            dataType: "json",
            data: {
                id: id
            },
            success: function success(response) {
                $(".loading").fadeOut();

                let code = response['code'];

                if(code === '0000'){
                    let participant = response['data']['participant'];

                    $(".participants").removeClass('d-none');
                    $(".participants-title").text("Uredite učesnika");

                    /** Hide repeat checkbox and set as unchecked */
                    $(".participants__repeat").addClass('d-none');
                    $("#pr__checkbox").prop('checked', false);

                    /** Show delete button */
                    $(".remove-participant").removeClass('d-none');

                    /** Set info */
                    $("#participant_name").val(participant['name']);
                    participantGlobalID = participant['id'];

                    updateParticipant = true;
                }else{
                    Notify.Me([response['message'], "warn"]);
                }
            }
        });
    })

    /**
     *  Delete participants
     */
    $(".remove-participant").click(function (){
        $.ajax({
            url: deleteParticipantUri,
            method: "post",
            dataType: "json",
            data: {
                id: participantGlobalID
            },
            success: function success(response) {
                $(".loading").fadeOut();

                let code = response['code'];

                if(code === '0000'){
                    $('.participant_w[model-id="' + participantGlobalID + '"]').remove();

                    $("#participant_name").val("");
                    $(".participants").addClass('d-none');

                    updateParticipant = false;

                    if($(".participant_w").length === 0){
                        $(".shared_participants").addClass('d-none');
                    }

                    $(".total-participants").text(response['data']['total']);

                    Notify.Me([response['message'], "success"]);
                }else{
                    Notify.Me([response['message'], "warn"]);
                }
            }
        });
    })

    /**
     *  Open and close form
     */
    $(".close-preview-participants").click(function (){
        $(".participants").addClass('d-none');
    });
    let openForm = function (){
        /** Show wrapper */
        $(".participants").removeClass('d-none');

        /** Hide "Delete button" */
        $(".remove-participant").addClass('d-none');

        /** Show repeat checkbox and set as unchecked */
        $(".participants__repeat").removeClass('d-none');
        $("#pr__checkbox").prop('checked', false);

        /** Set title */
        $(".participants-title").text("Dodajte učesnika");

        /** Reset info */
        $("#participant_name").val("");

        updateParticipant = false;
    };

    /** Open participants and set event type to ie */
    $(".internal-events-add-participant").click(function (){
        /** Set type to internal events */
        type = 'ie';

        openForm();
    });
    $(".bodies-add-participant").click(function (){
        /** Set type to internal events */
        type = 'bodies';

        openForm();
    });

    /** Close whenever you click */
    $(".participants").click(function (event){
        if($(event.target).hasClass('participants')){
            $(".participants").addClass('d-none');
        }
    });
});
