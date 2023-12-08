const DEFAULT_MESSAGE = {
  show: false,
  icon: 'mdi-check',
  color: '',
  message: '',
  timeout: 5000,
}

export const state = {
  responseStatus: false,
  responseMessage: {
    ...DEFAULT_MESSAGE
  },
}

export const getters = {
  responseStatus: state => state.responseStatus,
  responseMessage: state => state.responseMessage,
}

export const mutations = {
  SET_RESPONSE_MESSAGE(state, {message, color ,status = 'success'}) {
    if(status === 'success') {
      state.responseStatus = true;
    }

    state.responseMessage = {
      show: true,
      icon: color === 'red' ? 'mdi-exclamation' : state.responseMessage.icon,
      color: color,
      message: message,
      timeout: 5000,
    }

    setTimeout(() => {
      state.responseMessage = DEFAULT_MESSAGE;
      state.responseStatus = false;
    }, 5000);
  },
}
