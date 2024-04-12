export default defineNuxtPlugin(async (nuxtApp) => {
  const auth = useAuthStore();
  const hasLogin = localStorage.getItem('hasLogin');

  if (!auth.isLoggedIn && hasLogin) {
    await auth.fetchUser();
  }
});
