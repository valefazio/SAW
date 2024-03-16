document.getElementsByTagName("form")[0].addEventListener("submit", function (event) {
	event.preventDefault();
	var location = document.getElementById("location").value;
	var checkin = document.getElementById("calendar").value || "anytime"; //ERROR
	var level = document.getElementById("nLevel").value || "0";
	var url = "http://localhost/SAW/Pages/search.php?location=" + location + "&checkin=" + checkin + "&level=" + level;	//ERROR assoluto
	window.location.href = url;
	return;
});

/***************** LEVEL *****************/
class Level {
	constructor() {
		this.level = document.getElementById('nLevel');
		this.level.onload = this.level.value = 0;

		const removeLevel = document.getElementsByClassName('g')[0];
		removeLevel.addEventListener('click', () => this.updateLevel(-1));

		const addLevel = document.getElementsByClassName('g')[2];
		addLevel.addEventListener('click', () => this.updateLevel(1));
	}

	updateLevel(change) {
		const currentValue = parseInt(this.level.value) || 0;
		const newValue = currentValue + change;

		if (newValue >= 0 && newValue <= 5) {
			this.level.value = newValue;
		}
	}
}

/***************** LEVEL *****************/
class Reviews {
	constructor() {
		this.star = document.getElementById('rLevel');
		this.star.onload = this.star.value = 0;

		const removeStar = document.getElementsByClassName('r')[0];
		removeStar.addEventListener('click', () => this.updateStar(-1));

		const addStar = document.getElementsByClassName('g')[2];
		addStar.addEventListener('click', () => this.updateStar(1));
	}

	updateStar(change) {
		const currentValue = parseInt(this.star.value) || 0;
		const newValue = currentValue + change;

		if (newValue >= 0 && newValue <= 5) {
			this.star.value = newValue;
		}
	}
}

/****************** SUBMIT  *****************/
class Submit {
	constructor() {
		this.btn = document.getElementsByTagName("button")[0];
		this.btn.addEventListener('mouseenter', () => this.showClosedEye());
		this.btn.addEventListener('mouseleave', () => this.showOpenEye());

	}

	showClosedEye() {
		var eye = document.getElementById("eye");
		if (eye) {
			eye.remove();
			var img = document.createElement('img');
			img.src = '../Management/Images/occhio_chiuso.png';
			img.setAttribute("id", "eye-closed");
			img.setAttribute("style", "margin-top: 5%; width: 50%");
			this.btn.append(img);
		}
	}

	showOpenEye() {
		var eyeClosed = document.getElementById("eye-closed");
		if (eyeClosed) {
			eyeClosed.remove();
			var p = document.createElement('p');
			var text = document.createTextNode("O");
			p.appendChild(text);
			p.setAttribute("id", "eye");
			this.btn.append(p)
		}
	}
}

/***************** CALENDAR *****************/
class Calendar {
	constructor() {
		const checkIn = document.getElementById('calendar');
		checkIn.value = "Add date";
		checkIn.setAttribute('style', 'color: #858585;');
		checkIn.addEventListener('click', () => this.showCalendar());

		this.currentDate = new Date();
		this.currentMonth = this.currentDate.getMonth();
		this.currentYear = this.currentDate.getFullYear();
	}

	showCalendar() {
		if (document.getElementsByClassName('calendar')[0] != null) {
			document.getElementsByClassName('calendar')[0].remove();
			return;
		}
		this.calendar = this.createCalendar();
		this.currDate = this.generateCalendar();

		document.getElementById('prevMonth').addEventListener('click', () => this.prevMonthAction());
		document.getElementById('nextMonth').addEventListener('click', () => this.nextMonthAction());
	}

