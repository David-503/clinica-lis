<template>
    <div class="content">
        <div class="md-layout">
            <div class="md-layout-item md-medium-size-100 md-size-100">
                 <md-card>
                    <md-card-header data-background-color="rose">
                        <h4 class="title">Lista de Pacientes</h4>
                        <p class="category">Administra los datos de los pacientes desde acá</p>
                    </md-card-header>
                    <md-card-content>
                        <md-table class="visible" v-model="searched" md-sort="name" md-sort-order="asc">
                            <md-table-toolbar>
                                <div class="md-toolbar-section-start">
                                </div>

                                <md-field md-clearable class="md-toolbar-section-end">
                                    <md-input placeholder="Buscar por nombre..." v-model="search" @input="searchOnTable" />
                                </md-field>
                            </md-table-toolbar>

                            <md-table-empty-state
                                md-label="No hay Pacientes"
                                :md-description="`No se han encontrado resultados con la búsqueda: '${search}'. Intentalo de nuevo con una diferente manera.`">
                                <md-button class="md-primary md-raised" @click="$router.push('/dashboard/paciente/crear')">Crear nueva Paciente</md-button>
                            </md-table-empty-state>
                            <md-table-row slot="md-table-row" slot-scope="{ item }">
                                <md-table-cell md-label="DUI" md-sort-by="dui">{{ item.dui }}</md-table-cell>
                                <md-table-cell md-label="Nombre completo" md-sort-by="name">{{ item.name }} {{item.lastname}}</md-table-cell>
                                <md-table-cell md-label="Email" md-sort-by="email">{{ item.email }}</md-table-cell>
                                <md-table-cell md-label="Edad" md-sort-by="birthdate">{{ item.birthdate | age }}</md-table-cell>
                                <md-table-cell md-label="Telefono" >{{ getPhone(item.phones) }}</md-table-cell>
                                <md-table-cell class="flex-center" md-label="Acciones" >
                                    <drop-down>
                                        <a slot="title" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="material-icons">drag_indicator</i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a class="md-warning-hover" @click.prevent="editPatient(item)"><md-icon>edit</md-icon> Editar</a></li>
                                            <li><a class="md-danger-hover" @click.prevent="deletePatient(item)"><md-icon>delete</md-icon> Borrar</a></li>
                                        </ul>
                                    </drop-down>
                                </md-table-cell>
                            </md-table-row>
                        </md-table>
                    </md-card-content>
                </md-card>
                
            </div>
        </div>
    </div>
</template>
<script>


    // Global Constant's
    const Bus = window.Bus;
    // Global Component Functions
    const toLower = text => {
        return text.toString().toLowerCase()
    }

    const searchByName = (items, term) => {
        if (term) {
            return items.filter(item => toLower(item.name).includes(toLower(term)))
        }

        return items
    }

    import axios from "axios";
    import Paciente from "./Paciente.vue";
    export default {
        components: {
            Paciente
        },
        data() {
            return {
                // Data for functional table
                search: null,
                searched: [],
                patients: [],
                // Data Form
                patient: {
                    dui: null,
                    name: null,
                    lastname: null,
                    email: null,
                    address: null,
                    password: null,
                    birthdate: null,
                    phone: null
                }
            }
        },
        methods: {
            // Get Data
            searchOnTable () {
                this.searched = searchByName(this.patients, this.search)
            },
            getPhone(phones){
                let strPhones = "";
                if(phones.length == 0) return "Sin teléfono";
                [...phones].forEach(phone => {
                    strPhones += phone.phone;
                });
                return strPhones;
            },
            // Action's Method
            editPatient(patient){
                Bus.$emit('loading');
                this.$router.push(`/dashboard/paciente/edit/${patient.dui}`);
            },
            deletePatient(patient){
                Bus.$emit('loading');
                axios.delete(`/dashboard/paciente/${patient.dui}`)
                .then(
                    response => {
                        Bus.$emit('stopLoading');
                        this.$notify(
                        {
                            message: response.data,
                            icon: 'check',
                            horizontalAlign: 'right',
                            verticalAlign: 'top',
                            timeout: 5000,
                            type: 'success'
                        });
                    }
                )
            }
        },
        created () {
            Bus.$emit('loading');
            axios.post('/dashboard/paciente')
            .then(
                response => {
                    Bus.$emit('stopLoading');
                    this.patients = response.data;
                    this.searched = this.patients;
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
        }
    }
</script>
<style lang="scss">
    .visible{
        table{
            overflow-y: visible !important;
        }
    }
    .dropdown{
        .dropdown-toggle{
            cursor: pointer !important;
            color: #894F84 !important;
        }
        .dropdown-menu.dropdown-menu-right{
            li{
                a{
                    display: flex !important;
                    align-items: center;
                    justify-content: flex-start;
                    i{
                        font-size: 1.4em !important;
                        margin: 0 1em 0 .5em;
                    }
                }
            }
        }
        .dropdown-menu {
            .md-warning-hover{
                &:hover{
                    background-color: #ff9800!important;
                    i{
                        color: white !important;
                    }
                }
            }
            .md-danger-hover{
                &:hover{
                    background-color: #f44336!important;
                    i{
                        color: white !important;
                    }
                }
            }
        }
    }
    .md-speed-dial.md-theme-default{
        position: relative !important;
        & > button{
            background-color: var(--md-theme-default-accent) !important; 
            display: flex !important;
            justify-content: center;
            align-items: center;
        }
        .md-speed-dial-content{
            position: absolute !important;
            top: 100%;
            button{
                width: 40px;
                height: 40px;
                border-radius: 50%;
            }
        }
    }
    
    .md-table-sortable-icon{
        left: auto !important;
        right: 0 !important;
    }
    .d-none{
        display: none !important;
    }
    .md-table-content{
        height: auto !important;
        min-height: 20px;
    }
    .md-title{
        line-height: 25px;
    }
    .md-invalid label{
        color: #ff1744 !important;
    }
    .md-toolbar{
        padding: 1em 0.5em !important;
    }
    .ml-auto {
        margin-left: auto !important;
    }
    .flex-center{
        display: flex;
        justify-content: center;
    }
</style>
