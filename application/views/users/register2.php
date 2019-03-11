<!DOCTYPE html>
<html>
    <head>
        <style>
            button.accordion {
                background-color: #eee;
                color: #444;
                cursor: pointer;
                padding: 18px;
                width: 100%;
                border: none;
                text-align: left;
                outline: none;
                font-size: 15px;
                transition: 0.4s;
            }

            button.accordion.active, button.accordion:hover {
                background-color: #ddd;
            }

            button.accordion:after {
                content: '\002B';
                color: #777;
                font-weight: bold;
                float: right;
                margin-left: 5px;
            }

            button.accordion.active:after {
                content: "\2212";
            }

            div.panel {
                padding: 0 180px;
                background-color: white;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.2s ease-out;
            }
        </style>
    </head>
    <body>
        <?php
        echo validation_errors();
//$clientData = $this->session->userdata('clientData');
        ?>                                 <div id="successMsg" style="display:none;" ></div>        
        <?php echo form_open('emailVerification', array('name' => 'emailVerification', 'method' => 'post', 'class' => 'form form-signup', 'id' => "emailVerification-form"));
        ?>
        <?php if ($clientData->isEmailVerified == 1) { ?><h4>Confirm your email address: <?php echo $clientData->clientEmail; ?> <span id="resentVerificationEmail" ref="<?php echo $clientData->clientEmail; ?>" >Resend verification email</span></h4><?php } ?>

        <div>
            <div id="successMsg" style="display:none;" ></div>
            <h5>Step 1: Email </h5>   <?php if ($clientData->isEmailVerified == 1) {
            echo 'Verification pending';
        } else {
            echo $clientData->clientEmail;
        } ?><br>

            <h5>Step 2: Company Details</h5><br>
            <ul>
                <li>Company Name 
                    <input type="text" class="form-control" name="email" id="checkemail" placeholder="Company Name" >
                </li>
                <li>Company Type 
                    <input type="radio" class="form-control" value="Trading" name="companyType" >Trading
                    <input type="radio" class="form-control" value="Service/Consultancy" name="companyType" >Service/Consultancy
                </li>

            </ul>
            <h5>Contact Person</h5>
            <ul>
                <li>Name 
                    <input type="text" class="form-control" name="contactName" id="contactName" >
                </li>
                <li>Phone
                    <input type="text" class="form-control" name="contactPhone" >
                </li>

            </ul>

            <h5>Step 3: VAT NO</h5><br>


            <input type="text" class="form-control" name="email" id="checkemail" placeholder="VAT NO" >
            <br><br><input type="submit" id="emailNextBtn" placeholder="Submit" />

        </div>

        <!--        <h5 class="accordion">Company Information</h5>
                <div class="panel">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
        
                <h5 class="accordion">Vat Information</h5>
                <div class="panel">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        
                    <input type="submit" class="btn btn-sm btn-primary btn-sign-now" role="button" placeholder="Login"> 
                </div>-->
<?php echo form_close(); ?>          
        <script>
            var acc = document.getElementsByClassName("accordion");
            var i;

            for (i = 0; i < acc.length; i++) {
                acc[i].onclick = function () {
                    this.classList.toggle("active");
                    var panel = this.nextElementSibling;
                    if (panel.style.maxHeight) {
                        panel.style.maxHeight = null;
                    } else {
                        panel.style.maxHeight = panel.scrollHeight + "1px";
                    }
                }
            }
        </script>

    </body>
