$(function () {
  $("#login_user_form").validity(function () {
    $("#phoneNumber")                      // The first input:
      .require()                          // Required:
      .match("number")                    // In the format of a number:
      .maxLength(10, "Phone Number must be a 10 digit number");

    $("#pin")                           // The second input:
      .require()                          // Required:
      .match("number")                    // In the format of a number:
      .maxLength(4, "Pin must be a four digit number");                    // In the format of a number:
  });

})();