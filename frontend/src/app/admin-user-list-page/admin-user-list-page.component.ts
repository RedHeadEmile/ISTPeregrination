import {ChangeDetectorRef, Component, inject, OnInit} from '@angular/core';
import {ApiService} from '../core/services/api.service';
import {UserModel} from '../core/models/user.model';
import {TableModule} from 'primeng/table';
import {Button} from 'primeng/button';
import {DialogService} from 'primeng/dynamicdialog';
import {AdminUserAddComponent} from './admin-user-add/admin-user-add.component';

@Component({
  selector: 'app-admin-user-list-page',
  imports: [
    TableModule,
    Button
  ],
  templateUrl: './admin-user-list-page.component.html',
  styleUrl: './admin-user-list-page.component.less',
})
export class AdminUserListPageComponent implements OnInit {
  private readonly _apiService = inject(ApiService);
  private readonly _changeDetectorRef = inject(ChangeDetectorRef);
  private readonly _dialogService = inject(DialogService);

  users: UserModel[] = [];

  private async _pullUsers(): Promise<void> {
    this.users = await this._apiService.getUsers();
    this._changeDetectorRef.detectChanges();
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
