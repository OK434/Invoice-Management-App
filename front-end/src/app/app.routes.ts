import { Routes } from '@angular/router';
import { Login } from './components/login/login';
import { Singin } from './components/singin/singin';
import { Home } from './components/home/home';
import { CreatInvoice } from './components/creat-invoice/creat-invoice';
import { ListInvoice } from './components/list-invoice/list-invoice';
import { ImportInvoice } from './components/import-invoice/import-invoice';
import { Layout } from './components/layout/layout';

export const routes: Routes = [
  { path: '', redirectTo: 'login', pathMatch: 'full' },
  { path: 'login', component: Login },
  { path: 'singin', component: Singin },

  {
    path: '',
    component: Layout,
    children: [
      { path: 'home', component: Home },
      { path: 'creat-invoice', component: CreatInvoice },
      { path: 'list-invoice', component: ListInvoice },
      { path: 'import-invoice', component: ImportInvoice },
    ],
  },
];
