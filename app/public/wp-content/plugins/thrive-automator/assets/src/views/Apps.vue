<template>
	<div class="tap-apps-container tap-fw">
		<div class="tap-sunset-banner">
			<div class="tap-sunset-svg">
				<img src="../../images/sunset.svg" alt="Sunset"/>
			</div>
			<div class="tap-sunset-text">
				<h2>We are sunsetting Thrive Automator</h2>
				<p>Thrive Themes is retiring Thrive Automator in favor of Uncanny Automator, the #1 Automation Plugin for WordPress. Get started for free and access 185+ integrations, and 1000+ new triggers and actions.</p>
					<button 
						@click="activateUncanny" 
						class="tap-sunset-uncanny-activate">
						<span v-if="isUncannyActive">
							<a href="/wp-admin/edit.php?post_type=uo-recipe&page=uncanny-automator-dashboard">Get Started</a>
						</span>
						<span v-else v-html="uncannyInstallButton"></span>
					</button>					
					<p v-if="message">{{ message }}</p>
					<button @click="showPopupOnClick" class="tap-learn-more-sunset">Learn more</button>
			</div>
		</div>
		<!-- Popup component -->
		<div v-if="showPopup" class="popup-overlay-tap">
            	<div class="tap-popup-content">
					<button @click="closePopup" class="tap-popup-close">&times;</button>
					<div class="tap-automator-reitired">
						<div class="tap-sunset-popup-svg">
							<img src="../../images/sunset-popup.svg" alt="Sunset-popup"/>
						</div>
                		<h2>Thrive Automator is Being Retired</h2>
                		<p>At Thrive Themes, we are focused on building our core products to the absolute best standard for you and your <br>business.</p>
						<p>To achieve this goal, we are retiring Thrive Automator in favor of Uncanny Automator, a specialist website automation tool with a dedicated development team.</p>
						<a href="https://thrivethemes.com/uncanny-automator/" target="_blank" class="tap-sunset-link">Learn More to See Why Uncanny Automator is Better</a>
					</div>
					<div class="tap-uncanny">
						<div class="tap-uncanny-popup-svg">
							<img src="../../images/uncanny-popup.svg" alt="uncanny-popup"/>
						</div>
						<div class="tap-uncanny-header">
						<h2>Get started with Uncanny Automator</h2><img src="../../images/sunset-free.svg" class="tap-uncanny-free" alt="uncanny-free"/>
						</div>
						<p>Automate your Thrive Themes website with the Number #1 automation plugin for WordPress.</p>
						<p>Connect with over 185+ integrations, including all Thrive Themes products, and achieve more with your website</p>
						<ul>
							<li><div class="tap-uncanny-list"><img src="../../images/sunset-check.svg" alt="uncanny-popup"/> Used by over 40,000+ websites</div></li>
							<li><div class="tap-uncanny-list"><img src="../../images/sunset-check.svg" alt="uncanny-popup"/> 110+ Million automations performed</div></li>
							<li><div class="tap-uncanny-list"><img src="../../images/sunset-check.svg" alt="uncanny-popup"/> Access 1000+ new triggers, actions and conditions</div></li>
						</ul>
						<div class="tap-uncanny-activate-holder">
							<button @click="activateUncannyPopup" class="tap-uncanny-activate">
								<span v-if="isUncannyActive">
									<a href="/wp-admin/edit.php?post_type=uo-recipe&page=uncanny-automator-dashboard">Get Started</a>
								</span>
								<span v-else v-html="uncannyInstallButtonPopup"></span>
							</button>
							<img class="tap-arrow" src="../../images/sunset-arrow.svg" alt="uncanny-popup"/>
						</div>
					</div>
            	</div>
        	</div>
		<iframe :src="appsLink" class="tap-suite-apps-iframe" title="Apps" @load="iframeLoaded"/>
	</div>
</template>

<script>
import { toggleAppLoader } from "@/utils/ui-fn";
import { mapGetters } from "vuex";

