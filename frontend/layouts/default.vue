<template>
  <q-layout view="lHh lpR fFf">
    <NavBar />

    <q-page-container class="bg-grey-2">
      <q-page padding>
        <slot />
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script lang="ts" setup>
import '@formkit/themes/genesis';
useSeoMeta({
  title: 'Simple Blog',
});
</script>

<style>
.q-page {
  display: flex;
  flex-direction: column;
}
</style>
