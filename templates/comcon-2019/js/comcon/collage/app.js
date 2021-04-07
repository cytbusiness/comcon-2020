let collage = (function()
{
  // Handles the calculations of the module
  let model = (function()
  {

  })();

  // Handles the visual alterations carried out by the module
  let view = (function()
  {
    let strings =
    {
      base: [],
      collage: [],
      fullscreen: []
    };

    let objects =
    {
      allImages: [],
      images: [],
      // Store current page for gallery
      page: 0,
      // Store current image index
      current: 0
    };

    let getImages = function()
    {
      return objects.images;
    };

    let addControls = function(element)
    {
      if (objects.images.length > 1)
      {
        $("." + element).append(`<div class="${strings.collage.controls}">
          <button class="${strings.collage.btn} ${strings.collage.btnLeft}"></button>
          <p class="${strings.collage.pages} ${strings.base.line} ${strings.base.lineMin}"><span class="${strings.collage.page}">1</span> of <span class="${strings.collage.pageNum}">${objects.images.length}</span></p>
          <button class="${strings.collage.btn} ${strings.collage.btnRight}"></button>
        </div>`);
      }
    };

    let controlsFullscreen = function(dir)
    {
      let image = $("." + strings.fullscreen.image);
      let index = parseInt(image.data("index"));

      let title = $("." + strings.fullscreen.title);
      let desc = $("." + strings.fullscreen.desc);
      let body = $("." + strings.fullscreen.body);

      let imgcur = $("." + strings.fullscreen.imgcur);

      switch (dir)
      {
        case "next":
          if (objects.current < (objects.allImages.length - 1))
          {
            ++objects.current;
            image.attr("src", $(objects.allImages[objects.current]).attr("src"));
            image.attr("alt", $(objects.allImages[objects.current]).attr("alt"));
            image.attr("data-index", objects.current);

            title.text($(objects.allImages[objects.current]).attr("title"));
            desc.text($(objects.allImages[objects.current]).attr("alt"));
            body.text($(objects.allImages[objects.current]).data("text"));

            imgcur.text(parseInt(objects.current + 1));

            // console.log(objects.current);
          }
          else
          {
            objects.current = 0;
            image.attr("src", $(objects.allImages[objects.current]).attr("src"));
            image.attr("alt", $(objects.allImages[objects.current]).attr("alt"));
            image.attr("data-index", objects.current);

            title.text($(objects.allImages[objects.current]).attr("title"));
            desc.text($(objects.allImages[objects.current]).attr("alt"));
            body.text($(objects.allImages[objects.current]).data("text"));

            imgcur.text(parseInt(objects.current + 1));

            // console.log(objects.current);
          }
        break;
        case "prev":
          if (objects.current > 0)
          {
            --objects.current;
            image.attr("src", $(objects.allImages[objects.current]).attr("src"));
            image.attr("alt", $(objects.allImages[objects.current]).attr("alt"));
            image.attr("data-index", objects.current);

            title.text($(objects.allImages[objects.current]).attr("title"));
            desc.text($(objects.allImages[objects.current]).attr("alt"));
            body.text($(objects.allImages[objects.current]).data("text"));

            imgcur.text(parseInt(objects.current + 1));

            // console.log(objects.current);
          }
          else
          {
            objects.current = (objects.allImages.length - 1);
            image.attr("src", $(objects.allImages[objects.current]).attr("src"));
            image.attr("alt", $(objects.allImages[objects.current]).attr("alt"));
            image.attr("data-index", objects.current);

            title.text($(objects.allImages[objects.current]).attr("title"));
            desc.text($(objects.allImages[objects.current]).attr("alt"));
            body.text($(objects.allImages[objects.current]).data("text"));

            imgcur.text(parseInt(objects.current + 1));

            // console.log(objects.current);
          }
        break;
      }
    };

    let controlsPage = function(dir)
    {
      switch (dir)
      {
        case "next":
          // Have we reached the end of the pages?
          if (objects.page >= (objects.images.length - 1))
          {
            objects.page = 0;
            objects.images.forEach(function(current)
            {
              if (current != objects.images[0])
              {
                // Set all of the current images to invisible
                current.forEach((image) =>
                {
                  $(image).parent("." + strings.collage.item).removeClass(strings.collage.visible);
                });
              }
            });
            // Set first page images to visible again
            objects.images[0].forEach((image) =>
            {
              $(image).parent("." + strings.collage.item).addClass(strings.collage.visible);
            });

            // Set current page text
            $("." + strings.collage.page).text(objects.page + 1);
          }
          // If we've not reached the end, move onto the next page
          else
          {
            objects.images.forEach(function(current)
            {
              if (current != objects.images[objects.page + 1])
              {
                current.forEach((image) =>
                {
                  $(image).parent("." + strings.collage.item).removeClass(strings.collage.visible);
                });
              }
            });

            // Set the next page of images to visible
            objects.images[objects.page + 1].forEach((image) =>
            {
              $(image).parent("." + strings.collage.item).addClass(strings.collage.visible);
            });

            objects.page++;

            // Set current page text
            $("." + strings.collage.page).text(objects.page + 1);
          }
          break;

        case "prev":
          // Have we reached the beginning of the pages?
          if (objects.page < 1)
          {
            // Reset the index to the last page, so we can cycle back through
            objects.page = objects.images.length - 1;

            objects.images.forEach(function(current)
            {
              if (current != objects.images[objects.images.length - 1])
              {
                current.forEach((image) =>
                {
                  $(image).parent("." + strings.collage.item).removeClass(strings.collage.visible);
                });
              }
            });

            // Set the final page to visible - we've cycled back through to it
            objects.images[objects.images.length - 1].forEach((image) =>
            {
              $(image).parent("." + strings.collage.item).addClass(strings.collage.visible);
            });

            // Set current page text
            $("." + strings.collage.page).text(objects.page + 1);
          }
          // We haven't reached the end, keep going back through the pages
          else
          {
            objects.images.forEach(function(current)
            {
              if (current != objects.images[objects.page - 1])
              {
                current.forEach((image) =>
                {
                  $(image).parent("." + strings.collage.item).removeClass(strings.collage.visible);
                });
              }
            });

            objects.images[objects.page - 1].forEach((image) =>
            {
              $(image).parent("." + strings.collage.item).addClass(strings.collage.visible);
            });

            objects.page--;

            // Set current page text
            $("." + strings.collage.page).text(objects.page + 1);
          }
          break;
      }
    };

    let addFullscreen = function()
    {
      // Add current image index
      objects.current = parseInt($(this).data("index"));

      // Get data from the image that has been clicked
      let image =
      {
        title: "",
        desc: "",
        text: "",
        src: "",
        index: ""
      };
      if (typeof $(this).attr("title") !== "undefined") {  image.title = $(this).attr("title"); };
      if (typeof $(this).attr("alt") !== "undefined") { image.desc = $(this).attr("alt"); };
      if (typeof $(this).data("text") !== "undefined") { image.text = $(this).data("text"); };
      if (typeof $(this).attr("src") !== "undefined") { image.src = $(this).attr("src"); };
      if (typeof $(this).attr("data-index") !== "undefined") { image.index = $(this).attr("data-index"); };

      $("body").append(`<div class="${strings.fullscreen.fullscreen}">
        <a href="#" class="${strings.fullscreen.exit}" title="Close (Esc)"></a>
        <div class="${strings.fullscreen.container}">
          <div class="${strings.fullscreen.content}">
            <div class="${strings.fullscreen.gallery}">
              <p class="${strings.fullscreen.imgcount}">
                <span class="${strings.fullscreen.imgcur}">${parseInt(image.index) + 1}</span>/<span class="${strings.fullscreen.imgs}">${objects.allImages.length}</span>
              </p>
              <div class="${strings.fullscreen.btn} ${strings.fullscreen.btnLeft}"></div>
              <img src="${image.src}" alt="${image.title}" class="${strings.fullscreen.image}" data-index=\"${image.index}\">
              <div class="${strings.fullscreen.btn} ${strings.fullscreen.btnRight}"></div>
            </div>
            <div class="${strings.fullscreen.text}">
              <h2 class="${strings.fullscreen.title} ${strings.base.heading}">${image.title}</h2>
              <p class="${strings.fullscreen.desc} ${strings.base.line}">${image.desc}</p>
              <p class="${strings.fullscreen.body} ${strings.base.line}">${image.text}</p>
            </div>
          </div>
        </div>
      </div>`);

      // Add action to close the fullscreen window
      $("." + strings.fullscreen.exit).on("click", function(el) { el.preventDefault(); });
      $("." + strings.fullscreen.exit).on("click", removeFullscreen);

      // Add action to go through images
      $("." + strings.fullscreen.btnRight).on("click", function()
      {
        controlsFullscreen("next");
      });
      $("." + strings.fullscreen.btnLeft).on("click", function()
      {
        controlsFullscreen("prev");
      });

      // Prevent scroll
      $("." + strings.fullscreen.fullscreen).on("scroll touchmove mousewheel", function(e)
      {
        e.preventDefault();
        e.stopPropagation();
        return false;
      });

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
      // Remove default link action - i.e. don't open the link to the page, do our actions instead
      $("." + strings.collage.item).on("click", function(el) { el.preventDefault(); });

      // Add event to each of the images - when clicked, open the fullscreen window
      objects.images.forEach((chunk) =>
      {
        chunk.forEach((image) =>
        {
          $(image).on("click", addFullscreen);
        });
      });

      // Add events to the control buttons
      // Next
      $("." + strings.collage.btnRight).on("click", function()
      {
        controlsPage("next");
      });
      // Previous
      $("." + strings.collage.btnLeft).on("click", function()
      {
        controlsPage("prev");
      });
    };

    // Set an index against each image so we can cycle through them
    let setAllImagesIndex = function()
    {
      let index = 0;
      $("." + strings.collage.image).toArray().forEach(el =>
      {
        $(el).attr("data-index", index);
        ++index;
      });
    };

    // Group all images together to cycle through the gallery
    let setAllImages = function()
    {
      $("." + strings.collage.items).each(function()
      {
        $(this).find("." + strings.collage.image).each(function()
        {
          objects.allImages.push(this);
        });
      });
    };

    // Find images in the collage
    let setImages = function(size)
    {
      // Group images together by what page they appear on e.g. the first 3 images will be in one array
      // $("." + strings.collage.items).each(function() { objects.images.push($(this).find("." + strings.collage.image)); });
      var i = 0;
      $("." + strings.collage.items).each(function()
      {
        var imgArray = [];

        // Put all found images into an array, so we can separate them
        $(this).find("." + strings.collage.image).each(function()
        {
          imgArray.push(this);
        });

        // Split the array into the defined size - each chunk == size
        var i, j, temp, chunk = size;
        for (i = 0, j = imgArray.length; i < j; i+= chunk)
        {
          temp = imgArray.slice(i, i + chunk);
          objects.images.push(temp);
        }
      });
    };

    let setStrings = function(args)
    {
      strings.base = args[0];
      strings.collage = args[1];
      strings.fullscreen = args[2];
    };

    return {
      init: function(args)
      {
        setStrings(args[0]);
        setAllImagesIndex();
        setAllImages();
        setImages(args[1]);
        getImages();

        addControls(args[2]);
        addEvents();
      }
    }
  })();

  // Handles the model and view modules
  let controller = (function(m, v)
  {
    return {
      init: function(args)
      {
        v.init(args);
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

export {collage};
