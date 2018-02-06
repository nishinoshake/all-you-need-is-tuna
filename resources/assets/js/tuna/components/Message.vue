<template>
  <div :class="['message', {'is-focused': isCovertIOS, 'is-iOS': isIOS}]">
      <div class="message-inside">
          <div class="message-box">
              <textarea
                :value="inputText"
                @keydown="e => handleKeydown(e)"
                @keypress.enter="e => handlePressEnter(e)"
                @input="e => handleInput(e)"
                @keyup="e => handleKeyup(e)"
                @focus="e => handleFocus(e)"
                @blur="e => handleBlur(e)"
                name="message-input"
                placeholder="Your message..."
                ref="textarea"
                class="message-input"
              ></textarea>
          </div>
          <button type="button" @click="send" :class="['message-send', {
            'is-active': canSend,
            'i-can-fly': iCanFly
          }]" >
            <i class="fa fa-paper-plane" aria-hidden="true"></i>
          </button>
      </div>
  </div>
</template>

<script>
import store from "../store";

export default {
  props: {
    friendId: Number,
    inputText: String,
    oops: Boolean,
    scrollToBottom: Function
  },
  data() {
    return {
      skipInput: false,
      iCanFly: false,
      pressedKey: {
        Alt: false,
        Meta: false,
        Shift: false
      },
      onShift: false,
      isFocused: false,
      isIOS: false,
      isCovertIOS: false
    };
  },
  computed: {
    canSend() {
      return this.inputText && this.inputText.length > 0 && !this.oops;
    }
  },
  mounted() {
    this.isIOS = /iP(hone|(o|a)d)/.test(navigator.userAgent);
    setTimeout(() => (this.iCanFly = true), 1600);
  },
  methods: {
    handleInput(e) {
      if (this.skipInput) {
        this.skipInput = false;
        return false;
      }

      if (e.target.value.length > 0) {
        this.isCovertIOS = true;
      }

      store.setInputText(e.target.value);
    },
    handleKeydown(e) {
      this.setPressedKey(e.key);
    },
    handlePressEnter(e) {
      if (this.pressedKey.Shift || this.pressedKey.Meta) {
        //
      } else if (this.pressedKey.Alt) {
        store.setInputText(`${this.inputText}\n`);
      } else {
        this.send();
      }

      this.skipInput = true;
      this.clearPressedKey();
    },
    handleKeyup(e) {
      this.clearPressedKey(e.key);
    },
    send() {
      const text = this.inputText.trim().replace(/\n$/, "");

      if (this.canSend && text) {
        store.clearInputText();
        store.appendMessage({
          friendId: this.friendId,
          messages: [
            {
              type: "text",
              body: text
            }
          ]
        });
        store.postMessage(text);
      }
    },
    setPressedKey(key) {
      if (this.pressedKey.hasOwnProperty(key)) {
        this.pressedKey[key] = true;
      }
    },
    clearPressedKey(key) {
      if (this.pressedKey.hasOwnProperty(key)) {
        this.pressedKey[key] = false;
      }
    },
    handleFocus() {
      this.isFocused = true;
    },
    handleBlur() {
      this.isFocused = false;
      this.isCovertIOS = false;

      this.scrollToBottom();
    }
  }
};
</script>
