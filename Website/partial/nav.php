		<!-- NAVIGATION -->
		<nav id="navigation">
		    <!-- container -->
		    <div class="container">
		        <!-- responsive-nav -->
		        <div id="responsive-nav">
		            <!-- NAV -->
		            <ul class="main-nav nav navbar-nav">
		                <li class="active"><a href="index.php">Home</a></li>
		                <?php
						include_once "../Dashboard/partial/DB_CONNECTION.php";
						$query = "SELECT * from categories";
						$result = mysqli_query($connection,$query);
						while($row = mysqli_fetch_assoc($result)){
							$id = $row["id"];
							$category =$row["name"];
							echo "<li><a href='show_stores.php?category_id=$id'>".$row["name"]."</a></li>";
						}

						?>
		            </ul>
		            <!-- /NAV -->
		        </div>
		        <!-- /responsive-nav -->
		    </div>
		    <!-- /container -->
		</nav>
		<!-- /NAVIGATION -->