<template>
    <div class="content">
        <div class="md-layout">
            <div class="md-layout-item md-medium-size-100 md-size-100">
                <File :idPatient="null"></File>
            </div>
        </div>
  </div>
</template>
<script>
    import File from './File.vue';
    export default {
        components: {
            File
        },
        data() {
            return {

            }
        }
    }
</script>
