// src/app/services/empleado.service.ts
import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Empleado {
  id_empleado: number;
  nombre: string;
  telefono: string;
  foto?: string;
  id_salon: number;
}

@Injectable({
  providedIn: 'root'
})
export class EmpleadoService {
  private baseUrl = 'http://localhost/api';

  constructor(private http: HttpClient) {}

  // Obtener todos los empleados
  getEmpleados(): Observable<Empleado[]> {
    return this.http.get<Empleado[]>(`${this.baseUrl}/empleados`);
  }

  // Obtener un empleado por ID
  getEmpleado(id: number): Observable<Empleado> {
    return this.http.get<Empleado>(`${this.baseUrl}/empleados/${id}`);
  }

  // Obtener empleados de un salón específico
  getEmpleadosPorSalon(idSalon: number): Observable<Empleado[]> {
    return this.http.get<Empleado[]>(`${this.baseUrl}/salones/${idSalon}/empleados`);
  }

  // Crear un nuevo empleado (sin imagen)
  crearEmpleado(data: Partial<Empleado>): Observable<Empleado> {
    return this.http.post<Empleado>(`${this.baseUrl}/empleados`, data);
  }

  // Crear un nuevo empleado con imagen
  crearEmpleadoConImagen(formData: FormData): Observable<Empleado> {
    // No hace falta establecer headers; HttpClient detecta multipart/form-data
    return this.http.post<Empleado>(`${this.baseUrl}/empleados`, formData);
  }

  // Actualizar un empleado existente (sin imagen)
  actualizarEmpleado(id: number, data: Partial<Empleado>): Observable<Empleado> {
    return this.http.put<Empleado>(`${this.baseUrl}/empleados/${id}`, data);
  }

  // Actualizar un empleado existente con imagen
  actualizarEmpleadoConImagen(id: number, formData: FormData): Observable<Empleado> {
    // Aquí incluimos el método _method=PUT dentro del FormData
    return this.http.post<Empleado>(`${this.baseUrl}/empleados/${id}`, formData);
  }

  // Eliminar un empleado
  eliminarEmpleado(id: number): Observable<any> {
    return this.http.delete(`${this.baseUrl}/empleados/${id}`);
  }
}
