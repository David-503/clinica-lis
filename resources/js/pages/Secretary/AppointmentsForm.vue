<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-100">
        <form novalidate @submit.prevent="validateAppointment">
          <md-snackbar :md-position="'center'" :md-duration="10000" :md-active.sync="showError" md-persistent>
            <span>{{errorMessage}}</span>
            <md-button class="md-simple md-danger" @click="showError = false">Lo arreglaré!</md-button>
          </md-snackbar>
          <md-card>
            <md-card-header data-background-color="rose">
              <h4 class="title">Perfil</h4>
              <p class="category">Añadir Nueva Cita Medica</p>
            </md-card-header>

            <md-card-content>
              <h3 class="text-rose">Ingrese información necesaria para crear una cita</h3>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-datepicker name="Date" id="Date" :class="getValidationClass('Date')" v-model="Appointment.Date" :md-disabled-dates="disabledDates" :md-override-native="false">
                    <label>Fecha de la cita</label>
                    <span class="md-error text-danger" v-if="!$v.Appointment.Date.required">
											La fecha es requerida
										</span>
															<span class="md-error text-danger" v-if="!$v.Appointment.Date.miniValue">
											La fecha minima es el dia de mañana
										</span>
                  </md-datepicker>
                </div>
								<div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field :class="{'md-invalid': hourErrorbetweenI}">
                        <label>Hora de inicio</label>
                        <md-input name="InitialHour" id="InitialHour" v-model="Appointment.InitialHour" type="time"></md-input>
												<span class="md-error text-danger" v-if="hourErrorbetweenI">El horario de citas es de 8:00 AM a 4:00 PM</span>
                		</md-field>
                </div>
								<div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field :class="{'md-invalid': hourErrorbetweenF || FinalHourMax}">
                        <label>Hora de finalización</label>
                        <md-input name="FinalHour" id="FinalHour" v-model="Appointment.FinalHour" type="time"></md-input>
												<span class="md-error text-danger" v-if="hourErrorbetweenF">El horario de citas es de 8:00 AM a 4:00 PM</span>
												<span class="md-error text-danger" v-if="FinalHourMax">La hora de finalizacion debe ser mayor a la de inicio</span>
										</md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-50">
								<md-autocomplete name="SelectedPatient" id="SelectedPatient" :class="getValidationClass('SelectedPatient')" v-model="Appointment.SelectedPatient" :md-options="Patients" @md-changed="getPatients" @md-selected="selectNamePatient" @md-opened="getPatients">
                    	<label>Pacientes</label>
                    	<template slot="md-autocomplete-item" slot-scope="{ item }">{{ item.name }}</template>
                    	<template slot="md-autocomplete-empty" slot-scope="{ term }">
												No se encuentra ningun paciente que coincida con el dui ingresado ({{term}})
											</template>
                    	<span class="md-helper-text">Debe buscar al paciente por su dui</span>
                    	<span class="md-error text-danger" v-if="!$v.Appointment.SelectedPatient.required">
												El paciente es requerido
											</span>
                  	</md-autocomplete>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-autocomplete name="SelectedDoctor" id="SelectedDoctor" :class="getValidationClass('SelectedDoctor')" v-model="Appointment.SelectedDoctor" :md-options="Doctors" @md-changed="getDoctors" @md-selected="selectNameDoctor" @md-opened="getDoctors">
						<label>Medicos</label>
						<template slot="md-autocomplete-item" slot-scope="{ item }">{{ item.name }}</template>
						<template slot="md-autocomplete-empty" slot-scope="{ term }">
							No se encuentra ningun medico que coincida con el dui ingresado ({{term}})
						</template>
						<span class="md-helper-text">Debe buscar al medico por su dui</span>
						<span class="md-error text-danger" v-if="!$v.Appointment.SelectedDoctor.required">
							El medico es requerido
						</span>
                  </md-autocomplete>
                </div>
                <div class="md-layout-item md-size-100 text-right">
                  <md-button type="button" class="md-simple md-rose" @click="reset">Cancelar</md-button>
                  <md-button type="submit" class="md-raised md-rose">Crear Cita</md-button>
                </div>
              </div>
            </md-card-content>
          </md-card>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, minValue, between  } from "vuelidate/lib/validators";
import axios from "axios";
import moment from 'moment';

// Helper's Validator
const miDate = new Date();

