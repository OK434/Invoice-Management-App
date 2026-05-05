import { Component, signal } from '@angular/core';
import { Api } from '../../services/api';
import { NgIf } from '@angular/common';

@Component({
  selector: 'app-import-invoice',
  imports: [NgIf],
  templateUrl: './import-invoice.html',
  styleUrl: './import-invoice.css',
  standalone: true,
})
export class ImportInvoice {
  constructor(private api: Api) {}
  fileName = '';

  onFileSelected(event: any) {
    const file = event.target.files[0];

    if (!file) {
      console.log('No file selected');
      return;
    }
    this.fileName = file.name;

    const formData = new FormData();
    formData.append('file', file);

    this.api.importInvoice(formData).subscribe({
      next: (res) => console.log(res),
      error: (err) => console.log(err),
    });
  }
}
