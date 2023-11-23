<template>
  <!--      <card :title="$t('login')">-->
  <!--        <form @keydown="form.onKeydown($event)" @submit.prevent="login">-->
  <!--          &lt;!&ndash; Email &ndash;&gt;-->
  <!--          <div class="mb-3 row">-->
  <!--            <label class="col-md-3 col-form-label text-md-end">{{ $t('email') }}</label>-->
  <!--            <div class="col-md-7">-->
  <!--              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control"-->
  <!--                     name="email" type="email">-->
  <!--              <has-error :form="form" field="email"/>-->
  <!--            </div>-->
  <!--          </div>-->

  <!--          &lt;!&ndash; Password &ndash;&gt;-->
  <!--          <div class="mb-3 row">-->
  <!--            <label class="col-md-3 col-form-label text-md-end">{{ $t('password') }}</label>-->
  <!--            <div class="col-md-7">-->
  <!--              <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control"-->
  <!--                     name="password" type="password">-->
  <!--              <has-error :form="form" field="password"/>-->
  <!--            </div>-->
  <!--          </div>-->

  <!--          &lt;!&ndash; Remember Me &ndash;&gt;-->
  <!--          <div class="mb-3 row">-->
  <!--            <div class="col-md-3"/>-->
  <!--            <div class="col-md-7 d-flex">-->
  <!--              <checkbox v-model="remember" name="remember">-->
  <!--                {{ $t('remember_me') }}-->
  <!--              </checkbox>-->

  <!--              <router-link :to="{ name: 'password.request' }" class="small ms-auto my-auto">-->
  <!--                {{ $t('forgot_password') }}-->
  <!--              </router-link>-->
  <!--            </div>-->
  <!--          </div>-->

  <!--          <div class="mb-3 row">-->
  <!--            <div class="col-md-7 offset-md-3 d-flex">-->
  <!--              &lt;!&ndash; Submit Button &ndash;&gt;-->
  <!--              <v-button :loading="form.busy">-->
  <!--                {{ $t('login') }}-->
  <!--              </v-button>-->

  <!--              &lt;!&ndash; GitHub Login Button &ndash;&gt;-->
  <!--              <login-with-github/>-->
  <!--            </div>-->
  <!--          </div>-->
  <!--        </form>-->
  <!--      </card>-->
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