</html>
<style>
    input[type="text"],
    input[type="email"],
    input[type="date"],
    select.form-control {
        height: 50px;
        margin: 0;
        padding: 0 20px;
        vertical-align: middle;
        background: #f8f8f8;
        border: 3px solid #ddd;
        font-family: 'Roboto', sans-serif;
        font-size: 16px;
        font-weight: 300;
        line-height: 50px;
        color: #888;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px;
        -moz-box-shadow: none;
        -webkit-box-shadow: none;
        box-shadow: none;
        -o-transition: all .3s;
        -moz-transition: all .3s;
        -webkit-transition: all .3s;
        -ms-transition: all .3s;
        transition: all .3s;
    }

    input[type="file"] {
        height: 35px;
        margin: 0;
        padding: 0 20px;
        vertical-align: bottom;
        background: #f8f8f8;
        border: 3px solid #ddd;
        font-family: 'Roboto', sans-serif;
        font-size: 16px;
        font-weight: 300;
        line-height: 30px;
        color: #888;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px;
        -moz-box-shadow: none;
        -webkit-box-shadow: none;
        box-shadow: none;
        -o-transition: all .3s;
        -moz-transition: all .3s;
        -webkit-transition: all .3s;
        -ms-transition: all .3s;
        transition: all .3s;
    }

    input[type=radio] {
        margin-top: 8px !important;
    }

    textarea,
    textarea.form-control {
        padding-top: 10px;
        padding-bottom: 10px;
        line-height: 30px;
    }

    input[type="text"]:focus,
    input[type="password"]:focus,
    textarea:focus,
    textarea.form-control:focus {
        outline: 0;
        background: #fff;
        border: 3px solid #ccc;
        -moz-box-shadow: none;
        -webkit-box-shadow: none;
        box-shadow: none;
    }

    input[type="text"]:-moz-placeholder,
    input[type="password"]:-moz-placeholder,
    textarea:-moz-placeholder,
    textarea.form-control:-moz-placeholder {
        color: #888;
    }

    input[type="text"]:-ms-input-placeholder,
    input[type="password"]:-ms-input-placeholder,
    textarea:-ms-input-placeholder,
    textarea.form-control:-ms-input-placeholder {
        color: #888;
    }

    input[type="text"]::-webkit-input-placeholder,
    input[type="password"]::-webkit-input-placeholder,
    textarea::-webkit-input-placeholder,
    textarea.form-control::-webkit-input-placeholder {
        color: #888;
    }

    button.btn {
        height: 50px;
        margin: 0;
        padding: 0 20px;
        vertical-align: middle;
        background: #26A69A;
        ;
        border: 0;
        font-family: 'Roboto', sans-serif;
        font-size: 16px;
        font-weight: 300;
        line-height: 50px;
        color: #fff;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px;
        text-shadow: none;
        -moz-box-shadow: none;
        -webkit-box-shadow: none;
        box-shadow: none;
        -o-transition: all .3s;
        -moz-transition: all .3s;
        -webkit-transition: all .3s;
        -ms-transition: all .3s;
        transition: all .3s;
    }

    button.btn:hover {
        opacity: 0.6;
        color: #fff;
    }

    button.btn:active {
        outline: 0;
        opacity: 0.6;
        color: #fff;
        -moz-box-shadow: none;
        -webkit-box-shadow: none;
        box-shadow: none;
    }

    button.btn:focus {
        outline: 0;
        opacity: 0.6;
        background: #26A69A;
        ;
        color: #fff;
    }

    button.btn:active:focus,
    button.btn.active:focus {
        outline: 0;
        opacity: 0.6;
        background: #26A69A;
        ;
        color: #fff;
    }


    /*style.css**/

    body {
        font-family: 'Roboto', sans-serif;
        font-size: 16px;
        font-weight: 300;
        color: #888;
        line-height: 30px;
        text-align: center;
    }

    strong {
        font-weight: 500;
    }

    a,
    a:hover,
    a:focus {
        color: #26A69A;
        ;
        text-decoration: none;
        -o-transition: all .3s;
        -moz-transition: all .3s;
        -webkit-transition: all .3s;
        -ms-transition: all .3s;
        transition: all .3s;
    }

    h1,
    h2 {
        margin-top: 10px;
        font-size: 38px;
        font-weight: 100;
        color: #555;
        line-height: 50px;
    }

    h3 {
        font-size: 22px;
        font-weight: 300;
        color: #555;
        line-height: 30px;
    }

    ::-moz-selection {
        background: #26A69A;
        ;
        color: #fff;
        text-shadow: none;
    }

    ::selection {
        background: #26A69A;
        ;
        color: #fff;
        text-shadow: none;
    }

    .btn-link-1 {
        display: inline-block;
        height: 50px;
        margin: 0 5px;
        padding: 16px 20px 0 20px;
        background: #26A69A;
        font-size: 16px;
        font-weight: 300;
        line-height: 16px;
        color: #fff;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px;
    }

    .btn-link-1:hover,
    .btn-link-1:focus,
    .btn-link-1:active {
        outline: 0;
        opacity: 0.6;
        color: #fff;
    }

    .btn-link-2 {
        display: inline-block;
        height: 50px;
        margin: 0 5px;
        padding: 15px 20px 0 20px;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid #fff;
        font-size: 16px;
        font-weight: 300;
        line-height: 16px;
        color: #fff;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px;
    }

    .btn-link-2:hover,
    .btn-link-2:focus,
    .btn-link-2:active,
    .btn-link-2:active:focus {
        outline: 0;
        opacity: 0.6;
        background: rgba(0, 0, 0, 0.3);
        color: #fff;
    }


    /***** Top content *****/

    .form-box {
        padding-top: 40px;
        font-family: 'Roboto', sans-serif !important;
    }

    .form-top {
        overflow: hidden;
        padding: 0 25px 15px 25px;
        background: #26A69A;
        -moz-border-radius: 4px 4px 0 0;
        -webkit-border-radius: 4px 4px 0 0;
        border-radius: 4px 4px 0 0;
        text-align: left;
        color: #fff;
        transition: opacity .3s ease-in-out;
    }

    .form-top h3 {
        color: #fff;
    }

    .form-bottom {
        padding: 25px 25px 30px 25px;
        background: #eee;
        -moz-border-radius: 0 0 4px 4px;
        -webkit-border-radius: 0 0 4px 4px;
        border-radius: 0 0 4px 4px;
        text-align: left;
        transition: all .4s ease-in-out;
    }

    .form-bottom:hover {
        -webkit-box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    }

    form .form-bottom button.btn {
        min-width: 105px;
    }

    form .form-bottom .input-error {
        border-color: #d03e3e;
        color: #d03e3e;
    }

    form.registration-form fieldset {
        display: none;
    }
</style>