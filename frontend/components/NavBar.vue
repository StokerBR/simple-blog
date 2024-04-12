<template>
  <q-header class="header bg-dark text-white">
    <q-toolbar class="menu">
      <div class="header-left">
        <q-btn
          class="sidebar-btn"
          dense
          flat
          round
          icon="menu"
          @click="toggleLeftDrawer"
        />

        <q-btn to="/" flat dense stretch>
          <q-avatar>
            <img src="~/assets/images/logo.png" />
          </q-avatar>
          Simple Blog
        </q-btn>
      </div>

      <div class="menu-btns">
        <q-btn
          v-for="(r, index) in routes"
          :key="index"
          :to="r.path"
          :text-color="
            currentRoute.path.startsWith(r.path) ? 'blue-5' : 'white'
          "
          :label="r.name"
          flat
          stretch
        />
      </div>

      <div class="header-right">
        <UserMenu />
      </div>
    </q-toolbar>
  </q-header>

  <q-drawer v-model="sidebarOpen" side="left" bordered>
    <q-list>
      <q-item
        v-for="(r, index) in routes"
        :key="index"
        :to="r.path"
        clickable
        :active="currentRoute.path.startsWith(r.path)"
      >
        <q-item-section>
          <q-item-label>{{ r.name }}</q-item-label>
        </q-item-section>
      </q-item>
    </q-list>
  </q-drawer>
</template>

<script lang="ts" setup>
const routes = [
  // { name: 'Login', path: '/login' },
  // { name: 'Cadastro', path: '/register' },
  { name: 'Posts', path: '/posts' },
  { name: 'Teste 1', path: '/teste1' },
  { name: 'Teste 2', path: '/teste2' },
];

const currentRoute = useRoute();

const sidebarOpen = ref(false);
function toggleLeftDrawer() {
  sidebarOpen.value = !sidebarOpen.value;
}
</script>

<style lang="scss" scoped>
.header {
  &,
  .menu {
    height: 75px;
  }

  .menu {
    display: flex;
    justify-content: space-between;

    .header-left,
    .header-right {
      display: flex;
      align-items: center;
      width: 200px;
      height: 100%;
    }

    .header-right {
      justify-content: flex-end;
    }

    .sidebar-btn {
      display: none;

      @media (max-width: 768px) {
        display: flex;
      }
    }

    .menu-btns {
      display: flex;
      height: 100%;
      @media (max-width: 768px) {
        display: none;
      }
    }
  }
}
</style>
