/***************** GUESTS *****************/
const removeGuest = document.getElementsByClassName('material-symbols-outlined')[0];
removeGuest.addEventListener('click', () => {
    const guests = document.querySelector('.guests p');
    if (guests.innerHTML > 0)
        guests.innerHTML--;
});

const addGuest = document.getElementsByClassName('material-symbols-outlined')[1];
addGuest.addEventListener('click', () => {
    const guests = document.querySelector('.guests p');
    if (guests.innerHTML < 20)
        guests.innerHTML++;
});



/***************** CALENDAR *****************/
const checkIn = document.getElementById('check-in');
checkIn.addEventListener('click', () => showCalendar(1));
const checkOut = document.getElementById('check-out');
checkOut.addEventListener('click', () => showCalendar(2));

var currentDate = new Date();
var currentMonth = currentDate.getMonth();
var currentYear = currentDate.getFullYear();

function showCalendar(n) {
    // Check if calendar is already displayed
    if(document.getElementsByClassName("container")[0].children.length > 2){
        if(document.getElementById('calendarIn') != null && n == 1){
            document.getElementById('calendarIn').remove();
            return;
        }
        if(document.getElementById('calendarOut') != null && n == 2){
            document.getElementById('calendarOut').remove();
            return;
        }
        if(document.getElementById('calendarIn') != null && n == 2)
            document.getElementById('calendarIn').remove();
        if(document.getElementById('calendarOut') != null && n == 1)
            document.getElementById('calendarOut').remove();
    }
    calendar = createCalendar();
    if(n == 1)
        calendar.setAttribute('style', 'position: static; margin: -30px auto auto 29%;');
    else
        calendar.setAttribute('style', 'position: static; margin: -30px auto auto 47%;');
    if(n == 1)
		calendar.setAttribute('id', 'calendarIn');
	else	calendar.setAttribute('id', 'calendarOut');

    currDate = generateCalendar();

	document.getElementById('prevMonth').addEventListener('click', () => prevMonthAction());
	document.getElementById('nextMonth').addEventListener('click', () => nextMonthAction());	
}

function createCalendar() {
    var calendar = document.createElement('div');
    calendar.className = 'calendar';
    calendar.id = 'calendar';
        var monthHeader = document.createElement('div');
        monthHeader.className = 'month-header';
            var prevMonth = document.createElement('span');
            prevMonth.id = 'prevMonth';
            prevMonth.innerHTML = '&#9666;';
			if(currentYear == currentDate.getFullYear() && currentMonth == currentDate.getMonth())
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
            daysHeader.appendChild(document.createElement('span')).innerHTML = 'Lu';
            daysHeader.appendChild(document.createElement('span')).innerHTML = 'Ma';
            daysHeader.appendChild(document.createElement('span')).innerHTML = 'Me';
            daysHeader.appendChild(document.createElement('span')).innerHTML = 'Gi';
            daysHeader.appendChild(document.createElement('span')).innerHTML = 'Ve';
            daysHeader.appendChild(document.createElement('span')).innerHTML = 'Sa';
            daysHeader.appendChild(document.createElement('span')).innerHTML = 'Do';
        calendar.appendChild(daysHeader);
        var calendarDays = document.createElement('div');
        calendarDays.className = 'calendar-days';
        calendarDays.id = 'calendarDays';
        calendar.appendChild(calendarDays);
    document.getElementsByClassName("container")[0].appendChild(calendar);

	return calendar;
}

function generateCalendar() {
    const calendar = document.getElementById('calendar');
    const currentMonthElement = document.getElementById('currentMonth');
    const calendarDays = document.getElementById('calendarDays');

    currentMonthElement.innerText = new Date(currentYear, currentMonth).toLocaleString('default', { month: 'long', year: 'numeric' });

    // Clear previous days
    calendarDays.innerHTML = '';
    // Get the first day of the month
    const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay();
    const daysInWeek = 7;
    // Generate empty cells for days before the first day of the month
    for (let i = 0; i < (firstDayOfMonth + daysInWeek - 1) % daysInWeek; i++) {
        const emptyDay = document.createElement('div');
        emptyDay.className = 'day inactive';
        calendarDays.appendChild(emptyDay);
    }
    // Generate cells for each day of the month
    for (let i = 1; i <= new Date(currentYear, currentMonth + 1, 0).getDate(); i++) {
        const day = document.createElement('div');
        day.className = 'day';
        day.innerText = i;
        day.addEventListener('click', () => scrivi(i));
        calendarDays.appendChild(day);
    }
}

function prevMonthAction() {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    if (currentMonth === currentDate.getMonth() && currentYear === currentDate.getFullYear())
        document.getElementById('prevMonth').setAttribute('style', 'visibility: hidden; pointer-events: none;');
    generateCalendar();
}

function nextMonthAction() {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    if((currentYear > currentDate.getFullYear()) || (currentYear == currentDate.getFullYear() && currentMonth > currentDate.getMonth()))
        document.getElementById('prevMonth').setAttribute('style', 'visibility: visible; pointer-events: auto;');
    generateCalendar();
}

function scrivi(i) {
	if(document.getElementById("calendarIn") != null){
		var checkIn = document.getElementById("check-in");
		checkIn.innerHTML = i + '/' +  (currentMonth + 1)+ '/' + currentYear;
		checkIn.setAttribute('style', 'color: #000;');
		if(document.getElementById("check-in").innerHTML != "Check-in" && document.getElementById("check-out").innerHTML != "Check-out")
			checkDate();
		showCalendar(2);
	} else if(document.getElementById("calendarOut") != null) {
		var checkOut = document.getElementById("check-out");
		checkOut.innerHTML = i + '/' +  (currentMonth + 1)+ '/' + currentYear;
		checkOut.setAttribute('style', 'color: #000;');
		if(document.getElementById("check-in").innerHTML != "Aggiungi data" && document.getElementById("check-out").innerHTML != "Aggiungi data")
			checkDate();
		if(document.getElementById("check-out").innerHTML != "Aggiungi data")
			showCalendar(2);
		return;
	}
}

function checkDate() {
	var checkIn = document.getElementById("check-in").innerHTML;
	var checkOut = document.getElementById("check-out").innerHTML;
	var checkInDate = new Date(checkIn.split('/')[2], checkIn.split('/')[0], checkIn.split('/')[1]);
	var checkOutDate = new Date(checkOut.split('/')[2], checkOut.split('/')[0], checkOut.split('/')[1]);
	if(checkInDate > checkOutDate){
		document.getElementById("check-in").innerHTML = document.getElementById("check-out").innerHTML;
		document.getElementById("check-out").innerHTML = "Aggiungi data";
		document.getElementById("check-out").setAttribute('style', 'color: #858585;');
	}
	return;
}