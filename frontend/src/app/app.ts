import {Component, inject} from '@angular/core';
import {RouterLink, RouterOutlet} from '@angular/router';
import {Toast} from 'primeng/toast';
import {Menu} from 'primeng/menu';
import {Button} from 'primeng/button';
import {MenuItem} from 'primeng/api';
import {AuthenticationService} from './core/services/authentication.service';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, Toast, RouterLink, Menu, Button],
  templateUrl: './app.html',
  styleUrl: './app.less'
})
export class App {
  private readonly _authenticationService = inject(AuthenticationService);

  menuItems: MenuItem[] = [
    {
      label: 'Gestion des mobilités',
      icon: 'pi pi-car',
      routerLink: '/admin/mobility-reviews'
    },
    {
      label: 'Gestion des utilisateurs',
      icon: 'pi pi-user',
      routerLink: '/admin/users'
    }
  ];

  get isAuthenticated(): boolean {
    return !!this._authenticationService.getCurrentUser();
  }
}
