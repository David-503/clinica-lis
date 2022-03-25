<template>
  <ul class="nav nav-mobile-menu md-list">
    <li>
      <md-field>
        <label>Search</label>
        <md-input v-model="search" type="text"></md-input>
      </md-field>
    </li>
    <li class="md-list-item">
      <router-link class="md-list-item-router md-list-item-container md-button-clean" tag="a" to="/dashboard" exact-active-class="nav-item active">
          <i class="material-icons">dashboard</i>
          <p>Dashboard</p>
      </router-link>

    </li>
    <li>
      <drop-down>
        <a slot="title" class="dropdown-toggle" data-toggle="dropdown">
          <i class="material-icons">notifications</i>
          <span class="notification">{{numNotification}}</span>
          <p>Notifications</p>
        </a>
        <ul class="dropdown-menu dropdown-menu-right">
          <li v-for="notification in notifications" v-bind:key="notification.id">
            <a @click="visto(notification)">{{notification["message"]}}</a>
          </li>
        </ul>
      </drop-down>
    </li>
    <li>
      <a href="#" data-toggle="dropdown" class="dropdown-toggle"
        ><i class="material-icons">person</i>
        <p>Profile</p></a
      >
    </li>
  </ul>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      notifications: [],
      numNotification: 0,
      search: null,
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
