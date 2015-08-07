<?php
/********************************************************************************/
add_action('wp_ajax_my_action', 'appvitrine_action_ajaxcallback');
function appvitrine_action_ajaxcallback() {
	global $wpdb;
	// this is how you get access to the database

	$name = $_POST['appvitrine_subscription_name'];
	$email = $_POST['appvitrine_subscription_email'];

	echo true;

	wp_die();
	// this is required to terminate immediately and return a proper response
}
?>
<div class="wrap appvitrin " >
	<h2 id="add-new-user">
		AppVitrine :: Subscription
	</h2>
		<br>
	<div class="sction_border">
	<p>
		Enter your name and email address and click on the subscribe button. <p> We will email you the news and updates about the AppVitrine plugin. You will also receive some interesting tutorials about how to monetize your weblog using AppVitrine plugin whenever we lunched the monetization service. <p>Your email is safe with us and we will not share it with any third party.
	</p>
	<div class="alert-success" style="display:none;">
		You have been successfully subscribed to our newsletter.
	</div>
	<form action="" method="post" name="SubscriptionForm" id="SubscriptionForm" class="validate">
		<table class="form-table">
			<tbody>
				<tr class="form-field form-required">
					<th scope="row" style="width:100px;">
						<label for="appvitrine_subscription_name">
							Name
						</label>
					</th>
					<td>
						<label for="appvitrine_subscription_name">
							<input
							style="width: 25em;"
							name="appvitrine_subscription_name"
							type="text"
							id="appvitrine_subscription_name"
							value=""/>
						</label>
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row" style="width:100px;">
						<label for="appvitrine_subscription_email">
							Email
						</label>
					</th>
					<td>
						<label for="appvitrine_subscription_email">
							<input
							style="width: 25em;"
							name="appvitrine_subscription_email"
							type="email"
							id="appvitrine_subscription_email"
							value=""/>
						</label>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<input type="button" name="btnSubscribe" id="btnSubscribe" class="button button-primary" value="subscribe">
		</p>
	</form>
	</div>
</div>
<script>
	(function($) {
		$(document).ready(function() {
			$("#btnSubscribe").click(function() {
				var data = {
					'action' : 'appvitrine_action_ajaxcallback',
					'name' : $("#appvitrine_subscription_name").val(),
					'email' : $("#appvitrine_subscription_email").val(),
				};
				// We can also pass the url value separately from ajaxurl for front end AJAX implementations
				jQuery.post(ajaxurl, data, function(response) {
					if (response == "0") {
						$("#SubscriptionForm").hide();
						$(".alert-success").show();
					} else {
						alert('Subscription failed');
					}
				});
				return;
			});
		});
	})(jQuery); 
</script>
