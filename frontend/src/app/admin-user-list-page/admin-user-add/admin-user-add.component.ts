import {ChangeDetectorRef, Component, inject} from '@angular/core';
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
  private readonly _changeDetectorRef = inject(ChangeDetectorRef);

  ref = inject(DynamicDialogRef);

  firstname: string = '';
  lastname: string = '';
  email: string = '';
  password: string = '';

  loading: boolean = false;
  errorMessage?: string;

  async addUser(): Promise<void> {
    this.loading = true;
    try {
      await this._apiService.createUser(this.email, this.password, this.firstname, this.lastname);
      this.ref.close(true);
    }
    catch (error) {
      if (error instanceof ApiError && error.isApiError) {
        switch (error.error) {
          case "email_already_exists":
            this.errorMessage = "Cette adresse email est déjà utilisée !";
            break;

          case "invalid_email":
            this.errorMessage = "Cette adresse email n'est pas valide !";
            break;

          case "invalid_name":
            this.errorMessage = "Nom/Prénom invalide !";
            break;

          case "password_too_weak":
            this.errorMessage = "Mot de passe trop faible !";
            break;
        }
        this.loading = false;
        this._changeDetectorRef.detectChanges();
      }
      else
        throw error;
    }
  }
}
