<template>
    <div>
        <div class="logo">
            <a href="" class="simple-text logo-normal">
            FemCenter
            </a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav" @click.stop="changePage">
                <li v-bind:class="{'nav-item': true, 'active': hasActive === 'Home'}">
                    <a class="nav-link" data-name="Home">
                        <i class="material-icons">dashboard</i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li :class="{'nav-item': true, 'active': hasActive === 'Usuarios'}">
                    <a class="nav-link" data-name="Usuarios">
                        <i class="material-icons">person</i>
                        <p>Usuarios</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            hasActive: 'Home'
        }
    },
    methods: {

        changePage: function(e){
            this.hasActive = e.target.dataset.name || e.target.parentElement.dataset.name || this.hasActive;
        }
    }
}
</script>

