<template>
  <li class="nav-item dropdown d-none d-md-block">
    <a
      class="nav-link dropdown-toggle"
      href="#"
      id="notification_bell"
      role="button"
      data-toggle="dropdown"
      aria-haspopup="true"
      aria-expanded="false"
      :class="this.unreadNotifications.length > 0 ? 'has_notf' : ''"
      @click.prevent="markAsRead"
    >
      <i class="far fa-bell"></i>
    </a>
    <div
      class="dropdown-menu dropdown-menu-right notification-dropdown"
      aria-labelledby="notification_bell"
    >
      <div class="upper clearfix">
        <b>Notifications</b>
        <a href="/notifications" class="show-all">Show All</a>
      </div>
      <div class="notification-box">
        <notification-item v-for="unread in unreadNotifications" :unread="unread" :key="unread.id"></notification-item>
        <a class="dropdown-item notification-item clearfix" v-if="unreads.length < 1">
          <p class="d-inline-block m-0">
            <b>You have no unread notifications.</b>
          </p>
        </a>
      </div>
    </div>
  </li>
</template>

<script>
var types = ["notification.post"];
var post = types.includes("notification.post");

export default {
  props: ["unreads", "user"],

  methods: {
    markAsRead() {
      if (this.unreadNotifications.length) {
        $.get("/markasread");
        // this.fetchNotifications();
      }
    }
    // fetchNotifications() {
    //   axios.get("/notifications/all").then(response => {
    //     this.unreadNotifications = response;
    //   });
    // }
  },

  data: function() {
    return {
      unreadNotifications: this.unreads
    };
  },

  mounted() {
    Echo.private("App.User." + this.user).notification(notification => {
      this.unreadNotifications.unshift(notification);
      Toast.fire({
        icon: "success",
        title: notification.message,
        imageUrl: notification.image,
        imageHeight: 50,
        imageAlt: notification.type
      });
    });
  }
};
</script>
