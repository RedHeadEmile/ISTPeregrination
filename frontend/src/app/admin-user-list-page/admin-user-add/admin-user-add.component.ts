import {Component, inject, model, signal} from '@angular/core';
import {ButtonDirective} from 'primeng/button';
import {FormsModule} from '@angular/forms';
import {InputText} from 'primeng/inputtext';
import {Password} from 'primeng/password';
import {ApiError, ApiService} from '../../core/services/api.service';
import {DynamicDialogRef} from 'primeng/dynamicdialog';

@Component({
  selector: 'app-admin-user-add.component',
  imports: [
    ButtonDirective,
    FormsModule,
    InputText,
    Password
  ],
  templateUrl: './admin-user-add.component.html',
  styleUrl: './admin-user-add.component.less',
})
export class AdminUserAddComponent {

  private readonly _apiService = inject(ApiService);

  ref = inject(DynamicDialogRef);

  firstname = model('');
  lastname = model('');
  email = model('');
  password = model('');

  loading = signal(false);
  errorMessage = signal<string | undefined>(undefined);

  async addUser(): Promise<void> {
    this.loading.set(true);
    try {
      await this._apiService.createUser(this.email(), this.password(), this.firstname(), this.lastname());
      this.ref.close(true);
    }
    catch (error) {
      if (error instanceof ApiError && error.isApiError) {
        switch (error.error) {
          case "email_already_exists":
            this.errorMessage.set("Cette adresse email est déjà utilisée !");
            break;

          case "invalid_email":
            this.errorMessage.set("Cette adresse email n'est pas valide !");
            break;

          case "invalid_name":
            this.errorMessage.set("Nom/Prénom invalide !");
            break;

          case "password_too_weak":
            this.errorMessage.set("Mot de passe trop faible !");
            break;
        }
        this.loading.set(false);
      }
      else
        throw error;
    }
  }
}
