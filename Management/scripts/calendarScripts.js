const eventCalendarLocation = document.getElementById('eventsCalendar');
const today = new Date();
currentDay = today.getDate();
currentMonth = today.getMonth();
currentYear = today.getFullYear();

createEventsCalendar();

function createEventsCalendar() {
	createListCalendar();
	createDatesCalendar();
	document.getElementById('listaEventi').style = "max-height:" + document.getElementById('calendarioEventi').offsetHeight + "px";
	document.getElementById('listaEventiBox').style = 'max-height: ' + (document.getElementById('calendarioEventi').offsetHeight-60) + 'px; border-radius: 10px; overflow-y: auto';
}

/************************ CALENDARIO A ELENCO ************************/
function createListCalendar() {
	var calendar = document.createElement('div');
	calendar.id = 'listaEventi';
	text = document.createElement('h2');
	text.innerText = 'List of events';
	text.style = 'text-align: center';
	calendar.appendChild(text);
	eventCalendarLocation.appendChild(calendar);

	var box = document.createElement('div');
	box.id = 'listaEventiBox';
	calendar.appendChild(box);

	/* var nextEl = null; */
	var nextDate = null;
	$(document).ready(function() {
		$.ajax({
			url: '../Management/calendarUtility.php',
			dataType: 'json',
			type: 'POST',
			data: { opt: "list"},
			success: function(response) {
				response.forEach(function(row) {
					var event = document.createElement('div');
					date = document.createElement('p');
					day = row.date.split('-')[2];
					month = row.date.split('-')[1];
					year = row.date.split('-')[0];

					const formattedDate = new Date(year, month - 1, day).toLocaleString('en-US', {day:'numeric', month: 'short', year: 'numeric' });
					date.innerHTML = formattedDate;
					date.style = 'font-style: italic';
					event.appendChild(date);
					if ((year > today.getFullYear() || (year == today.getFullYear() && (parseInt(month)-1) > today.getMonth()) || (year == today.getFullYear() && (today.getMonth()-1) == today.getMonth() && day >= today.getDate())) /* && (nextEl==null || row.date<nextDate) */) {
						nextEl = event;
						nextDate = row.date;
					}

					title = document.createElement('h3');
					title.innerHTML = row.name.toUpperCase();
					title.style = 'text-align: center; margin-top: -10px';
					event.appendChild(title);
					door = document.createElement('p');
					door.innerHTML = row.door;
					door.style = 'text-align: center';
					event.appendChild(door);
					event.className = 'event_list';
					event.addEventListener('click', function() {
						document.location.href = 'room.php?' + row.num;
					});
					box.appendChild(event);
				});
				/* if(nextEl!=null)
					nextEl.scrollIntoView({behavior: "smooth", block: "center"}); */
			},
			error: function(xhr, status, error) {
				console.error(error);
			}
		});
	});
}


