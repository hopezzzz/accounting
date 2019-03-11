$(document).ready(function ()
{
    var minPhoneLen = 10;
    var maxPhoneLen = 15;
    $.validator.addMethod("noSpace", function(value, element,param)
    {
//      	return value.indexOf(" ") >= 0 && value != "";
          return $.trim(value).length >= param;

    }, "No space please and don't leave it empty");
    /*$.validator.addMethod('minStrict', function (value, el, param) {
        return value > param;
    },"Rate should be greater then 0.00");*/
    /*====================Start login form validation================= */
    var site_url = $('#site_url').val();
    $("#login-form").validate({
        errorClass   : "has-error",
        highlight    : function(element, errorClass) {
            $(element).parents('.form-group').addClass(errorClass);
        },
        unhighlight  : function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass(errorClass);
        },
        rules:
                {
                    email:
                            {
                                required: true,
                                noSpace: true,
                                email: true
                            },
                    password:
                            {
                                required: true,
                                noSpace: true,
                                minlength: 5,
                            }
                },
        messages:
                {
                    email: {
                        required: "Email is required.",
                        email: "Please enter valid email",
                    },
                    password: {
                        required: "Password is required.",
                        minlength: "Password must contain at least 5 characters.",
                    },
                },
        submitHandler: function (form)
        {
            formSubmit(form);
        }
    });

    //forgot Password
    $("#forgotPassword-form").validate({
        errorClass   : "has-error",
        highlight    : function(element, errorClass) {
            $(element).parents('.form-group').addClass(errorClass);
        },
        unhighlight  : function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass(errorClass);
        },
        rules:
                {
                    email:
                            {
                                required: true,
                                noSpace: true,
                                email: true
                            },
                },
        messages:
                {
                    email: {
                        required: "Email is required.",
                        email: "Please enter valid email",
                    },
                },
        submitHandler: function (form)
        {
            formSubmit(form);
        }
    });

    // register Email
    $("#emailVerification-form").validate({
        errorClass   : "has-error",
        highlight    : function(element, errorClass) {
            $(element).parents('.form-group').addClass(errorClass);
        },
        unhighlight  : function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass(errorClass);
        },
        rules:
                {
                    email:
                            {
                                required: true,
                                noSpace: true,
                                email: true
                            },
                },
        messages:
                {
                    email: {
                        required: "Email is required.",
                        email: "Please enter valid email",
                    },
                },
        submitHandler: function (form)
        {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                dataType: "json",
                beforeSend: function () {
                    $(".loader_div").css("display", "block");
                },
                complete: function () {
                    $(".loader_div").css("display", "none");
                },
                success: function (response) {
                    if (response.success)
                    {
                        $("#successMsg").addClass("alert alert-success");
                        $("#successMsg").removeClass("alert-danger");
                        $("#successMsg").css("display", "block");
                        $("#step-2").css("display", "block");
                        $('#successMsg').html(response.success_message);
                        $("#step-1").css("display", "none");
                        $('#step1').removeClass("btn-success");
                        $('#step2').addClass("btn-success");
                        setTimeout(
                                function ()
                                {
                                    //  window.location = site_url + "register2/";
                                    $("#step-2").css("display", "block");
                                }, 3000);
                        setTimeout(
                                function ()
                                {
                                    //  window.location = site_url + "register2/";
                                   $("#successMsg").css("display", "none");
                                }, 5000);
                    }
                    else if (!response.success)
                    {
                        $("#step2").addClass("invalidMail");
                        $("#successMsg").addClass("alert alert-danger");
                        $("#successMsg").removeClass("alert-success");
                        $("#successMsg").css("display", "block");
                        //$("#successMsg").fadeOut();
                        setTimeout(
                        function ()
                        {
                            //  window.location = site_url + "register2/";
                           $("#successMsg").css("display", "none");
                        }, 4000);
                        $('#successMsg').html(response.error_message);
                    }
                }
            });
        }
    });

    //register Company
    $("#registerCompany-form").validate({
        errorClass   : "has-error",
        highlight    : function(element, errorClass) {
            $(element).parents('.form-group').addClass(errorClass);
        },
        unhighlight  : function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass(errorClass);
        },
        rules:
                {
                    companyName:
                            {
                                required: true,
                                noSpace: true
                            },
                    contactName:
                            {
                                required: true,
                                noSpace: true
                            },
                    contactPhone:
                            {
                                required: true,
                                minlength: 8,
                                maxlength: 15
                            },
                },
        messages:
                {
                    companyName: "Company Name is required.",
                    contactName: "Contact Name is required.",
                    contactPhone: {
                        'required' :"Phone is required.",
                        'minlength' :"Phone must contain at least 8 characters",
                        'maxlength' :"Phone must contain at least 15 characters",
                    },
                },
        submitHandler: function (form)
        {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                dataType: "json",
                beforeSend: function () {
                    $(".loader_div").css("display", "block");
                },
                complete: function () {
                    $(".loader_div").css("display", "none");
                },
                success: function (response) {
                    if (response.success)
                    {
                        $("#successMsg2").addClass("alert alert-success");
                        $("#successMsg2").removeClass("alert-danger");
                        $("#successMsg2").css("display", "block");
                        $("#step-2").css("display", "block");
                        $('#successMsg2').html(response.success_message);
                        setTimeout(
                                function ()
                                {
                                    window.location = site_url + "dashboard/";
                                }, 2000);
                    }
                    else if (!response.success)
                    {
                        $("#successMsg2").addClass("alert alert-danger");
                        $("#successMsg2").removeClass("alert-success");
                        $("#successMsg2").css("display", "block");
                        $('#successMsg2').html(response.error_message);
                    }
                }
            });
        }
    });


    //change Password-form
    $("#changePassword-form").validate({
        errorClass: "has-error",
        highlight: function (element, errorClass) {
            $(element).parents('.form-group').addClass(errorClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass(errorClass);
        },
        rules:
                {
                    oldPassword:
                            {
                                required: true,
                                noSpace: true
                            },
                    newPassword:
                            {
                                required: true,
                                noSpace: true,
                                minlength: 5,
                                // equalTo: '#confirmPassword'
                            },
                    confirmPassword:
                            {
                                required: true,
                                noSpace: true,
                                minlength: 5,
                                equalTo: '#newPassword'
                            },
                },
        messages:
                {
                    oldPassword: "Old Password is required.",
                    newPassword:
                            {
                                'required': "New Password is required.",
                                'minlength': "New Password must contain at least 5 characters.",
                                //'equalTo': "New Password and Confirm Password not mactched."
                            },
                    confirmPassword:
                            {
                                'required': "Confirm Password is required.",
                                'minlength': "Confirm Password must contain at least 5 characters.",
                                'equalTo': "New Password and Confirm Password not mactched."
                            },
                },
        submitHandler: function (form)
        {
            formSubmit(form);
        }
    });
	 //add-debtor-form
    $("#add-debtor-form").validate({
        errorClass: "has-error",
        highlight: function (element, errorClass) {
            $(element).parents('.form-group').addClass(errorClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass(errorClass);
        },
        rules:
                {
                  debtorCompanyRef:
                  {
                      required: true,
                      noSpace: true,
                  },
                    title:
                            {
                                required: true,
                                noSpace: true
                            },
                  firstName:
                            {
                                required: true,
                                noSpace: true,
                            },
                companyname:
                            {
                              required: function(element) {
                                  var company = $('#companySelect').val();
                                  if( company == 'addnew' )
                                      return true;
                                  else
                                      return false;
                            },
                    noSpace: true,
                            },
                    lastName:
                            {
                                required: true,
                                noSpace: true
                                // equalTo: '#confirmPassword'
                            },
                    email:
                            {
                                required: true,
                                noSpace: true,
                                email: true,
                            },
                    phone:
                            {
                                required: true,
                                //number : true,
                            },
                },
        messages:
                {
                    title: "Title is required.",
                    comapny: "This field is required.",
                    companyname: "This field  is required.",
                    firstName: "First Name is required.",
                    lastName: "Last Name is required.",
                    phone:
                            {
                                'required': "Phone No. is required.",
                                //'number': "Phone No must contain number only.",
                            },
                    email: {
                        required: "Email is required.",
                        email: "Please enter valid email",
                    },
                },
        submitHandler: function (form)
        {
            formSubmit(form);
        }
    });

	//add-creditor-form
    $("#add-creditor-form").validate({
        errorClass: "has-error",
        highlight: function (element, errorClass) {
            $(element).parents('.form-group').addClass(errorClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass(errorClass);
        },
        rules:
                {
                  creditorCompanyRef:
                  {
                      required: true,
                      noSpace: true,
                  },
                    title:
                            {
                                required: true,
                                noSpace: true
                            },
                  firstName:
                            {
                                required: true,
                                noSpace: true,
                            },
                            companyname:
                            {
                                required: function(element) {
                                    var company = $('#companySelect').val();
                                    if( company == 'addnew' )
                                        return true;
                                    else
                                        return false;
                                },
                                noSpace: true,
                            },
                    lastName:
                            {
                                required: true,
                                noSpace: true
                                // equalTo: '#confirmPassword'
                            },
                    email:
                            {
                                required: true,
                                noSpace: true,
                                email: true,
                            },
                    phone:
                            {
                                required: true,
                                //number : true,
                            },
                },
        messages:
                {
                    title: "Title is required.",
                    comapny: "This field is required.",
                    companyname: "This field  is required.",
                    firstName: "First Name is required.",
                    lastName: "Last Name is required.",
                    phone:
                            {
                                'required': "Phone No. is required.",
                                //'number': "Phone No must contain number only.",
                            },
                    email: {
                        required: "Email is required.",
                        email: "Please enter valid email",
                    },
                },
        submitHandler: function (form)
        {
            formSubmit(form);
        }
    });

    /***************** Add client step one ***************/
    $("#client-form-1").validate({
        errorClass   : "has-error",
        highlight    : function(element, errorClass) {
            $(element).parents('.form-group').addClass(errorClass);
        },
        unhighlight  : function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass(errorClass);
        },
        rules:
        {
            title:{
                required: true,
                noSpace: true
            },
            firstName:{
                required: true,
                noSpace: true
            },
            lastName:{
                required: true,
                noSpace: true
            },
            email:{
                required: true,
                noSpace: true,
                email: true
            },
            phone:{
                minlength : 10,
                maxlength : 17
            },
            mobile:{
                minlength : 10,
                maxlength : 17
            },
            fax:{
                minlength : 6,
                maxlength : 15
            },
            website:{
                url: true,
            }
        },
        messages:
        {
            title     : "Please select a title.",
            firstName : "The First Name is required.",
            lastName  : "The Last Name is required.",
            email     : {
                required    : "The Email is required.",
                email       : "Invalid email.",
            },
            phone     : {
                maxlength   : "Maximum length should be 15.",
                minlength   : "Minimum length should be 10.",
            },
            mobile     : {
                maxlength   : "Maximum length should be 15.",
                minlength   : "Minimum length should be 10.",
            },
            fax     : {
                maxlength   : "Maximum length should be 15.",
                minlength   : "Minimum length should be 6.",
            },
            url :"The website url is invalid.",
        },
        submitHandler: function (form)
        {
            formSubmit(form);
        }
    });

    /***************** Add client step two ***************/
    $("#client-form-2").validate({
        errorClass   : "has-error",
        highlight    : function(element, errorClass) {
            $(element).parents('.form-group').addClass(errorClass);
        },
        unhighlight  : function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass(errorClass);
        },
        rules:
        {
            companyName:{
                required: true,
                noSpace: true
            },
            companyType:{
                required: true,
                noSpace: true
            },
            /*compRegNo:{
                required: true,
                noSpace: true
            },
            corporationTaxRef:{
                required: true
            },
            dateOfIncorporation:{
                required: true
            },*/
            returnDate:{
                required: true,
                noSpace: true
            },
            yearEndDate:{
                required: true,
                noSpace: true
            },
            companyLogo:{
                accept : 'gif,csv,jpg,jpeg,png'
            }
        },
        messages:
        {
            companyName          : "The company name is required.",
            companyType          : "",
            /*compRegNo            : "The registration number is required.",
            corporationTaxRef    : "The corporation tax reference is required.",
            dateOfIncorporation  : "The date of incorporation is required.",*/
            returnDate           : "The return date is required.",
            yearEndDate          : "The year end date is required.",
            companyLogo          : {
                accept   : "Only Gif, CSV, JPG, JPEG, PNG files are allowed.",
            },
        },
        submitHandler: function (form)
        {
            formSubmit(form);
        }
    });

    //Purchase Form Validations
    $("#add-purchase-form").validate({

        errorClass: "has-error",
        highlight: function (element, errorClass) {
            $(element).parents('.form-group').addClass(errorClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass(errorClass);
        },
        ignore: ':hidden:not(.do-not-ignore)',
        rules:
                {
                    paymentMethod:
                            {
                                required: true,
                                noSpace: true
                            },
                    bankRef:
                    {
                        required: function(element) {
                            var payMethod = $('#payMethod').val();
                            if( payMethod == '2' || payMethod == '4' || payMethod == '5' )
                            {
                                return true;
                            }
                            else
                            {
                                return false;
                            }

                        },
                    },
                    payeeRef:
                    {
                        required: function(element) {
                            var creditorName = $('.creditorName').val();
                            var payeeRef = $('.payeeRef').val();
                            console.log('payeeRef => ' + payeeRef);
                            if( creditorName != '' && payeeRef == '' )
                            {
                                return true;
                            }
                            else
                            {
                                return false;
                            }

                        },
                    },
                    purchaseType:
                            {
                                required: true,
                                noSpace: true
                            },
                    type:
                            {
                                required: true,
                                noSpace: true
                            },
                    payeeName:
                            {
                              required: function(element) {
                                  var payMethod = $('#payMethod').val();
                                  if( payMethod == '3' )
                                  {
                                      return true;
                                  }
                                  else
                                  {
                                      return false;
                                  }

                              },
                            },
                    "addNewProductService[]":
                            {
                                required: true,
                            },
                    "productRef[]":
                            {
                                required: true,
                            },
                    "quantity[]":
                            {
                                required: true,
                            },
                    "rate[]":
                            {
                                required: true,
                            },
                    "serviceRef[]":
                            {
                                required: true,
                            },
                    "qtyType[]":
                            {
                                required: true,
                            }
                },
        messages:
                {
                    paymentMethod             : "Payment Method is required.",
                    bankRef                   : "Bank Name is required.",
                    payeeRef                   : "Please enter valid payee name.",
                    purchaseType              : "Purchase Type  is required.",
                    type                      : "Type  is required.",
                    "addNewProductService[]"  : "Product Name is required.",
                    payeeName                 : "Payee Name is required.",
                    "productRef[]"               : "Product / Service Name is required.",
                    "quantity[]"              : "QTY is required.",
                    "rate[]"                  : "Rate is required.",
                    "serviceRef[]"        : "Expense Category is required.",
                    "qtyType[]"               : "QTY Type is required.",

                },
        submitHandler: function (form)
        {
            formSubmit(form);
        }
    });

    $(".productRef").each(function()
    {

        $(this).rules('remove');
        $(this).rules('add', {
                required: true,
                messages: {
                    required: "Product / Service Name is required."
                },
         });
    });
    $(".serviceRefValidate").each(function()
    {

        $(this).rules('remove');
        $(this).rules('add', {
                required: true,
                messages: {
                    required: "Expense Category is required."
                },
         });
    });

    $(".productServiceQty").each(function()
    {
        $(this).rules('remove');
        $(this).rules('add', {
                required: true,
                noSpace: true,
                messages: {
                    required: "QTY is required."
                },
         });
    });

    $(".oneServiceProductPrice").each(function()
    {
        $(this).rules('remove');
        $(this).rules('add', {
                required: true,
                noSpace: true,
                messages: {
                    required: "Rate is required."
                },
         });
    });
    $(".qtyType").each(function()
    {
        $(this).rules('remove');
        $(this).rules('add', {
                required: true,
                noSpace: true,
                messages: {
                    required: "Qty Type is required."
                },
         });
    });
    //addbankform Form Validations
    $("#addbankform").validate({
        errorClass: "has-error",
        highlight: function (element, errorClass) {
            $(element).parents('.form-group').addClass(errorClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass(errorClass);
        },
        rules:
                {
                    name:
                            {
                                required: true,
                            },
                    code:
                            {
                                required: true,
                                noSpace: true
                            },
                    accountNumber:
                            {
                                required: true,
                            },
                },
        messages:
                {
                    name: "Bank Name is required.",
                    code: "Bank Code is required.",
                    accountNumber: "Account Number is required.",

                },
        submitHandler: function (form)
        {
            formSubmit(form);
        }
    });

    //add Loans Form Validations
    $("#ajaxaddBorrowing").validate({
        errorClass: "has-error",
        highlight: function (element, errorClass) {
            $(element).parents('.form-group').addClass(errorClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass(errorClass);
        },
        rules:
                {
                    borrowName:
                            {
                                required: true,
                                noSpace:true,
                            },

                    amount:
                            {
                                required: true,

                            },
                    date:
                            {
                                required: true,
                            },
                    bankRef:
                            {
                                required: true,
                            },
                    loanType:
                            {
                                required: true,
                            },
                },
        messages:
                {
                    borrowName: "Borrower Name is required.",
                    amount: "Amount is required.",
                    date: "Date is required.",
                    bankRef: "This field is required.",
                    loanType: "Loan Type is required.",

                },
        submitHandler: function (form)
        {
            formSubmit(form);
        }
    });
    //add Loans Form Validations
    $("#ajaxaddLoans").validate({
        errorClass: "has-error",
        highlight: function (element, errorClass) {
            $(element).parents('.form-group').addClass(errorClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass(errorClass);
        },
        rules:
                {
                    borrowName:
                            {
                                required: true,
                                noSpace:true,
                            },

                    amount:
                            {
                                required: true,

                            },
                    date:
                            {
                                required: true,
                            },
                    bankRef:
                            {
                                required: true,
                            },
                    loanType:
                            {
                                required: true,
                            },
                },
        messages:
                {
                    borrowName: "Lender Name is required.",
                    amount: "Amount is required.",
                    date: "Date is required.",
                    bankRef: "This field is required.",
                    loanType: "Loan Type is required.",

                },
        submitHandler: function (form)
        {
            formSubmit(form);
        }
    });


    //add-share-form
      $("#add-share-form").validate({
          errorClass: "has-error",
          highlight: function (element, errorClass) {
              $(element).parents('.form-group').addClass(errorClass);
          },
          unhighlight: function (element, errorClass, validClass) {
              $(element).parents('.form-group').removeClass(errorClass);
          },
          rules:
                  {
                    shareholCompanyRef:
                    {
                        required: true,
                        noSpace: true,
                    },

                      firstName:
                              {
                                  required: true,
                                  noSpace: true,
                              },
                      lastName:
                              {
                                  required: true,
                                  noSpace: true,
                                  // equalTo: '#confirmPassword'
                              },
                      email:
                              {
                                  required: true,
                                  noSpace: true,
                                  email: true,
                              },
                      noOfShare:
                              {
                                  required: true,
                                  //number : true,
                              },
                      companyname:
                      {
                          required: function(element) {
                              var company = $('#companySelect').val();
                              if( company == 'addnew' )
                                  return true;
                              else
                                  return false;
                          },
                          noSpace: true,
                      },

                  },
          messages:
                  {
                      firstName: "First Name is required.",
                      lastName: "Last Name is required.",
                      shareholCompanyRef: "Company Name is required.",
                      comapny: "This field is required.",
                      companyname: "This field  is required.",
                      noOfShare:
                              {
                                  'required': "Number of shares is required.",
                                  //'number': "Phone No must contain number only.",
                              },
                      email: {
                          required: "Email is required.",
                          email: "Please enter valid email",
                      },
                  },
          submitHandler: function (form)
          {
              formSubmit(form);
          }
      });

    //add-borrower-form
    $("#add-borrower-form").validate({
        errorClass: "has-error",
        highlight: function (element, errorClass) {
            $(element).parents('.form-group').addClass(errorClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass(errorClass);
        },
        rules:
            {
                borrowerCompanyRef:
                {
                    required: true,
                    noSpace: true,
                },
                firstName:
                {
                    required: function(element) {
                        var company = $('#companySelect').val();
                        if( company != 'addnew' )
                            return true;
                        else
                            return false;
                    },
                    noSpace: function(element) {
                        var company = $('#companySelect').val();
                        if( company != 'addnew' && company != '' )
                            return true;
                        else
                            return false;
                    },
                },
                companyname:
                {
                    required: function(element) {
                        var company = $('#companySelect').val();
                        if( company == 'addnew' )
                            return true;
                        else
                            return false;
                    },
                    noSpace: true,
                },
                email:
                {
                    required: true,
                    noSpace: true,
                    email: true,
                }
            },
        messages:
            {
                firstName: "This field is required.",
                comapny: "This field is required.",
                companyname: "This field  is required.",
                email: {
                    required: "This field is required.",
                    email: "Please enter valid email",
                },
            },
        submitHandler: function (form)
        {
            formSubmit(form);
        }
    });


    //dd-share-capital-form Form Validations
    $("#add-share-capital-form").validate({

      errorClass: "has-error",
      highlight: function (element, errorClass) {
          $(element).parents('.form-group').addClass(errorClass);
      },
      unhighlight: function (element, errorClass, validClass) {
          $(element).parents('.form-group').removeClass(errorClass);
      },
      ignore : '',
      rules:
              {
                  paymentMethod:
                          {
                              required: true,
                          },
                  shareHolderRef:
                          {
                            required: function(element) {
                                var shareHolderReff = $('#shareHolderRef').val();
                                if( shareHolderReff == '' )
                                    return true;
                                else
                                    return false;
                            },
                              noSpace:true,
                          },
                  bankRef:
                  {
                      required: function(element) {
                          var payMethod = $('#payMethod').val();
                          if( payMethod == '2' || payMethod == '4' || payMethod == '5' )
                          {
                              return true;
                          }
                          else
                          {
                              return false;
                          }

                      },
                  },
              "quantity[]":
                      {
                              required: true,
                              noSpace : true
                      },
              "rate[]":
                      {
                              required: true,
                              noSpace : true
                      },
              },
      messages:
              {
                  paymentMethod : "Payment Method is required.",
                  shareHolderRef     : "Share Holder Name is required.",
                  bankRef     : "Bank is required.",
                  "quantity[0]" : "QTY is required.",
                  "rate[0]"     : "Rate is required.",

              },
        submitHandler: function (form)
        {
            formSubmit(form);
        }
    });

    $(".shareQty").each(function()
    {
        $(this).rules('remove');
        $(this).rules('add', {
                required: true,
                messages: {
                  required: "QTY is required."
                },
         });
    });

    $(".shareRate").each(function()
    {
        $(this).rules('remove');
        $(this).rules('add', {
                required: true,
                messages: {
                  required: "Rate is required."
                },
         });
    });

    //add-accounting-form
    $("#addAccounting").validate({
        errorClass: "has-error",
        highlight: function (element, errorClass) {
            $(element).parents('.form-group').addClass(errorClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass(errorClass);
        },
        rules:
            {
                cattype:
                {
                    required: true,
                },

                title:
                {
                    required: true,
                },
                ParentCategory:
                {
                    required: true,
                }
            },
        messages:
            {
                cattype: "Category Type is required.",
                title: "Category is required.",
                ParentCategory: "Parent Category is required.",
            },
        submitHandler: function (form)
        {
            formSubmit(form);
        }
    });

    $("#delete-chart-form").validate({

        submitHandler: function (form)
        {
            formSubmit(form);
        }
    });
    $("#unit-of-measurement").validate({
      errorClass: "has-error",
      highlight: function (element, errorClass) {
          $(element).parents('.form-group').addClass(errorClass);
      },
      unhighlight: function (element, errorClass, validClass) {
          $(element).parents('.form-group').removeClass(errorClass);
      },
      rules:
          {
              typeName:
              {
                  required: true,
              },
          },
      messages:
          {
              typeName: "Unit of measurement is required.",
          },
        submitHandler: function (form)
        {
            formSubmit(form);
        }
    });



 });


function formSubmit(form)
{
    $.ajax({
        url         : form.action,
        type        : form.method,
        //data        : $(form).serialize(),
        data        : new FormData(form),
        contentType : false,
        cache       : false,
        processData : false,
        dataType    : "json",
        beforeSend  : function () {
            $("input[type=submit]").attr("disabled", "disabled");
            $(".loader_div").show();
        },
        complete: function () {
            $(".loader_div").hide();
        },
        success: function (response) {
            $(".loader_div").hide();
            jQuery('#addAccounting').attr('action',"");
            $("input[type=submit]").removeAttr("disabled");
            $.toast().reset('all');
            var delayTime = 3000;
            if(response.delayTime)
                delayTime = response.delayTime;
            if (response.success)
            {

                $.toast({
                    heading             : 'Success',
                    text                : response.success_message,
                    loader              : true,
                    loaderBg            : '#fff',
                    showHideTransition  : 'fade',
                    icon                : 'success',
                    hideAfter           : delayTime,
                    position            : 'top-right'
                });
            }
            else
            {
                if( response.formErrors)
                {
                    $.each(response.errors, function( index, value )
                    {
                        $("input[name='"+index+"']").parents('.form-group').addClass('has-error');
                        $("input[name='"+index+"']").after('<label id="'+index+'-error" class="has-error" for="'+index+'">'+value+'</label>');

                        $("select[name='"+index+"']").parents('.form-group').addClass('has-error');
                        $("select[name='"+index+"']").after('<label id="'+index+'-error" class="has-error" for="'+index+'">'+value+'</label>');
                    });
                }
                else
                {
                    $.toast({
                        heading             : 'Error',
                        text                : response.error_message,
                        loader              : true,
                        loaderBg            : '#fff',
                        showHideTransition  : 'fade',
                        icon                : 'error',
                        hideAfter           : delayTime,
                        position            : 'top-right'
                    });
                }
            }
            if(response.modelhide)
            {
              $('#add-Category-modal').modal('hide');
              $('#confirm-status-update-modal-chart').modal('hide');
              if( response.status == 1 )
  						{
  							$('#accounting_'+response.categoryRef).find('.statusTd').html('<span class="label label-success">Active</span>');
  							$('#accounting_'+response.categoryRef).find('.updateAccounting').html('Make Inactive').attr('data-status',response.status);
  						}
  						else
  						{
  							$('#accounting_'+response.categoryRef).find('.statusTd').html('<span class="label label-warning">Inactive</span>');
  							$('#accounting_'+response.categoryRef).find('.updateAccounting').html('Make Active').attr('data-status',response.status);
  						}
              var srNo       = jQuery('#add-Category-modal #selectedSrNo').val();
              jQuery('.trSrNo'+srNo).find('.searchExpense').val(response.title);
              jQuery('.trSrNo'+srNo).find('.serviceRef').val(response.subcatRef);
              jQuery('.trSrNo'+srNo).find('.ParentCategoryRef').val(response.ParentCategoryRef);

            }
            if(response.ajaxPageCallBack)
            {
                response.formid = form.id;
                ajaxPageCallBack(response);
            }

            if(response.resetform)
            {
                $('#'+form.id).resetForm();
            }
            if(response.submitDisabled)
            {
                  $("input[type=submit]").attr("disabled", "disabled");
                  $("button[type=submit]").attr("disabled", "disabled");
            }
            if(response.url)
            {
                if(response.delayTime)
                    setTimeout(function() { window.location.href=response.url;}, response.delayTime);
                else
                    window.location.href=response.url;
            }
        },
        error:function(response){
            var delayTime = 3000;
            $.toast({
                heading             : 'Error',
                text                : 'Connection error.',
                loader              : true,
                loaderBg            : '#fff',
                showHideTransition  : 'fade',
                icon                : 'error',
                hideAfter           : delayTime,
                position            : 'top-right'
            });
        }
    });
}
