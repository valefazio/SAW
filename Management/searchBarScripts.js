/***************** LEVEL *****************/
class Level {
	constructor() {
		this.level = document.getElementById('nLevel');
		this.level.onload = this.level.value = 0;

		const removeGuest = document.getElementsByClassName('g')[0];
		removeGuest.addEventListener('click', () => this.updateLevel(-1));

		const addGuest = document.getElementsByClassName('g')[2];
		addGuest.addEventListener('click', () => this.updateLevel(1));
	}

	updateLevel(change) {
		const currentValue = parseInt(this.level.value) || 0;
		const newValue = currentValue + change;

		if (newValue >= 0 && newValue <= 5) {
			this.level.value = newValue;
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
		daysHeader.appendChild(document.createElement('span')).innerText = 'Lu';
		daysHeader.appendChild(document.createElement('span')).innerText = 'Ma';
		daysHeader.appendChild(document.createElement('span')).innerText = 'Me';
		daysHeader.appendChild(document.createElement('span')).innerText = 'Gi';
		daysHeader.appendChild(document.createElement('span')).innerText = 'Ve';
		daysHeader.appendChild(document.createElement('span')).innerText = 'Sa';
		daysHeader.appendChild(document.createElement('span')).innerText = 'Do';
		calendar.appendChild(daysHeader);

		var calendarDays = document.createElement('div');
		calendarDays.className = 'calendar-days';
		calendarDays.id = 'calendarDays';
		calendar.appendChild(calendarDays);

		document.getElementsByClassName("container")[0].appendChild(calendar);

		return calendar;
	}

	generateCalendar() {
		const calendar = document.getElementById('calendar');
		const currentMonthElement = document.getElementById('currentMonth');
		const calendarDays = document.getElementById('calendarDays');

		currentMonthElement.innerText = new Date(this.currentYear, this.currentMonth).toLocaleString('default', { month: 'long', year: 'numeric' });

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
const submitInstance = new Submit();
const calendarInstance = new Calendar();