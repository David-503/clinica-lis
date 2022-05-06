<template>
    <form novalidate @submit.prevent="validateFile">
        <md-snackbar :md-position="'center'" :md-duration="10000" :md-active.sync="showError" md-persistent>
            <span>{{errorMessage}}</span>
            <md-button class="md-simple md-danger" @click="showError = false">Lo arreglaré!</md-button>
        </md-snackbar>
        <md-card>
            <md-card-header data-background-color="rose">
                <h4 class="title">Perfil</h4>
                <p class="category">Llenar Expediente</p>
            </md-card-header>
            <md-card-content>
                <h2 class="text-rose">Archivo Identificación del Expediente</h2>
                <div>
                    <h6 class="text-rose">Información del paciente</h6>
                    <div class="md-layout">
                        <div style="padding: 0 15px;" class="md-layout-item md-small-size-100 md-size-50">
                            <label>Sexo</label>
                            <div class="wrapper"></div>
                            <md-radio v-model="IdentificationFile.gender" class="md-rose" :value="1">Masculino</md-radio>
                            <md-radio v-model="IdentificationFile.gender" class="md-rose" :value="0">Femenino</md-radio>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-50">
                            <md-field name="age" id="age" :class="getValidationClass('age',0)">
                                <label>Edad</label>
                                <md-input v-model="IdentificationFile.age" type="number"></md-input>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.age.required">Este es un campo requerido</span>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.age.minAge">La edad no debe ser menor a 10 años</span> 
                            </md-field>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-50">
                            <md-field name="marital_status" id="marital_status">
                                <label for="marital_status">Estado Marital</label>
                                <md-select v-model="IdentificationFile.marital_status">
                                    <md-option value="Soltero/a">Soltero/a</md-option>
                                    <md-option value="Casado/a">Casado/a</md-option>
                                    <md-option value="Viudo/a">Viudo/a</md-option>
                                    <md-option value="Divorciado/a">Divorciado/a</md-option>
                                </md-select>
                            </md-field>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-50">
                            <md-field :class="getValidationClass('occupation',0)">
                                <label>Ocupación</label>
                                <md-input name="occupation" id="occupation" v-model="IdentificationFile.occupation" type="text"></md-input>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.occupation.required">Este es un campo requerido</span>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.occupation.minLength">Ingrese una ocupación valida</span>
                            </md-field>
                        </div>
                    </div>
                    <h6 class="text-rose">Información de la familia</h6>
                    <div class="md-layout">
                        <div class="md-layout-item md-small-size-100 md-size-50">
                            <md-field :class="getValidationClass('father_name',0)">
                                <label>Nombre del padre</label>
                                <md-input name="father_name" id="father_name" v-model="IdentificationFile.father_name" type="text"></md-input>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.father_name.required">Este es un campo requerido</span>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.father_name.minLength">Ingrese un nombre valido</span>
                            </md-field>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-50">
                            <md-field :class="getValidationClass('mother_name',0)">
                                <label>Nombre de la madre</label>
                                <md-input name="mother_name" id="mother_name" v-model="IdentificationFile.mother_name" type="text"></md-input>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.mother_name.required">Este es un campo requerido</span>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.mother_name.minLength">Ingrese un nombre valida</span>
                            </md-field>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-50">
                            <md-field>
                                <label>Nombre de la pareja</label>
                                <md-input name="couple_name" id="couple_name" v-model="IdentificationFile.couple_name" type="text"></md-input>
                                <span class="md-helper-text">De no poseer dejarlo vacio</span>
                            </md-field>
                        </div>
                    </div>
                    <h6 class="text-rose">Información del responsable</h6>
                    <div class="md-layout">
                        <div class="md-layout-item md-small-size-100 md-size-50">
                            <md-field :class="getValidationClass('attendant_name',0)">
                                <label>Nombre</label>
                                <md-input name="attendant_name" id="attendant_name" v-model="IdentificationFile.attendant_name" type="text"></md-input>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.attendant_name.required">Este es un campo requerido</span>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.attendant_name.minLength">Ingrese un nombre valida</span>
                            </md-field>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-50">
                            <md-field :class="getValidationClass('attendant_address',0)">
                                <label>Dirección</label>
                                <md-input name="attendant_address" id="attendant_address" v-model="IdentificationFile.attendant_address" type="text"></md-input>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.attendant_address.required">Este es un campo requerido</span>
                            </md-field>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-50">
                            <md-field :class="getValidationClass('attendant_phone',0)">
                                <label>Teléfono</label>
                                <md-input name="attendant_phone" id="attendant_phone" v-model="IdentificationFile.attendant_phone" type="text"></md-input>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.attendant_phone.required">Este es un campo requerido</span>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.attendant_phone.phone">Debe cumplir el formato de teléfono salvadoreño</span>    
                            </md-field>
                        </div>
                    </div>
                    <h6 class="text-rose">Información del que brindo la información</h6>
                    <div class="md-layout">
                        <div class="md-layout-item md-small-size-100 md-size-50">
                            <md-field :class="getValidationClass('provided_information_name',0)">
                                <label>Nombre</label>
                                <md-input name="provided_information_name" id="provided_information_name" v-model="IdentificationFile.provided_information_name" type="text"></md-input>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.provided_information_name.required">Este es un campo requerido</span>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.provided_information_name.minLength">Ingrese un nombre valida</span>
                            </md-field>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-50">
                            <md-field :class="getValidationClass('provided_information_relationship',0)">
                                <label>Relación con el paciente</label>
                                <md-input name="provided_information_relationship" id="provided_information_relationship" v-model="IdentificationFile.provided_information_relationship" type="text"></md-input>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.provided_information_relationship.required">Este es un campo requerido</span>
                            </md-field>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-50">
                            <md-field :class="getValidationClass('provided_information_dui',0)">
                                <label>DUI</label>
                                <md-input name="provided_information_dui" id="provided_information_dui" v-model="IdentificationFile.provided_information_dui" type="text"></md-input>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.provided_information_dui.required">Este es un campo requerido</span>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.provided_information_dui.dui">Debe cumplir el formato de DUI</span>
                            </md-field>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-50">
                            <md-field>
                                <label>Nombre de la pareja</label>
                                <md-input name="couple_provided_information_name" id="couple_provided_information_name" v-model="IdentificationFile.couple_provided_information_name" type="text"></md-input>
                                <span class="md-helper-text">De no poseer dejarlo vacio</span>
                            </md-field>
                        </div>
                    </div>
                    <h6 class="text-rose">Otra información</h6>
                    <div class="md-layout">
                        <div class="md-layout-item md-small-size-100 md-size-50">
                            <md-field :class="getValidationClass('take_information_name',0)">
                                <label>Nombre del que tomo la información</label>
                                <md-input name="take_information_name" id="take_information_name" v-model="IdentificationFile.take_information_name" type="text"></md-input>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.take_information_name.required">Este es un campo requerido</span>
                                <span class="md-error text-danger" v-if="!$v.IdentificationFile.take_information_name.minLength">Ingrese un nombre valida</span>
                            </md-field>
                        </div>
                    </div>
                    <h2 class="text-rose">Información del Expediente</h2>
                    <div class="md-layout">
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.highrisk_pregnancy">Embarazo de alto riesgo</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-field :class="getValidationClass('location',1)">
                                <label>Ubicación</label>
                                <md-input name="location" id="location" v-model="FileData.location" type="text"></md-input>
                                <span class="md-error text-danger" v-if="!$v.FileData.location.required">Este es un campo requerido</span>
                            </md-field>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-field :class="getValidationClass('ethnic',1)">
                                <label>Etnia</label>
                                <md-input name="ethnic" id="ethnic" v-model="FileData.ethnic" type="text"></md-input>
                                <span class="md-error text-danger" v-if="!$v.FileData.ethnic.required">Este es un campo requerido</span>
                            </md-field>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.literate">Alfabetizado</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.studies">Cuenta con estudios</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.lonely">Soltero</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.tbc">Tuberculosis</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.diabetes">Diabetes</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.hipertension">Hipertensión</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.preeclamsia">Preeclampsia</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.eclampsia">Eclampsia</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-field :class="getValidationClass('other_illness',1)">
                                <label>Otras enfermedades</label>
                                <md-input name="other_illness" id="other_illness" v-model="FileData.other_illness" type="text"></md-input>
                                <span class="md-helper-text">Puede dejar el campo vacio</span>
                            </md-field>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.surgery">Cirugia Genito-Urinaria</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.infertility">Infertilidad</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.heart_disease">Problemas de corazón</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.nephropathy">Nefropatía</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.violence">Sufre violencia</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.VIH">VIH</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-datepicker name="end_of_last_pregnancy" id="end_of_last_pregnancy" :class="getValidationClass('end_of_last_pregnancy',1)" v-model="FileData.end_of_last_pregnancy" :md-disabled-dates="disabledDates" :md-override-native="false">
                                <label>Fecha del ultimo embarazo</label>
                                <span class="md-helper-text">De ser el primer embarazo dejar vacio</span>
                            </md-datepicker>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.planned_pregnancy">Embarazo planeado</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-field>
                                <label>Anticonceptivos</label>
                                <md-input name="contraceptives" id="contraceptives" v-model="FileData.contraceptives" type="text"></md-input>
                                <span class="md-helper-text">Puede dejar el campo vacio</span>
                            </md-field>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-field name="last_weight" id="last_weight" :class="getValidationClass('last_weight',1)">
                                <label>Peso</label>
                                <span class="md-prefix">LB</span>
                                <md-input v-model="FileData.last_weight" type="number"></md-input>
                                <span class="md-error text-danger" v-if="!$v.FileData.last_weight.required">Este es un campo requerido</span>
                                <span class="md-error text-danger" v-if="!$v.FileData.last_weight.minWeight">El peso no debe ser menor 0</span> 
                            </md-field>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-field name="size" id="size" :class="getValidationClass('size',1)">
                                <label>Tamaño</label>
                                <span class="md-prefix">cm</span>
                                <md-input v-model="FileData.size" type="number"></md-input>
                                <span class="md-error text-danger" v-if="!$v.FileData.size.required">Este es un campo requerido</span>
                                <span class="md-error text-danger" v-if="!$v.FileData.size.minSize">El tamaño no debe ser menor a 10 años</span> 
                            </md-field>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.antirubeola">Antirubeola</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.antitetanica">Antitetanica</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.actively_smoke">Fumador activo</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.passively_smoke">Fumador pasivo</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.use_drugs">Usa drogas</md-switch>
                        </div>
                        <div class="md-layout-item md-small-size-100 md-size-33">
                            <md-switch v-model="FileData.alcoholic">Alcoholico</md-switch>
                        </div>
                    </div>
                    <div class="md-layout-item md-size-100 text-right">
                        <md-button type="button" class="md-simple md-rose" @click="reset">Cancelar</md-button>
                        <md-button v-if="!editMode" type="submit" class="md-raised md-rose">Añadir Expediente</md-button>
                        <md-button v-if="editMode" type="submit" class="md-raised md-rose">Editar Expediente</md-button>
                    </div>
                </div>
            </md-card-content>
        </md-card>
    </form>
