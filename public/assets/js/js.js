var btn = document.getElementById("responsive-menu");
var nav = document.getElementById("nav");

btn.onclick = function() {
  nav.classList.toggle("expand");
}

function openModal(imgElement) {
  imgElement.classList.toggle("show");
}