import { defineStore } from 'pinia';

type User = {
  id: number;
  name: string;
  email: string;
};

type LoginData = {
  email: string;
  password: string;
};

type RegistrationInfo = {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
};

export const useAuthStore = defineStore('auth', () => {
  const user = ref<User | null>(null);
  const isLoggedIn = computed(() => !!user.value);

  // Obtem o usuário logado
  async function fetchUser() {
    const { data, error } = await useApiFetch('/user');
    user.value = data.value as User;

    if (user.value) {
      localStorage.setItem('hasLogin', 'true');
    } else {
      localStorage.removeItem('hasLogin');
    }

    if (error.value) {
      // $alert.error(error.value.data.message /* 'Erro ao obter o usuário' */);
      console.log(error.value);
      apiErrorMessage(error.value, 'Erro ao obter o usuário');
    }
  }

  // Realiza o login
  async function login(credentials: LoginData) {
    Loading.show();

    await useApiFetch('/sanctum/csrf-cookie');

    const response = await useApiFetch('/login', {
      method: 'POST',
      body: credentials,
    });

    const { data, error } = response;
    console.log(response, data, error);

    if (error.value) {
      apiErrorMessage(error.value, 'Erro ao realizar login');
    }

    if (response.status.value == 'success') {
      await fetchUser();
    }

    Loading.hide();

    return response;
  }

  // Realiza o cadastro
  async function register(info: RegistrationInfo) {
    Loading.show();

    await useApiFetch('/sanctum/csrf-cookie');

    const response = await useApiFetch('/register', {
      method: 'POST',
      body: info,
    });

    const { data, error } = response;

    if (error && error.value) {
      apiErrorMessage(error.value, 'Erro ao realizar cadastro');
    }

    if (response.status.value == 'success') {
      await fetchUser();
    }

    Loading.hide();

    return response;
  }

  // Realiza o logout
  async function logout() {
    await useApiFetch('/logout', { method: 'POST' });
    user.value = null;
    localStorage.removeItem('hasLogin');
    navigateTo('/login');
  }

  return { user, isLoggedIn, fetchUser, login, logout, register };
});
