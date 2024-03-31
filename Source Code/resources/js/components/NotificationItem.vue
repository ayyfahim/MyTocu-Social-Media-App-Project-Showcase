<template>
  <a
    class="dropdown-item notification-item clearfix"
    v-if="unread.url || unread.data.url"
    :href="unread.url || unread.data.url"
  >
    <p
      class="d-inline-block m-0"
      :class="hasImage(unread) ? '' : 'w-100'"
      v-html="unread.message || unread.data.message"
    ></p>
    <span v-if="hasImage(unread)">
      <img :src="this.image" class="img-fluid" />
    </span>
  </a>
</template>

<script>
export default {
  props: ["unread"],
  data: function() {
    return {
      image: {}
    };
  },
  methods: {
    hasImage(notification) {
      if ("data" in notification) {
        if (notification.data.image) {
          this.image = notification.data.image;
          return true;
        } else {
          return false;
        }
      } else if (notification.image) {
        this.image = notification.image;
        return true;
      } else {
        return false;
      }
    }
  }
};
</script>
