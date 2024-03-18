function affixColumnBar() {
    var column = document.getElementById("column");

    if (!column.classList.contains('visible')) {
        column.classList.add('visible');
        var parentLi = column.closest('li');
        if (parentLi) {
            parentLi.classList.add('visible');
        }
    }

    document.getElementById("menu").setAttribute("onclick", "removeColumnBar()");
    document.getElementById("menu").textContent = "close";
}

function removeColumnBar() {
    var column = document.getElementById("column");

    if (column.classList.contains('visible')) {
        column.classList.remove('visible');
        var parentLi = column.closest('li');
        if (parentLi) {
            parentLi.classList.remove('visible');
        }
    }

    document.getElementById("menu").setAttribute("onclick", "affixColumnBar()");
    document.getElementById("menu").textContent = "account_circle";
}

function createNewElement(link, spanName, textToPrint) {
    var li = document.createElement("li");
    li.setAttribute("class", "sub-item clickable");
    li.setAttribute("onclick", "window.location.href='" + link + "'");

    var span = document.createElement("span");
    span.setAttribute("class", "material-icons-outlined");
    var text = document.createTextNode(spanName);
    span.appendChild(text);

    var p = document.createElement("p");
    var text = document.createTextNode(textToPrint);
    p.appendChild(text);

    li.append(span);
    li.append(p);
    document.getElementById("column").append(li);
}