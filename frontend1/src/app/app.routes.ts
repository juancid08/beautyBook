import { Routes } from '@angular/router';
import { PaginaPrincipalComponent } from './paginas/pagina-principal/pagina-principal.component';
import { LoginComponent } from './paginas/login/login.component';
import { RegisterComponent } from './paginas/register/register.component';
import { QuienesSomosComponent } from './paginas/quienes-somos/quienes-somos.component'
import { DetallesBarberiaComponent } from './paginas/detalles-barberia/detalles-barberia.component';
import { PreguntasFrecuentesComponent} from './paginas/preguntas-frecuentes/preguntas-frecuentes.component';

export const routes: Routes = [{
    path: '',
    component: PaginaPrincipalComponent
    },
    {
        path: 'login',
        component: LoginComponent
    },
    {
        path: 'register',
        component: RegisterComponent
    },
    {
        path: 'quienesSomos',
        component: QuienesSomosComponent
    },
    {
        path: 'detallesBarberia',
        component: DetallesBarberiaComponent
    },
    {
       path: 'preguntasFrecuentes',
       component: PreguntasFrecuentesComponent 
    }
];