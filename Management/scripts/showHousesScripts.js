/* HEARTS - FAVS */
const heart = document.getElementsByClassName('heart');
function hearts(i) {
	if (!heart[i].classList.contains('heart_red')) {
		$.ajax({
			type: "POST",
			url: "../Management/showHousesFunctions.php",
			data: { to_do: 'heart', div_n: i, action: 'add', room: heart[i].parentElement.getElementsByClassName("address")[0].innerText },
			success: function (res) {
				if (res == true)
					heart[i].classList.add('heart_red');
				else window.location.href = "../Pages/../Management/checkAccess.php?login";
			}
		});
	} else {
		$.ajax({
			type: "POST",
			url: "../Management/showHousesFunctions.php",
			data: { to_do: 'heart', div_n: i, action: 'remove', room: heart[i].parentElement.getElementsByClassName("address")[0].innerText },
			success: function (res) {
				if (res == true)
					heart[i].classList.remove('heart_red');
				else console.log("Error remove");
			}
		});
	}
}


/* OPEN DOOR */
doors = document.getElementsByClassName('doorPic');
for (let i = 0; i < doors.length; i++) {
	let s = doors[i].src;
	doors[i].addEventListener('mouseenter', function () {
		//this.src = "../Management/Images/rooms/"+(i+1)+"_1.jpg";
		$.ajax({
			type: "POST",
			url: "../Management/showHousesFunctions.php",
			data: { to_do: 'getCover', div_n: i, room: this.parentElement.getElementsByClassName("address")[0].innerText },
			success: function (res) {
				if (res != null)
					doors[i].src = "../" + res;
				
			}
		});
	});
	doors[i].addEventListener('mouseleave', function () {
		this.src = s;
	});
}

/* CUT TEXT */
const scares = document.getElementsByClassName('scaredOf');
for (let i = 0; i < scares.length; i++) {
	let text = scares[i].innerText;
	scares[i].setAttribute('title', text);
	if (text.length > 70)
		scares[i].innerText = text.substr(0, 70) + '...';
}