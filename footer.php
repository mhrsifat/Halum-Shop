<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$footer_about               = $row['footer_about'];
	$contact_email              = $row['contact_email'];
	$contact_phone              = $row['contact_phone'];
	$contact_address            = $row['contact_address'];
	$footer_copyright           = $row['footer_copyright'];

	$footer_address             = $row['footer_address'];
	$footer_phone               = $row['footer_phone'];
	$footer_mail                = $row['footer_mail'];
	$footer_address_text        = $row['footer_address_text'];
	$footer_phone_text          = $row['footer_phone_text'];
	$footer_mail_text           = $row['footer_mail_text'];

	$total_recent_post_footer   = $row['total_recent_post_footer'];
	$total_popular_post_footer  = $row['total_popular_post_footer'];
	$newsletter_on_off          = $row['newsletter_on_off'];
	$quickfooter_on_off         = $row['quickfooter_on_off'];
	$before_body                = $row['before_body'];
	$footer_logo_text           = $row['footer_logo_text'];
}
?>


<?php if ($newsletter_on_off == 1): ?>
	<section class="home-newsletter">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="single">
						<?php
						if (isset($_POST['form_subscribe'])) {

							if (empty($_POST['email_subscribe'])) {
								$valid = 0;
								$error_message1 .= LANG_VALUE_131;
							} else {
								if (filter_var($_POST['email_subscribe'], FILTER_VALIDATE_EMAIL) === false) {
									$valid = 0;
									$error_message1 .= LANG_VALUE_134;
								} else {
									$statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_email=?");
									$statement->execute(array($_POST['email_subscribe']));
									$total = $statement->rowCount();
									if ($total) {
										$valid = 0;
										$error_message1 .= LANG_VALUE_147;
									} else {
										// Sending email to the requested subscriber for email confirmation
										// Getting activation key to send via email. also it will be saved to database until user click on the activation link.
										$key = md5(uniqid(rand(), true));

										// Getting current date
										$current_date = date('Y-m-d');

										// Getting current date and time
										$current_date_time = date('Y-m-d H:i:s');

										// Inserting data into the database
										$statement = $pdo->prepare("INSERT INTO tbl_subscriber (subs_email,subs_date,subs_date_time,subs_hash,subs_active) VALUES (?,?,?,?,?)");
										$statement->execute(array($_POST['email_subscribe'], $current_date, $current_date_time, $key, 0));

										// Sending Confirmation Email
										$to = $_POST['email_subscribe'];
										$subject = 'Subscriber Email Confirmation';

										// Getting the url of the verification link
										$verification_url = BASE_URL . 'verify.php?email=' . $to . '&key=' . $key;

										$message = '
Thanks for your interest to subscribe our newsletter!<br><br>
Please click this link to confirm your subscription:
					' . $verification_url . '<br><br>
This link will be active only for 24 hours.
					';

										$headers = 'From: ' . $contact_email . "\r\n" .
											'Reply-To: ' . $contact_email . "\r\n" .
											'X-Mailer: PHP/' . phpversion() . "\r\n" .
											"MIME-Version: 1.0\r\n" .
											"Content-Type: text/html; charset=ISO-8859-1\r\n";

										// Sending the email
										mail($to, $subject, $message, $headers);

										$success_message1 = LANG_VALUE_136;
									}
								}
							}
						}
						if ($error_message1 != '') {
							echo "<script>alert('" . $error_message1 . "')</script>";
						}
						if ($success_message1 != '') {
							echo "<script>alert('" . $success_message1 . "')</script>";
						}
						?>
						<form action="" method="post">
							<?php $csrf->echoInputField(); ?>
							<h2><?php echo LANG_VALUE_93; ?></h2>
							<div class="input-group">
								<input type="email" class="form-control" placeholder="<?php echo LANG_VALUE_95; ?>" name="email_subscribe">
								<span class="input-group-btn">
									<button class="btn btn-theme" type="submit" name="form_subscribe"><?php echo LANG_VALUE_92; ?></button>
								</span>
							</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>



