import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { map, Observable } from "rxjs";

export interface Servicio {
  id_servicio: number;
  id_salon: number;
  nombre: string;
  descripcion: string;
  precio: number;
  duracion_minutos: number;
  salon_nombre?: string;
}

@Injectable({
  providedIn: "root",
})
export class ServicioService {
  private baseUrl = "https://beautybookadmin.duckdns.org/api/servicios";

  constructor(private http: HttpClient) {}

  // Obtener todos los servicios
  getServicios(): Observable<Servicio[]> {
    return this.http.get<Servicio[]>(this.baseUrl);
  }

  // Obtener un servicio por ID
  getServicio(id: number): Observable<Servicio> {
    return this.http.get<Servicio>(`${this.baseUrl}/${id}`);
  }

  // Crear nuevo servicio
  crearServicio(data: Partial<Servicio>): Observable<Servicio> {
    return this.http.post<Servicio>(this.baseUrl, data);
  }

  // Actualizar servicio
  actualizarServicio(
    id: number,
    data: Partial<Servicio>
  ): Observable<Servicio> {
    return this.http.put<Servicio>(`${this.baseUrl}/${id}`, data);
  }

  // Eliminar servicio
  eliminarServicio(id: number): Observable<any> {
    return this.http.delete(`${this.baseUrl}/${id}`);
  }

  // Obtener servicios de un salón específico (opcional)
  getServiciosPorSalon(salonId: number): Observable<Servicio[]> {
    return this.http.get<Servicio[]>(`${this.baseUrl}?id_salon=${salonId}`);
  }
}
