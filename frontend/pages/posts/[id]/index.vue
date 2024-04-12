<style lang="scss" scoped></style>
<template>
  <div class="container">
    <div v-if="post">
      <div class="post">
        <div class="title">
          <h1>{{ post.title }}</h1>
          <h2>Por {{ post.author }} em {{ post.date }}</h2>
          <NuxtLink :to="`/categories/${post.category_slug}`">
            <q-badge>{{ post.category }}</q-badge>
          </NuxtLink>
        </div>
        <div class="image">
          <img
            :src="`https://picsum.photos/500/400?random=${post.id}`"
            alt="Post image"
          />
        </div>
        <div class="text">
          <p>{{ post.content }}</p>
        </div>
      </div>
    </div>
    <div class="loading" v-else>
      <q-spinner color="primary" size="3em" />
    </div>
  </div>
</template>

<script lang="ts" setup>
const route = useRoute();
definePageMeta({
  validate: async (route) => {
    // Check if the id is made up of digits
    return typeof route.params.id === 'string' && /^\d+$/.test(route.params.id);
  },
});

const post = ref();

onMounted(async () => {
  const { data } = await useApiFetch(`/posts/${route.params.id}`);
  post.value = data.value;
  useSeoMeta({
    title: post.value.title,
  });
});
</script>

<style lang="scss" scoped>
.container {
  max-width: 800px;
}

.post {
  text-decoration: none;
  color: black;
  // box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

  .title {
    margin-bottom: 10px;

    h1 {
      margin: 10px 0;
      font-size: 32px;
      font-weight: 900;
      line-height: 1;
    }

    h2 {
      margin: 0 0 5px 0;
      font-size: 18px;
      line-height: 1;
    }
  }

  .image {
    aspect-ratio: 16/9;
    border-radius: 10px;
    overflow: hidden;
    // max-width: 50%;
    object-fit: cover;
    img {
      width: 100%;
    }
  }

  .text {
    // padding: 20px;
    padding-top: 10px;

    p {
      margin: 0;
      font-size: 14px;
      font-weight: 400;
      overflow: hidden;
      text-overflow: ellipsis;
    }
  }
}
</style>
