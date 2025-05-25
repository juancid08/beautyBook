import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Resena {
  id_resena: number;
  id_usuario: string;
  id_servicio: string;
  comentario: string;
  calificacion: number;
  fecha_resena: string;
}

@Injectable({
  providedIn: 'root'
})
export class ResenaService {
  private baseUrl = 'http://localhost/api/resenas';

  constructor(private http: HttpClient) {}

  // Obtener todas las reseñas
  getResenas(): Observable<Resena[]> {
    return this.http.get<Resena[]>(this.baseUrl);
  }

  // Obtener una reseña por su ID
  getResena(id: number): Observable<Resena> {
    return this.http.get<Resena>(`${this.baseUrl}/${id}`);
  }

  // Crear nueva reseña
  crearResena(data: Partial<Resena>): Observable<Resena> {
    return this.http.post<Resena>(this.baseUrl, data);
  }

  // Actualizar reseña existente
  actualizarResena(id: number, data: Partial<Resena>): Observable<Resena> {
    return this.http.put<Resena>(`${this.baseUrl}/${id}`, data);
  }

  // Eliminar reseña
  eliminarResena(id: number): Observable<any> {
    return this.http.delete(`${this.baseUrl}/${id}`);
  }

  // Obtener reseñas por servicio 
  getResenasPorServicio(idServicio: number): Observable<Resena[]> {
    return this.http.get<Resena[]>(`${this.baseUrl}?id_servicio=${idServicio}`);
  }

  getResenasPorSalon(idSalon: number): Observable<Resena[]> {
    return this.http.get<Resena[]>(`http://localhost/api/salones/${idSalon}/resenas`);
  }
}
