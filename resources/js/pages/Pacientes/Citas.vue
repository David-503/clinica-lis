<template>
    <div>
        <md-dialog :md-active.sync="showDialog">
            <div style="padding: 1.5em;">
                <md-dialog-title>{{selectedAppointment.title}}</md-dialog-title>
                <div style="padding: .6em 3em;" class="md-subhead">{{selectedAppointment.start.calendar()}} - {{selectedAppointment.end.format('LT')}}</div>
            </div>

            <md-dialog-actions>
                <md-button class="md-primary" @click="showDialog = false">Cerrar</md-button>
            </md-dialog-actions>
        </md-dialog>
        <div class="content">
            <div class="md-layout">
                <div class="md-layout-item md-medium-size-100 md-size-100">
                    <md-card>
                        <md-card-header data-background-color="rose">
                            <h4 class="title">Mis citas</h4>
                            <p class="category">Observa las citas que tendrás en los próximos días</p>
                        </md-card-header>
                        <md-card-content>
                            <full-calendar 
                                defaultView="month" :plugins="calendarPlugins"
                                :editable="false"
                                @event-selected="showAppointment"
                                :events="events"
                                :header="header"
                            ></full-calendar>
                        </md-card-content>
                    </md-card>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import { Calendar } from 'dayspan';
import dayGridPlugin from "@fullcalendar/daygrid"
import axios from 'axios';
import Moment from 'moment';
export default {
    
    data() {
        return {
            showDialog: false,
            appointments: [],
            calendarPlugins: [ dayGridPlugin ],
            header: {
                left:   'prev, next today',
                center: 'title',
                right:  'month,agendaWeek'
            },
            events: [
            ],
            selectedAppointment: {
                title: null,
                code_medical_appointment: null,
                doctor: null,
                start: new Moment(),
                end: new Moment()
            }
        }
    },
    methods: {
        showAppointment(arg) {
            this.showDialog = true;
            this.selectedAppointment = arg;
        }
    },
    created() {
        axios.post('/dashboard/paciente/citas')
        .then(
            response => {
                this.appointments = response.data;
                [...this.appointments].forEach(appointment => {
                    let event= {
                        id: appointment.code_medical_appointment,
                        title: `Cita médica con el doctor: ${appointment.doctor.name}`,
                        start: `${appointment.appointment_date}T${appointment.initial_date}`,
                        end: `${appointment.appointment_date}T${appointment.finalization_date}`,
                        doctor: appointment.doctor,
                        code_medical_appointment: appointment.code_medical_appointment,
                        color: (appointment.status == 1) ? '#ff5252' : '#c8c8c8',
                        textColor: 'white'
                    };
                    this.events.push(event);
                });
            }
        )
    }
}
</script>
<style lang="scss">
    .fc-time-grid-event.fc-v-event.fc-event, .fc-day-grid-event.fc-h-event.fc-event{
        &:hover{
            cursor:pointer !important;
            color: white !important;
            box-shadow: 0 12px 20px -10px rgba(233, 30, 99, 0.28), 0 4px 20px 0px rgba(0, 0, 0, 0.12), 0 7px 8px -5px rgba(233, 30, 99, 0.2)!important;
        }
    }
</style>