/************************ CALENDARIO A GRIGLIA ************************/
function prevMonthEventsAction() {
	currentMonth--;
	if (currentMonth < 0) {
		currentMonth = 11;
		currentYear--;
	}
	updateEventsCalendar();
}
function nextMonthEventsAction() {
	currentMonth++;
	if (currentMonth > 11) {
		currentMonth = 0;
		currentYear++;
	}
	updateEventsCalendar();
}
function updateEventsCalendar() {
	eventCalendarLocation.removeChild(document.getElementById('calendarioEventi'));
	createDatesCalendar();
}
function createDatesCalendar() {
	var calendar = document.createElement('div');
	calendar.className = 'calendarioEventi';
	calendar.id = 'calendarioEventi';

	var monthHeader = document.createElement('div');
	monthHeader.className = 'events-month-header';
	var prevMonth = document.createElement('span');
	prevMonth.id = 'events-prevMonth';
	prevMonth.innerHTML = '&#9666;';
	prevMonth.style = 'user-select: none;';
	prevMonth.addEventListener('click', () => prevMonthEventsAction());
	monthHeader.appendChild(prevMonth);
	var currentMonthElement = document.createElement('span');
	currentMonthElement.id = 'events-currentMonth';
	monthHeader.appendChild(currentMonthElement);
	var nextMonth = document.createElement('span');
	nextMonth.id = 'events-nextMonth';
	nextMonth.innerHTML = '&#9656;';
	nextMonth.style = 'user-select: none;';
	nextMonth.addEventListener('click', () => nextMonthEventsAction());
	monthHeader.appendChild(nextMonth);
	calendar.appendChild(monthHeader);
	
	var daysHeader = document.createElement('div');
	daysHeader.className = 'events-days-header';
	daysHeader.appendChild(document.createElement('span')).innerText = 'Mon';
	daysHeader.appendChild(document.createElement('span')).innerText = 'Tus';
	daysHeader.appendChild(document.createElement('span')).innerText = 'Wed';
	daysHeader.appendChild(document.createElement('span')).innerText = 'Thu';
	daysHeader.appendChild(document.createElement('span')).innerText = 'Fri';
	daysHeader.appendChild(document.createElement('span')).innerText = 'Sat';
	daysHeader.appendChild(document.createElement('span')).innerText = 'Sun';
	calendar.appendChild(daysHeader);

	var calendarDays = document.createElement('div');
	calendarDays.className = 'events-calendar-days';
	calendarDays.id = 'events-calendarDays';
	calendar.appendChild(calendarDays);

	eventCalendarLocation.appendChild(calendar);

	generateCalendar();
}

function generateCalendar() {
	const currentMonthElement = document.getElementById('events-currentMonth');
	const calendarDays = document.getElementById('events-calendarDays');

	currentMonthElement.innerText = new Date(currentYear, currentMonth).toLocaleString('en-US', { month: 'long', year: 'numeric' });

	calendarDays.value = '';
	const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay();
	const daysInWeek = 7;

	// Add empty days in the beginning of the month
	for (let i = 0; i < (firstDayOfMonth + daysInWeek - 1) % daysInWeek; i++) {
		const emptyDay = document.createElement('div');
		emptyDay.className = 'events-day inactive';
		calendarDays.appendChild(emptyDay);
	}
	// Add days
	for (let i = 1; i <= new Date(currentYear, currentMonth + 1, 0).getDate(); i++) {
		const day = document.createElement('span');
		day.className = 'events-day';
		day.id = currentYear + '-' + ('0' + (currentMonth + 1)).slice(-2) + '-' + ('0' + i).toString().slice(-2);
		day.innerText = i;
		const dayBox = document.createElement('div');
		dayBox.id = 'events-day-box_' + day.id;
		dayBox.className = 'events-day-box';
		day.appendChild(dayBox);
		$(document).ready(function() {
			$.ajax({
				url: '../Management/calendarUtility.php',
				dataType: 'json',
				type: 'POST',
				data: { opt: "grid", date: day.id },
				success: function(response) {
					response.forEach(function(row) {
						var event = document.createElement('div');
						event.innerHTML = row.name;
						event.className = 'event';
						event.addEventListener('click', function() {
							document.location.href = 'room.php?' + row.num;
						});
						document.getElementById('events-day-box_' + row.date).appendChild(event);
					});
				},
				error: function(xhr, status, error) {
					console.error(error);
				}
			});
		});
		calendarDays.appendChild(day);
	}
	// Add empty days in the end of the month
	if (!isLastDaySunday(currentMonth, currentYear)) {
		for (let i = 0; i < daysInWeek - new Date(currentYear, currentMonth + 1, 0).getDay(); i++) {
			const emptyDay = document.createElement('div');
			emptyDay.className = 'events-day inactive';
			calendarDays.appendChild(emptyDay);
		}
	}
}

function isLastDaySunday(month, year) {
	return new Date(year, month + 1, 0).getDay() == 0;
}