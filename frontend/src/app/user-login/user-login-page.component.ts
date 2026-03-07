import {ChangeDetectorRef, Component, inject} from '@angular/core';
import {FormsModule, FormSubmittedEvent} from '@angular/forms';
import {InputText} from 'primeng/inputtext';
import {Password} from 'primeng/password';
import {ButtonDirective} from 'primeng/button';
import {ProgressSpinner} from 'primeng/progressspinner';
import {AuthenticationService} from '../core/services/authentication.service';
import {Router} from '@angular/router';

@Component({
  selector: 'app-user-login-page',
  imports: [
    FormsModule,
    InputText,
    Password,
    ButtonDirective,
  ],
  templateUrl: './user-login-page.component.html',
  styleUrl: './user-login-page.component.less',
})
export class UserLoginPageComponent {

  private readonly _authenticationService = inject(AuthenticationService);
  private readonly _router = inject(Router);
  private readonly _crd = inject(ChangeDetectorRef);

  email: string = '';
  password: string = '';
  errorMessage?: string;

  loading: boolean = false;

  async login(): Promise<void> {
    this.loading = true;
    await this._authenticationService.login(this.email, this.password);
    if (!!this._authenticationService.getCurrentUser()) {
      await this._router.navigate(['/admin']);
    }
    else {
      this.errorMessage = 'Adresse email ou mot de passe incorrect';
    }
    this.loading = false;
    this._crd.detectChanges();
  }
}