	createCalendar() {
		var calendar = document.createElement('div');
		calendar.className = 'calendar';
		calendar.id = 'calendar';

		var monthHeader = document.createElement('div');
		monthHeader.className = 'month-header';
		var prevMonth = document.createElement('span');
		prevMonth.id = 'prevMonth';
		prevMonth.innerHTML = '&#9666;';
		if (this.currentYear == this.currentDate.getFullYear() && this.currentMonth == this.currentDate.getMonth())
			prevMonth.style = 'visibility: hidden;';
		monthHeader.appendChild(prevMonth);
		var currentMonthElement = document.createElement('span');
		currentMonthElement.id = 'currentMonth';
		monthHeader.appendChild(currentMonthElement);
		var nextMonth = document.createElement('span');
		nextMonth.id = 'nextMonth';
		nextMonth.innerHTML = '&#9656;';
		monthHeader.appendChild(nextMonth);
		calendar.appendChild(monthHeader);

		var daysHeader = document.createElement('div');
		daysHeader.className = 'days-header';
		daysHeader.appendChild(document.createElement('span')).innerText = 'Mo';
		daysHeader.appendChild(document.createElement('span')).innerText = 'Tu';
		daysHeader.appendChild(document.createElement('span')).innerText = 'We';
		daysHeader.appendChild(document.createElement('span')).innerText = 'Th';
		daysHeader.appendChild(document.createElement('span')).innerText = 'Fr';
		daysHeader.appendChild(document.createElement('span')).innerText = 'Sa';
		daysHeader.appendChild(document.createElement('span')).innerText = 'Su';
		calendar.appendChild(daysHeader);

		var calendarDays = document.createElement('div');
		calendarDays.className = 'calendar-days';
		calendarDays.id = 'calendarDays';
		calendar.appendChild(calendarDays);

		document.getElementsByClassName("header")[0].appendChild(calendar);

		return calendar;
	}

	generateCalendar() {
		const calendar = document.getElementById('calendar');
		const currentMonthElement = document.getElementById('currentMonth');
		const calendarDays = document.getElementById('calendarDays');

		currentMonthElement.innerText = new Date(this.currentYear, this.currentMonth).toLocaleString('en-US', { month: 'long', year: 'numeric' });

		calendarDays.value = '';
		const firstDayOfMonth = new Date(this.currentYear, this.currentMonth, 1).getDay();
		const daysInWeek = 7;

		for (let i = 0; i < (firstDayOfMonth + daysInWeek - 1) % daysInWeek; i++) {
			const emptyDay = document.createElement('div');
			emptyDay.className = 'day inactive';
			calendarDays.appendChild(emptyDay);
		}

		for (let i = 1; i <= new Date(this.currentYear, this.currentMonth + 1, 0).getDate(); i++) {
			const day = document.createElement('div');
			day.className = 'day';
			day.innerText = i;
			day.addEventListener('click', () => this.scrivi(i));
			calendarDays.appendChild(day);
		}

		if (!this.isLastDaySunday(this.currentMonth, this.currentYear)) {
			for (let i = 0; i < daysInWeek - new Date(this.currentYear, this.currentMonth + 1, 0).getDay(); i++) {
				const emptyDay = document.createElement('div');
				emptyDay.className = 'day inactive';
				calendarDays.appendChild(emptyDay);
			}
		}
	}

	isLastDaySunday(month, year) {
		return new Date(year, month + 1, 0).getDay() == 0;
	}

	prevMonthAction() {
		this.currentMonth--;
		if (this.currentMonth < 0) {
			this.currentMonth = 11;
			this.currentYear--;
		}
		if (this.currentMonth === this.currentDate.getMonth() && this.currentYear === this.currentDate.getFullYear())
			document.getElementById('prevMonth').setAttribute('style', 'visibility: hidden; pointer-events: none;');
		this.updateCalendar();
	}

	nextMonthAction() {
		this.currentMonth++;
		if (this.currentMonth > 11) {
			this.currentMonth = 0;
			this.currentYear++;
		}
		if ((this.currentYear > this.currentDate.getFullYear()) || (this.currentYear == this.currentDate.getFullYear() && this.currentMonth > this.currentDate.getMonth()))
			document.getElementById('prevMonth').setAttribute('style', 'visibility: visible; pointer-events: auto;');
		this.updateCalendar();
	}

	scrivi(i) {
		if (document.getElementsByClassName('calendar')[0] != null) {
			var checkIn = document.getElementById("calendar");

			var selectedDate = new Date(this.currentYear, this.currentMonth, i);
			if (selectedDate > this.currentDate || (this.currentYear == this.currentDate.getFullYear() && this.currentMonth == this.currentDate.getMonth() && i == this.currentDate.getDate())) {
				checkIn.value = i + '/' + (this.currentMonth + 1) + '/' + this.currentYear;
				checkIn.setAttribute('style', 'color: #000;');
				this.closeCalendar();
			} else {
				checkIn.value = "";
			}
		}
	}

	closeCalendar() {
		document.getElementsByClassName('calendar')[0].remove();
	}

	updateCalendar() {
		this.closeCalendar();
		this.showCalendar();
	}
}

// Initialize the classes
const levelInstance = new Level();
const reviewsInstance = new Reviews();
const submitInstance = new Submit();
const calendarInstance = new Calendar();