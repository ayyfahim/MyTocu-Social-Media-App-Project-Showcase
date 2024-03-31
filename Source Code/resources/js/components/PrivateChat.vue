<template>
  <div class="messaging">
    <div class="inbox_msg bg-white">
      <div class="inbox_people">
        <div class="headind_srch">
          <div class="recent_heading">
            <h4>Recent</h4>
          </div>
        </div>
        <div class="inbox_chat">
          <div
            v-for="friend in friends"
            :key="friend.id"
            @click="setActiveUser=friend.id, hasSeen"
            :class="(friend.id==setActiveUser)?'active_chat':''"
            class="chat_list"
            style="cursor: pointer;"
          >
            <div class="chat_people">
              <div
                class="chat_img"
                :class="(onlineUsers.find(user=>user.id===friend.id))?'active':'lol'"
              >
                <img :src="'/userimage/'+friend.user_image" />
              </div>
              <div class="chat_ib">
                <h5>{{friend.name}}</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="mesgs">
        <div class="msg_history" id="messagebox" v-chat-scroll>
          <span
            v-if="allMessages.length < 1"
            style="display: block;
                  color: rgb(0, 0, 0);
                  padding: 10px;
                  width: 180px;
                  text-align: center;
                  border-radius: 2em;
                  font-style: italic;
                  font-weight: 300;
                  margin-left: auto;"
          >No messages found.</span>
          <div v-for="(message, index) in allMessages" :key="index">
            <template v-if="user.id !== message.user.id">
              <div class="incoming_msg" style="margin: 26px 0 26px;">
                <div class="incoming_msg_img">
                  <img :src="'/userimage/'+message.user.user_image" />
                </div>
                <div class="received_msg">
                  <div class="received_withd_msg">
                    <p v-if="message.message">{{ message.message }}</p>
                    <a :href="'/chat-image/'+message.image">
                      <img
                        v-if="message.image"
                        class="img-fluid"
                        width="200"
                        :src="'/chat-image/'+message.image"
                      />
                    </a>
                    <span
                      class="time_date"
                    >{{ message.created_at | moment("dddd") }} , {{ message.created_at | moment("MMMM Do") }}</span>
                  </div>
                </div>
              </div>
            </template>
            <template v-if="user.id == message.user.id">
              <div class="outgoing_msg">
                <div class="sent_msg">
                  <p v-if="message.message">{{ message.message }}</p>
                  <a :href="'/chat-image/'+message.image">
                    <img
                      v-if="message.image"
                      class="img-fluid"
                      width="200"
                      :src="'/chat-image/'+message.image"
                    />
                  </a>
                  <span
                    class="time_date"
                  >{{ message.created_at | moment("dddd") }} , {{ message.created_at | moment("MMMM Do") }}</span>
                </div>
              </div>
            </template>
          </div>
          <span
            v-if="typingUser.name"
            style="margin: 10px 0; display: block; background-color: grey; color: #fff; padding: 10px; width: 150px; text-align: center; border-radius: 2em;"
          >Typing...</span>
        </div>
        <div class="type_msg">
          <div class="input_msg_write row">
            <input
              v-model="message"
              single-line
              @keydown="onTyping"
              @keyup.enter="sendMessage"
              type="text"
              class="write_msg col-md-9 col-sm-8 col-8"
              placeholder="Type a message"
            />
            <div class="input-button col-md-3 col-sm-4 col-4">
              <file-upload
                :post-action="'private_messages/'+setActiveUser"
                ref="upload"
                v-model="files"
                @input-file="$refs.upload.active = true"
                :headers="{'X-CSRF-TOKEN': token}"
              >
                <i class="fas fa-paperclip"></i>
              </file-upload>
              <button @click="sendMessage" class="msg_send_btn p-0" type="button">
                <i style="line-height: 33px; text-align: center;" class="far fa-paper-plane"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["user", "setActiveUser"],
  data() {
    return {
      message: null,
      files: [],
      // setActiveUser: null,
      typingUser: {},
      typingClock: {},
      allMessages: [],
      onlineUsers: [],
      users: [],
      token: document.head.querySelector('meta[name="csrf-token"]').content
    };
  },

  computed: {
    friends() {
      return this.users.filter(user => {
        return user.id !== this.user.id;
      });
    }
  },

  watch: {
    files: {
      deep: true,
      handler() {
        let success = this.files[0].success;
        if (success) {
          this.fetchMessages();
        }
      }
    },
    setActiveUser(val) {
      this.fetchMessages();
    }
  },

  methods: {
    onTyping() {
      Echo.private("pchannel." + this.setActiveUser).whisper("typing", {
        user: this.user
      });
    },
    sendMessage() {
      //check if there message
      if (!this.message) {
        return alert("Please enter message.");
      }

      if (!this.setActiveUser) {
        return alert("Please Select a user.");
      }
      axios
        .post("private_messages/" + this.setActiveUser, {
          message: this.message
        })
        .then(response => {
          this.message = null;
          this.fetchMessages();
          setTimeout(this.scrollToEnd, 100);
        });
    },
    fetchMessages() {
      axios.get("/private_messages/" + this.setActiveUser).then(response => {
        this.allMessages = response.data;
        this.hasSeen();
        setTimeout(this.scrollToEnd, 100);
      });
    },

    // hasSeen: () => {
    //   axios
    //     .post("/set_seen/" + this.setActiveUser)
    //     .then(response => {})
    //     .catch(response => {
    //       console.log(response);
    //     });
    // },

    hasSeen() {
      axios.post("/set_seen/" + this.setActiveUser).then(response => {});
    },

    fetchUsers() {
      axios.get("/users_list").then(response => {
        this.users = response.data;
        if (!this.setActiveUser) {
          if (this.friends.length > 0) {
            this.setActiveUser = this.friends[0].id;
          }
        }
      });
    },
    scrollToEnd() {
      document.getElementById("messagebox").scrollTo(0, 99999);
    },
    onResponse(e) {
      console.log("onResponse file up", e);
    }
  },
  mounted() {},
  created() {
    this.fetchUsers();

    Echo.join("online_user")
      .here(users => {
        // console.log("online", users);
        this.onlineUsers = users;
      })
      .joining(user => {
        this.onlineUsers.push(user);
        // console.log("joining", user.name);
      })
      .leaving(user => {
        this.onlineUsers.splice(this.onlineUsers.indexOf(user), 1);
        // console.log("leaving", user.name);
      });

    Echo.private("pchannel." + this.user.id)
      .listen("PrivateMessageSent", e => {
        this.setActiveUser = e.message.user.id;
        this.allMessages.push(e.message);
        setTimeout(this.scrollToEnd, 100);
      })
      .listenForWhisper("typing", e => {
        if (e.user.id == this.setActiveUser) {
          this.typingUser = e.user;

          if (this.typingClock) clearTimeout();
          this.typingClock = setTimeout(() => {
            this.typingUser = {};
          }, 9000);
        }
      });
  }
};
</script>


<style>
.chat_img {
  position: relative;
}

.chat_img::after {
  position: absolute;
  content: "";
  bottom: 0px;
  right: -4px;
  background: grey;
  width: 8px;
  height: 8px;
  border-radius: 50%;
}

.chat_img.active::after {
  background: #00de00 !important;
}
</style>
