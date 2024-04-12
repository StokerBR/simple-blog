import type { FetchError } from 'ofetch';

/**
 * Retorna a URL da API com o path especificado
 * @param path string
 * @returns string
 */
export function apiUrl(path: string): string {
  if (path[0] === '/') {
    path = path.substring(1);
  }

  return useRuntimeConfig().public.apiUrl + '/' + path;
}

/**
 * Exibe a mensagem de erro da API ou a mensagem padrão
 * @param error FetchError<any>
 * @param defaultMessage string
 * @returns void
 */
export function apiErrorMessage(
  error: FetchError<any>,
  defaultMessage: string
): void {
  if (error.data) {
    if (typeof error.data === 'string') {
      return $alert.error(error.data);
    }

    if (error.data.message) {
      if (error.data.message === 'Unauthenticated.') {
        return $alert.error('Você não está autenticado.');
      }

      return $alert.error(error.data.message);
    }

    if (error.data.errors) {
      const errorMessage = getErrorMessage(error.data.errors);
      if (errorMessage) {
        return $alert.error(errorMessage);
      }
    }
  }

  $alert.error(defaultMessage);
}

function getErrorMessage(data: ErrorData): string | undefined {
  const firstError =
    data instanceof Array ? data[0] : data[Object.keys(data)[0]];

  if (typeof firstError === 'string' && firstError.length > 0) {
    return firstError;
  } else if (firstError instanceof Array || firstError instanceof Object) {
    return getErrorMessage(firstError);
  }
}

interface ErrorData {
  [key: string]: any;
}
