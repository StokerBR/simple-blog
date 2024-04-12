import { Notify } from 'quasar';

type NotificationOptions = {
  type?: 'success' | 'warning' | 'info' | 'error';
  timeout?: number;
  progress?: boolean;
  position?:
    | 'top-left'
    | 'top-right'
    | 'bottom-left'
    | 'bottom-right'
    | 'top'
    | 'bottom'
    | 'left'
    | 'right'
    | 'center';
  group?: string | number | boolean;
};

export const $alert = {
  show,
  success,
  warning,
  error,
};

/**
 * Exibe uma notificação na tela
 * @param options NotificationOptions
 */
function show(message: string, options: NotificationOptions = {}) {
  options = {
    type: 'info',
    position: 'top',
    timeout: 5000,
    progress: true,
    group: `${options?.type ?? ''} - ${message}`,
    ...options,
  };

  let color = 'primary';
  let textColor = 'white';
  let icon = 'info';
  let timeout = options.timeout;

  switch (options.type) {
    case 'success':
      color = 'positive';
      icon = 'check';
      timeout = 3000;
      break;
    case 'warning':
      color = 'warning';
      icon = 'warning';
      break;
    case 'error':
      color = 'negative';
      icon = 'warning';
      break;
  }

  Notify.create({
    color: color,
    textColor: textColor,
    icon: icon,
    message: message,
    position: options.position,
    group: options.group,
    actions: [
      {
        icon: 'close',
        color: 'white',
        round: true,
        handler: () => {},
      },
    ],
    timeout: timeout,
    progress: options.progress,
  });
}

// Exibe uma notificação de sucesso
function success(message: string) {
  $alert.show(message, { type: 'success' });
}

// Exibe uma notificação de aviso
function warning(message: string) {
  $alert.show(message, { type: 'warning' });
}

// Exibe uma notificação de erro
function error(message: string) {
  $alert.show(message, { type: 'error' });
}
