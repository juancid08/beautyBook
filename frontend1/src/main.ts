import { bootstrapApplication } from "@angular/platform-browser";
import { importProvidersFrom } from "@angular/core";
import {
  provideHttpClient,
  withInterceptorsFromDi,
  HTTP_INTERCEPTORS,
} from "@angular/common/http";
import { FormsModule } from "@angular/forms";

import { AppComponent } from "./app/app.component";
import { appConfig } from "./app/app.config";
import { AuthInterceptor } from "./app/services/auth-interceptor.service";

bootstrapApplication(AppComponent, {
  ...appConfig,
  providers: [
    // 1) Proveedor global de HttpClient + interceptores
    provideHttpClient(withInterceptorsFromDi()),

    // 2) Registrar FormsModule (para poder usar [(ngModel)])
    importProvidersFrom(FormsModule),

    // 3) Nuestro interceptor de autenticación
    {
      provide: HTTP_INTERCEPTORS,
      useClass: AuthInterceptor,
      multi: true,
    },

    // 4) Otros providers de appConfig
    ...(appConfig.providers || []),
  ],
}).catch((err) => console.error(err));
