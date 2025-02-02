import { Notify } from './../../../../style/layout/notify.ts';
import { Validator } from "../../../../style/layout/validator.ts";

$("document").ready(function () {
    let saveTrainerUri = '/system/admin/trainings/save-author';
    let fetchTrainerUri = '/system/admin/trainings/fetch-author';

    $(".instances-add-trainer").click(function (){
        $(".add__trainer_wrapper").removeClass('d-none');
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
});
