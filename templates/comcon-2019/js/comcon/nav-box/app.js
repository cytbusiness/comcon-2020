$(document).ready(function()
{
  $(".nav-box__link").on("click", function(e)
  {
    let element = this;

    if ($(element).attr('href') == "#")
    {
      e.preventDefault();
    }

    let navbox = $(element).parent(".nav-box").toArray()[0];
    let parent = $(navbox).closest("ul").toArray()[0];
    let children = $(navbox).children(".nav-box__children").toArray()[0];

    let allNavBoxes = $(".nav-box").toArray();
    let allChildren = $(".nav-box__children").toArray();

    allNavBoxes.forEach(el =>
    {
      // Don't alter the current navbox
      if (el != navbox)
      {
        // Only modify if part of the same parent
        if ($(el).parent().toArray()[0] == parent)
        {
          if ($(el).hasClass("nav-box--show"))
          {
            $(el).removeClass("nav-box--show");
          }
        }
      }
      else
      {
        if ($(el).hasClass("nav-box--show"))
        {
          $(el).removeClass("nav-box--show");
        }
        else
        {
          $(el).addClass("nav-box--show");
        }
      }
    });

    allChildren.forEach(el =>
    {
      if (el != children)
      {
        if ($(el).hasClass("nav-box__children--visible"))
        {
          $(el).removeClass("nav-box__children--visible");
        }
      }
      else
      {
        if ($(el).hasClass("nav-box__children--visible"))
        {
          $(el).removeClass("nav-box__children--visible");
        }
        else
        {
          $(el).addClass("nav-box__children--visible");
        }
      }
    });
  });

  // Hide dropdown tag if the link isn't a dropdown
  $(".nav-box__caption").each(function()
  {
    // console.log($(this).closest(".nav-box__link"));
    if ($(this).closest(".nav-box__link").attr('href') != "#")
    {
      $(this).addClass(".nav-box__caption--nodrop");
    }
  });
});
