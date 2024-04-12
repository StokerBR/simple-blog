<template>
  <div class="container">
    <PostForm v-if="post" :post="post" :is-edit="true" />
    <div class="loading" v-else>
      <q-spinner color="primary" size="3em" />
    </div>
  </div>
</template>

<script lang="ts" setup>
const route = useRoute();
const post = ref();

definePageMeta({
  title: 'Editar Post',
  middleware: ['auth'],
});

onMounted(async () => {
  const { data, error } = await useApiFetch(`/posts/${route.params.id}/edit`);
  if (error.value) {
    console.error(error);
    apiErrorMessage(error.value, 'Erro ao obter os dados do post');

    navigateTo('/posts');
  }
  post.value = data.value;
  console.log(post.value);
});
</script>

<style></style>
