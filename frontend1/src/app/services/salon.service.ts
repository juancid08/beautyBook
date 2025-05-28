import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { map, Observable } from "rxjs";

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
  rating?: number;
  liked?: boolean;
  id_usuario: number;
}

@Injectable({
  providedIn: "root",
})
export class SalonService {
  private baseUrl = "http://localhost/api/salones";

  constructor(private http: HttpClient) {}

  getSalones(): Observable<Salon[]> {
    return this.http.get<Salon[]>(this.baseUrl);
  }

  getSalonesPorUsuario(idUsuario: number): Observable<Salon[]> {
    return this.http.get<Salon[]>(`http://localhost/api/usuarios/${idUsuario}/salones`);
  }

  getSalonesFiltrado(especializacion?: string): Observable<Salon[]> {
    let url = this.baseUrl;
    if (especializacion) {
      url += `?especializacion=${encodeURIComponent(especializacion)}`;
    }

    return this.http.get<Salon[]>(url).pipe(
      map((salones) =>
        salones.map((salon) => {
          let fotoUrl = "/assets/default.webp";

          if (salon.foto) {
            const fileName = salon.foto.split("/").pop() || salon.foto;
            fotoUrl = `http://localhost/storage/salones/${fileName}`;
          }

          return {
            ...salon,
            foto: fotoUrl,
            rating: Math.random() * (5 - 3.5) + 3.5,
            liked: false,
          };
        })
      )
    );
  }

  buscarSalonesPorNombre(nombre: string): Observable<Salon[]> {
    const url = `${this.baseUrl}?nombre=${encodeURIComponent(nombre)}`;

    return this.http.get<Salon[]>(url).pipe(
      map((salones) =>
        salones.map((salon) => {
          let fotoUrl = "/assets/default.webp";

          if (salon.foto) {
            const fileName = salon.foto.split("/").pop() || salon.foto;
            fotoUrl = `http://localhost/storage/salones/${fileName}`;
          }

          return {
            ...salon,
            foto: fotoUrl,
            rating: Math.random() * (5 - 3.5) + 3.5,
            liked: false,
          };
        })
      )
    );
  }
  buscarNombresSugeridos(termino: string): Observable<string[]> {
    const url = `${this.baseUrl}/sugerencias?nombre=${encodeURIComponent(
      termino
    )}`;
    return this.http.get<string[]>(url);
  }

  getSalonesFormateados(): Observable<Salon[]> {
    return this.getSalones().pipe(
      map((salones) =>
        salones.map((salon) => {
          let fotoUrl = "/assets/default.webp";

          if (salon.foto) {
            const fileName = salon.foto.split("/").pop() || salon.foto;
            fotoUrl = `http://localhost/storage/salones/${fileName}`;
          }

          return {
            ...salon,
            foto: fotoUrl,
            rating: Math.random() * (5 - 3.5) + 3.5,
            liked: false,
          };
        })
      )
    );
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
