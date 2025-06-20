<template>
	<div class="tap-deactivate-app">
		<generic-modal v-if="showConfirmation" :has-footer="true" extra-class="tap-deactivate-modal" @cancel="showConfirmation=false">
			<template #title>
				<h5 class="m-0">
					Please share why you are deactivating Thrive Automator
				</h5>
			</template>
			<template #content>
				<div class="tap-flex--column-start tap-fw">
					<radio v-for="(opt,index) in options" :id="opt.key" :key="index" :class="'mt-5 mb-5'" :text="opt.label" :value="opt.key===selectedOpt" @input="changeOption"/>
					<textarea v-if="showExtraReason" v-model="otherReason" class="tap-deactivate-reason tap-fw" placeholder="Reason for deactivation"/>
				</div>
			</template>
			<template #footer>
				<div class="tap-flex--between tap-fw pt-10">
					<div :class="{'tap-disabled': !canSend }" class="tap-metrics-button" @click="log">
						Submit & Deactivate
					</div>
					<div class="tap-metrics-button tap-skip" @click="deactivate">
						Skip & Deactivate
					</div>
				</div>
			</template>
		</generic-modal>
		<teleport to="body">
			<div class="tap-app-loader"/>
		</teleport>
	</div>
</template>

<script>
import GenericModal from "@/components/general/modals/GenericModal";
import Radio from "@/components/general/Radio";
import ApiRequest from "@/utils/ApiRequest";
import { toggleAppLoader } from "@/utils/ui-fn";

