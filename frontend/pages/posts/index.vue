<template>
  <div class="container">
    <div class="row top">
      <h1>Posts</h1>
      <q-space />
      <q-btn
        class="col-sm-auto col-12"
        v-if="auth.isLoggedIn"
        color="primary"
        icon="add"
        label="Criar post"
        to="/posts/create"
      />
    </div>
    <div v-if="posts">
      <div class="posts">
        <NuxtLink
          class="post"
          :to="`/posts/${post.id}`"
          v-for="post in posts"
          :key="post.id"
        >
          <q-btn
            v-if="auth.isLoggedIn && post.author_id == auth.user!.id"
            color="primary"
            icon="edit"
            title="Editar post"
            :to="`/posts/${post.id}/edit`"
            class="btn-edit"
            round
            size="sm"
          />
          <img
            :src="`https://picsum.photos/400/300?random=${post.id}`"
            alt="Post image"
          />
          <div class="text">
            <h2>{{ post.title }}</h2>
            <p>{{ post.summary }}</p>
          </div>
        </NuxtLink>
      </div>
      <div class="q-pt-lg flex flex-center">
        <q-pagination
          v-model="currentPage"
          :max="lastPage"
          :max-pages="6"
          boundary-numbers
          boundary-links
          direction-links
        />
      </div>
    </div>
    <div v-else class="q-pt-lg flex flex-center">
      <p>Nenhum post encontrado</p>
    </div>
  </div>
</template>

<script lang="ts" setup>
useSeoMeta({
  title: 'Posts',
});

const posts = ref();
const currentPage = ref(1);
const lastPage = ref(1);
const auth = useAuthStore();

function getPosts() {
  useApiFetch(`/posts?page=${currentPage.value}`).then(({ data }) => {
    if (data.value) {
      const responseData = data.value as Record<string, any>;
      lastPage.value = responseData.last_page;
      posts.value = responseData.data;
    }
  });
}

// Carregar os posts ao mudar de página
watch(currentPage, () => {
  getPosts();
});

// Carregar os posts ao montar a página
onMounted(async () => {
  getPosts();
});
</script>

<style lang="scss" scoped>
.top.row {
  h1 {
    margin: 0 0 10px 0;
    font-size: 32px;
    font-weight: 900;
    line-height: 1;
  }
  margin-bottom: 20px;
}

.posts {
  --cols: 3;
  --gap: 30px;

  display: flex;
  flex-wrap: wrap;
  gap: var(--gap);

  .post {
    flex-basis: calc(
      (100% / var(--cols)) - ((var(--gap) / var(--cols)) * (var(--cols) - 1))
    );
    border-radius: 10px;
    overflow: hidden;
    text-decoration: none;
    color: black;
    // box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    transition: all 0.2s;
    position: relative;

    &:hover {
      color: $primary;
    }

    .btn-edit {
      position: absolute;
      top: 10px;
      right: 10px;
    }

    img {
      width: 100%;
      aspect-ratio: 16/9;
      object-fit: cover;
      border-radius: 10px;
    }

    .text {
      // padding: 20px;
      padding-top: 10px;

      h2 {
        margin: 0 0 10px 0;
        font-size: 18px;
        font-weight: 700;
        line-height: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      p {
        margin: 0;
        font-size: 14px;
        font-weight: 400;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
      }
    }

    @media (max-width: 991px) {
      --cols: 2;
    }
    @media (max-width: 767px) {
      --cols: 1;
    }
  }
}
</style>