export default {
	name: "Apps",
	computed: {
		...mapGetters( 'suite', [ 'getConnected' ] ),
		appsLink() {
			return `${TAPAdmin.urls.apps_link}&body_class=tap-suite-apps-body`;
		}
	},
	data() {
		return {
			showPopup: false,
			message: '',
			isUncannyActive: false,
			uncannyInstallButtonPopup: '<img src="/wp-content/plugins/thrive-automator/assets/images/sunset-simple-check.svg"/> Activate',
			uncannyInstallButton: 'Install Uncanny Automator',
			activationCounter: 0,
		}
	},
	created() {
    // Check if the popup should be shown when the component is created
		this.shouldShowPopup();
		this.checkUncannyStatus();
	},
	mounted() {
		this.checkUncannyStatus();
		if ( ! this.getConnected ) {
			this.$router.push( {path: '/suite'} );
		} else {
			toggleAppLoader()
		}
	},
	methods: {
		iframeLoaded() {
			toggleAppLoader( false )
		},
		getCurrentDate() {
			const today = new Date();
			return today.toISOString().split('T')[0];
		},
		// Function to determine if the popup should be shown
		shouldShowPopup() {
			const lastShownDate = localStorage.getItem('popupLastShownDate');
			const today = this.getCurrentDate();

		// Check if the popup has never been shown or if three days have passed since it was last shown
		if (!lastShownDate || new Date(today) - new Date(lastShownDate) >= 3 * 24 * 60 * 60 * 1000) {
			this.showPopup = true; // Show the popup
			localStorage.setItem('popupLastShownDate', today); // Update the date in local storage
			}
		},
		// Function to handle button click and show the popup
		showPopupOnClick() {
			this.showPopup = true; // Show the popup on button click
			const today = this.getCurrentDate();
			localStorage.setItem('popupLastShownDate', today); // Update the date in local storage
		},
		    // Function to close the popup
		closePopup() {
      		this.showPopup = false; // Hide the popup
    	},
		navigateToSunsetUrl() {
      	window.location.href = '#';
    	},
		activateUncanny() {
		if (this.activationCounter === 0) {
			this.uncannyInstallButton = 'Activating...';
			this.activationCounter++;
		}

		// Save the updated counter back to localStorage
		localStorage.setItem('activationCounter', activationCounter);
		if (typeof TAPAdminAjax === 'undefined' || !TAPAdminAjax.nonce) {
			console.error("Nonce for TAPAdminNonce is not defined!");
			return;
		}
		if (typeof TAPAdminAjax.ajax_url === 'undefined' ) {
			console.error("URL is not defined!");
			return;
		}
		fetch(TAPAdminAjax.ajax_url, {  // Ensure TAPAdmin is used if it was localized with the AJAX URL
			method: 'POST',
			headers: {
			'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
			},
			body: new URLSearchParams({
			action: 'thrive_automator_uncanny', // Adjust this to match your registered AJAX action
			nonce: TAPAdminAjax.nonce  // Use the nonce from TAPAdminNonce
			})
		})
		.then(response => response.json())
			.then(data => {
				if (data.success) {
					this.isUncannyActive = true;
					this.uncannyInstallButton = '<a href="/wp-admin/edit.php?post_type=uo-recipe&page=uncanny-automator-dashboard">Get Started</a>';
				} else {
					this.uncannyInstallButton = 'Activate';
				}
			})
			.catch(error => {
				this.uncannyInstallButton = '<a href="/wp-admin/edit.php?post_type=uo-recipe&page=uncanny-automator-dashboard">Get Started</a>';
			})
		},
		checkUncannyStatus() {
			this.isUncannyActive = false;
			if (typeof TAPAdminAjax === 'undefined' || !TAPAdminAjax.nonce) {
				console.error("Nonce for TAPAdminNonce is not defined!");
				return;
			}
			if (typeof TAPAdminAjax.ajax_url === 'undefined' ) {
				console.error("URL is not defined!");
				return;
			}
			fetch(TAPAdminAjax.ajax_url, {  
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
				},
				body: new URLSearchParams({
					action: 'thrive_automator_check_uncanny', 
					nonce: TAPAdminAjax.nonce 
				})
			})
			.then(response => response.json())
			.then(data => {
				if (data.data.message === 'active') {
					this.isUncannyActive = true;
					this.uncannyInstallButtonPopup = '<a href="/wp-admin/edit.php?post_type=uo-recipe&page=uncanny-automator-dashboard">Get Started</a>';
					this.uncannyInstallButton = '<a href="/wp-admin/edit.php?post_type=uo-recipe&page=uncanny-automator-dashboard">Get Started</a>';
				} 
				else if (data.data.message === 'installed') {
					this.uncannyInstallButton = 'Activate Uncanny Automator';
				} 				
				else {
					this.isUncannyActive = false;
				}
			})
		},
		activateUncannyPopup() {
		if (this.activationCounter === 0) {
			this.uncannyInstallButtonPopup = 'Activating...';
			this.activationCounter++;
		}
		if (typeof TAPAdminAjax === 'undefined' || !TAPAdminAjax.nonce) {
			console.error("Nonce for TAPAdminNonce is not defined!");
			return;
		}
		if (typeof TAPAdminAjax.ajax_url === 'undefined' ) {
			console.error("URL is not defined!");
			return;
		}
		fetch(TAPAdminAjax.ajax_url, {  
			method: 'POST',
			headers: {
			'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
			},
			body: new URLSearchParams({
			action: 'thrive_automator_uncanny', 
			nonce: TAPAdminAjax.nonce 
			})
		})
		.then(response => response.json())
			.then(data => {
				if (data.success) {
					this.isUncannyActive = true;
					this.uncannyInstallButtonPopup = '<a href="/wp-admin/edit.php?post_type=uo-recipe&page=uncanny-automator-dashboard">Get Started</a>';
				} else {
					this.uncannyInstallButtonPopup = '<img src="/wp-content/plugins/thrive-automator/assets/images/sunset-simple-check.svg"/> Activate';
				}
			})
			.catch(error => {
				this.uncannyInstallButtonPopup = '<a href="/wp-admin/edit.php?post_type=uo-recipe&page=uncanny-automator-dashboard">Get Started</a>';
			})
		}
}
}
</script>
