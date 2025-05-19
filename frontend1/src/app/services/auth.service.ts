import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject, Observable } from 'rxjs';
import { tap } from 'rxjs/operators';
import { Router } from '@angular/router';
import { environment } from '../../environments/environments';

interface LoginResponse {
  usuario: any;
  token: string;
}

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private currentUserSubject = new BehaviorSubject<any>(
    JSON.parse(localStorage.getItem('usuario') || 'null')
  );
  public currentUser$ = this.currentUserSubject.asObservable();

  constructor(
    private http: HttpClient,
    private router: Router
  ) {}

  login(email: string, password: string): Observable<LoginResponse> {
    return this.http.post<LoginResponse>(
      `${environment.apiUrl}/login`,
      { email, password }
    ).pipe(
      tap(resp => {
        localStorage.setItem('token', resp.token);
        localStorage.setItem('usuario', JSON.stringify(resp.usuario));
        this.currentUserSubject.next(resp.usuario);
      })
    );
  }

  logout() {
    const token = localStorage.getItem('token');
    if (token) {
      this.http.post(
        `${environment.apiUrl}/logout`,
        {},
        { headers: { Authorization: `Bearer ${token}` } }
      ).subscribe();
    }

    localStorage.removeItem('token');
    localStorage.removeItem('usuario');
    this.currentUserSubject.next(null);
    this.router.navigate(['/login']);
  }

  getToken(): string | null {
    return localStorage.getItem('token');
  }
}
