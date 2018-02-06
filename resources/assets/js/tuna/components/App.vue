<template>
    <div class="tuna">
      <transition name="tuna-body" tag="div">
        <div class="tuna-body" v-if="state.isFetched">
          <Talk
            :timeline="state.timeline"
            :friend-id="state.friendId"
            :scroll-to-bottom="scrollToBottom"
          />
          <Message
            :friend-id="state.friendId"
            :input-text="state.inputText"
            :scroll-to-bottom="scrollToBottom"
            :oops="oops"
          />
          <p :class="['tuna-oops', {'is-active': oops}]">マグロは有限です</p>
        </div>
      </transition>

      <p @transitionend="handleTransitionend" v-if="!isAway" :class="['tuna-loading', {
        'is-fetching': state.isFetching,
        'is-fetched': state.isFetched,
        'is-hidden': isAway
      }]"><i class="fa fa-paper-plane" aria-hidden="true"></i></p>
    </div>
</template>

<script>
import SweetScroll from "sweet-scroll";
import Message from "./Message";
import Talk from "./Talk";
import store from "../store";

export default {
  components: { Talk, Message },
  data() {
    return {
      state: store.state,
      isAway: false
    };
  },
  computed: {
    oops() {
      return this.state.inputText && this.state.inputText.length > 255;
    }
  },
  mounted() {
    this.connectChannel();

    setTimeout(() => {
      store.fetchFriendId();
    }, 0);

    this.sweetScroll = new SweetScroll({
      duration: 700,
      easing: "easeOutCubic"
    });
  },
  methods: {
    connectChannel() {
      Echo.channel("tuna").listen("MessageRecieved", e => {
        store.recieveMessage(e.messages);
      });
    },
    handleTransitionend() {
      if (this.state.isFetched) {
        this.isAway = true;
      }
    },
    scrollToBottom() {
      setTimeout(() => {
        this.sweetScroll.to(document.getElementById("talk").clientHeight);
      }, 0);
    }
  }
};
</script>
