<template>
  <div class="container">
    <PageHeader
      title="Meus Posts"
      :breadcrumbs="[
        { name: 'Home', to: '/', icon: 'home' },
        { name: 'Meus Posts' },
      ]"
    />
    <q-table
      title="Posts"
      ref="tableRef"
      :rows="rows"
      :columns="columns"
      no-data-label="Nenhum post encontrado"
      row-key="name"
      :loading="loading"
      v-model:pagination="pagination"
      @request="getPosts"
    >
      <template v-slot:top-right="props">
        <q-btn
          color="primary"
          icon="add"
          label="Novo post"
          to="/posts/create"
        />
      </template>
      <template v-slot:body-cell-category_id="props">
        <q-td :props="props">
          <q-badge>{{ props.row.category }}</q-badge>
        </q-td>
      </template>
      <template v-slot:body-cell-actions="props">
        <q-td :props="props">
          <q-btn
            round
            size="sm"
            color="blue"
            icon="edit"
            title="Editar post"
            class="q-mr-sm"
            :to="`/posts/${props.row.id}/edit`"
          />
          <q-btn
            round
            size="sm"
            color="red"
            icon="delete"
            title="Deletar post"
            @click="
              () => {
                deleteDialog = true;
                deleteDialogPostId = props.row.id;
              }
            "
          />
        </q-td>
      </template>
    </q-table>
  </div>
  <q-dialog v-model="deleteDialog">
    <q-card>
      <q-card-section class="row items-center">
        Tem certeza que deseja deletar este post?
      </q-card-section>

      <q-card-actions align="right">
        <q-btn flat label="Cancelar" color="primary" v-close-popup />
        <q-btn
          flat
          label="Deletar"
          color="red"
          v-close-popup
          @click="deletePost()"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script lang="ts" setup>
const loading = ref(false);
const deleteDialog = ref(false);
const deleteDialogPostId = ref();
const tableRef = ref();
const columns = [
  {
    name: 'id',
    required: true,
    label: 'ID',
    align: 'left',
    field: 'id',
    sortable: true,
  },
  {
    name: 'title',
    required: true,
    label: 'Título',
    align: 'left',
    field: 'title',
    sortable: true,
  },
  /* {
    name: 'summary',
    required: true,
    label: 'Resumo',
    align: 'left',
    field: 'summary',
    format: (val: string) => `${val}`,
  }, */
  {
    name: 'category_id',
    required: true,
    label: 'Categoria',
    align: 'left',
    // field: 'category',
    // format: (val: string) => `${val}`,
    sortable: true,
  },
  {
    name: 'created_at',
    required: true,
    label: 'Data de criação',
    align: 'left',
    field: 'created_at',
    format: (val: string) => useMoment(val).format('DD/MM/YYYY'),
    sortable: true,
  },
  {
    name: 'actions',
    required: true,
    label: 'Ações',
    align: 'center',
  },
];
const pagination = ref({
  sortBy: 'id',
  descending: true,
  page: 1,
  rowsPerPage: 5,
  rowsNumber: 10,
});
const rows = ref<any[]>([]);

useSeoMeta({
  title: 'Meus Posts',
});
definePageMeta({
  middleware: ['auth'],
});

async function getPosts(props: any) {
  const { page, rowsPerPage, sortBy, descending } = props.pagination;

  loading.value = true;

  const { data } = await useApiFetch('/posts/own', {
    params: {
      page: page,
      display_qty: rowsPerPage,
      sort_by: sortBy,
      descending: descending,
    },
  });
  if (data.value) {
    const responseData = data.value as Record<string, any>;

    rows.value = responseData.data;

    pagination.value.page = responseData.current_page;
    pagination.value.rowsPerPage = responseData.per_page;
    pagination.value.rowsNumber = responseData.total;

    pagination.value.sortBy = sortBy;
    pagination.value.descending = descending;
  }

  loading.value = false;
}

async function deletePost() {
  loading.value = true;
  const id = deleteDialogPostId.value;
  deleteDialog.value = false;
  deleteDialogPostId.value = null;

  const { error } = await useApiFetch(`/posts/${id}`, {
    method: 'DELETE',
  });

  if (error.value) {
    $alert.error('Erro ao deletar post');
  } else {
    $alert.success('Post deletado com sucesso');
  }

  tableRef.value.requestServerInteraction();
}

onMounted(() => {
  // getPosts();
  tableRef.value.requestServerInteraction();
});
</script>

<style></style>
