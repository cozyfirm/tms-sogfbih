import { Notify } from './../../../style/layout/notify.ts';
import { Validator } from "../../../style/layout/validator.ts";

$("document").ready(function (){
    let saveAuthorUri = '/system/admin/trainings/save-author';
    let fetchAuthorUri = '/system/admin/trainings/fetch-author';

    /**
     *  Global vars
     */
    let authorGlobalID = 0;
    let updateAuthor = false;

    /**
     * Change switch state
     * @type {string}
     */
    let switchState = "off";
    function changeSwitchState(){
        let switchBtn = $(".add-author-switch");

        if(switchState === "off"){
            /* Add author */
            switchBtn.addClass('switched');
            switchBtn.attr('state', 'on');

            $(".ta_search__author").addClass('d-none');
            $(".ta_insert__author").removeClass('d-none');

            switchState = "on";
            $(".add-author-note").text('Dodajte autora');
        }else{
            /* Search for authors */
            switchBtn.removeClass('switched');
            switchBtn.attr('state', 'off');

            $(".ta_search__author").removeClass('d-none');
            $(".ta_insert__author").addClass('d-none');

            switchState = "off";
            $(".add-author-note").text('Pretraga autora');
        }
    }

    $(".add-author-switch").click(function (){
        changeSwitchState();
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

            /* Set Author ID as global variable */
            authorGlobalID = search_author;
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
                authorGlobalID: authorGlobalID,
                updateAuthor: updateAuthor,
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
                    /* Reset update flag */
                    updateAuthor = false;

                    if(typeof response['message'] !== 'undefined') Notify.Me([response['message'], "success"]);

                    setTimeout(function (){
                        if(typeof response['url'] !== 'undefined') window.location = response['url'];
                    }, 2000);
                }else{
                    Notify.Me([response['message'], "warn"]);
                }
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
        /**
         *  SET GUI INFO
         */
        $(".add-author-note").text('Pretraga autora');
        $(".add-author-title").text('Autori programa');
        $(".add-author-desc").text('Unesite ili odaberite autora programa obuke');
        $(".save-author").text('SAČUVAJTE');

        /* Allow switching */
        $(".switch").removeClass('d-none');

        /* Set flag to false */
        updateAuthor = false;

        $(".add__author_wrapper").removeClass('d-none');
    });

    $(".add__author_wrapper").click(function (event){
        if($(event.target).hasClass('add__author_wrapper')){
            $(".add__author_wrapper").addClass('d-none');
        }
    });

    /**
     *  Preview Author info
     */
    $(".training-check-author").click(function (){
        authorGlobalID = $(this).attr('author-id');

        /* Set switch state */
        switchState = "off";
        $(".switch").addClass('d-none');

        /* Set flag to true */
        updateAuthor = true;

        $(".loading").fadeIn(5);

        $.ajax({
            url: fetchAuthorUri,
            method: "post",
            dataType: "json",
            data: {
                authorID: authorGlobalID
            },
            success: function success(response) {
                $(".loading").fadeOut(0);

                $(".add__author_wrapper").removeClass('d-none');

                /* Change switch state */
                changeSwitchState();

                let code = response['code'];

                if(code === '0000'){
                    let author = response['data']['author'];

                    $(".author_type").val(author['type']);
                    $(".author_title").val(author['title']);
                    $(".author_email").val(author['email']);
                    $(".author_address").val(author['address']);
                    $(".author_city").val(author['city']);
                    $(".author_phone").val(author['phone']);
                    $(".author_cellphone").val(author['cellphone']);
                    $(".author_comment").val(author['comment']);

                    /**
                     *  PopUp GUI content
                     */
                    $(".add-author-note").text("Pregled autora");
                    $(".add-author-title").text(author['title']);
                    $(".add-author-desc").text('Detaljan pregled autora obuke');
                    $(".save-author").text('AŽURIRAJTE');

                    if(parseInt(author['type']) === 18){
                        /* User */
                        $(".author_title_label").text('Ime i prezime');
                    }else{
                        /* Company */
                        $(".author_title_label").text('Naziv kompanije');
                    }
                }else{
                    Notify.Me([response['message'], "warn"]);
                }
            }
        });


        console.log(authorGlobalID);
    });
});