<?php if ($quickfooter_on_off == 1):  ?>
	<!-- Required CSS (add to your stylesheet) -->
	<style>
		.footer a:hover {
			text-decoration: underline;
		}

		.footer p,
		.footer a {
			font-size: 1.5rem;
		}
	</style>
	<!-- Footer Start -->
	<footer class="footer bg-dark text-light pt-5 text-center">
		<div class="container">
			<div class="row">

				<!-- Column 1: Logo & About -->
				<div class="col-md-3 mb-4 text-center">
					<a href="#" class="d-block mb-3">
						<a href="index.php"><img src="assets/uploads/<?php echo $logo; ?>" alt="logo image" style="max-width: 150px;"></a>
					</a>
					<p><?php echo $footer_logo_text; ?></p>
				</div>

				<!-- Column 2: Quick Links -->
				<div class="col-md-3 mb-4 text-center">
					<h5 class="mb-3"><?php echo LANG_VALUE_164; ?></h5>

					<?php
					$stmt = "select * from tbl_quick_links order by `order` asc";
					$links = $pdo->prepare($stmt);
					$links->execute();
					if ($links->rowCount() > 0):
					?>
						<ul class="list-unstyled">
							<?php foreach ($links as $link): ?>
								<li><a href="<?= $link['link_url'] ?>" class="text-light" target="_blank"><?= $link['link_name'] ?></a></li>
							<?php endforeach; ?>
						</ul>
					<?php else: ?>
						<ul class="list-unstyled">
							<li><a href="#" class="text-light">Home</a></li>
						</ul>
					<?php endif; ?>

				</div>

				<!-- Column 3: Customer Service -->
				<div class="col-md-3 mb-4 text-center">
					<h5 class="mb-3"><?php echo LANG_VALUE_165; ?></h5>
					<?php
					$stmt = "select * from customer_service order by sort_by asc";
					$links = $pdo->prepare($stmt);
					$links->execute();
					if ($links->rowCount() > 0):
					?>
						<ul class="list-unstyled">
							<?php foreach ($links as $link): ?>
								<li><a href="<?= $link['link_url'] ?>" class="text-light"><?= $link['link_name'] ?></a></li>
							<?php endforeach; ?>
						</ul>
					<?php else: ?>
						<ul class="list-unstyled">
							<li><a href="/faq" class="text-light">FAQ</a></li>
						</ul>
					<?php endif; ?>

				</div>

				<!-- Column 4: Contact & Social -->
				<div class="col-md-3 mb-4 text-center">
					<h5 class="mb-3"><?php echo LANG_VALUE_166; ?></h5>
					<?php if ($footer_address == 1): ?><p><i class="fa fa-map-marker"></i><?= $footer_address_text ?></p> <?php endif; ?>
					<?php if ($footer_phone == 1): ?><p><i class="fa fa-phone"></i><?= $footer_phone_text ?></p> <?php endif; ?>
					<?php if ($footer_mail == 1): ?><p><i class="fa fa-solid fa-envelope"></i><?= $footer_mail_text ?></p> <?php endif; ?>
				</div>

			</div>

			<!-- Payment Icons -->
			<div class="row mt-4 text-center">
				<div class="col-xs-12 text-center">
					<img src="assets/img/payment.png" alt="Visa" class="me-2" style="height:45px;">
				</div>
			</div>

		</div>
	</footer>
	<!-- Footer End -->

	<!-- Required JS (for font‑awesome icons) -->
	<script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>
<?php endif; ?>





<div class="footer-bottom">
	<div class="container">
		<div class="row">
			<div class="col-md-12 copyright">
				<?php echo $footer_copyright; ?>
			</div>
		</div>
	</div>
</div>


<a href="#" class="scrollup">
	<i class="fa fa-angle-up"></i>
</a>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$stripe_public_key = $row['stripe_public_key'];
	$stripe_secret_key = $row['stripe_secret_key'];
}
?>

<!-- <script src="assets/js/jquery-2.2.4.min.js"></script> -->
<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/jquery-2.2.4.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="https://js.stripe.com/v2/"></script>
<script src="assets/js/megamenu.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/owl.animate.js"></script>
<script src="assets/js/jquery.bxslider.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/rating.js"></script>
<script src="assets/js/jquery.touchSwipe.min.js"></script>
<script src="assets/js/bootstrap-touch-slider.js"></script>
<script src="assets/js/select2.full.min.js"></script>
<script src="assets/js/custom.js"></script>
<script>
	function confirmDelete() {
		return confirm("Sure you want to delete this data?");
	}
	$(document).ready(function() {
		advFieldsStatus = $('#advFieldsStatus').val();

		$('#paypal_form').hide();
		$('#stripe_form').hide();
		$('#bank_form').hide();

		$('#advFieldsStatus').on('change', function() {
			advFieldsStatus = $('#advFieldsStatus').val();
			if (advFieldsStatus == '') {
				$('#paypal_form').hide();
				$('#stripe_form').hide();
				$('#bank_form').hide();
			} else if (advFieldsStatus == 'PayPal') {
				$('#paypal_form').show();
				$('#stripe_form').hide();
				$('#bank_form').hide();
			} else if (advFieldsStatus == 'Stripe') {
				$('#paypal_form').hide();
				$('#stripe_form').show();
				$('#bank_form').hide();
			} else if (advFieldsStatus == 'Bank Deposit') {
				$('#paypal_form').hide();
				$('#stripe_form').hide();
				$('#bank_form').show();
			}
		});
	});


	$(document).on('submit', '#stripe_form', function() {
		// createToken returns immediately - the supplied callback submits the form if there are no errors
		$('#submit-button').prop("disabled", true);
		$("#msg-container").hide();
		Stripe.card.createToken({
			number: $('.card-number').val(),
			cvc: $('.card-cvc').val(),
			exp_month: $('.card-expiry-month').val(),
			exp_year: $('.card-expiry-year').val()
			// name: $('.card-holder-name').val()
		}, stripeResponseHandler);
		return false;
	});
	Stripe.setPublishableKey('<?php echo $stripe_public_key; ?>');

	function stripeResponseHandler(status, response) {
		if (response.error) {
			$('#submit-button').prop("disabled", false);
			$("#msg-container").html('<div style="color: red;border: 1px solid;margin: 10px 0px;padding: 5px;"><strong>Error:</strong> ' + response.error.message + '</div>');
			$("#msg-container").show();
		} else {
			var form$ = $("#stripe_form");
			var token = response['id'];
			form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
			form$.get(0).submit();
		}
	}
</script>
<?php echo $before_body; ?>
</body>

</html>