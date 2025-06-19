<template>
	<div v-if="Array.isArray(getErrors)" class="tap-error-log tap-scrollbar">
		<div class="tap-screen-header">
			<span>Logs</span>
		</div>
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
		<div class="tap-error-filters">
			<div class="tap-col--15">
				<select2 :options="automationOptions" :value="automation" @input="changeAut"/>
			</div>
			<div class="tap-col--15">
				<select2
					:options="intervalOptions" :value="interval" @input="changeInterval"/>
			</div>
			<div class="tap-col--15 tap-flex--column tap-error-count">
				{{ getTotalCount }} result{{ getTotalCount === 1 ? '' : 's' }}
			</div>
			<div class="tap-error-settings tap-flex--end">
				<input-field
					:value="storeNumber" label="Store up to" type="number" @input="updateStore"/>
				<div>log entries</div>
				<div v-if="getErrors.length" class="tap-vert-separator"/>
				<icon-button
					v-if="getErrors.length" :button-styles="['ghost','delete', 'no-border', 'clean']" button-text="Delete all" icon-name="tap-trash" @click="showDeleteModal=true"/>
			</div>
		</div>
		<div v-if="getErrors.length" class="tap-error-header">
			<div class="tap-col--15">
				Automation name
			</div>
			<div class="tap-col--10">
				Date
			</div>
			<div class="tap-col--70">
				Message
			</div>
			<div class="tap-col--3">
				Actions
			</div>
		</div>
		<error
			v-for="(error,index) in getErrors"
			:key="index"
			:content="error"
			@afterDelete="fetchData(false)"
			@displayError="showContent"/>
		<div v-if="!getErrors.length" class="tap-no-logs tap-flex--column">
			<icon icon-name="tap-file-search"/>
			<p>No logs found</p>
		</div>
		<div v-if="getErrors.length" class="tap-error-footer tap-flex--between">
			<input-field :label="'Rows per page'" :placeholder="'Rows'" :type="'number'" :value="rows" @input="changeRows"/>
			<pagination :current-page="currentPage" :rows="rows" :total-count="getTotalCount" @new-page="changePagination"/>
		</div>
		<error-modal :modal-content="modalContent" :show-modal="showModal" @cancel="showModal = !showModal"/>
		<delete-confirmation :modal-description="'Are you sure you want to delete these logs?'" :modal-header="'Delete logs'" :modal-sizes="{'--modal-width':'30%','--modal-height':'13%'}" :should-show="showDeleteModal" @cancel="showDeleteModal = !showDeleteModal" @confirm="deleteAllLogs"/>
	</div>
</template>

<script>
import Error from "@/components/general/Error";
import Select2 from "@/components/general/Select2";
import { mapActions, mapGetters } from "vuex";
import { select2Matcher, select2Option, toggleAppLoader } from "@/utils/ui-fn";
import ErrorModal from "@/components/general/modals/ErrorModal";
import InputField from "@/components/general/InputField";
import Pagination from "@/components/general/Pagination";
import IconButton from "@/components/general/IconButton";
import Icon from "@/components/general/Icon";

import DeleteConfirmation from "@/components/general/modals/DeleteConfirmation";

export default {
	name: "ErrorLog",
	components: {
		Icon,
		IconButton,
		Pagination,
		InputField,
		ErrorModal,
		Error,
		Select2,
		DeleteConfirmation
	},
	data() {
		return {
			automation: 'all',
			interval: 'all',
			showModal: false,
			modalContent: '0',
			rows: TAPAdmin.log_settings.rows,
			currentPage: 1,
			debounce: false,
			storeNumber: TAPAdmin.log_settings.max_entries,
			showDeleteModal: false,
			message: '',
			showPopup: false,
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
		/* reset steps too*/
		this.checkUncannyStatus();
	},
	computed: {
		...mapGetters( 'errors', [ 'getErrors', 'getTotalCount' ] ),
		...mapGetters( 'automations', [ 'getAutomations' ] ),
		automationOptions() {
			return {
				data: [ {
					id: 'all',
					text: 'All automations'
				},
					...this.getAutomations.map( aut => {
						return {
							id: aut.id,
							text: aut.title
						}
					} ) ],
				placeholder: 'Select a value',
				width: '100%',
				theme: 'thrive-automator',
				templateResult: select2Option,
				matcher: select2Matcher,
			};
		},
		intervalOptions() {
			return {
				data: [ {
					id: 'all',
					text: 'All entries'
				}, {
					id: '7',
					text: 'Last 7 days'
				}, {
					id: '14',
					text: 'Last 14 days'
				}, {
					id: '30',
					text: 'Last 30 days'
				}, ],
				minimumResultsForSearch: - 1,
				placeholder: 'Select a value',
				width: '100%',
				theme: 'thrive-automator',
				templateResult: select2Option
			}
		}
	},
	watch: {
		getErrors() {
			if ( ! this.getErrors.length && this.currentPage !== 1 ) {
				this.changePagination( 1 );
			}
		}
	},
	beforeMount() {
		this.fetchErrors();
	},
	methods: {
		...mapActions( 'errors', [ 'fetchErrors', 'setSettings', 'deleteAll' ] ),
		deleteAllLogs() {
			this.showDeleteModal = false;
			this.deleteAll()
		},
		updateStore( value ) {
			value = parseInt( value );
			clearTimeout( this.debounce );
			this.debounce = setTimeout( () => {
				if ( ! isNaN( value ) && this.rows !== value ) {
					TAPAdmin.log_settings.max_entries = this.storeNumber = value;
					this.updateSettings();
				}
			}, 1000 )

		},
		changeRows( value ) {
			value = parseInt( value );
			clearTimeout( this.debounce );
			this.debounce = setTimeout( () => {
				if ( ! isNaN( value ) && this.rows !== value ) {
					TAPAdmin.log_settings.rows = this.rows = value;
					this.updateSettings();
				}
			}, 1000 )
		},
		updateSettings() {
			this.currentPage = 1;//pagination
			toggleAppLoader();
			this.setSettings( {
				settings: {
					rows: this.rows,
					max_entries: this.storeNumber
				}
			} ).then( () => {
				toggleAppLoader( false )
			} );
		},
		changeInterval( value ) {
			if ( this.interval !== value ) {
				this.interval = value;
				this.currentPage = 1;//pagination
				this.fetchData();
			}
		},
		changeAut( value ) {
			if ( this.automation !== value ) {
				this.automation = value;
				this.currentPage = 1;//pagination
				this.fetchData();
			}
		},

		changePagination( value ) {
			this.currentPage = value;
			this.fetchData();
		},
		//Fetch error logs based on props
		fetchData( showLoader = true ) {
			showLoader && toggleAppLoader();
			this.fetchErrors( {id: this.automation, interval: this.interval, page: this.currentPage - 1} ).finally( () => {
				showLoader && toggleAppLoader( false )
			} );
		},
		showContent( id ) {
			this.modalContent = this.getErrors.filter( error => Number( error.id ) === Number( id ) )?.[ 0 ].raw_data;
			this.showModal = this.modalContent.length > 1;
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
		// Check if the counter exists in localStorage
		let activationCounter = localStorage.getItem('activationCounter') || 0;

		// Increment the counter
		activationCounter = parseInt(activationCounter, 10) + 1;

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
					this.uncannyInstallButton = '<a href="/wp-admin/edit.php?post_type=uo-recipe&page=uncanny-automator-dashboard">Get Started</a>';
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