</template>
<script>
import { validationMixin } from "vuelidate";
    import { required, maxValue, minValue, minLength, helpers, email} from "vuelidate/lib/validators"
    import axios from "axios";
    // Helper's Validator
    const phone = helpers.regex('telefono', /^(7|6|2)[0-9]{3}( |-|)[0-9]{4}$/);
    const dui = helpers.regex('dui', /^[0-9]{8}-[0-9]{1}$/);
    // Event's Bus
    Bus = window.Bus;
    export default {
        props: ['idPatient'],
        // Mixins
        mixins: [validationMixin],
        // Data validations
        validations: {
            IdentificationFile: {
                age: {
                    required,
                    minAge: minValue(10)
                },
                occupation: {
                    required,
                    minLength: minLength(5)
                },
                father_name: {
                    required,
                    minLength: minLength(3)
                },
                mother_name: {
                    required,
                    minLength: minLength(3)
                },
                attendant_name: {
                    required,
                    minLength: minLength(3)
                },
                attendant_address: {
                    required
                },
                attendant_phone: {
                    required,
                    phone
                },
                provided_information_name: {
                    required,
                    minLength: minLength(3)
                },
                provided_information_relationship: {
                    required
                },
                provided_information_dui: {
                    required,
                    dui
                },
                take_information_name: {
                    required,
                    minLength: minLength(3)
                }
            },
            FileData: {
                location: {
                    required
                },
                ethnic: {
                    required
                },
                last_weight: {
                    required,
                    minWeight: minValue(0)
                },
                size: {
                    required,
                    minSize: minValue(0)
                }
            }
        },
        data() {
            return {
                //Modes
                editMode: false,
                // Data Errors
                showError: false,
                showMessageDialog: false,
                errorMessage: null,
                // Data Form
                disabledDates: date => {
                    let now = new Date();
                    return date >= now ? true : false;
                },
                IdentificationFile: {
                    gender: 1,
                    age: null,
                    marital_status: "Soltero/a",
                    occupation: null,
                    father_name: null,
                    mother_name: null,
                    couple_name: null,
                    attendant_name: null,
                    attendant_phone: null,
                    attendant_address: null,
                    provided_information_name: null,
                    provided_information_relationship: null,
                    provided_information_dui: null,
                    couple_provided_information_name: null,
                    take_information_name: null
                },
                FileData: {
                    highrisk_pregnancy: false,
                    location: null,
                    ethnic: null,
                    literate: false,
                    studies: false,
                    lonely: false,
                    tbc: false,
                    diabetes: false,
                    hipertension: false,
                    preeclamsia: false,
                    eclampsia: false,
                    other_illness: null,
                    surgery: false,
                    infertility: false,
                    heart_disease: false,
                    nephropathy: false,
                    violence: false,
                    VIH: false,
                    end_of_last_pregnancy: null,
                    planned_pregnancy: false,
                    contraceptives: null,
                    last_weight: null,
                    size: null,
                    antirubeola: false,
                    antitetanica: false,
                    actively_smoke: false,
                    passively_smoke: false,
                    use_drugs: false,
                    alcoholic: false
                }
            }
        },
        methods: {
            saveFile(){
                Bus.$emit('loading');
                axios.post('/dashboard/expediente/crear', {identificacion: this.IdentificationFile, datos: this.FileData, dui: this.$route.params.dui})
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
            reset() {
                this.IdentificationFile.gender = 1;
                this.IdentificationFile.age = null;
                this.IdentificationFile.marital_status = "Soltero/a";
                this.IdentificationFile.occupation = null;
                this.IdentificationFile.father_name = null;
                this.IdentificationFile.mother_name = null;
                this.IdentificationFile.couple_name = null;
                this.IdentificationFile.attendant_name = null;
                this.IdentificationFile.attendant_phone = null;
                this.IdentificationFile.attendant_address = null;
                this.IdentificationFile.provided_information_name = null;
                this.IdentificationFile.provided_information_relationship = null;
                this.IdentificationFile.provided_information_dui = null;
                this.IdentificationFile.couple_provided_information_name = null;
                this.IdentificationFile.take_information_name = null;
                this.FileData.highrisk_pregnancy = false;
                this.FileData.location = null;
                this.FileData.ethnic = null;
                this.FileData.literate = false;
                this.FileData.studies = false;
                this.FileData.lonely = false;
                this.FileData.tbc = false;
                this.FileData.diabetes = false;
                this.FileData.hipertension = false;
                this.FileData.preeclamsia = false;
                this.FileData.eclampsia = false;
                this.FileData.other_illness = null;
                this.FileData.surgery = false;
                this.FileData.infertility = false;
                this.FileData.heart_disease = false;
                this.FileData.nephropathy = false;
                this.FileData.violence = false;
                this.FileData.VIH = false;
                this.FileData.end_of_last_pregnancy = "0/0/0";
                this.FileData.planned_pregnancy = false;
                this.FileData.contraceptives = null;
                this.FileData.last_weight = null;
                this.FileData.size = null;
                this.FileData.antirubeola = false;
                this.FileData.antitetanica = false;
                this.FileData.actively_smoke = false;
                this.FileData.passively_smoke = false;
                this.FileData.use_drugs = false;
                this.FileData.alcoholic = false;
                this.$v.$reset();
            },
            // Validaciones
            getValidationClass(fieldName,tabla) {
                const field = (tabla == 0) ? this.$v.IdentificationFile[fieldName] : this.$v.FileData[fieldName];

                if (field) {
                    return {
                        "md-invalid": field.$invalid && field.$dirty
                    };
                }
            },
            validateFile() {
                this.$v.$touch();

                if (!this.$v.$invalid) {
                    this.saveFile();
                }else{
                    this.showError = true;
                    this.errorMessage = "Datos incorrectos, reviselos e intente de nuevo";
                }
            }
        },
        created() {
            let changeFast = response => {
                // console.log(this);

                this.IdentificationFile = response.data[0].identification_file;
                this.FileData = response.data[0].information_datum;
                this.editMode = true;
            }
            Bus.$on('searchFile', function(dui) {
                if(dui != null){
                    axios.post('/dashboard/expediente', {dui: dui})
                    .then(
                        response => {
                            changeFast(response);
                            // console.log(response.data[0].identification_file.gender);
                            // this.IdentificationFile.gender = 0;
                            // this.IdentificationFile.age = response.data[0].identification_file.age;
                            // this.IdentificationFile.marital_status = response.data[0].identification_file.marital_status;
                            // this.IdentificationFile.occupation = response.data[0].identification_file.occupation;
                            // this.IdentificationFile.father_name = response.data[0].identification_file.father_name;
                            // this.IdentificationFile.mother_name = response.data[0].identification_file.mother_name;
                            // this.IdentificationFile.couple_name = response.data[0].identification_file.couple_name;
                            // this.IdentificationFile.attendant_name = response.data[0].identification_file.attendant_name;
                            // this.IdentificationFile.attendant_phone = response.data[0].identification_file.attendant_phone;
                            // this.IdentificationFile.attendant_address = response.data[0].identification_file.attendant_address;
                            // this.IdentificationFile.provided_information_name = response.data[0].identification_file.provided_information_name;
                            // this.IdentificationFile.provided_information_relationship = response.data[0].identification_file.provided_information_relationship;
                            // this.IdentificationFile.provided_information_dui = response.data[0].identification_file.provided_information_dui;
                            // this.IdentificationFile.couple_provided_information_name = response.data[0].identification_file.couple_provided_information_name;
                            // this.IdentificationFile.take_information_name = response.data[0].identification_file.take_information_name;
                            // this.FileData.highrisk_pregnancy = response.data[0].information_datum.highrisk_pregnancy; 
                            // this.FileData.location = response.data[0].information_datum.location; 
                            // this.FileData.ethnic = response.data[0].information_datum.ethnic; 
                            // this.FileData.literate = response.data[0].information_datum.literate; 
                            // this.FileData.studies = response.data[0].information_datum.studies; 
                            // this.FileData.lonely = response.data[0].information_datum.lonely; 
                            // this.FileData.tbc = response.data[0].information_datum.tbc; 
                            // this.FileData.diabetes = response.data[0].information_datum.diabetes; 
                            // this.FileData.hipertension = response.data[0].information_datum.hipertension; 
                            // this.FileData.preeclamsia = response.data[0].information_datum.preeclamsia; 
                            // this.FileData.eclampsia = response.data[0].information_datum.eclampsia; 
                            // this.FileData.other_illness = response.data[0].information_datum.other_illness; 
                            // this.FileData.surgery = response.data[0].information_datum.surgery; 
                            // this.FileData.infertility = response.data[0].information_datum.infertility; 
                            // this.FileData.heart_disease = response.data[0].information_datum.heart_disease; 
                            // this.FileData.nephropathy = response.data[0].information_datum.nephropathy; 
                            // this.FileData.violence = response.data[0].information_datum.violence; 
                            // this.FileData.VIH = response.data[0].information_datum.VIH; 
                            // this.FileData.end_of_last_pregnancy = response.data[0].information_datum.end_of_last_pregnancy; 
                            // this.FileData.planned_pregnancy = response.data[0].information_datum.planned_pregnancy; 
                            // this.FileData.contraceptives = response.data[0].information_datum.contraceptives; 
                            // this.FileData.last_weight = response.data[0].information_datum.last_weight; 
                            // this.FileData.size = response.data[0].information_datum.size; 
                            // this.FileData.antirubeola = response.data[0].information_datum.antirubeola; 
                            // this.FileData.antitetanica = response.data[0].information_datum.antitetanica; 
                            // this.FileData.actively_smoke = response.data[0].information_datum.actively_smoke; 
                            // this.FileData.passively_smoke = response.data[0].information_datum.passively_smoke; 
                            // this.FileData.use_drugs = response.data[0].information_datum.use_drugs; 
                            // this.FileData.alcoholic = response.data[0].information_datum.alcoholic;
                        }
                    )
                }
            });
        }
        
    }
</script>

