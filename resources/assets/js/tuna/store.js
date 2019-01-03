import _ from "lodash";

const store = {
  state: {
    isFetching: false,
    isFetched: false,
    friendId: null,
    timeline: [],
    inputText: "今夜はマグロの寿司にしよう"
  },
  fetchFriendId() {
    this.setFetching();
    axios.post("/api/friend").then(res => {
      this.setFetched();
      this.setFriendId(res.data.friendId);
    });
  },
  setFetching() {
    this.state.isFetching = true;
  },
  setFetched() {
    this.state.isFetched = true;
  },
  setFriendId(friendId) {
    this.state.friendId = friendId;
  },
  setInputText(text) {
    this.state.inputText = text;
  },
  clearInputText() {
    this.state.inputText = "";
  },
  postMessage(text) {
    axios.post("/api/message", {
      friendId: this.state.friendId,
      text
    });
  },
  appendMessage(message) {
    this.state.timeline = [...this.state.timeline, message];
  },
  recieveMessage(messages) {
    this.state.timeline = [
      ...this.state.timeline,
      ...messages.filter(
        message =>
          parseInt(message.friendId, 10) !== parseInt(this.state.friendId, 10)
      )
    ];
  }
};

export default store;
