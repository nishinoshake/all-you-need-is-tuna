<template>
  <div class="talk-item">
    <p class="talk-icon">{{ name[0] }}</p>
    <div class="talk-body">
      <p class="talk-name">{{ name }}</p>
      <div class="talk-detail-list">
        <div
          :class="['talk-detail-item', {'mod-tuna': isTuna}]"
          v-for="(message, index) in talk.messages"
          :key="index"
        >
          <p class="talk-text" v-if="message.type === 'text'">
            <span v-for="(line, index) in message.body.split('\n')" :key="index">{{line}}</span>
          </p>
          <p class="talk-image" v-if="message.type == 'image'" >
            <img :src="message.body" />
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    talk: Object,
    friendId: Number,
    scrollToBottom: Function
  },
  computed: {
    isMe() {
      return this.friendId === this.talk.friendId;
    },
    isTuna() {
      return this.name === "Tuna";
    },
    name() {
      if (this.talk.name && this.talk.friendId !== this.friendId) {
        return this.talk.name;
      } else {
        return "You";
      }
    }
  },
  mounted() {
    this.scrollToBottom();
  }
};
</script>
