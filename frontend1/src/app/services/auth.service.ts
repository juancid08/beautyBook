import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { BehaviorSubject, Observable } from "rxjs";
import { tap } from "rxjs/operators";
import { Router } from "@angular/router";
import { environment } from "../../environments/environments";

export interface LoginResponse {
  usuario: any;
  token: string;
}
export interface RegisterResponse {
  usuario: any;
  token: string;
}

@Injectable({
  providedIn: "root",
})
export class AuthService {
  private currentUserSubject = new BehaviorSubject<any>(
    JSON.parse(localStorage.getItem("usuario") || "null")
  );
  public currentUser$ = this.currentUserSubject.asObservable();

  constructor(private http: HttpClient, private router: Router) {}

  login(email: string, password: string): Observable<LoginResponse> {
    return this.http
      .post<LoginResponse>(`${environment.apiUrl}/login`, { email, password })
      .pipe(
        tap((resp) => {
          localStorage.setItem("token", resp.token);
          localStorage.setItem("usuario", JSON.stringify(resp.usuario));
          this.currentUserSubject.next(resp.usuario);
        })
      );
  }

  register(
    nombre: string,
    apellidos: string,
    email: string,
    password: string,
    password_confirmation: string
  ): Observable<RegisterResponse> {
    return this.http
      .post<RegisterResponse>(`${environment.apiUrl}/register`, {
        nombre,
        apellidos,
        email,
        password,
        password_confirmation,
      })
      .pipe(
        tap((resp) => {
          localStorage.setItem("token", resp.token);
          localStorage.setItem("usuario", JSON.stringify(resp.usuario));
          this.currentUserSubject.next(resp.usuario);
        })
      );
  }

  logout() {
    const token = this.getToken();
    if (token) {
      this.http
        .post(
          `${environment.apiUrl}/logout`,
          {},
          { headers: { Authorization: `Bearer ${token}` } }
        )
        .subscribe();
    }

    localStorage.removeItem("token");
    localStorage.removeItem("usuario");
    this.currentUserSubject.next(null);
    this.router.navigate(["/"]);
  }

  getToken(): string | null {
    return localStorage.getItem("token");
  }

  actualizarPerfil(userId: number, datos: any): Observable<any> {
    const token = this.getToken();
    return this.http.put(`${environment.apiUrl}/usuarios/${userId}`, datos, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
  }

  actualizarPerfilConImagen(
    userId: number,
    formData: FormData
  ): Observable<any> {
    const token = this.getToken();
    return this.http.post(
      `${environment.apiUrl}/usuarios/${userId}?_method=PUT`,
      formData,
      {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      }
    );
  }
}
