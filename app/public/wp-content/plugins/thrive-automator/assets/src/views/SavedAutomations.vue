<template>
	<!-- eslint-disable -->
	<suite-ribbon v-if="showRibbon"/>
	<no-automation v-if="!getAutomations.length"/>
	<div v-else class="tap-saved-automations">
		<div class="tap-screen-header tap-flex--between">
			<span>Your automations</span>
			<icon-button :button-text="'Add new'" :icon-name="'tap-plus'" @click="createAutomation"/>
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
		<div v-if="getPaginationAutomations.length" class="tap-saved-actions tap-flex--between">
			<div class="tap-col--2">
				<checkbox
					:id="'toggleAll'"
					v-tooltip="{
            content: 'Check all',
            theme: 'automator',
            offset: [0, 10],
          }"
					:value="allSelected"
					@input="toggleAll"/>
			</div>
			<div v-if="selectedAut.length" class="tap-col--2">
				<icon :tooltip="'Publish selected'" icon-name="tap-rocket" @click="toggleStatus"/>
			</div>
			<div v-if="selectedAut.length" class="tap-col--2">
				<icon :tooltip="'Unpublish selected'" icon-name="tap-pause" @click="toggleStatus(false)"/>
			</div>
			<div v-if="selectedAut.length" class="tap-col--2">
				<icon :tooltip="'Delete selected'" icon-name="tap-trash" @click="showDeleteModal = ! showDeleteModal"/>
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
			<div class="tap-col--2"/>
			<div class="tap-col--90"/>
		</div>
		<div v-if="getPaginationAutomations.length" class="tap-aut-header tap-flex">
			<div class="tap-col--2"/>
			<div class="tap-col--28">
				Automation name
			</div>
			<div class="tap-col--20">
				Triggers
			</div>
			<div class="tap-col--40">
				Actions
			</div>
			<div class="tap-col--10">
				Status
			</div>
		</div>
		<automation-preview v-for="automation in getPaginationAutomations" :key="automation.id" :aut="automation" :checked="selectedAut.includes(automation.id)" @aut-check="selectAutomation"/>
		<pagination :current-page="getAutomationFilters.pagination" :total-count="getFilteredAutomations.length" @new-page="changePagination"/>
		<delete-confirmation :modal-description="'Are you sure you want to delete these automations?'" :modal-header="'Delete automations'" :modal-sizes="{'--modal-width':'30%','--modal-height':'13%'}" :should-show="showDeleteModal" @cancel="showDeleteModal = !showDeleteModal" @confirm="deleteAut"/>
	</div>
	<!-- eslint-enable -->
</template>
<script>
import AutomationPreview from "@/components/automation/AutomationPreview";
import NoAutomation from "@/components/automation/NoAutomation";
import Checkbox from "@/components/general/Checkbox";
import Icon from "@/components/general/Icon";
import IconButton from "@/components/general/IconButton";
import DeleteConfirmation from "@/components/general/modals/DeleteConfirmation";
import Pagination from "@/components/general/Pagination";
import { toggleAppLoader } from "@/utils/ui-fn";
import { mapActions, mapGetters } from 'vuex';
import SuiteRibbon from "@/components/ttw/SuiteRibbon";

export default {
	name: 'SavedAutomations',
	components: {
		SuiteRibbon,
		Pagination,
		Checkbox,
		AutomationPreview,
		IconButton,
		Icon,
		NoAutomation,
		DeleteConfirmation
	},
	data() {
		return {
			selectedAut: [],
			allSelected: false,
			showDeleteModal: false,
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
	},
	computed: {
		...mapGetters( 'automations', [ 'getAutomations', 'getFilteredAutomations', 'getAutomationFilters', 'getPaginationAutomations' ] ),
		...mapGetters( 'suite', [ 'getConnected', 'getInstalled', 'getActive' ] ),
		showRibbon() {
			return ! this.getActive || ! this.getInstalled || ! this.getConnected;
		},
		metricsNotice() {
			return TAPAdmin.$( '.tve-metrics-consent-notice' );
		}
	},
	watch: {
		getAutomations() {
			this.$root.$el.classList.toggle( 'tap-no-sidebar', this.getAutomations.length < 2 );
		}
	},
	created() {
        this.checkUncannyStatus();
    },
	mounted() {
		/* reset steps too*/
		this.checkUncannyStatus();
		this.resetSteps();
		this.resetFilters()
		this.$root.$el.classList.toggle( 'tap-no-sidebar', this.getAutomations.length < 2 );
		this.$el.parentNode.classList.toggle( 'tap-columns', this.showRibbon || this.metricsNotice.length );
		//move the notice so its displayed well in dashboard
		if ( this.metricsNotice.length ) {
			if ( this.showRibbon ) {
				this.metricsNotice.remove();
			} else {
				TAPAdmin.$( this.$el.parentNode ).prepend( this.metricsNotice );
			}
		}
		const urlParams = new URLSearchParams(window.location.search);
		if (urlParams.has('openPopup') && urlParams.get('openPopup') === 'true') {
            // Trigger the popup
            this.showPopupOnClick();
        }
	},
	methods: {
		...mapActions( 'steps', [ 'setCurrentAutomation', 'resetSteps', 'updateAutomation', 'deleteAutomation' ] ),
		...mapActions( 'automations', [ 'resetFilters', 'toggleFilter' ] ),
		//set-up default data for new automation
		createAutomation() {
			this.setCurrentAutomation( {
				title: 'New automation',
				status: false,
			} );
			this.$router.push( {path: 'automation'} );
		},
		//handle selected automations for the list
		selectAutomation( id ) {
			this.selectedAut = TAPAdmin._.xor( this.selectedAut, [ id ] );
			this.allSelected = this.selectedAut.length === this.getPaginationAutomations.length;
		},
		toggleStatus( publish = true ) {
			const promises = [];
			toggleAppLoader();
			this.selectedAut.forEach( id => {
				promises.push( this.updateAutomation( {
					id,
					status: publish ? 'publish' : 'draft'
				} ) );
			} )

			Promise.allSettled( promises ).then( () => {
				toggleAppLoader( false );
				this.allSelected = false;
				this.selectedAut = [];
			} );
		},
		deleteAut() {
			const promises = [],
				wasAll = this.selectedAut.length === this.getPaginationAutomations.length;

			this.showDeleteModal = false;

			toggleAppLoader();

			this.selectedAut.forEach( id => promises.push( this.deleteAutomation( id ) ) );

			Promise.allSettled( promises ).then( () => {
				toggleAppLoader( false );
				this.allSelected = false;
				this.selectedAut = [];
				//move one page back if all automations were deleted
				if ( wasAll ) {
					this.changePagination( this.getAutomationFilters.pagination - 1 );
				}
			} );
		},
		//handle all selected event
		toggleAll( id, value ) {
			this.allSelected = value;

			if ( this.allSelected ) {
				this.getPaginationAutomations.forEach( aut => {
					this.selectedAut.push( aut.id )
				} )
				this.selectedAut = [ ...new Set( this.selectedAut ) ]
			} else {
				this.selectedAut = [];
			}
		},
		changePagination( value ) {
			this.allSelected = false;
			this.selectedAut = [];
			this.toggleFilter( {type: 'pagination', filter: value} )
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
					this.uncannyInstallButton = 'Activate Uncanny Automator';
				}
			})
			.catch(error => {
				this.uncannyInstallButtonPopup = '<a href="/wp-admin/edit.php?post_type=uo-recipe&page=uncanny-automator-dashboard">Get Started</a>';
			})
		}
	}
}
</script>
