import type { UseFetchOptions } from 'nuxt/app';

/**
 * Realiza a requisição para a API, incluindo o token de autenticação
 * @param path string
 * @param options
 * @returns
 */
export async function useApiFetch<T>(
  path: string,
  options: UseFetchOptions<T> = {}
) {
  const url = apiUrl(path);
  const accessToken = localStorage.getItem('access_token');

  let headers: Record<string, string> = {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  };

  if (accessToken) {
    headers['Authorization'] = `Bearer ${accessToken}`;
  }

  /* if (process.server) {
    headers = {
      ...headers,
      ...useRequestHeaders(['referer', 'cookie']),
    };
  } */

  return useFetch(url, {
    credentials: 'include',
    watch: false,
    ...options,
    headers: {
      ...headers,
      ...options?.headers,
    },

    async onResponseError({ request, response, options }) {
      console.log('[fetch response error]', response);
      if (response.status === 401) {
        await useAuthStore().logout();
      }
    },
  });
}
