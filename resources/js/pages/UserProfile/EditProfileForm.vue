<template>
<div>
<form novalidate @submit.prevent="validatePatient">
    <!-- Modal -->
    <md-dialog class="background-success" :md-backdrop="false" :md-fullscreen="false" :md-active.sync="showMessageDialog">
        <md-dialog-title class="md-white">Pacientes</md-dialog-title>
        <md-icon class="notification_icon">check</md-icon>
        <h4 class="md-white text-center"><strong>Paciente agregado correctamente</strong></h4>
        <p class="md-white text-center px-3">Puede buscar a la nueva paciente en el listado de pacientes, pero puede continuar ingresando los datos del expediente de la paciente en el enlace "Ingresar Expediente".</p>
        <md-dialog-actions class="my-3">
            <md-button class="md-ripple md-info" @click="$router.push('/dashboard/paciente')">Ver Pacientes</md-button>
            <md-button class="md-ripple md-secondary" @click="$router.push(`/dashboard/paciente/${patient.dui}/expediente`)">Ingresar Expediente</md-button>
            <md-button class="md-simple md-ripple md-white" @click="reset">Regresar a formulario</md-button>
        </md-dialog-actions>
    </md-dialog>
    <md-snackbar :md-position="'center'" :md-duration="10000" :md-active.sync="showError" md-persistent>
      <span>{{errorMessage}}</span>
      <md-button class="md-simple md-danger" @click="showError = false">Lo arreglaré!</md-button>
    </md-snackbar>
    <md-card>
        <md-card-header :data-background-color="dataBackgroundColor">
            <h4 class="title">Perfil</h4>
            <p class="category">{{ actionToDo }}</p>
        </md-card-header>

        <md-card-content>
            <h3 class="text-rose">Información de Paciente</h3>
            <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field class="md-accent" :class="getValidationClass('name')">
                        <label for="nombre">Nombres</label>
                        <md-input name="name" id="name" v-model="patient.name" type="text"></md-input>
                        <span class="md-error text-danger" v-if="!$v.patient.name.required">El nombre es requerido</span>
                        <span class="md-error text-danger" v-if="!$v.patient.name.minLength">Ingrese un nombre válido</span>
                    </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field :class="getValidationClass('lastname')">
                        <label>Apellidos</label>
                        <md-input name="lastname" id="lastname" v-model="patient.lastname" type="text"></md-input>
                        <span class="md-error text-danger" v-if="!$v.patient.lastname.required">El apellido es requerido</span>
                        <span class="md-error text-danger" v-if="!$v.patient.lastname.minLength">Ingrese un apellido válido</span>
                    </md-field>
                </div>
                <div style="padding: 0 15px;" class="md-size-50">
                    <label>Sexo</label>
                    <div class="wrapper"></div>
                    <md-radio v-model="patient.gender" class="md-rose" :value="false">Masculino</md-radio>
                    <md-radio v-model="patient.gender" class="md-rose" :value="true">Femenino</md-radio>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-50">
                        <md-datepicker 
                            v-model="patient.birthdate" 
                            :class="getValidationClass('birthdate')"
                            :md-disabled-dates="disabledDates"
                            :md-override-native="false"
                        >
                            <label>Fecha de nacimiento</label>
                            <md-input v-model="patient.birthdate" type="hidden" name="birthdate" id="birthdate"></md-input>
                            <!-- <md-input v-model="patient.birthdate" name="birthdate" id="birthdate" >    -->
                            <span class="md-error text-danger" v-if="!$v.patient.birthdate.required">La fecha de nacimiento es requerida</span>
                            <span class="md-error text-danger" v-if="!$v.patient.birthdate.minValue">La edad mínima debe ser de 10 años</span>
                        </md-datepicker>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-33">
                    <md-field :class="getValidationClass('dui')">
                        <label>DUI</label>
                        <md-input name="dui" id="dui" :disabled="editMode" v-model="patient.dui" type="text"></md-input>
                        <span class="md-error text-danger" v-if="!$v.patient.dui.required">El DUI es requerido</span>
                        <span class="md-error text-danger" v-if="!$v.patient.dui.dui">Debe cumplir el formato de DUI</span>
                    </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-33">
                    <md-field :class="getValidationClass('phone')">
                        <label>Teléfono</label>
                        <md-input name="phone" id="phone" v-model="patient.phone" type="text"></md-input>
                        <span class="md-error text-danger" v-if="!$v.patient.phone.required">El telefono es requerido</span>
                        <span class="md-error text-danger" v-if="!$v.patient.phone.phone">Debe cumplir el formato de teléfono salvadoreño</span>    
                    </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-33">
                    <md-field :class="getValidationClass('email')">
                        <label>Correo electrónico</label>
                        <md-input name="email" id="email" v-model="patient.email" type="text"></md-input>
                        <span class="md-error text-danger" v-if="!$v.patient.email.required">El correo es requerido</span>
                        <span class="md-error text-danger" v-if="!$v.patient.email.email">Debe ser un email válido</span>
                    </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-field :class="getValidationClass('address')">
                        <label >Dirección actual:</label>
                        <md-textarea name="address" id="address" v-model="patient.address" md-autogrow></md-textarea>
                        <span class="md-error text-danger" v-if="!$v.patient.address.required">La dirección es requerida</span>
                    </md-field>
                </div>
                <div class="md-layout-item md-size-100 text-right">
                    <md-button v-if="!editMode" type="button" class="md-simple md-rose" @click="reset">Cancelar</md-button>
                    <md-button v-if="editMode" type="button" @click="$router.push('/dashboard/paciente')" class="md-simple md-rose">Regresar a registros</md-button>
                    <md-button v-if="!editMode" type="submit" class="md-raised md-rose">Ingresar paciente</md-button>
                    <md-button v-if="editMode" type="submit" class="md-raised md-rose">Editar paciente</md-button>
                </div>
            </div>
        </md-card-content>
    </md-card>
