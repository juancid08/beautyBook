// src/app/services/empleado.service.ts
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
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

  getEmpleados(): Observable<Empleado[]> {
    return this.http.get<Empleado[]>(`${this.baseUrl}/empleados`);
  }

  getEmpleado(id: number): Observable<Empleado> {
    return this.http.get<Empleado>(`${this.baseUrl}/empleados/${id}`);
  }

  getEmpleadosPorSalon(idSalon: number): Observable<Empleado[]> {
    return this.http.get<Empleado[]>(`${this.baseUrl}/salones/${idSalon}/empleados`);
  }
}
