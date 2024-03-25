//Add link to the door page
var boxes = document.getElementsByClassName("box_text");
for (var i = 0; i < boxes.length; i++) {
    boxes[i].addEventListener("click", function () {
        window.location.href = "door.php?"+i;
    });
}
var doors = document.getElementsByClassName("doorPic");
for (var i = 0; i < doors.length; i++) {
    doors[i].addEventListener("click", function () {
        window.location.href = "door.php?"+i;
    });
}


//HEARTS
/* const heart = document.getElementsByClassName('heart');

function toggle(i) {
  if(!heart[i].classList.contains('heart_red')) {
	heart[i].classList.add('heart_red');
  } else {
	heart[i].classList.remove('heart_red');
  }
} */
