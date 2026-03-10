import {Component, inject, OnInit, signal} from '@angular/core';
import {ApiService} from '../core/services/api.service';
import {UserModel} from '../core/models/user.model';
import {TableModule} from 'primeng/table';
import {Button} from 'primeng/button';
import {DialogService} from 'primeng/dynamicdialog';
import {AdminUserAddComponent} from './admin-user-add/admin-user-add.component';
import {FormsModule} from '@angular/forms';

@Component({
  selector: 'app-admin-user-list-page',
  imports: [
    TableModule,
    Button,
    FormsModule
  ],
  templateUrl: './admin-user-list-page.component.html',
  styleUrl: './admin-user-list-page.component.less',
})
export class AdminUserListPageComponent implements OnInit {
  private readonly _apiService = inject(ApiService);
  private readonly _dialogService = inject(DialogService);

  users = signal<UserModel[]>([]);

  private async _pullUsers(): Promise<void> {
    this.users.set(await this._apiService.getUsers());
  }

  async ngOnInit(): Promise<void> {
    await this._pullUsers();
  }

  addUser(): void {
    this._dialogService.open(
      AdminUserAddComponent,
      {
        header: 'Ajouter un utilisateur',
        modal: true,
        draggable: false,
        focusOnShow: true,
        closable: true,
        closeOnEscape: true,
        width: '32rem',
      }
    )?.onClose.subscribe(async (created: boolean) => {
      if (created)
        await this._pullUsers();
    });
  }
}
