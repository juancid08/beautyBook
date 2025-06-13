import { Injectable } from "@angular/core";
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { Observable } from "rxjs";
import { AuthService } from "./auth.service";

export interface Resena {
  id_resena: number;
  id_usuario: string;
  id_servicio: string;
  comentario: string;
  calificacion: number;
  fecha_resena: string;
}

@Injectable({
  providedIn: "root",
})
export class ResenaService {
  private baseUrl = "http://localhost/api/resenas";

  constructor(private http: HttpClient, private authSvc: AuthService) {}

  private headers(): HttpHeaders {
    const token = this.authSvc.getToken();
    return new HttpHeaders({
      Authorization: token ? `Bearer ${token}` : "",
    });
  }

  // Obtener todas las reseñas (público)
  getResenas(): Observable<Resena[]> {
    return this.http.get<Resena[]>(this.baseUrl);
  }

  // Obtener una reseña por su ID (público)
  getResena(id: number): Observable<Resena> {
    return this.http.get<Resena>(`${this.baseUrl}/${id}`);
  }

  // Crear nueva reseña (requiere token)
  crearResena(data: Partial<Resena>): Observable<Resena> {
    return this.http.post<Resena>(this.baseUrl, data, {
      headers: this.headers(),
    });
  }

  // Actualizar reseña existente (requiere token)
  actualizarResena(id: number, data: Partial<Resena>): Observable<Resena> {
    return this.http.put<Resena>(`${this.baseUrl}/${id}`, data, {
      headers: this.headers(),
    });
  }

  // Eliminar reseña (requiere token)
  eliminarResena(id: number): Observable<any> {
    return this.http.delete(`${this.baseUrl}/${id}`, {
      headers: this.headers(),
    });
  }

  // Obtener reseñas por servicio (público)
  getResenasPorServicio(idServicio: number): Observable<Resena[]> {
    return this.http.get<Resena[]>(`${this.baseUrl}?id_servicio=${idServicio}`);
  }

  // Si tuvieras ruta GET /api/salones/{id}/resenas:
  getResenasPorSalon(idSalon: number): Observable<Resena[]> {
    return this.http.get<Resena[]>(
      `http://localhost/api/salones/${idSalon}/resenas`
    );
  }
}
