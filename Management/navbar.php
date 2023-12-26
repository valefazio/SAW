<!-- Code adapted from "Create a Navbar Dropdown Menu" tutorial by TimeToProgram.
  Source: https://timetoprogram.com/create-navbar-dropdown-menu-html-css/
-->

<?php
	include("accessControl.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined"
      rel="stylesheet"
    />
    <link rel="stylesheet" type="text/css" href="../Management/Style/style.css">
    <link rel="stylesheet" type="text/css" href="../Management/Style/bars.css">
    <title>Document</title>
  </head>
    
	<script>
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
		document.getElementById("menu").textContent = "menu";
	}
</script>

<body>
    <nav>
		<ul id="bar">
		<li>
			<span class="material-icons-outlined clickable" title="Notifications" onclick="window.location.href='Access/login.php'">
				notifications
			</span>
		</li>
		<li>
			<span class="material-icons-outlined clickable" title="Favorites" onclick="window.location.href='Access/login.php'">
				favorite_border
			</span>
		</li>
		<li>
			<span class="material-icons-outlined clickable" title="Servizio clienti" onclick="window.location.href='help.php'">
				contact_support
			</span>
		</li>
		<li>
			<!-- FOTO DA DB
				<img src="../Management/images/profile.png" class="profile"/>-->
			<span class="material-icons-outlined clickable" onclick="affixColumnBar()" id="menu" title="affix column bar">
				menu
			</span>
			<ul id="column">
				<li class="sub-item clickable"  onclick="removeColumnBar(); window.location.href='Access/login.php'" id="login">
					<span class="material-icons-outlined"> login </span>
					<p>Login</p>
				</li>
			</ul>
		</li>
    	</ul>
    </nav>

	

	<?php
	$logged = isLogged();
	checkAccess($logged);	//checks if current page is for admin users only
	if ($logged) {
	?><script>
		document.getElementById("login").remove();
		document.getElementsByTagName("span")[0].setAttribute("onclick", "window.location.href='../Pages/news.php'");
		document.getElementsByTagName("span")[1].setAttribute("onclick", "window.location.href='../Pages/favs.php'");
		createNewElement("../Pages/profile.php", "account_circle", "Profilo");
		createNewElement("../Pages/dash.php", "luggage", "Le tue prenotazioni");
		//createNewElement("../Pages/orders.php", "format_list_bulleted", "My Orders");
		createNewElement("../Pages/updateProfile.php", "manage_accounts", "Gestisci Profilo");//aggiungere elimina profilo
		//createNewElement("../Pages/users.php", "group", "List of users");
		createNewElement("Access/logout.php", "logout", "Logout");

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
    </script><?php } ?>
  </body>
</html>