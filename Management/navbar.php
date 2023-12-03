<!-- Code adapted from "Create a Navbar Dropdown Menu" tutorial by TimeToProgram.
  Source: https://timetoprogram.com/create-navbar-dropdown-menu-html-css/
-->
<?php
		include("accessControl.php");
        $logged = isLogged();
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
    <link rel="stylesheet" type="text/css" href="../Management/style.css">
    <style>
        html {
            box-sizing: border-box;
        }
        * {
            box-sizing: inherit;
        }     
        nav {
            background-color: var(--navbar-color);
            padding: 0 4rem;
            border-radius: 0.625rem;
        }        
        ul {
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 2rem;
			width: fit-content;
		}
		#bar {
			position: relative;
			margin-left: auto; /* Align the ul to the right */
		}
		#column {
			position: absolute;
			right: -30px;
			top: 3rem;
		}
		#column.visible {
            visibility: visible;
            opacity: 1;
            display: absolute;
        }
		li.visible ul {
			visibility: visible;
			opacity: 1;
			display: flex;
		}
        li {
            list-style-type: none;
            position: relative;
            padding: 0.625rem 0 0.5rem;
        }
        li ul {
            flex-direction: column;
            position: absolute;
            background-color: white;
            align-items: flex-start;
            transition: all 0.5s ease;
            width: 20rem;
            right: -3rem;
            top: 4.5rem;
            border-radius: 0.325rem;
            gap: 0;
            padding: 1rem 0rem;
            opacity: 0;
            box-shadow: 0px 0px 100px rgba(20, 18, 18, 0.25);
            display: none;
        } 
        ul li:hover > ul,
        ul li ul:hover {
            visibility: visible;
            opacity: 1;
            display: flex;
        }   
        .material-icons-outlined {
            color: #888888;
            transition: all 0.3s ease-out;
        }
        .material-icons-outlined:hover {
            color: var(--colorB);
            transform: scale(1.25) translateY(-4px);
            cursor: pointer;
        }
        .sub-item {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 0.725rem;
            cursor: pointer;
            padding: 0.5rem 1.5rem;
        }
        .sub-item:hover {
            background-color: rgba(232, 232, 232, 0.4);
        }
        .sub-item:hover .material-icons-outlined {
            color: var(--colorB);
            transform: scale(1.08) translateY(-2px);
            cursor: pointer;
        }
        .sub-item:hover p {
            color: var(--colorB);
            transform: scale(1.08) translateX(8px) translateY(-2.5px);
            cursor: pointer;
        }
        .sub-item p {
            font-size: 0.85rem;
            color: #888888;
            font-weight: 500;
            margin: 0.4rem 0;
            flex: 1;
        }
    </style>
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
		document.getElementById("menu").textContent = "account_circle";
	}
</script>


  <body>
    <nav>
    	<ul id="bar">
        	<li>
        		<span class="material-icons-outlined clickable" title="Notifications" onclick="window.location.href='../Access/login.php'">
					notifications
				</span>
        	</li>
        	<li>
        		<span class="material-icons-outlined clickable" title="Favorites" onclick="window.location.href='../Access/login.php'">
					favorite_border
				</span>
        	</li>
        	<li>
				<span class="material-icons-outlined clickable" title="Cart" onclick="window.location.href='../Access/login.php'">
					shopping_cart
				</span>
        	</li>
        	<li>
				<!-- FOTO DA DB
					<img src="../Management/images/profile.png" class="profile"/>-->
				<span class="material-icons-outlined clickable" onclick="affixColumnBar()" id="menu" title="affix column bar">
					menu
				</span>
          		<ul id="column">
					<li class="sub-item clickable"  onclick="removeColumnBar(); window.location.href='../Access/login.php'" id="login">
						<span class="material-icons-outlined"> login </span>
						<p>Login</p>
					</li>
				</ul>
			</li>
      </ul>
    </nav>

	<?php
		if ($logged) {
	?>
            <script>
                document.getElementById("login").remove();
                document.getElementsByTagName("span")[0].setAttribute("onclick", "window.location.href='../Pages/news.php'");
				document.getElementsByTagName("span")[1].setAttribute("onclick", "window.location.href='../Pages/favs.php'");
				document.getElementsByTagName("span")[2].setAttribute("onclick", "window.location.href='../Pages/cart.php'");
                createNewElement("../Pages/profile.php", "account_circle", "My Profile");
                createNewElement("../Pages/dash.php", "grid_view", "Dashboard");
                createNewElement("../Pages/orders.php", "format_list_bulleted", "My Orders");
                createNewElement("../Pages/updateProfile.php", "manage_accounts", "Update Profile");
                createNewElement("../Access/logout.php", "logout", "Logout");

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

            </script>
	<?php
		}
	?>
  </body>
</html>