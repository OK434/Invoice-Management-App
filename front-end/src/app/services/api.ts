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
    return this.http.post('http://localhost:8000/api/client/login', data);
  }
  getClients() {
    return this.http.get('http://localhost:8000/api/client/client');
  }
  createInvoice(data: any) {
    return this.http.post('http://localhost:8000/api/invoice/create', data);
  }
  getInvoice() {
    return this.http.get('http://localhost:8000/api/invoice');
  }
  importInvoice(data : any){

    return this.http.post('http://localhost:8000/api/invoice/import',data);
  };
}
