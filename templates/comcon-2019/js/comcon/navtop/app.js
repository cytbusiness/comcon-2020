let navtop = (function()
{
  // <button class="nav-top__dropdown">Menu</button>
  //  class="noscroll"
  // nav-top--dropdown
  //  nav-top__items--dropdown nav-top__items--dropdownvis

  let strings =
  {
    noscroll: "noscroll",
    navtop: "nav-top",
    dropdown: "nav-top--dropdown",
    dropdownvis: "nav-top--dropdownvis",
    container: "nav-top__container",
    btn: "nav-top__dropdown",
    items: "nav-top__items",
    itemsdrop: "nav-top__items--dropdown",
    itemsdropvis: "nav-top__items--dropdownvis"
  };

  let texts =
  {
    show: "Menu",
    hide: "Close Menu"
  }

  let init = function()
  {
    $("." + strings.navtop).addClass(strings.dropdown);
    $("." + strings.container).prepend("<button class=\"" + strings.btn + "\">" + texts.show + "</button>");
    $("." + strings.items).addClass(strings.itemsdrop);

    let body = $("body");
    let navtop = $("." + strings.navtop);
    let items = $("." + strings.items);
    let btn = $("." + strings.btn);

    // Toggle the dropdown menu
    $("." + strings.btn).on("click", function(el)
    {
      body.toggleClass(strings.noscroll);
      navtop.toggleClass(strings.dropdownvis);
      items.toggleClass(strings.itemsdropvis);

      // Toggle texts
      if (btn.text() == texts.show)
      {
        btn.text(texts.hide);
      }
      else
      {
        btn.text(texts.show);
      }
    });
  };

  return {
    init: function()
    {
      init();
    }
  }
})();

export {navtop};
