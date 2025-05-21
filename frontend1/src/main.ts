import { bootstrapApplication } from '@angular/platform-browser';
import { importProvidersFrom } from '@angular/core';
import {
  provideHttpClient,
  withInterceptorsFromDi,
  HTTP_INTERCEPTORS
} from '@angular/common/http';
import { FormsModule } from '@angular/forms';

import { AppComponent } from './app/app.component';
import { appConfig } from './app/app.config';
import { AuthInterceptor } from './app/services/auth-interceptor.service';

bootstrapApplication(AppComponent, {
  ...appConfig,
  providers: [
    // 1) HttpClient + carga automática de interceptores
    provideHttpClient(withInterceptorsFromDi()),

    // 2) Registrar FormsModule (para ngModel) en el DI
    importProvidersFrom(FormsModule),

    // 3) Nuestro interceptor de autenticación
    {
      provide: HTTP_INTERCEPTORS,
      useClass: AuthInterceptor,
      multi: true
    },

    // 4) Cualquier otro provider que viniera en appConfig
    ...(appConfig.providers || [])
  ]
}).catch(err => console.error(err));