export default {
	name: "DeactivateApp",
	components: {
		Radio,
		GenericModal,
	},
	data() {
		return {
			selectedOpt: '',
			otherReason: '',
			deactivateButton: null,
			deactivateHref: '',
			showConfirmation: false,
			showExtraReason: false,
			message: '',
			isUncannyActive: false,
			activationCounter: 0,
		}
	},
	computed: {
		options() {
			return TAPAdmin.deactivate_reasons;
		},
		canSend() {
			return this.selectedOpt && ( this.selectedOpt !== 'other' || ( this.selectedOpt === 'other' && this.otherReason.length > 0 ) );
		},
	},
	mounted() {
		this.bindEvents();
		const pluginsForm = document.querySelector( '#bulk-action-form' );
		if ( pluginsForm ) {
			const mutationObserver = new MutationObserver( () => {
				this.bindEvents();
			} );

			mutationObserver.observe( pluginsForm, {childList: true} );
		}
		const uncannyButtons = document.querySelectorAll('.tap-sunset-uncanny-activate');
		uncannyButtons.forEach(button => {
			button.addEventListener('click', this.externalButtonClickHandler);
		});
		this.checkUncannyStatus();		
	},
	beforeDestroy() {
    // Clean up the event listeners when the component is destroyed
    const uncannyButtons = document.querySelectorAll('.tap-sunset-uncanny-activate');
    uncannyButtons.forEach(button => {
      button.removeEventListener('click', this.externalButtonClickHandler);
    });
  	},
	methods: {
		bindEvents() {
			this.deactivateButton = document.querySelector( '#the-list [data-slug="thrive-automator"] span.deactivate a' );
			if ( this.deactivateButton ) {
				this.deactivateHref = this.deactivateButton.getAttribute( 'href' );
				this.deactivateButton.addEventListener( 'click', this.showModal );
			}
			
		},
		changeOption( value ) {
			this.selectedOpt = value;
			this.showExtraReason = value === 'other';
		},
		showModal( e ) {
			e.preventDefault();
			this.showConfirmation = true;
		},
		deactivate() {
			this.showConfirmation = false;
			window.location.href = this.deactivateHref;
		},
		log() {
			toggleAppLoader();
			ApiRequest.wpFetchRequest( {
				path: `${TAPAdmin.routes}/track_deactivate`,
				method: 'POST',
				body: {
					reason: this.options.find( opt => opt.key === this.selectedOpt ).label || 'Other',
					reason_id: this.selectedOpt,
					extra_message: this.selectedOpt === 'other' ? this.otherReason : '',
					nonce: TAPAdmin.deactivate_nonce
				}
			} ).finally( () => {
				this.deactivate();
				toggleAppLoader( false );
			} );
		},
		externalButtonClickHandler() {
      		// Call the method you want to trigger
      		this.activateUncanny();
    	},
		activateUncanny() {
			const uncannyButton = document.querySelector('.tap-sunset-uncanny-activate');
			if (uncannyButton && this.isUncannyActive === false) {
				uncannyButton.textContent = 'Activating...';
			}
			if (!window.TAPAdminAjax?.ajax_url || !window.TAPAdminAjax?.nonce) {
				console.error("Required TAPAdminAjax configuration is missing");
				this.uncannyInstallButton = 'Activate';
				return;
			}

			fetch(window.TAPAdminAjax.ajax_url, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
				},
				body: new URLSearchParams({
					action: 'thrive_automator_uncanny',
					nonce: window.TAPAdminAjax.nonce
				})
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					this.isUncannyActive = true;
					const uncannyButtons = document.querySelectorAll('.tap-sunset-uncanny-activate');
					uncannyButtons.forEach(button => {
						button.innerHTML = '<a href="/wp-admin/edit.php?post_type=uo-recipe&page=uncanny-automator-dashboard">Get Started</a>';
					});
				} else {
					this.uncannyInstallButton = 'Activate';
				}
			})
			.catch(error => {
				const uncannyButtons = document.querySelectorAll('.tap-sunset-uncanny-activate');
					uncannyButtons.forEach(button => {
						button.innerHTML = '<a href="/wp-admin/edit.php?post_type=uo-recipe&page=uncanny-automator-dashboard">Get Started</a>';
					});
			})
		},
		checkUncannyStatus() {
			this.isUncannyActive = false;
			if (!window.TAPAdminAjax?.ajax_url || !window.TAPAdminAjax?.nonce) {
				console.error("Required TAPAdminAjax configuration is missing");
				return;
			}

			fetch(window.TAPAdminAjax.ajax_url, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
				},
				body: new URLSearchParams({
					action: 'thrive_automator_check_uncanny',
					nonce: window.TAPAdminAjax.nonce
				})
			})
			.then(response => response.json())
			.then(data => {
				if (data.data.message === 'active') {
					this.isUncannyActive = true;
					const uncannyButtons = document.querySelectorAll('.tap-sunset-uncanny-activate');
					uncannyButtons.forEach(button => {
						button.innerHTML = '<a href="/wp-admin/edit.php?post_type=uo-recipe&page=uncanny-automator-dashboard">Get Started</a>';
					});
					
				} 
				else if (data.data.message === 'installed') {
					const uncannyButtons = document.querySelectorAll('.tap-sunset-uncanny-activate');
					uncannyButtons.forEach(button => {
						button.textContent = 'Activate Uncanny Automator';
					});
				} 				
				else {
					const uncannyButtons = document.querySelectorAll('.tap-sunset-uncanny-activate');
					uncannyButtons.forEach(button => {
						button.textContent = 'Install Uncanny Automator';
					});
				}
			})
		}
	}
}
</script>

<style lang="scss">
.tap-modal {
	&.tap-deactivate-modal {
		--modal-width: 500px !important;
		padding: 25px !important;
		--modal-height: 30%;
		max-height: fit-content;
		box-sizing: border-box;

		.tap-modal-content {
			position: relative;
			padding: 0;
			height: auto;
			display: block;
			margin: 20px 0 0;

			.tap-radio-wrapper {
				padding-left: 1px;
			}

			.tap-deactivate-reason {
				height: 200px;
				resize: none;
				outline: none !important;
				box-shadow: none !important;
				border-color: var(--tap-heading-color) !important;
			}
		}

		.tap-modal-footer {
			background: transparent;
			height: auto;
		}
	}
}
</style>
