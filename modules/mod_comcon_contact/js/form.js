var ContactForm = (function()
{
  var contactModel = (function()
  {
    var model =
    {
      allRequired: [],
      url: "",
      response: "",
      responsePass: false,
      requiredComplete: false
    };

    var handleAJAXError = function(jqXHR, textStatus, errorThrown)
    {
      console.log(jqXHR.responseText);
      console.log(textStatus);
      console.log(errorThrown);
    };

    var setRecaptchaResponse = function(response)
    {
      model.response = response;
    };

    var setRecaptchaPass = function(value)
    {
      model.responsePass = value;
    };

    var checkFormReady = function()
    {
      if ((model.responsePass == true && model.requiredComplete == true))
      {
        return true;
      }
      else
      {
        return false;
      }
    };

    return {
      init: function()
      {
        //waitRequiredComplete();
      },
      recaptchaCallback: function(response)
      {
        setRecaptchaResponse(response);
        
        var request = $.ajax({url: model.url,
          type: "GET",
          contentType: "application/json",
          dataType: "json",
          data: { response: response },
          success: function(response)
          {
            if (response.success === true)
            {
              setRecaptchaPass(response.success);
              checkFormReady();
            }
            else if (response.success === false)
            {
              setRecaptchaPass(response.success);
              checkFormReady();
            }
          },
          error: handleAJAXError
        });
      },
      recaptchaExpired: function(expired)
      {
        setRecaptchaPass(false);
      },
      setAJAXUrl: function(url)
      {
        model.url = url;
      },
      showAJAXUrl: function()
      {
        console.log(model.url);
      },
      // Set all required fields with requiredComplete property
      setAllRequired: function(elements)
      {
        elements.forEach(function(el)
        {
          model.allRequired.push(el);
        });
      },
      setRequiredCompleteValue: function(value)
      {
        model.requiredComplete = value;
      },
      showRequiredComplete: function()
      {
        return model.requiredComplete;
      },
      // Check if all fields have been completed, and the reCaptcha is valid
      checkFormReady: function()
      {
        var flag = checkFormReady();
        return flag;
      }
    }
  })();

  var contactView = (function()
  {
    // Keep track of all of the required inputs
    var allRequired = [];

    var allowSubmit = false;

    var DOMStrings =
    {
      emailId: "#email",
      formId: "#contactform",
      teleId: "#tele",
      submitId: "#send",
      failure: "failure",
      form: "contact-form",
      formVisible: "contact-form--visible"
    };

    var enableForm = function()
    {
      $(DOMStrings.formId).removeClass(DOMStrings.form);
      $(DOMStrings.formId).addClass(DOMStrings.formVisible);
    };

    // Get all required inputs in the form
    var setAllRequired = function()
    {
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
    };

    // If the user clicks away from a required field, notify them
    // that it needs to be completed
    var inputPrompt = function()
    {
      allRequired.forEach(el =>
      {
        // User leaves the input
        $(el).on("focusout", function(e)
        {
          // No value entered into the input
          if (this.value.length === 0)
          {
            // Add CSS class to prompt them of error
            if (!$(this).hasClass(DOMStrings.failure))
            {
              $(this).addClass(DOMStrings.failure);
            }
          }
          else
          {
            if ($(this).hasClass(DOMStrings.failure))
            {
              $(this).removeClass(DOMStrings.failure);
            }
          }
        });
      });
    };

    // Only allow numbers to be input into the field
    var inputNumbersOnly = function(element)
    {
      $(element).keypress(function(e)
      {
        var ev = e || window.event;

        // Get the key input from either the keyboard, or keypress
        var key = ev.type === 'paste' ? ev.clipBoardData.getData('text/plain') : String.fromCharCode((ev.keyCode || ev.which));

        // Filter
        let regex = /[0-9]|\+/;
        if (!regex.test(key))
        {
          ev.returnValue = false;
          if (ev.preventDefault) ev.preventDefault();
        }
      });
    };

    // Check valid email address entered
    var inputEmail = function(element)
    {
      $(element).on("focusout", function()
      {
        let input = $(this).val();
        let regex = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,63}\b$/i;

        // If the email address doesn't pass the test, then add CSS class prompt
        if (input.length > 0)
        {
          if (!regex.test(input))
          {
            if (!$(this).hasClass(DOMStrings.failure));
            {
              $(this).addClass(DOMStrings.failure);
            }
          }
          else
          {
            if ($(this).hasClass(DOMStrings.failure))
            {
              $(this).removeClass(DOMStrings.failure);
            }
          }
        }
      });
    };

    return {
      init: function()
      {
        enableForm();
        setAllRequired();
        inputPrompt();
        inputNumbersOnly(DOMStrings.teleId);
        inputEmail(DOMStrings.emailId);
      },
      toggleSubmit: function(condition)
      {
        if (condition)
        {
          $(DOMStrings.submitId).attr("disabled", false);
        }
        else
        {
          $(DOMStrings.submitId).attr("disabled", true);
        }
      },
      getAllRequired: function()
      {
        return allRequired;
      },
      getForm: function()
      {
        return $(DOMStrings.formId);
      },
      getSubmit: function()
      {
        return $(DOMStrings.submitId);
      },
      // Set condition to enable form submit
      setSubmitCondition: function(condition)
      {

      }
    }
  })();

  var contactController = (function(m, v)
  {
    var data =
    {
      allRequired: []
    };

    var setAllRequired = function(elements)
    {
      elements.forEach(function(el)
      {
        data.allRequired.push(el);
      });
    };

    var checkRequired = function()
    {
      // Bool to track whether all inputs completed
      var flag = true;
      data.allRequired.forEach(el =>
      {
        if ($(el).val().trim().length === 0 || $(el).val().trim() === '')
        {
          flag = false;
          m.setRequiredCompleteValue(flag);
          return false;
        }
      });
      if (flag) { m.setRequiredCompleteValue(flag); }
      return flag;
    }

    var setEvents = function()
    {
      // Add event to inputs to check if all completed
      data.allRequired.forEach(el =>
      {
        $(el).change(checkRequired);
        $(el).change(m.checkFormReady);
      });

      // Disable default submit action, check if everything completed before submitting
      var submit = v.getSubmit();
      var form = v.getForm();
      submit.submit(function(e)
      {
        e.preventDefault();
      });
      submit.on('click', function(e)
      {
        var flag = m.checkFormReady();
        if (flag)
        {
          return true;
        }
        else
        {
          return false;
        }
      });
    };

    return {
      init: function()
      {
        v.init();
        m.init();
        m.setAllRequired(v.getAllRequired());
        setAllRequired(v.getAllRequired());
        setEvents();
      },
      logRequiredComplete: function()
      {
        //console.log(required);
      },
      recaptchaCallback: function(response)
      {
        m.recaptchaCallback(response);
      },
      recaptchaExpired: function(expired)
      {
        m.recaptchaExpired(expired);
      },
      setAJAXUrl: function(url)
      {
        m.setAJAXUrl(url);
      },
      showAJAXUrl: function()
      {
        m.showAJAXUrl();
      }
    }
  })(contactModel, contactView);


  return {
    init: function(url)
    {
      $(document).ready(function()
      {
        contactController.init();
        contactController.setAJAXUrl(url);
      });
    },
    recaptchaCallback: function(response)
    {
      contactController.recaptchaCallback(response);
    },
    recaptchaExpired: function(expired)
    {
      contactController.recaptchaExpired(expired);
    },
    showAJAXUrl: function()
    {
      contactController.showAJAXUrl();
    }
  }
})();

export default ContactForm;
