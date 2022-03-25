<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-100">
        <edit-profile-form-Promotor data-background-color="rose"> </edit-profile-form-Promotor>
      </div>
    </div>
  </div>
</template>

<script>
import EditProfileFormPromotor from "../../pages/UserProfile/EditProfileFormPromotor.vue";
import  UserCard  from "../../pages/UserProfile/UserCard.vue";

export default {
  components: {
    EditProfileFormPromotor,
    UserCard
  }
};
</script>