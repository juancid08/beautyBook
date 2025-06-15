// src/app/services/cita.service.ts
import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { Observable } from "rxjs";
import { map } from "rxjs/operators";
export interface Cita {
  id_cita: number;
  id_usuario: number;
  id_servicio: number;
  fecha: string;
  estado: "confirmada" | "pendiente" | "cancelada";
  hora: string;
  id_empleado: number;
}

@Injectable({
  providedIn: "root",
})
export class CitaService {
  private baseUrl = "http://52.202.205.94/api/citas";

  constructor(private http: HttpClient) {}

  // Obtener todas las citas
  getCitas(): Observable<Cita[]> {
    return this.http.get<Cita[]>(this.baseUrl);
  }

  // Obtener una cita por ID
  getCita(id: number): Observable<Cita> {
    return this.http.get<Cita>(`${this.baseUrl}/${id}`);
  }

  // Crear una nueva cita
  crearCita(data: Partial<Cita>): Observable<Cita> {
    return this.http.post<Cita>(this.baseUrl, data);
  }

  // Actualizar cualquier campo de una cita
  actualizarCita(id: number, data: Partial<Cita>): Observable<Cita> {
    return this.http.put<Cita>(`${this.baseUrl}/${id}`, data);
  }

  // Cancelar una cita (internamente solo cambia estado a "cancelada")
  cancelarCita(id: number): Observable<Cita> {
    return this.actualizarCita(id, { estado: "cancelada" });
  }

  // Eliminar una cita
  eliminarCita(id: number): Observable<any> {
    return this.http.delete(`${this.baseUrl}/${id}`);
  }

  // Obtener todas las citas de un usuario
  getCitasPorUsuario(idUsuario: number): Observable<Cita[]> {
    return this.http.get<Cita[]>(
      `http://52.202.205.94/api/usuarios/${idUsuario}/citas`
    );
  }

  // Obtener todas las citas de un servicio
  getCitasPorServicio(idServicio: number): Observable<Cita[]> {
    return this.http.get<Cita[]>(`${this.baseUrl}?id_servicio=${idServicio}`);
  }

  // Obtener todas las citas de un empleado en una fecha determinada
  getCitasPorEmpleadoYFecha(
    idEmpleado: number,
    fecha: string
  ): Observable<Cita[]> {
    return this.http.get<Cita[]>(
      `${this.baseUrl}?id_empleado=${idEmpleado}&fecha=${fecha}`
    );
  }

  // Obtener nombre de un servicio
  getNombreServicio(id: number): Observable<string> {
    return this.http
      .get<any>(`http://52.202.205.94/api/servicios/${id}`)
      .pipe(map((servicio) => servicio.nombre));
  }

  // Obtener nombre de un empleado
  getNombreEmpleado(id: number): Observable<string> {
    return this.http
      .get<any>(`http://52.202.205.94/api/empleados/${id}`)
      .pipe(map((empleado) => empleado.nombre));
  }
}
