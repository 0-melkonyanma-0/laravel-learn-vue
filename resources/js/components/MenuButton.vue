<template>
  <v-list-item
    @click="$router.push(uri)"
    role="listitem"
    class="rounded"
  >
    <v-list-item-icon>
      <v-icon>
        {{ icon }}
      </v-icon>
    </v-list-item-icon>
    <v-list-item-content>
      <slot/>
    </v-list-item-content>
  </v-list-item>
</template>

<script>
export default {
  props: {
    icon: {
      required: true,
      type: String
    }
  }
}
</script>

<style scoped>

</style>
