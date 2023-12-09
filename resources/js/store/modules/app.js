export const state = {
  responseStatus: false,
  responseMessages: [],
}

export const getters = {
  responseStatus: state => state.responseStatus,
  responseMessages: state => state.responseMessages,
}

export const mutations = {
  SET_RESPONSE_MESSAGE(state, {message, color, status = 'success'}) {
    if (status === 'success') {
      state.responseStatus = true;
    }

    state.responseMessages.push({
      show: true,
      icon: color === 'red' ? 'mdi-exclamation' : 'mdi-check',
      color: color,
      message: message,
      timeout: 5000,
    });

    setTimeout(() => {
      state.responseMessages = [];
    }, 10000);
  },
}

export const actions = {
  resetResponseStatus({state}) {
    console.log('test');
    state.responseStatus = false;
    console.log(state.responseStatus);
  }
}
