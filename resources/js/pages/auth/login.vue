<template>
  <v-container
    fill-height
    fluid
  >
    <v-row
      align="center"
      justify="center"
    >
      <v-col
        cols="12"
        lg="3"
        md="6"
        sm="7"
      >
        <v-card>
          <v-card-title>
            {{ $t('login') }}
          </v-card-title>
          <v-card-text>
            <v-form @keydown="form.onKeydown($event)" @submit.prevent="login">
              <v-text-field
                v-model="form.email"
                :label="$t('email')"
                name="email"
                outlined
                type="email"
              >
                <has-error :form="form" field="email"/>
              </v-text-field>

              <v-text-field
                v-model="form.password"
                :label="$t('password')"
                name="password"
                outlined
                type="password"
              >
                <has-error :form="form" field="password"/>
              </v-text-field>

              <v-btn
                block
                color="success"
                type="success"
              >
                Login
              </v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Form from 'vform'
import Cookies from 'js-cookie'
import LoginWithGithub from '~/components/LoginWithGithub'

export default {
  components: {
    LoginWithGithub
  },

  middleware: 'guest',

  metaInfo() {
    return {title: this.$t('login')}
  },

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    remember: false
  }),

  methods: {
    async login() {
      // Submit the form.
      const {data} = await this.form.post('/api/login')

      // Save the token.
      this.$store.dispatch('auth/saveToken', {
        token: data.token,
        remember: this.remember
      })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      // Redirect home.
      this.redirect()
    },

    redirect() {
      const intendedUrl = Cookies.get('intended_url')

      if (intendedUrl) {
        Cookies.remove('intended_url')
        this.$router.push({path: intendedUrl})
      } else {
        this.$router.push({name: 'home'})
      }
    }
  }
}
</script>
