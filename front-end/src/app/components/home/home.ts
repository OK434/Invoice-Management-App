import { Component, signal, computed } from '@angular/core';
import { Api } from '../../services/api';
import { CommonModule } from '@angular/common';
import {Client} from "../../services/client";

@Component({
  selector: 'app-home',
  imports: [CommonModule],
  templateUrl: './home.html',
  styleUrl: './home.css',
  standalone: true,
})
export class Home {
  constructor(
      private api: Api,
      protected clientService: Client,
  ) {}

  ngOnInit() {

    this.api.getClients().subscribe((res: any) => {
      const data = Array.isArray(res[0]) ? res[0] : res;
      this.clientService.setClients(data);
    });
  }
}
