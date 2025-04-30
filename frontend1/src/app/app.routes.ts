import { Routes } from '@angular/router';
import { PaginaPrincipalComponent } from './paginas/pagina-principal/pagina-principal.component';
import { LoginComponent } from './paginas/login/login.component';
export const routes: Routes = [{
    path: '',
    component: PaginaPrincipalComponent
    },
    {
        path: 'login',
        component: LoginComponent
    }
];