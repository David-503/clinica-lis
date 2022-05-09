<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-100">
        <md-card>
            <md-card-header data-background-color="rose">
                <h4 class="title">Realizar Consulta</h4>
                <p class="category">Realizar una nueva consulta</p>
            </md-card-header>
            <md-card-content>
                <md-steppers :md-active-step.sync="active" md-linear>
                    <md-step id="first" :md-label="`Paciente: ${patient.name}`" :md-error="patientStepError" md-description="Ingrese al paciente" :md-done.sync="first">
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
                        <md-button class="md-raised md-primary" @click="validatePatient">Continuar</md-button>
                    </md-step>

                    <md-step id="second" md-label="Expediente" :md-error="secondStepError" :md-done.sync="second">
                        <File :idPatient="patient.dui"></File>
                        <md-button class="md-raised md-primary" @click="setDone('second', 'third')">Continuar</md-button>
                    </md-step>

                    <md-step id="third" md-label="Finalizar" :md-done.sync="third">
                        <form>
                            <h3 class="text-rose">Datos de la consulta realizada</h3>
                            <div class="md-layout">
                                <div class="md-layout-item md-small-size-100 md-size-50">
                                    <md-field >
                                        <label >Receta Médica:</label>
                                        <md-textarea name="address" id="address" v-model="medical.drugs" md-autogrow></md-textarea>
                                        <!-- <span class="md-error text-danger" v-if="!$v.patient.address.required">La dirección es requerida</span> -->
                                    </md-field>
                                </div>
                                <div class="md-layout-item md-small-size-100 md-size-50">
                                    <md-field >
                                        <label >Indicaciones:</label>
                                        <md-textarea name="address" id="address" v-model="medical.indications" md-autogrow></md-textarea>
                                        <!-- <span class="md-error text-danger" v-if="!$v.patient.address.required">La dirección es requerida</span> -->
                                    </md-field>
                                </div>
                                <div class="md-layout-item md-small-size-100 md-size-100">
                                    <md-field >
                                        <label >Observaciones / Progreso:</label>
                                        <md-textarea name="address" id="address" v-model="medical.progress" md-autogrow></md-textarea>
                                        <!-- <span class="md-error text-danger" v-if="!$v.patient.address.required">La dirección es requerida</span> -->
                                    </md-field>
                                </div>
                                <div class="md-layout-item md-size-100 text-right">
                                    <md-button  type="submit" class="md-raised md-rose">Finalizar Consulta</md-button>
                                </div>
                            </div>
                        </form>
                    </md-step>
                </md-steppers>
            </md-card-content>
        </md-card>
        
      </div>
    </div>
  </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, minValue, between  } from "vuelidate/lib/validators";
import File from "../Secretary/File.vue"
import axios from "axios";
import moment from 'moment';

// Helper's Validator
const miDate = new Date();

// Event's Bus
Bus = window.Bus;
export default {
    // Mixins
    mixins: [validationMixin],
    components: {
        File
    },
  	// Data validations
  	data() {
    	return {
            // Data Errors
            active: 'first',
            first: false,
            second: false,
            third: false,
            patientStepError: "",
            secondStepError: null,
      		showError: false,
            errorMessage: null,
            setDone (id, index) {
                this[id] = true

                this.secondStepError = null

                if (index) {
                    this.active = index
                }
            },
            setError () {
                this.secondStepError = 'Oh no un error!'
            },
              // Data Form
            patient: {
                dui: null,
                name: 'Sin Seleccionar'
            },
            medical: {
                progress: null,
                indications: null,
                drugs: null
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
            this.patient = patient;
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
		validatePatient() {
			this.$v.$touch();
			if(!this.$v.Appointment.SelectedPatient.required){
                this.patientStepError = "Debe ingresar un paciente";
            }else{
                Bus.$emit('searchFile', this.patient.dui);
                this.setDone('first', 'second');
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
    .md-button.md-stepper-header.md-theme-default.md-active,.md-button.md-stepper-header.md-theme-default{
        background-color: white !important;
    }
	.md-invalid.md-field {
		label {
			color: lighten(#ff1744, 10) !important;
		}
	}
	.md-invalid.md-field:not(.md-disabled):after {
		background-color: #ff1744 !important;
	}
</style>