<div class="container">
		<div class="nav">
			<div>
				<img id="nav-logo" src="images/swapspace-logo2.png" alt="Logo">
			</div>
			<ul class="nav-list">
				<li class="list-items" id="first-item"><a href="dashboard.php">Dashboard</a></li>
				<li class="list-items active"><a href="view-balance.php">View Balance</a></li>
				<li class="list-items"><a href="last-transaction.php">Last Transaction</a></li>
				<li class="list-items"><a href="add-pin.php">Add PIN</a></li>
				<li class="list-items"><a href="transfer.php">Transfer</a></li>
				<li class="list-items"><a href="view-beneficiaries.php">View Beneficiaries</a></li>
				<li class="list-items"><a href="add-beneficiaries.php">Add Beneficiaries</a></li>
			</ul>
			<span id="logout-button"><a href="index.php">Logout</a></span>
		</div>
		<div class="main">
			<p> 
				Hello 
				<?php
					if(!empty($_SESSION['fname'])) {

					echo $_SESSION['fname'] . " " . $_SESSION['lname'] . ",";

					} else {

						echo "Customer,";

					}
				?>
			</p>
			<br><br><br>	
		</div>
		
		<div class="footer"></div>
	</div>