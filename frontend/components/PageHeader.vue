<template>
  <div class="page-header">
    <div class="title">
      <h1>{{ props.title }}</h1>
      <h2 v-if="props.subtitle">{{ props.subtitle }}</h2>
    </div>
    <q-breadcrumbs v-if="props.breadcrumbs">
      <template v-slot:separator>
        <q-icon name="chevron_right" />
      </template>
      <q-breadcrumbs-el
        v-for="(breadcrumb, index) in props.breadcrumbs"
        :key="index"
        :label="breadcrumb.name"
        :to="breadcrumb.to"
        :icon="breadcrumb.icon"
      />
    </q-breadcrumbs>
  </div>
</template>

<script lang="ts" setup>
type BreadCrumb = {
  name: string;
  to?: string;
  icon?: string;
};

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  subtitle: {
    type: String,
    required: false,
  },
  breadcrumbs: {
    type: Array as PropType<BreadCrumb[]>,
    required: false,
  },
});
</script>

<style lang="scss" scoped>
.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

h1 {
  margin: 10px 0 0;
  font-size: 32px;
  font-weight: 600;
  line-height: 1;
}
</style>
