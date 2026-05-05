import { Component, signal } from '@angular/core';
import { Api } from '../../services/api';
import { Client } from '../../services/client';

@Component({
  selector: 'app-list-invoice',
  imports: [],
  templateUrl: './list-invoice.html',
  styleUrl: './list-invoice.css',
  standalone: true,
})
export class ListInvoice {
  constructor(
    private api: Api,
    public clientService: Client,
  ) {}
  invoice = signal<any[]>([]);
  getCompanyName(clientId: number) {
    const client = this.clientService.Clients().find((c) => c.id === clientId);
    return client ? client.companyName : 'Unknown';
  }
  ngOnInit() {
    this.api.getClients().subscribe((res: any) => {
      const data = Array.isArray(res[0]) ? res[0] : res;
      this.clientService.setClients(data);
    });
    this.api.getInvoice().subscribe((res: any) => {
      const data = Array.isArray(res[0]) ? res[0] : res;
      this.invoice.set(data);
    });

  }
}
