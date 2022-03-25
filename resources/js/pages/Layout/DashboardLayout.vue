<template>
<div class="wrapper" :class="{ 'nav-open': $sidebar.showSidebar }">
	<notifications></notifications>
    <div :class="{'d-none': !loadStatus}" class="loader">
        <md-progress-spinner class="md-accent" md-mode="indeterminate"></md-progress-spinner>
    </div>
	<side-bar>
        <mobile-menu slot="content"></mobile-menu>
        <li class="md-list-item" >
            <a :href="location" class="md-list-item-router md-list-item-container md-button-clean">
                <div class="md-list-item-content md-ripple">
                    <i class="md-icon md-icon-font md-theme-default">home</i> 
                    <p>Home</p>
                </div>
            </a>
        </li>
        <!-- Dropdown -->
        <md-list-item v-if="user.id_type_user == 1 || user.id_type_user == 4" class="dropdown-list" md-expand :md-expanded.sync="expand">
            <md-icon>person</md-icon>
            <p>Pacientes</p>

            <md-list slot="md-expand">
                <sidebar-link to="/dashboard/paciente/crear">
                    <md-icon>N</md-icon>
                    <p>Nuevo Paciente</p>
                </sidebar-link>
                <sidebar-link to="/dashboard/paciente">
                    <md-icon>L</md-icon>
                    <p>Listar Pacientes </p>
                </sidebar-link>
            </md-list>
        </md-list-item>

        <!-- Dropdown -->
        <md-list-item v-if="user.id_type_user == 1" class="dropdown-list" md-expand :md-expanded.sync="expandAppointment">
            <md-icon>calendar_today</md-icon>
            <p>Citas</p>

            <md-list slot="md-expand">
                <sidebar-link to="/dashboard/citas">
                    <md-icon>N</md-icon>
                    <p>Nueva Cita</p>
                </sidebar-link>
                <sidebar-link to="sjskj">
                    <md-icon>L</md-icon>
                    <p>Listar Citas </p>
                </sidebar-link>
            </md-list>
        </md-list-item>
        <sidebar-link v-if="user.id_type_user == 5" to="/dashboard/paciente/citas">
            <md-icon>calendar_today</md-icon>
            <p>Calendario</p>
        </sidebar-link>
        <sidebar-link v-if="user.id_type_user == 2" to="/dashboard/doctor/citas">
            <md-icon>calendar_today</md-icon>
            <p>Calendario</p>
        </sidebar-link>
        <sidebar-link v-if="user.id_type_user == 2" to="/dashboard/consultas">
            <md-icon>chrome_reader_mode</md-icon>
            <p>Realizar Consulta</p>
        </sidebar-link>
                        <!-- Dropdown -->
        <md-list-item v-if="user.id_type_user == 1" class="dropdown-list" md-expand :md-expanded.sync="expandDoctor">
            <md-icon>healing</md-icon>
            <p>Doctores</p>

            <md-list slot="md-expand">
                <sidebar-link to="/dashboard/doctor/crear">
                    <md-icon>I</md-icon>
                    <p>Ingresar Doctor</p>
                </sidebar-link>
                <sidebar-link to="/dashboard/doctor">
                    <md-icon>L</md-icon>
                    <p>Listar Doctores </p>
                </sidebar-link>
            </md-list>
        </md-list-item>
                                <!-- Dropdown -->
        <md-list-item v-if="user.id_type_user == 1" class="dropdown-list" md-expand :md-expanded.sync="expandSecretaria">
            <md-icon>business</md-icon>
            <p>Secretaria</p>

            <md-list slot="md-expand">
                <sidebar-link to="/dashboard/secretaria/crear">
                    <md-icon>I</md-icon>
                    <p>Ingresar Secretaria</p>
                </sidebar-link>
                <sidebar-link to="/dashboard/secretaria">
                    <md-icon>L</md-icon>
                    <p>Listar Secretarias </p>
                </sidebar-link>
            </md-list>
        </md-list-item>
                                <!-- Dropdown -->
        <md-list-item v-if="user.id_type_user == 1" class="dropdown-list" md-expand :md-expanded.sync="expandPromotor">
            <md-icon>assignment_ind</md-icon>
            <p>Promotor</p>

            <md-list slot="md-expand">
                <sidebar-link to="/dashboard/promotor/crear">
                    <md-icon>I</md-icon>
                    <p>Ingresar Promotor</p>
                </sidebar-link>
                <sidebar-link to="/dashboard/promotor">
                    <md-icon>L</md-icon>
                    <p>Listar Promotores </p>
                </sidebar-link>
            </md-list>
        </md-list-item>
        <!-- <sidebar-link to="#">
        </sidebar-link> -->
        <!-- <sidebar-link to="/table">
            <md-icon>content_paste</md-icon>
            <p>Table list</p>
        </sidebar-link>
        <sidebar-link to="/typography">
            <md-icon>library_books</md-icon>
            <p>Typography</p>
        </sidebar-link>
        <sidebar-link to="/icons">
            <md-icon>bubble_chart</md-icon>
            <p>Icons</p>
        </sidebar-link>
        <sidebar-link to="/maps">
            <md-icon>location_on</md-icon>
            <p>Maps</p>
        </sidebar-link>
        <sidebar-link to="/notifications">
            <md-icon>notifications</md-icon>
            <p>Notifications</p>
        </sidebar-link>
        <sidebar-link to="/upgrade" class="active-pro">
            <md-icon>unarchive</md-icon>
            <p>Upgrade to PRO</p>
        </sidebar-link> -->
	</side-bar>

	<div class="main-panel">
	<top-navbar></top-navbar>

	<dashboard-content> </dashboard-content>

	<content-footer v-if="!$route.meta.hideFooter"></content-footer>
	</div>
