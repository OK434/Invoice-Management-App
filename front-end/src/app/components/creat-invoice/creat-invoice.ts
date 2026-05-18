import { Component, computed, signal } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Api } from '../../services/api';
import { Client } from '../../services/client';

@Component({
  selector: 'app-creat-invoice',
  imports: [FormsModule],
  templateUrl: './creat-invoice.html',
  styleUrl: './creat-invoice.css',
  standalone: true,
})
export class CreatInvoice {
  isOpen = signal(false);
  constructor(
    private api: Api,
    public clientService: Client,
  ) {}
  selectedClient = signal<any | null>(null);
  openDialog() {
    this.isOpen.set(true);
  }

  closeDialog() {
    this.isOpen.set(false);
  }
  selectClient(client: any) {
    this.selectedClient.set(client);
    this.closeDialog();
  }
  cancelInvoice() {
    this.selectedClient.set(null);
  }
  ngOnInit() {
    this.api.getClients().subscribe((res: any) => {
      const data = Array.isArray(res[0]) ? res[0] : res;
      this.clientService.setClients(data);
    });
  }
  items = signal<any[]>([{ description: '', quantity: 1, price: 0 }]);
  addItem() {
    this.items.update((items) => [...items, { description: '', quantity: 1, price: 0 }]);
  }
  removeItem(index: number) {
    this.items.update((items) => items.filter((_, i) => i !== index));
  }
  updateItem(index: number, field: string, value: any) {
    this.items.update((items) => {
      const newItems = [...items];
      newItems[index][field] = value;
      return newItems;
    });
  }
  total = computed(() => {
    return this.items().reduce((sum, item) => {
      return sum + item.quantity * item.price;
    }, 0);
  });
  createInvoice() {
    const data = {
      client_id: this.selectedClient()?.id,
      items: this.items(),
    };
    const token = localStorage.getItem('token');
    this.api.createInvoice(data, token!).subscribe({
      next: (res) => console.log(res),
      error: (err) => console.log(err),
    });
    this.selectedClient.set(null);
  }
}
