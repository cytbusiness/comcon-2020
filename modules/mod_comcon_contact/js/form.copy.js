$(document).ready(function()
{
  // Enable the form when JavaScript is enabled
  let enableForm = function()
  {
    $("#contactform").removeClass("contact-form");
    $("#contactform").addClass("contact-form--visible");
  };

  // If the user clicks away from a required field, notify them
  // that it needs to be completed
  let inputPrompt = function()
  {
    // Put all the required fields into one array
    allRequired = [];
    $("input[required]").toArray().forEach(el =>
    {
      allRequired.push(el);
    });
    $("select[required]").toArray().forEach(el =>
    {
      allRequired.push(el);
    });
    $("textarea[required]").toArray().forEach(el =>
    {
      allRequired.push(el);
    });

    allRequired.forEach(el =>
    {
      $(el).on("focusout", function(e)
      {
        if (this.value.length === 0)
        {
          if (!$(this).hasClass("failure"))
          {
            $(this).addClass("failure");
          }
        }
        else
        {
          if ($(this).hasClass("failure"))
          {
            $(this).removeClass("failure");
          }
        }
      });
    });
  };

  // Only allow numbers to be input to the field
  let inputNumbersOnly = function(element)
  {
    $(element).keypress(function(e)
    {
      let ev = e || window.event;

      // Get the key input from either the clipboard or keypress
      let key = ev.type === 'paste' ? ev.clipBoardData.getData('text/plain') : String.fromCharCode((ev.keyCode || ev.which));

      let regex = /[0-9]|\+/;
      if (!regex.test(key))
      {
        ev.returnValue = false;
        if (ev.preventDefault) ev.preventDefault();
      }
    });
  };

  // Check valid email address entered
  let inputEmail = function(element)
  {
    $(element).on("focusout", function()
    {
      let input = $(this).val();
      let regex = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

      if (!regex.test(input))
      {
        if (!$(this).hasClass("failure"))
        {
          $(this).addClass("failure");
        }
      }
      else
      {
        if ($(this).hasClass("failure"))
        {
          $(this).removeClass("failure");
        }
      }
    });
  };

  let disableSubmit = function()
  {
    $("#submit").attr("disabled", true);
  };

  // Enable form submit after reCaptcha check and required fields set.
  let enableSubmit = function()
  {
    $("#submit").attr("disabled", false);
  };

  // Init
  enableForm();
  inputNumbersOnly("#tele");
  inputEmail("#email");
  inputPrompt();
  // disableSubmit();
});
