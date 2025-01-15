import { Notify } from './../../../style/layout/notify.ts';
import { Validator } from "../../../style/layout/validator.ts";

$("document").ready(function (){
    let saveAuthorUri = '/system/admin/trainings/save-author';

    /**
     * Change switch state
     * @type {string}
     */
    let switchState = "off";
    $(".add-author-switch").click(function (){
        if(switchState === "off"){
            /* Add author */
            $(this).addClass('switched');
            $(this).attr('state', 'on');

            $(".ta_search__author").addClass('d-none');
            $(".ta_insert__author").removeClass('d-none');

            switchState = "on";
            $(".add-author-note").text('Dodajte autora');
        }else{
            /* Search for authors */
            $(this).removeClass('switched');
            $(this).attr('state', 'off');

            $(".ta_search__author").removeClass('d-none');
            $(".ta_insert__author").addClass('d-none');

            switchState = "off";
            $(".add-author-note").text('Pretraga autora');
        }
    });

    /**
     *  Change type of author: Company or user
     */
    $(".author_type").change(function (){
        if(parseInt($(this).val()) === 18){
            /* User */
            $(".author_title_label").text('Ime i prezime');
        }else{
            /* Company */
            $(".author_title_label").text('Naziv kompanije');
        }
    });

    /**
     *  Save author
     */
    $(".save-author").click(function (){
        let training_id = $(".author_training_id").val();
        let search_author = $(".search_author").val();

        let type    = $(".author_type").val();
        let title   = $(".author_title").val();
        let email   = $(".author_email").val();
        let address = $(".author_address").val();
        let city    = $(".author_city").val();
        let phone   = $(".author_phone").val();
        let cellphone = $(".author_cellphone").val();
        let comment   = $(".author_comment").val();

        if(switchState === "off"){
            /* Searched author */
            if(search_author === ''){
                Notify.Me(["Molimo da odaberete autora", "warn"]);
                return;
            }
        }else{
            /* New author */

            if(title === ''){
                if(parseInt(type) === 18){
                    Notify.Me(["Molimo da unesete ime i prezime", "warn"]);
                }else{
                    Notify.Me(["Molimo da unesete naziv kompanije", "warn"]);
                }
                return;
            }
            if(!Validator.email(email)){
                Notify.Me(["Molimo da unesete validnu email adresu", "warn"]);
                return;
            }

            if(address === ''){
                Notify.Me(["Molimo da unesete adresu", "warn"]);
                return;
            }
            if(phone === '' || cellphone === ''){
                Notify.Me(["Molimo da unesete broj telefona i mobitela", "warn"]);
                return;
            }
        }

        $.ajax({
            url: saveAuthorUri,
            method: "post",
            dataType: "json",
            data: {
                training_id: training_id,
                switchState: switchState,
                search_author: search_author,
                type: type,
                title: title,
                email: email,
                address: address,
                city: city,
                phone: phone,
                cellphone: cellphone,
                comment: comment
            },
            success: function success(response) {
                $(".loading").fadeOut();

                let code = response['code'];

                if(code === '0000'){
                    if(typeof response['message'] !== 'undefined') Notify.Me([response['message'], "success"]);

                    setTimeout(function (){
                        if(typeof response['url'] !== 'undefined') window.location = response['url'];
                    }, 2000);
                }else{
                    Notify.Me([response['message'], "warn"]);
                }
                console.log(response, typeof response['link']);
            }
        });
    });

    /**
     *  Open and close form
     */
    $(".close-add-author").click(function (){
        $(".add__author_wrapper").addClass('d-none');
    });
    $(".open-add-author").click(function (){
        $(".add__author_wrapper").removeClass('d-none');
    });
});
