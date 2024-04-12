<template>
  <div class="q-mb-sm">Hello World</div>
  <div>
    <q-btn color="primary" @click="$alert.show('teste')">notification</q-btn>
    <q-btn color="positive" @click="$alert.success('teste')">success</q-btn>
    <q-btn color="negative" @click="$alert.error('teste')">error</q-btn>
    <q-btn color="warning" @click="$alert.warning('teste')">warning</q-btn>
  </div>
  <div class="div">
    <q-btn class="q-mt-sm" color="dark" @click="showLoading">loading</q-btn>
  </div>
</template>

<script setup>
useSeoMeta({
  title: 'Simple Blog',
});

function showLoading() {
  Loading.show({
    // backgroundColor: 'rgba(0, 0, 0, 0.5)',
    // message: 'teste...',
  });

  setTimeout(() => {
    Loading.hide();
  }, 2000);
}
</script>

<style scoped></style>
