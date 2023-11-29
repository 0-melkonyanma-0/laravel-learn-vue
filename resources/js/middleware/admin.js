export default (to, from, next) => {
  if (!Permissions.includes('index users')) {
    next({ name: 'home' })
  } else {
    next()
  }
}
