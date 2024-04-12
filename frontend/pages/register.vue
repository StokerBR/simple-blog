<template>
  <div class="wrapper">
    <div class="card bg-white">
      <h1>Cadastro</h1>
      <form @submit.prevent="handleRegister">
        <FormKit
          v-model="form.name"
          type="text"
          label="Nome"
          help="Informe o seu nome"
          validation="required"
          placeholder="João da Silva"
          outer-class="required"
        />
        <FormKit
          v-model="form.email"
          type="email"
          label="E-mail"
          help="Informe o seu e-mail"
          validation="required|email"
          placeholder="nome@email.com"
          outer-class="required"
        />
        <FormKit type="group">
          <FormKit
            v-model="form.password"
            type="password"
            name="password"
            label="Senha"
            help="Informe a sua senha"
            validation="required"
            outer-class="required"
            suffix-icon="eyeClosed"
            @suffix-icon-click="togglePassword"
          />
          <FormKit
            v-model="form.password_confirmation"
            type="password"
            name="password_confirm"
            label="Confirmação da Senha"
            help="Confirme a sua senha"
            validation="required|confirm"
            outer-class="required"
            suffix-icon="eyeClosed"
            @suffix-icon-click="togglePassword"
          />
        </FormKit>
        <div class="row">
          <q-btn
            unelevated
            type="submit"
            color="primary"
            label="Cadastrar"
            class="col-12"
          />
        </div>
      </form>
    </div>
  </div>
</template>

<script lang="ts" setup>
useSeoMeta({
  title: 'Cadastro',
});
definePageMeta({
  middleware: ['guest'],
});

const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const auth = useAuthStore();

function togglePassword(node: any, e: any) {
  node.props.suffixIcon = node.props.suffixIcon === 'eye' ? 'eyeClosed' : 'eye';
  node.props.type = node.props.type === 'password' ? 'text' : 'password';
}

async function handleRegister() {
  const { error } = await auth.register(form.value);
  if (!error) {
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
    width: 100%;
    max-width: 400px;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

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