// Event's Bus
Bus = window.Bus;
export default {
		// Mixins
  	mixins: [validationMixin],
  	// Data validations
  	data() {
    	return {
					// Data Errors
					FinalHourMax: false,
					hourErrorbetweenI: false,
					hourErrorbetweenF: false,
      		showError: false,
      		errorMessage: null,
      		// Data Form
      		disabledDates: date => {
        		let now = new Date();
        		return date <= now ? true : false;
      		},
      		Patients: [],
      		Doctors: [],
      		Appointment: {
        		Date: null,
        		SelectedPatientDui: null,
        		SelectedDoctorDui: null,
        		SelectedPatient: null,
						SelectedDoctor: null,
						InitialHour: "08:00",
						FinalHour: "08:00",
      		}
    	};
		},
		validations: {
    	Appointment: {
      		Date: {
        		required,
        		miniValue: minValue(miDate)
      		},
      		SelectedPatient: {
        		required
      		},
      		SelectedDoctor: {
        		required
					}
    	}
  	},
  	methods: {
    	saveAppointment() {
						Bus.$emit('loading');
            axios.post('/dashboard/citas/crear', this.Appointment)
            .then(
                response => {
                    Bus.$emit('stopLoading');
                    if(response.status == 200){
												this.reset()
                        this.$notify(
                        {
                            message: response.data,
                            icon: 'check',
                            horizontalAlign: 'right',
                            verticalAlign: 'top',
                            timeout: 5000,
                            type: 'success'
                        })
                    }
                }
            )
            .catch(
                error => {
                    Bus.$emit('stopLoading');
                    if(error.response.data) {
                        this.$notify(
                        {
                            message: error.response.data,
                            timeout: 5000,
                            icon: 'error',
                            horizontalAlign: 'right',
                            verticalAlign: 'bottom',
                            type: 'danger'
                        })
                    }else if(error.request){
                        this.$notify(
                        {
                            message: error.request,
                            icon: 'error',
                            horizontalAlign: 'right',
                            verticalAlign: 'bottom',
                            timeout: 5000,
                            type: 'danger'
                        })
                    }else {
                        this.$notify(
                        {
                            message: error.message,
                            icon: 'error',
                            horizontalAlign: 'right',
                            verticalAlign: 'bottom',
                            timeout: 100000,
                            type: 'danger'
                        })
                    }
                }
            )
		},
    	getPatients(searchTerm) {
      		axios.post("/dashboard/paciente/listar", null).then(response => {
        		this.Patients = new Promise(resolve => {
          			if (!searchTerm) {
            			resolve(response.data);
          			} else {
            			const term = searchTerm.toLowerCase();
            			resolve(
              				response.data.filter(({ dui }) =>
                			dui.toLowerCase().includes(term))
            			);
          			}
        		});
      		});
    	},
		selectNamePatient(patient) {
			this.Appointment.SelectedPatient = patient.name;
			this.Appointment.SelectedPatientDui = patient.dui;
		},
		getDoctors(searchTerm) {
			axios.post("/dashboard/doctor/listar", null).then(response => {
				this.Doctors = new Promise(resolve => {
					if (!searchTerm) {
						resolve(response.data);
					} else {
						const term = searchTerm.toLowerCase();
						resolve(
							response.data.filter(({ dui }) =>
							dui.toLowerCase().includes(term))
						);
					}
				});
			});
		},
		selectNameDoctor(doctor) {
			this.Appointment.SelectedDoctor = doctor.name;
			this.Appointment.SelectedDoctorDui = doctor.dui;
		},
		validateAppointment() {
			this.$v.$touch();
			let format = 'hh:mm'
			if(!(moment(this.Appointment.InitialHour,format).isBetween(moment("7:59",format), moment("16:01",format)))){
					this.hourErrorbetweenF = false;
					if(!(moment(this.Appointment.FinalHour,format).isBetween(moment("7:59",format), moment("16:01",format)))){
						this.hourErrorbetweenF = true;
					}
					this.FinalHourMax = false;
					this.hourErrorbetweenI = true;
					this.showError = true;
					this.errorMessage = "Datos incorrectos, reviselos e intente de nuevo";
			}else if(!(moment(this.Appointment.FinalHour,format).isBetween(moment("7:59",format), moment("16:01",format)))){
						this.FinalHourMax = false;
						this.hourErrorbetweenF = true;
						this.hourErrorbetweenI = false;
						this.showError = true;
						this.errorMessage = "Datos incorrectos, reviselos e intente de nuevo";
			}else if(!moment(this.Appointment.InitialHour,format).isBefore(moment(this.Appointment.FinalHour,format))){
						this.FinalHourMax = true;
						this.hourErrorbetweenF = false;
						this.hourErrorbetweenI = false;
						this.showError = true;
						this.errorMessage = "Datos incorrectos, reviselos e intente de nuevo";
			} else if (!this.$v.$invalid) {
					this.saveAppointment();
			} else {
					this.hourErrorbetweenF = false;
					this.FinalHourMax = false;
					this.hourErrorbetweenI = false;
					this.showError = true;
					this.errorMessage = "Datos incorrectos, reviselos e intente de nuevo";
			}
		},
		reset() {
			this.Appointment.Date = "0/0/0";
			this.Appointment.SelectedPatientDui = "";
			this.Appointment.SelectedDoctorDui = null;
			this.Appointment.SelectedPatient = "";
			this.Appointment.SelectedDoctor = "";
			this.Appointment.InitialHour = "08:00";
			this.Appointment.FinalHour = "08:00";
			this.FinalHourMax = false;
			this.hourErrorbetweenI = false;
			this.hourErrorbetweenF = false;
			this.$v.$reset();
		},
		// Validaciones
		getValidationClass(fieldName) {
			const field = this.$v.Appointment[fieldName];

			if (field) {
				return {
					"md-invalid": field.$invalid && field.$dirty
				};
			}
		}
  	}
};
</script>

<style lang="scss">
	.md-invalid.md-field {
		label {
			color: lighten(#ff1744, 10) !important;
		}
	}
	.md-invalid.md-field:not(.md-disabled):after {
		background-color: #ff1744 !important;
	}
</style>