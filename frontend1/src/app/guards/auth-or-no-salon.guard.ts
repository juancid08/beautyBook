import { Injectable } from '@angular/core';
import { CanActivate, Router } from '@angular/router';
import { AuthService } from '../services/auth.service';
import { SalonService } from '../services/salon.service';
import { catchError, map, Observable, of, switchMap, take } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthOrNoSalonGuard implements CanActivate {
  constructor(
    private auth: AuthService,
    private salonService: SalonService,
    private router: Router
  ) {}

  canActivate(): Observable<boolean> {
    return this.auth.currentUser$.pipe(
      take(1), // solo tomar el valor actual
      switchMap(usuario => {
        if (!usuario) {
          this.router.navigate(['/login']);
          return of(false);
        }

        return this.salonService.getSalonesPorUsuario(usuario.id_usuario).pipe(
          map(salones => {
            if (salones.length > 0) {
              this.router.navigate(['/login']);
              return false;
            }
            return true;
          }),
          catchError(() => {
            this.router.navigate(['/login']);
            return of(false);
          })
        );
      })
    );
  }
}
