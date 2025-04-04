import { Notify } from './../../../../style/layout/notify.ts';
import { Validator } from "../../../../style/layout/validator.ts";

$("document").ready(function () {
    let fetchLocationUri = '/system/admin/trainings/instances/apis/locations/fetch';
    let fetchUserLocationUri = '/system/user-data/trainings/apis/locations/fetch';
    let fetchTrainerLocationUri = '/system/trainer-data/trainings/apis/locations/fetch';

    /**
     *  Open and close form
     */
    $(".close-preview-location").click(function (){
        $(".preview__location_wrapper").addClass('d-none');
    });
    $(".preview__location_wrapper").click(function (event){
        if($(event.target).hasClass('preview__location_wrapper')){
            $(".preview__location_wrapper").addClass('d-none');
        }
    });

    let fetchLocationInfo = function(id, uri){
        $.ajax({
            url: uri,
            method: "post",
            dataType: "json",
            data: {
                id: id
            },
            success: function success(response) {
                $(".loading").fadeOut(0);

                if(response['code'] === '0000'){

                    let location = response['data']['location'];

                    $(".preview-location-title").text(location['title']);
                    $(".pl_address").val(location['address']);
                    $(".pl_city").val(location['city_rel']['title']);
                    $(".pl_phone").val(location['phone']);
                    $(".pl_email").val(location['email']);

                    if($(".pl-uri").length){
                        // Not Admin, can be used
                        $(".pl-uri").attr('href', response['data']['uri']);
                    }
                    $(".preview__location_wrapper").removeClass('d-none');
                }else{
                    Notify.Me([response['message'], "warn"]);
                }
            }
        });
    }
    $(".location-info").click(function (){
        fetchLocationInfo($(this).attr('location-id'), fetchLocationUri);
    })
    $(".location-user-info").click(function (){
        fetchLocationInfo($(this).attr('location-id'), fetchUserLocationUri);
    })
    $(".location-trainer-info").click(function (){
        fetchLocationInfo($(this).attr('location-id'), fetchTrainerLocationUri);
    })
});
