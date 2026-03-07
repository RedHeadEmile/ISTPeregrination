import {ApplicationConfig, ErrorHandler, provideBrowserGlobalErrorListeners} from '@angular/core';
import {provideRouter} from '@angular/router';

import {routes} from './app.routes';
import {providePrimeNG} from 'primeng/config';
import Aura from '@primeuix/themes/aura';

import {definePreset, palette} from '@primeuix/themes';
import {MessageService} from 'primeng/api';
import {GlobalErrorHandler} from './core/handlers/global-error-handler';

const themePreset = definePreset(Aura, {
  semantic: {
    primary: palette('#203478'),
    secondary: palette('FFD000')
  }
});

export const appConfig: ApplicationConfig = {
  providers: [
    provideBrowserGlobalErrorListeners(),
    provideRouter(routes),
    providePrimeNG({
      theme: {
        preset: themePreset,
        options: {
          darkModeSelector: false
        }
      }
    }),
    MessageService,
    {
      provide: ErrorHandler,
      useClass: GlobalErrorHandler
    }
  ]
};
