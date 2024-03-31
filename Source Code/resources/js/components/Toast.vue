<template>
  <div style="
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 99999;
    ">
    <div
      class="toast"
      role="alert"
      aria-live="assertive"
      aria-atomic="true"
      data-autohide="false"
      v-for="unread in newNotifications"
      :key="unread.id"
      :class="unread.data != null ? 'show' : ''"
    >
      <div class="toast-header">
        <img
          :src="'/userimage/'+unread.data.user.user_image"
          width="40"
          height="40"
          class="rounded mr-2"
        />
        <strong class="mr-auto">{{unread.data.user.name}}</strong>
        <button type="button" class="ml-2 mb-1 close" @click="closeToast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="toast-body">
        <notification-item :unread="unread"></notification-item>
      </div>
    </div>
  </div>
</template>
<script>
import NotificationItem from "./NotificationItem.vue";

export default {
  props: ["userid"],
  components: {
    "notification-item": NotificationItem
  },
  methods: {
    myToast() {
      $("#myToast").toast("show");
    },
    closeToast() {
      var element = event.target.parentNode.parentNode.parentNode;
      $(element).toast("hide");
    }
  },
  data() {
    return {
      newNotifications: []
    };
  },
  mounted() {
    Echo.private("App.User." + this.userid).notification(notification => {
      let newUnreadNotifications = {
        data: {
          post: notification.post,
          journal: notification.journal,
          post_comment: notification.post_comment,
          journal_comment: notification.journal_comment,
          frequest: notification.frequest,
          frequest_sent: notification.frequest_sent,
          post_create: notification.post_create,
          post_update: notification.post_update,
          journal_create: notification.journal_create,
          journal_update: notification.journal_update,
          list_like: notification.list_like,
          list_comment: notification.list_comment,
          user: notification.user
        }
      };
      this.newNotifications.push(newUnreadNotifications);
    });
  }
};
</script>