</div>
</template>
<script>
import TopNavbar from "./TopNavbar.vue";
import ContentFooter from "./ContentFooter.vue";
import DashboardContent from "./Content.vue";
import MobileMenu from "./MobileMenu.vue";
import axios from 'axios';
import Vue from "vue";
window.Bus = new Vue;
export default {
components: {
	TopNavbar,
	DashboardContent,
	ContentFooter,
	MobileMenu
},
data() {
	return {
        expand: false,
        location: window.location.origin,
        expandAppointment: false,
        expandDoctor:false,
        expandSecretaria:false,
        expandPromotor:false,
        user: {
            id_type_user: null
        },
        loadStatus: false
	}
},
methods: {
    onLoader(){
        this.loadStatus = true;
    },
    offLoader(){
        this.loadStatus = false;
    }
},
created() {
    let Auth = sessionStorage.getItem('Auth');
    if(Auth === undefined || Auth === null){
        axios.post('/dashboard/auth')
        .then(
            response =>{
                sessionStorage.setItem('Auth', JSON.stringify(response.data));
                this.user = response.data;
                Auth = response.data;
            }
        )
    }else {
        Auth = JSON.parse(Auth);
        this.user = Auth;
    }
    Bus.$on('loading', () => {
        this.onLoader();
    });
    Bus.$on('stopLoading', () => {
        this.offLoader();
    });
}
};
</script>
<style lang="scss">
$list-width: 320px;
.loader{
    position: fixed;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    z-index: 1000;
    align-items: center;
    background-color: rgba(249, 250, 251, 0.4);
}
.d-none{
    display: none;
}
.dropdown-list > div {
    overflow: visible;
    border-radius: 3px !important;
}
.dropdown-list{
    overflow: visible;
    margin-top: 10px;
    margin-left: 15px;
    margin-right: 15px;
    border-radius: 3px !important;
    color: white;
    p{
        color: white !important;
    }
    i.md-icon.md-list-expand-icon{
        margin-left: auto !important;
        color: white !important;
        svg{
            fill: #fff !important;
        }
    }
}
.full-control {
	display: flex;
	flex-direction: row;
	flex-wrap: wrap-reverse;
}

.list {
	width: $list-width;
}

.full-control > .md-list {
	width: $list-width;
	max-width: 100%;
	height: 400px;
	display: inline-block;
	overflow: auto;
	border: 1px solid rgba(#000, .12);
	vertical-align: top;
}

.control {
	min-width: 250px;
	display: flex;
	flex-direction: column;
	padding: 16px;
}
.background-success{
    margin-top: 1px !important;
    background: linear-gradient(87deg,#2dce89 0,#2dcecc 100%)!important;
    transform: translate(-50%,-51%) !important;

}
</style>