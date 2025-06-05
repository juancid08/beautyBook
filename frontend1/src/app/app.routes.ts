import { Routes } from '@angular/router';
import { PaginaPrincipalComponent } from './paginas/pagina-principal/pagina-principal.component';
import { LoginComponent } from './paginas/login/login.component';
import { RegisterComponent } from './paginas/register/register.component';
import { PerfilComponent } from './paginas/perfil/perfil.component';
import { QuienesSomosComponent } from './paginas/quienes-somos/quienes-somos.component'
import { DetallesBarberiaComponent } from './paginas/detalles-barberia/detalles-barberia.component';
import { PreguntasFrecuentesComponent} from './paginas/preguntas-frecuentes/preguntas-frecuentes.component';
import { ContactoComponent } from './paginas/contacto/contacto.component';
import { PoliticaDePrivacidadComponent } from './paginas/politica-de-privacidad/politica-de-privacidad.component';
import { RegistrarNegocioComponent } from './paginas/registrar-negocio/registrar-negocio.component';
import { AuthOrNoSalonGuard } from './guards/auth-or-no-salon.guard';
import { AuthGuard } from './services/auth.guard';
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
        path: 'register-negocio',
        component: RegistrarNegocioComponent,
        canActivate: [AuthOrNoSalonGuard]
    },
    {
        path: 'perfil',
        component: PerfilComponent,
        canActivate: [AuthGuard]
    },
    {
        path: 'quienesSomos',
        component: QuienesSomosComponent
    },
    {
        path: 'detallesBarberia/:id',
        component: DetallesBarberiaComponent
    },
    {
       path: 'preguntasFrecuentes',
       component: PreguntasFrecuentesComponent 
    },
    {
        path: 'contacto',
        component: ContactoComponent
    },
    {
        path:'politicaDePrivacidad',
        component: PoliticaDePrivacidadComponent
    },
];