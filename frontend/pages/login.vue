<template>
  <div class="wrapper">
    <div class="card bg-white">
      <h1>Login</h1>
      <FormKit
        type="form"
        :actions="false"
        :incomplete-message="false"
        @submit="handleLogin"
      >
        <!-- <input type="email" v-model="form.email" /> -->
        <FormKit
          v-model="form.email"
          type="email"
          label="E-mail"
          help="Informe o seu e-mail"
          validation="required|email"
          placeholder="nome@email.com"
        />
        <FormKit
          v-model="form.password"
          type="password"
          label="Senha"
          help="Informe a sua senha"
          validation="required"
          suffix-icon="eyeClosed"
          @suffix-icon-click="togglePassword"
        />
        <div class="row">
          <q-btn
            unelevated
            type="submit"
            color="primary"
            label="Entrar"
            class="col-12"
          />
        </div>
      </FormKit>
    </div>
  </div>
</template>

<script lang="ts" setup>
useSeoMeta({
  title: 'Login',
});
definePageMeta({
  middleware: ['guest'],
});

const form = ref({
  email: 'henrique@email.com',
  password: 'senha123',
});

const auth = useAuthStore();

function togglePassword(node: any, e: any) {
  node.props.suffixIcon = node.props.suffixIcon === 'eye' ? 'eyeClosed' : 'eye';
  node.props.type = node.props.type === 'password' ? 'text' : 'password';
}

async function handleLogin() {
  const { error } = await auth.login(form.value);
  if (!error.value) {
    navigateTo('/');
  }
}
</script>

<style lang="scss" scoped>
.wrapper {
  display: flex;
  justify-content: center;
  align-items: center;

  .card {
    max-width: 400px;

    h1 {
      margin: 0 0 20px;
      text-align: center;
      font-size: 26px;
      font-weight: 600;
      line-height: 1;
    }

    form {
      .row {
        margin-top: 20px;
      }
    }
  }
}
</style>
