<template>
  <div v-if="!auth.isLoggedIn">
    <q-btn
      v-for="(r, index) in routes"
      :key="index"
      :to="r.path"
      :text-color="currentRoute.path.startsWith(r.path) ? 'blue-5' : 'white'"
      :label="r.name"
      flat
    />
  </div>
  <q-avatar
    v-else
    class="text-black"
    size="50px"
    color="white cursor-pointer non-selectable"
    >{{ userInitials }}
    <q-menu anchor="bottom right" self="top right" class="q-mt-sm">
      <q-list>
        <q-item class="user-info">
          <p>{{ auth.user?.name }}</p>
          <p>{{ auth.user?.email }}</p>
          <!-- <q-item-section>Login</q-item-section> -->
          <!-- <q-btn to="/login" label="Login" flat /> -->
        </q-item>
        <q-separator />
        <q-item class="row items-center" v-close-popup clickable to="/my-posts">
          <q-item-section>Meus Posts</q-item-section>
          <q-icon class="q-ml-sm" name="newspaper" />
        </q-item>
        <q-item
          class="row items-center text-red"
          v-close-popup
          clickable
          @click="auth.logout()"
        >
          <q-item-section>Logout </q-item-section>
          <q-icon class="q-ml-sm" name="logout" />
        </q-item>
      </q-list>
    </q-menu>
  </q-avatar>
</template>

<script lang="ts" setup>
const auth = useAuthStore();
const routes = [
  { name: 'Login', path: '/login' },
  { name: 'Cadastro', path: '/register' },
];

const currentRoute = useRoute();

let userInitials: string = 'AA';

watchEffect(() => {
  if (auth.user) {
    userInitials = auth.user.name
      .split(' ')
      .map((e: string) => (e.trim().length > 0 ? e.substring(0, 1) : ''))
      .filter((e: string) => /[a-zA-Z]/.test(e))
      .slice(0, 2)
      .join('')
      .toUpperCase();
  }
});
</script>

<style lang="scss" scoped>
.user-info {
  flex-direction: column;
  padding: 10px;
  font-size: 12px;
  p {
    margin: 0;
  }
}
</style>
