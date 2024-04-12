<template>
  <!-- <h1>{{ isEdit ? 'Editar' : 'Criar' }} Post</h1> -->
  <PageHeader
    :title="`${isEdit ? 'Editar' : 'Criar'} Post`"
    :breadcrumbs="[
      { name: 'Home', to: '/', icon: 'home' },
      { name: 'Posts', to: '/posts', icon: 'newspaper' },
      { name: `${isEdit ? 'Editar' : 'Criar'} Post` },
    ]"
  />
  <div class="card">
    <FormKit
      type="form"
      :actions="false"
      :incomplete-message="false"
      @submit="savePost"
    >
      <div class="row">
        <FormKit
          v-model="post.title"
          label="Título"
          placeholder="Título do post"
          validation="required"
          outer-class="col-8 required"
        />
        <FormKit
          v-model="post.category_id"
          label="Categoria"
          placeholder="Selecione uma categoria"
          validation="required"
          type="select"
          :options="
            categories?.map((category) => ({
              label: category.name,
              value: category.id,
            }))
          "
          outer-class="col-4 required"
        />
      </div>
      <FormKit
        v-model="post.summary"
        label="Resumo"
        placeholder="Resumo do post"
        validation="required"
        outer-class="col-12 required"
      />
      <FormKit
        v-model="post.content"
        label="Conteúdo"
        placeholder="Conteúdo do post"
        validation="required"
        type="textarea"
        outer-class="col-12 required"
      />
      <q-btn
        color="primary"
        label="Salvar"
        class="col-12 float-right"
        icon="save"
        type="submit"
      />
    </FormKit>
  </div>
</template>

<script lang="ts" setup>
const props = defineProps({
  isEdit: {
    type: Boolean,
    default: false,
  },
  post: {
    type: Object,
  },
});

const post = ref(
  props.post || {
    title: '',
    summary: '',
    content: '',
    category_id: null,
  }
);

type Category = {
  id: number;
  name: string;
};

const categories = ref<Category[]>([]);

onMounted(async () => {
  const { data } = await useApiFetch('/posts/categories');
  categories.value = data.value as Category[];
});

async function savePost() {
  const path = props.isEdit ? `/posts/${props.post!.id}` : '/posts';

  Loading.show();

  const { data, error } = await useApiFetch(path, {
    method: props.isEdit ? 'PUT' : 'POST',
    body: JSON.stringify(post.value),
  });

  Loading.hide();

  if (error.value) {
    apiErrorMessage(error.value, 'Erro ao salvar o post');
    return;
  }

  $alert.success('Post salvo com sucesso');
  navigateTo('/my-posts');
}
</script>

<style lang="scss" scoped></style>
