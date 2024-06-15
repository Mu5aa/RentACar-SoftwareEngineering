var users = [];
var trips = [];
var idCounter = 1;

serializeForm = (form) => {
  let jsonResult = {};
  $.each($(form).serializeArray(), function () {
    jsonResult[this.name] = this.value;
  });
  return jsonResult;
};

blockUi = (element) => {
  $(element).block({
    message: '<div class="spinner-border text-primary" role="status"></div>',
    css: {
      backgroundColor: "transparent",
      border: "0",
    },
    overlayCSS: {
      backgroundColor: "#000",
      opacity: 0.25,
    },
  });
};

unblockUi = (element) => {
  $(element).unblock({});
};



$("#register-form").validate({
  rules: {
    first_name: {
      required: true,
      minlength: 5,
    },
    username: {
        required: true,
        minlength: 5,
      },
    password: {
      required: true,
      minlength: 5,
    },
    email: {
        required: true,
        email: true,
    },
    confirm_password: {
      equalTo: "#password",
    },
  },
  messages: {
    first_name: {
      required: "You have to fill it in!",
      minlength: "Too short buddy.!",
    },
    confirm_password: {
       equalTo: "The password and confirm password fields should be the same",
    },
  },
  submitHandler: function (form, event) {
    event.preventDefault();
    blockUi("#register-form"); 
    let data = serializeForm(form);
    users.push(data);
    $("#register-form")[0].reset();
    console.log(users); 
    unblockUi("#register-form"); 
    window.location.href = "#login";

  },
});


// Validate and handle the login form submission
$("#login-form").validate({
  rules: {
    username: {
      required: true,
      minlength: 5,
    },
    password: {
      required: true,
      minlength: 5,
    },
  },
  messages: {
    username: {
      required: "You have to fill it in!",
      minlength: "Too short buddy!",
    },
  },
  submitHandler: function (form, event) {
    event.preventDefault();
    blockUi("#login-form");

    let data = serializeForm(form);
    console.log("Login data:", data);

    RestClient.post(
      'auth/login',
      data,
      function (response) {
        unblockUi("#login-form");
        Utils.set_to_localstorage("user", response);
        console.log('Login successful, navigating to #pocetna');
        window.location.hash = "#pocetna";1
      },
      function (error) {
        unblockUi("#login-form");
        toastr.error(error.responseText);
      }
    );
  },
});


  $("#contact-form").validate({
    rules: {
        name: {
            required: true,
            minlength: 5,
        },
        email: {
            required: true,
            email: true,
        },
        message: {
            required: true,
            maxlength: 500,
        },
    },
    messages: {
        name: {
            required: "Please enter your name.",
            minlength: "Name must be at least 5 characters.",
        },
        email: {
            required: "Please enter your email address.",
            email: "Please enter a valid email address.",
        },
        message: {
            required: "Please enter your message.",
            maxlength: "Message cannot exceed 500 characters.",
        },
    },
    submitHandler: function (form, event) {
        event.preventDefault();
        blockUi("#contact-form");
        let formData = $(form).serialize();

        console.log("Contact form data:", formData);
        unblockUi("#contact-form");
    },
});



  $("#edit-profile-form").validate({
    rules: {
      name: {
        required: true,
        minlength: 5,
      },
      bio: {
        required: true,
        maxlength: 500,
      },
    },
    messages: {
      name: {
        required: "You have to fill it in!",
        minlength: "Too short buddy!",
      },
      bio: { 
        required: "Bio is required!",
        maxlength: "Bio cannot exceed 500 characters!",
      },
    },
    submitHandler: function (form, event) {
      event.preventDefault();
      blockUi("#edit-profile-form");
      let data = serializeForm(form);

  
      console.log("Updated profile data:", data);
      unblockUi("#edit-profile-form");

      users.push(data);
      $("#edit-profile-form")[0].reset();
      console.log(users);
  
      alert("Profile has been successfully updated");
    },
  });
  

  $(document).ready(function () {
    $("#change-password-form").validate({
        rules: {
            current_password: {
                required: true,
                minlength: 5,
            },
            new_password: {
                required: true,
                minlength: 5,
            },
            confirm_password: {
                equalTo: "#new_password", // Ensure it matches the new password field
            },
        },
        messages: {
            current_password: {
                required: "You have to fill it in!",
                minlength: "Too short buddy!",
            },
            new_password: {
                required: "You have to fill it in!",
                minlength: "Too short buddy!",
            },
            confirm_password: {
                equalTo: "The new password and confirm password fields should be the same",
            },
        },
        invalidHandler: function (form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                alert("Please fill in all the required fields.");
            }
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            var newPassword = $("#new_password").val();
            var confirmPassword = $("#confirm_password").val();
            if (newPassword.trim() === '' || confirmPassword.trim() === '') {
                alert("Please fill in all the required fields.");
                return;
            }
            if (newPassword === confirmPassword) {
                blockUi("#change-password-form");
                let data = serializeForm(form);

                console.log("Changed password:", data);
                unblockUi("#change-password-form");
                alert("Password has been successfully changed");
            } else {
                alert("The new password and confirm password should be the same");
            }
        },
    });
});

