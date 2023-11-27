<template>
  <v-card>
    <v-card-title>
      {{ title }}
      <slot name="card-title"/>
    </v-card-title>
    <v-card-text>
      <slot name="card-text"/>
    </v-card-text>
    <v-card-actions class="pa-4">
      <slot name="card-actions"/>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  name: 'Card',

  props: {
    title: {type: String, default: null}
  }
}
</script>
