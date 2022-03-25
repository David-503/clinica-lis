<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-100">
        <edit-profile-form-Secretaria data-background-color="rose"> </edit-profile-form-Secretaria>
      </div>
    </div>
  </div>
</template>

<script>
import EditProfileFormSecretaria from "../../pages/UserProfile/EditProfileFormSecretaria.vue";
import  UserCard  from "../../pages/UserProfile/UserCard.vue";

export default {
  components: {
    EditProfileFormSecretaria,
    UserCard
  }
};
</script>