$("#pick-up-date, #drop-off-date").datepicker({
  dateFormat: 'yy-mm-dd' // Adjust the date format as needed
});

$("#pick-up-time").timepicker({
  timeFormat: 'HH:mm', // Adjust the time format as needed
  interval: 15, // Interval of 15 minutes
  minTime: '00:00', // Minimum time
  maxTime: '23:45', // Maximum time
  defaultTime: '12:00', // Default time
  startTime: '00:00', // Start time
  dynamic: false,
  dropdown: true,
  scrollbar: true
});

// Booking form validation and submission
$("#booking-form").validate({
  rules: {
    "pickup_location": {
      required: true,
    },
    "dropoff_location": {
      required: true,
    },
    "pickup_date": {
      required: true,
    },
    "dropoff_date": {
      required: true,
    },
    "card_holder_name": {
      required: true,
    },
    "card_number": {
      required: true,
      creditcard: true, // Ensures valid credit card number
    },
    "exp_date": {
      required: true,
      date: true, // Ensures valid date format
    },
    "ccv": {
      required: true,
      digits: true, // Ensures only numeric digits
      minlength: 3,
      maxlength: 4,
    },
    "zip_code": {
      required: true,
      digits: true, // Ensures only numeric digits
    },
  },
  messages: {
    "pickup_location": {
      required: "Please enter pick-up location.",
    },
    "dropoff_location": {
      required: "Please enter drop-off location.",
    },
    "pickup_date": {
      required: "Please select pick-up date.",
    },
    "dropoff_date": {
      required: "Please select drop-off date.",
    },
    "card_holder_name": {
      required: "Please enter the card holder's name.",
    },
    "card_number": {
      required: "Please enter a credit card number.",
      creditcard: "Please enter a valid credit card number.",
    },
    "exp_date": {
      required: "Please enter the expiry date.",
      date: "Please enter a valid date (MM/YY).",
    },
    "ccv": {
      required: "Please enter the CCV.",
      digits: "CCV must be a numeric value.",
      minlength: "CCV must be at least 3 digits.",
      maxlength: "CCV can be at most 4 digits.",
    },
    "zip_code": {
      required: "Please enter the zip code.",
      digits: "Zip code must be a numeric value.",
    },
  },
  submitHandler: function (form, event) {
    event.preventDefault();
    blockUi("#booking-form");
    
    let formData = serializeForm(form); // Using serializeForm for consistency
    console.log("Rent form data:", formData);
    
    trips.push(formData);
    $(form)[0].reset();
    console.log(trips);
    
    unblockUi("#booking-form");
    alert("Your car has been booked successfully.");
  },
});


  blockUi = (element) => {
    $(element).block({
      message: '<div class="spinner-border text-primary" role="status"></div>',
      css: {
        backgroundColor: "transparent",
        border: "0",
      },
      overlayCSS: {
        backgroundColor: "#000",
        opacity: 0.25,
      },
    });
  };
  
  unblockUi = (element) => {
    $(element).unblock({});
  };
  
