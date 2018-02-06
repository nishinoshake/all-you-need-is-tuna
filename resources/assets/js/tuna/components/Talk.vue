<template>
  <div class="talk" id="talk">
      <div class="talk-inside">
          <div class="talk-list">
              <TalkItem
                v-for="(talk, index) in timeline"
                :key="index"
                :talk="talk"
                :friend-id="friendId"
                :scroll-to-bottom="scrollToBottom"
              />
          </div>
      </div>
      <p :class="['talk-empty', {'is-hidden': hasTimeline}]">All You Need Is Tuna</p>
  </div>
</template>

<script>
import store from "../store";
import TalkItem from "./TalkItem";

export default {
  components: { TalkItem },
  props: {
    timeline: Array,
    friendId: Number,
    scrollToBottom: Function
  },
  computed: {
    hasTimeline() {
      return this.timeline && this.timeline.length > 0;
    }
  }
};
</script>
