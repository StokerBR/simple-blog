<template>
  <PostForm />
</template>

<script lang="ts" setup>
useHead({
  title: 'Criar Post',
});
definePageMeta({
  middleware: ['auth'],
});
</script>

<style lang="scss" scoped></style>
