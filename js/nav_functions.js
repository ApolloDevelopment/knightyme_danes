function toggleNav(navIsOpen) {
  open = document.getElementById("open-nav2");
  close = document.getElementById("close");
  nav = document.getElementById("nav2");

  if(navIsOpen) {
    nav.style.left = "0px";
  } else if(!navIsOpen) {
    nav.style.left = "-300px";
  } else {
    console.log("Don't change the source if you want the website to work properly for you. Please refresh your page. Thank you.");
  }
}