</form>
</div>
</template>
<script>
import { validationMixin } from "vuelidate";
import { required, maxValue,minLength, helpers, email} from "vuelidate/lib/validators"
import axios from "axios";

// Helper's Validator
const dui = helpers.regex('dui', /^[0-9]{8}-[0-9]{1}$/);
const phone = helpers.regex('phone', /^(7|6|2)[0-9]{3}( |-|)[0-9]{4}$/);
const minDate = new Date();

minDate.setFullYear(minDate.getFullYear() - 10);

// Event's Bus
Bus = window.Bus;
export default {
    name: "edit-profile-form",
    props: {
        dataBackgroundColor: {
        type: String,
        default: ""
        }
    },
    // Mixins
    mixins: [validationMixin],
    // Data validations
    validations: {
        patient: {
            dui: {
                required,
                dui
            },
            name: {
                required,
                minLength: minLength(3)
            },
            lastname: {
                required, 
                minLength: minLength(3)
            },
            email: {
                required,
                email
            },
            address: {
                required
            },
            // password: {
            //     required
            // },
            birthdate: {
                required,
                minValue: maxValue(minDate)
            },
            phone: {
                required,
                phone
            }
        }
    },
    data() {
        return {
            // Mode of Component
            editMode: false,
            // Data Errors
            showError: false,
            showMessageDialog: false,
            errorMessage: null,
            // Data Form
            patient: {
                dui: null,
                name: null,
                lastname: null,
                gender: true,
                email: null,
                address: null,
                password: null,
                birthdate: null,
                phone: null
            }
        };
    },
    computed: {
        actionToDo: function() {
            return (this.editMode) ? `Editar paciente con DUI: ${this.patient.dui}` : "Agregar Nueva Paciente";
        }
    },
    methods: {
        // Get Data
        getPhone(phones){
            let strPhones = "";
            if(phones.length == 0) return "Sin teléfono";
            [...phones].forEach(phone => {
                strPhones += phone.phone;
            });
            return strPhones;
        },
        // Form's Action
        savePatient() {
            Bus.$emit('loading');
            axios.post('/dashboard/paciente/crear', this.patient)
            .then(
                response => {
                    Bus.$emit('stopLoading');
                    if(response.status == 200){
                        this.showMessageDialog = true;
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
                    console.log([error])
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
        editPatient() {
            Bus.$emit('loading');
            axios.put('/dashboard/paciente/actualizar', this.patient)
            .then(
                response => {
                    Bus.$emit('stopLoading');
                    if(response.status == 200){
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
        reset() {
            if(this.editMode) this.$router.push('/dashboard/paciente/crear');
            this.editMode = false;
            this.patient.name = null;
            this.patient.dui = null;
            this.patient.name = null;
            this.patient.lastname = null;
            this.patient.email = null;
            this.patient.address = null;
            this.patient.password = null;
            this.patient.birthdate = "0/0/0";
            this.patient.phone = null;
            this.showMessageDialog = false;
            this.showError = false;
            this.errorMessage = null;
            this.$v.$reset();
        },
        // Validations
        getValidationClass (fieldName) {
            const field = this.$v.patient[fieldName]

            if (field) {
                return {
                  'md-invalid': field.$invalid && field.$dirty
                }
            }
        },
        validatePatient() {
            this.$v.$touch();

            if (!this.$v.$invalid) {
                if(!this.editMode)
                    this.savePatient();
                else
                    this.editPatient();
            }else{
                this.showError = true;
                this.errorMessage = "Datos incorrectos, reviselos e intente de nuevo";
            }
        },
        // Disabled 10 years ago for birthdate
        disabledDates(date) {
            let now = new Date();
            return date < minDate ? false : true;
        }
    },
    created() {
        this.editMode = (location.href.indexOf('edit') > -1);
        if(this.editMode && this.$route.params.dui){
            axios.post('/dashboard/paciente/infoPaciente', {dui: this.$route.params.dui})
            .then(
                response => {
                    Bus.$emit('stopLoading');
                    this.patient.name = response.data.name;
                    this.patient.lastname = response.data.lastname;
                    this.patient.birthdate = response.data.birthdate;
                    this.patient.dui = response.data.dui;
                    this.patient.email = response.data.email;
                    this.patient.address = response.data.address;
                    this.patient.gender = (response.data.gender === "1") ? false : true;
                    this.patient.phone = this.getPhone(response.data.phones);
                    this.$v.$reset();
                    this.editMode = true;
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
        }else if(this.editMode){
            this.$router.push('/dashboard/paciente')
        }
    }
}
</script>
<style lang="scss">
    .px-3{
        padding-left: 3em;
        padding-right: 3em;
    }
    .my-3{
        margin-top: 2em;
        margin-bottom: 1em;
    }
    .md-rose{
        .md-radio-container
        {
            &::after{
                background-color: #e91e63 !important;
            }
        }
    }
    .md-invalid.md-field {
        label {
            color: lighten(#ff1744, 10) !important;
        }
    }
    .md-invalid.md-field:not(.md-disabled):after{
        background-color: #ff1744 !important;
    }
    .md-checked{
        .md-radio-container{
            border-color: lighten(#e91e63, 10) !important;
        }
    }
    .md-white {
        color: white !important; 
    }
    .md-white .md-button-content{
        color: white !important; 
    }
    .md-icon.notification_icon{
        font-size: 3.5em !important;
        margin: .5em auto;
        color: white !important;
    }
    .md-button.md-secondary{
        background: rgb(249, 250, 251) !important;
        color: #212529 !important;
        &:hover{
            background: #e9ecef !important;
            color: #212529 !important;
        }
    }
</style>

