import { computed, Injectable, signal } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class Client {
  Clients = signal<any[]>([]);
  search = signal('');

  filteredClients = computed(() => {
    const text = this.search().toLowerCase();

    return this.Clients().filter(
      (c) =>
        (c.clientName || '').toLowerCase().includes(text) ||
        (c.companyName || '').toLowerCase().includes(text),
    );
  });

  setClients(data: any[]) {
    this.Clients.set(data);
  }
}
