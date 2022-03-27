<template>
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
                            @date-click="handleDateClick"
                            defaultView="month" :plugins="calendarPlugins"
                            :editable="false"
                            @event-selected="handleDateClick"
                            :events="events"
                            :header="header"
                        ></full-calendar>
                    </md-card-content>
                </md-card>
            </div>
        </div>
    </div>
</template>
<script>

import { Calendar } from 'dayspan';
import dayGridPlugin from "@fullcalendar/daygrid"
import axios from 'axios';
export default {
    
    data() {
        return {
            appointments: [],
            calendarPlugins: [ dayGridPlugin ],
            header: {
                left:   'prev, next today',
                center: 'title',
                right:  'month,agendaWeek'
            },
            events: [
                {
                    title  : 'event1',
                    start  : '2019-05-03',
                },
                {
                    title  : 'event2',
                    start  : '2019-05-05',
                    end    : '2019-05-08',
                },
                {
                    title  : 'event3',
                    start  : '2019-05-09T12:30:00',
                    allDay : false,
                },
            ]
        }
    },
    methods: {
        handleDateClick(arg) {
            console.log(arg.start.format("MM DD YY"));
        }
    },
    created() {
        axios.post('/dashboard/paciente/citas')
        .then(
            response => {
                this.appointments = response.data;
            }
        )
    }
}
</script>

