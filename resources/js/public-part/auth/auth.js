import { Notify } from './../../style/layout/notify.ts';
import { Validator } from "../../style/layout/validator.ts";

$( document ).ready(function() {
    let loginUrl = '/auth/authenticate';
    /* Save account - Register form */
    let saveAccUri  = '/auth/save-account';
    /* Restart password token */
    let generateTokenUri = '/auth/generate-restart-token';
    /* Generate new password */
    let generatePasswordUri = '/auth/generate-new-password';

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let signMeIn = function(){
        let email    = $("#email").val();
        let password = $("#password").val();

        if(!Validator.email(email)){
            Notify.Me(["Uneseni email nije validan!", "warn"]);
            return;
        }

        $.ajax({
            url: loginUrl,
            method: 'POST',
            dataType: "json",
            data: {
                email: email,
                password: password
            },
            success: function success(response) {
                let code = response['code'];

                if(code === '0000'){
                    window.location = response['url'];
                }else{
                    Notify.Me([response['message'], "warn"]);
                }
            }
        });
    };

    $(".auth-btn").click(function () {
        signMeIn();
    });

    $(document).on('keypress',function(e) {
        if(e.which === 13) {
            if($(".auth-btn").length) signMeIn();
        }
    });

    /* -------------------------------------------------------------------------------------------------------------- */
    /*
     *  Create new profile; Steps included
     */

    let step = 1;
    let progressElements = function(){
        $(".rf-body-element").addClass('d-none');
        $(".rf-body-element-" + step).removeClass('d-none');

        (step === 1) ? $(".create-profile-back-btn").addClass('d-none') : $(".create-profile-back-btn").removeClass('d-none');

        if(step === 2){
            $(".pl-e-bar-fill").css('width', '30%');
        }else if(step === 3){
            $(".pl-e-bar-fill").css('width', '50%');
        }else if(step === 4){
            $(".pl-e-bar-fill").css('width', '70%');
        }else if(step === 5){
            $(".pl-e-bar-fill").css('width', '90%');
            $(".button-wrapper").addClass('d-none');
        }else if(step === 1){
            $(".pl-e-bar-fill").css('width', '12.5%');
        }
    };

    $(".create-profile-next-btn").click(function () {
        let first_name = $("#first_name").val();
        let last_name  = $("#last_name").val();
        let email    = $("#email").val();
        let password = $("#password").val();
        let prefix = $("#prefix").val();
        let phone  = $("#phone").val();
        let birth_date = $("#birth_date").val();
        let gender     = $("#gender").val();

        let address  = $("#address").val();
        let city     = $("#city").val();

        let workplace   = $("#workplace").val();
        let institution = $("#institution").val();

        /**
         *  Education info
         */
        let ue_level  = $("#ue_level").val();
        let ue_school = $("#ue_school").val();
        let ue_university = $("#ue_university").val();
        let ue_title      = $("#ue_title").val();
        let ue_graduation_date = $("#ue_graduation_date").val();

        if(step === 1){
            if(first_name === '' || last_name === ''){
                Notify.Me(["Ime i prezime ne mogu biti prazni", "warn"]);
                return;
            }
            if(!Validator.email(email)) {
                Notify.Me(["Molimo da unesete validnu email adresu !", "warn"]);
                return;
            }
            if(password === ''){
                Notify.Me(["Molimo da unesete Vašu šifru", "warn"]);
                return;
            }
        }else if(step === 2){
            if(phone === ''){
                Notify.Me(["Unesite Vaš broj telefona", "warn"]);
                return;
            }
            // if(!Validator.date(birth_date)) {
            //     Notify.Me(["Molimo da odaberete datum Vašeg rođenja. Ispravan format je dd.mm.YYYY ", "warn"]);
            //     return;
            // }
            if(address === ''){
                Notify.Me(["Molimo da unesete Vašu adresu stanovanja", "warn"]);
                return;
            }
            if(city === ''){
                Notify.Me(["Molimo unesite grad u kojem živite", "warn"]);
                return;
            }
        }else if(step === 3){
            if(workplace === ''){
                Notify.Me(["Molimo unesite Vaše radno mjesto", "warn"]);
                return;
            }
            if(institution === ''){
                Notify.Me(["Molimo da odaberete instituciju u kojoj radite", "warn"]);
                return;
            }
        }else if(step === 4){


            /* Process request */
            $(".pl-e-bar-fill").css('width', '95%');
            $(".loading-gif").removeClass('d-none');


            $.ajax({
                url: saveAccUri,
                method: 'POST',
                dataType: "json",
                data: {
                    first_name: first_name,
                    last_name: last_name,
                    email: email,
                    password: password,
                    phone: phone,
                    birth_date: birth_date,
                    gender: gender,
                    address: address,
                    city: city,
                    workplace: workplace,
                    institution: institution,
                    ue_level: ue_level,
                    ue_school: ue_school,
                    ue_university: ue_university,
                    ue_title: ue_title,
                    ue_graduation_date: ue_graduation_date
                },
                success: function success(response) {
                    $(".loading-gif").addClass('d-none');

                    let code = response['code'];

                    if(code === '0000'){
                        step ++;
                        progressElements();

                        /* Hide buttons */
                        $(".back-next-btn-wrapper").addClass('d-none');
                    }else{
                        Notify.Me([response['message'], "warn"]);
                    }
                    console.log(response);
                }
            });
        }

        if(step < 4) step++;
        progressElements();
    });

    $(".create-profile-back-btn").click(function () {
        if(step > 1) step--;
        progressElements();
    });

    /* -------------------------------------------------------------------------------------------------------------- */
    /*
     *  Restart password functions
     */

    let generateToken = function(){
        let email  = $("#email");
        let loader = $(".loading-gif");

        if(!Validator.email(email.val())){
            Notify.Me(["Uneseni email nije validan!", "warn"]);
            return;
        }

        /* Show loading gif */
        loader.removeClass('d-none');

        $.ajax({
            url: generateTokenUri,
            method: 'POST',
            dataType: "json",
            data: {
                email: email.val()
            },
            success: function success(response) {
                let code = response['code'];

                /* Hide back */
                loader.addClass('d-none');

                if(code === '0000'){
                    Notify.Me([response['message'], "success"]);
                    email.val("");
                }else{
                    Notify.Me([response['message'], "warn"]);
                }
            }
        });
    };
    $(".generate-token-btn").click(function (){
       generateToken();
    });

    /**
     *  Generate new password
     */
    let generateNewPassword = function(){
        let loader = $(".loading-gif");

        let email  = $("#email");
        let password = $("#password");
        let repeat   = $("#passwordRepeat");

        if(!Validator.email(email.val())){
            Notify.Me(["Uneseni email nije validan!", "warn"]);
            return;
        }

        /* Show loading gif */
        // loader.removeClass('d-none');

        $.ajax({
            url: generatePasswordUri,
            method: 'POST',
            dataType: "json",
            data: {
                email: email.val(),
                password: password.val(),
                repeat: repeat.val(),
                token: $("#token").val()
            },
            success: function success(response) {
                let code = response['code'];

                /* Hide back */
                // loader.addClass('d-none');

                if(code === '0000'){
                    window.location = response['url'];
                }else{
                    /* If there is try to hack, redirect */
                    // if(code === '11416'){
                    //     window.location = response['data']['url'];
                    // }else Notify.Me([response['message'], "warn"]);

                    Notify.Me([response['message'], "warn"]);
                }
            }
        });
    };
    $(".generate-password-btn").click(function (){
        generateNewPassword();
    });
});
