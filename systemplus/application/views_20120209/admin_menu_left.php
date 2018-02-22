	<section id="secondary_bar">
		<div class="user">
			<p>John Doe (<a href="#">3 Messages</a>)</p>
			<!-- <a class="logout_user" href="#" title="Logout">Logout</a> -->
		</div>
		<div class="breadcrumbs_container">
			<article class="breadcrumbs"><a href="index.html">Website Admin</a> <div class="breadcrumb_divider"></div> <a class="current">Dashboard</a></article>
		</div>
	</section><!-- end of secondary bar -->
	
	<aside id="sidebar" class="column">
		<form class="quick_search">
			<input type="text" value="Quick Search" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;">
		</form>
		<hr/>
                <h3>Booking</h3>
		<ul class="toggle">
                        <li><a href="<?php echo base_url(); ?>index.php/gestione_centri">Booking Form</a></li>
			<li><a href="<?php echo base_url(); ?>index.php/gestione_centri/presearch">Booking Review</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/gestione_centri/list_confirm">Trasfert Status</a></li>
                </ul>

		<h3>Content</h3>
		<ul class="toggle">
			<li class="icn_new_article"><a href="<?php echo base_url(); ?>index.php/gestione_centri/add_agent">New Agent</a></li>
                        <li class="icn_new_article"><a href="<?php echo base_url(); ?>index.php/gestione_centri/add_destination">New Destination</a></li>
			<!--<li class="icn_edit_article"><a href="#">Edit Articles</a></li>
			<li class="icn_categories"><a href="#">Categories</a></li>
			<li class="icn_tags"><a href="#">Tags</a></li>-->
		</ul>
		<!--<h3>Users</h3>
		<ul class="toggle">
			<li class="icn_add_user"><a href="#">Add New User</a></li>
			<li class="icn_view_users"><a href="#">View Users</a></li>
			<li class="icn_profile"><a href="#">Your Profile</a></li>
		</ul>-->
		<!--<h3>Media</h3>
		<ul class="toggle">
			<li class="icn_folder"><a href="#">File Manager</a></li>
			<li class="icn_photo"><a href="#">Gallery</a></li>
			<li class="icn_audio"><a href="#">Audio</a></li>
			<li class="icn_video"><a href="#">Video</a></li>
		</ul>-->
		<h3>Admin</h3>
		<ul class="toggle">
			<!--<li class="icn_settings"><a href="#">Options</a></li>
			<li class="icn_security"><a href="#">Security</a></li>-->
			<li class="icn_jump_back"><a href="<?php echo base_url(); ?>index.php/gestione_centri/logout" class="text">Logout</a></li>
		</ul>
		<footer>
			<hr />
			<p><strong>Copyright &copy; 2011 Website Admin</strong></p>
			<p>Theme by <a href="http://www.medialoot.com">MediaLoot</a></p>
		</footer>
	</aside><!-- end of sidebar -->
