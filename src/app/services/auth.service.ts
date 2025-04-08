import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private apiUrl = "http://localhost:8000/api";
  constructor(private http: HttpClient) { }

  register(data:any): Observable<any> {
    return this.http.post(`${this.apiUrl}/register`,data);
  }

  login(data:any): Observable<any> {
    return this.http.post(`${this.apiUrl}/login`,data);
  }

  logout(): void {
    localStorage.removeItem('auth_token');
  }

  
  isAuthenticated(): boolean {
    return !!localStorage.getItem('auth_token');
  }

  getToken(): string | null {
    return localStorage.getItem('auth_token');
  }
}
