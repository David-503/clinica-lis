<template>
  <md-toolbar md-elevation="0" class="md-transparent">
    <div class="md-toolbar-row">
      <div class="md-toolbar-section-start">
        <h3 class="md-title">{{ $route.name }}</h3>
      </div>
      <div class="md-toolbar-section-end">
        <md-button
          class="md-just-icon md-simple md-toolbar-toggle"
          :class="{ toggled: $sidebar.showSidebar }"
          @click="toggleSidebar"
        >
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </md-button>

        <div class="md-collapse">
          <div class="md-autocomplete">
            <md-autocomplete class="search" v-model="selectedEmployee" :md-options="employees">
              <label>Search...</label>
            </md-autocomplete>
          </div>
          <md-list>
            <md-list-item href="/dashboard">
              <i class="material-icons">dashboard</i>
              <p class="hidden-lg hidden-md">Dashboard</p>
            </md-list-item>

            <md-list-item href="#/notifications" class="dropdown">
              <drop-down>
                <a slot="title" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="material-icons">notifications</i>
                  <span class="notification">{{numNotification}}</span>
                  <p class="hidden-lg hidden-md">Notifications</p>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                  <li v-for="notification in notifications" v-bind:key="notification.id">
                    <a @click="visto(notification)">{{notification["message"]}}</a>
                  </li>
                </ul>
              </drop-down>
            </md-list-item>

            <md-list-item href="#/user">
              <i class="material-icons">person</i>
              <p class="hidden-lg hidden-md">Profile</p>
            </md-list-item>
          </md-list>
        </div>
      </div>
    </div>
  </md-toolbar>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      notifications: [],
      numNotification: 0,
      selectedEmployee: null,
      employees: [
        "Jim Halpert",
        "Dwight Schrute",
        "Michael Scott",
        "Pam Beesly",
        "Angela Martin",
        "Kelly Kapoor",
        "Ryan Howard",
        "Kevin Malone"
      ]
    };
  },
  methods: {
    toggleSidebar() {
      this.$sidebar.displaySidebar(!this.$sidebar.showSidebar);
    },
    visto(noti){
      axios.post("/dashboard/notificaciones/visto",{id:noti["id"]})
        .then(response => {
          this.created();
          console.log(response.data)
      })
    },
    created() {
      axios.post("/dashboard/notificaciones/listar")
        .then(response => {
          this.numNotification = 0;
          response.data.forEach(noti => {
            if(noti["status"]==1){
              this.numNotification++
            }
          });
          this.notifications = response.data;
        })
        .catch(error => {
          if (error.response.data) {
            this.$notify({
              message: error.response.data,
              timeout: 5000,
              icon: "error",
              horizontalAlign: "right",
              verticalAlign: "bottom",
              type: "danger"
            });
          } else if (error.request) {
            this.$notify({
              message: error.request,
              icon: "error",
              horizontalAlign: "right",
              verticalAlign: "bottom",
              timeout: 5000,
              type: "danger"
            });
          } else {
            this.$notify({
              message: error.message,
              icon: "error",
              horizontalAlign: "right",
              verticalAlign: "bottom",
              timeout: 100000,
              type: "danger"
            });
          }
        });
    }
  },
  mounted(){
    this.created();
  }
};
</script>

<style lang="css"></style>
