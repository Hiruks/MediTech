let profileDropdownList = document.getElementById("two");
let btn = document.getElementById("one");

function toggle() { profileDropdownList.classList.add("active"); }

btn.addEventListener("click", toggle);
