import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Salon {
  id_salon: number;
  nombre: string;
  direccion: string;
  telefono: string;
  horario_apertura: string;
  horario_cierre: string;
  descripcion: string;
  especializacion: string;
  foto: string;
  foto_url?: string;
  liked?: boolean;
}

@Injectable({
  providedIn: 'root'
})
export class SalonService {
  private baseUrl = 'http://localhost/api/salones';

  constructor(private http: HttpClient) {}

  getSalones(): Observable<Salon[]> {
    return this.http.get<Salon[]>(this.baseUrl);
  }

  getSalon(id: number): Observable<Salon> {
    return this.http.get<Salon>(`${this.baseUrl}/${id}`);
  }

  crearSalon(data: Partial<Salon>): Observable<Salon> {
    return this.http.post<Salon>(this.baseUrl, data);
  }

  actualizarSalon(id: number, data: Partial<Salon>): Observable<Salon> {
    return this.http.put<Salon>(`${this.baseUrl}/${id}`, data);
  }

  eliminarSalon(id: number): Observable<any> {
    return this.http.delete(`${this.baseUrl}/${id}`);
  }
}
