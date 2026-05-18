import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root',
})
export class Api {
  constructor(private http: HttpClient) {}
  register(data: any) {
    return this.http.post('http://localhost:8000/api/client/register', data);
  }
  login(data: any) {
    return this.http.post('http://localhost:8000/api/login_check', data);
  }
  getClients() {
    const token = localStorage.getItem('token');

    return this.http.get('http://localhost:8000/api/client/client', {
      headers: {
        Authorization: 'Bearer ' + token,
      },
    });
  }
  createInvoice(data: any,token: string) {
    return this.http.post('http://localhost:8000/api/invoice/create', data, {
      headers: {
        Authorization: 'Bearer ' + token,
      },
      responseType: 'blob',
    });
  }
  getInvoice() {
    const token = localStorage.getItem('token');
    return this.http.get('http://localhost:8000/api/invoice', {
      headers: {
        Authorization: 'Bearer ' + token,
      },
    });
  }
  importInvoice(data: any, token: string) {
    return this.http.post('http://localhost:8000/api/invoice/import', data, {
      headers: {
        Authorization: 'Bearer ' + token,
      },
      responseType: 'blob',
    });
  }
  downloadCsv(token: string) {
    return this.http.get('http://localhost:8000/api/invoice/download', {
      headers: {
        Authorization: 'Bearer ' + token,
      },
      responseType: 'blob',
    });
  }
}
