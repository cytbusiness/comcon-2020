let downloads = (function()
{
  let model = (function()
  {

  })();

  let view = (function()
  {
    let strings =
    {
      base: [],
      downloads: [],
      fullscreen: [],
      product: []
    };

    let objects =
    {
      dlbtns: []
    };

    let addFullscreen = function(button)
    {
      $("body").append(`<div class="${strings.fullscreen.fullscreen} ${strings.fullscreen.downloads}">
        <a href="#" class="${strings.fullscreen.exit}" title="Close (Esc)"></a>
        <div class="${strings.fullscreen.container} ${strings.fullscreen.containerd}">

        </div>
      </div>`);

      // Clone the hidden download section by id into the fullscreen window
      $($(button).attr("href")).clone().appendTo("." + strings.fullscreen.container);
      //console.log(button);

      // Remove the invisibility of the section
      $("." + strings.fullscreen.container).find("." + strings.downloads.downloads).toggleClass(strings.downloads.invisible);
      $("." + strings.fullscreen.container).find("." + strings.downloads.title).toggleClass(strings.downloads.titleinv);
      // Place the download section onto the grid
      $("." + strings.fullscreen.container).find("." + strings.downloads.downloads).toggleClass(strings.downloads.grid);

      // Add action to close the fullscreen window
      $("." + strings.fullscreen.exit).on("click", function(el) { el.preventDefault(); });
      $("." + strings.fullscreen.exit).on("click", removeFullscreen);
      $(document).keydown(function(e)
      {
        if ((e.keyCode || e.which) == 27)
        {
          removeFullscreen();
        }
      });
    };

    let removeFullscreen = function()
    {
      $("." + strings.fullscreen.fullscreen).remove();
    };

    let addEvents = function()
    {
      $("." + strings.product.dlbtn).on("click", function(el) { el.preventDefault(); });
      // Open fullscreen window instead of jumping to page id
      objects.dlbtns.forEach((buttons) =>
      {
        buttons.forEach((buttons) =>
        {
          buttons.each(function()
          {
            $(this).on("click", function()
            {
              addFullscreen(this);
            });
          });
        });
      });
    };

    let hideDownloads = function()
    {
      $("." + strings.downloads.downloads).toggleClass(strings.downloads.invisible);
      $("." + strings.downloads.title).toggleClass(strings.downloads.titleinv);
    };

    let setButtons = function()
    {
      let btnArray = [];
      btnArray.push($("." + strings.product.downloads).find("." + strings.product.dlbtn));

      objects.dlbtns.push(btnArray);
    };

    let setStrings = function(args)
    {
      strings.base = args[0];
      strings.downloads = args[1];
      strings.fullscreen = args[2];
      strings.product = args[3];
    };

    return {
      init: function(args)
      {
        setStrings(args);
        setButtons();
        hideDownloads();
        addEvents();
      }
    }
  })();

  let controller = (function(m, v)
  {
    return {
      init: function(args)
      {
        v.init(args[0]);
      }
    }
  })(model, view);

  return {
    // Initialise the module
    init: function(args)
    {
      controller.init(args);
    }
  }
})();

export {downloads};
