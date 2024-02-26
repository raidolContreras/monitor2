<?php
header('Content-Type: text/html; charset=utf-8');
?>

<?php

// Comenzar la sesión
session_start();

?>

<!DOCTYPE html>
<html lang="zxx">

<head>

	<?php include "css.php"; ?>

</head>

<body>
	<div class="all-section-area">
		<!-- End Preloader Area -->

		<?php include "config/whiteList.php"; ?>
		monitor
		<?php include "js.php"; ?>

	</div>

	<!-- Bootstrap Modal for Alerts -->
	<div class="modal fade modal2" id="alertModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalLabel">Alert</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body modal-body-extra">
				</div>
				<div class="modal-footer modal-footer-extra">
				</div>
			</div>
		</div>
	</div>
	
</body>

</html>
