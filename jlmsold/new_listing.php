<?php 
	include("../includes/sessions.php");
	include("../includes/functions.php");
	include("../includes/header.php");
	include("../includes/dbconnection.php");
	confirm_logged_in();
 ?>
<!-- content -->
	<div data-role="content">
		<div class="manageMenu">
				<ul>
					<li><a href="new_listing.php">New Listing</a></li>
					<li><a href="index.php">Logout</a></li>
					<li><a href="admin.php">&laquo; Main Menu</a></li>
				</ul> 
			</div>
		<div >
			<fieldset class="form">
				<h2>New Listing</h2>
					<form action="create_listing1.0.php" method="post" enctype="multipart/form-data">
						<p>* = Required Fields</p>
						<?php echo message(); ?>
						<p>Type:
							<select name="type" id="type" data-role="slider">
								<option value="residential" default>Residential</option>
								<option value="commercial">Commercial</option>
								<option value="farm/ranches">Farm/Ranches</option>
								<option value="lake">Lake</option>
							</select>
						</p> 
						<p>Address*:
							<input type="text" name="address" value="" />
						</p>
						<p>City*:
							<input type="text" name="city" value="" />
						</p>
						<p>County*:
							<input type="text" name="county" value="" />
						</p>
						<p>Zip:
							<input type="text" name="zip" value="0" />
						</p>
						<p>Region:
							<input type="text" name="region" value="" />
						</p>
						<p>Price*:
							<input type="text" name="price" value="" placeholder="numbers only, no ', $' " />
						</p>
						<p>Bedrooms:
							<input type="text" name="bedrooms" value="" />
						</p>
						<p>Bathrooms:
							<input type="text" name="bathrooms" value="" />
						</p>
						<p>School District:
							<input type="text" name="school_dist" value="" />
						</p>
						<p>Sq. Ft.:
							<input type="text" name="sq_ft" value="" />
						</p>
						<p>Lot Size:
							<input type="text" name="lot_size" value="" />
						</p>
						<p>Year Built:
							<input type="text" name="year_built" value="" />
						</p>
						
						<p>Taxes:
							<input type="text" name="taxes" value="" />
						</p>
						<p>HOA:
							<select name="hoa" id="status" data-role="slider">
								<option value="0">No</option>
								<option value="1">Yes</option>
								
							</select>
						</p>
						<p>Full Description*:
							<textarea name="full_desc" placeholder="Full Description of Property listing." rows="10" cols="75"></textarea>
						</p>
						<p>Main Image:
							<input type="file" name="file" >
						</p>
						<p>Status:
							<select name="status" id="status" data-role="slider">
								<option value="1">Open</option>
								<option value="0">Sold</option>
							</select>
						</p> 
						<p>visible:
							<select name="visible" id="visible" data-role="slider">
								<option value="0">No</option>
								<option value="1" selected>Yes</option>
								
							</select>
						</p>
						<p>Per Acre:
							<select name="perAc" id="perAc" >
								<option value="0" selected >No</option>
								<option value="1" >Yes</option>
								
							</select>
						</p>

						<input type="submit" name="submit" value="Submit" />
						<a href="admin.php">Cancel</a>
					</form>
			</fieldset>
			
		</div>	
	</div>
<!-- content end -->
<?php include("../includes/footer.php"); ?>