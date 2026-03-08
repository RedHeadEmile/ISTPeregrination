import {ChangeDetectorRef, Component, inject} from '@angular/core';
import {FormsModule} from '@angular/forms';
import {InputText} from 'primeng/inputtext';
import {Password} from 'primeng/password';
import {Button, ButtonDirective} from 'primeng/button';
import {AuthenticationService} from '../core/services/authentication.service';
import {Router} from '@angular/router';
import {ApiService} from '../core/services/api.service';

@Component({
  selector: 'app-user-login-page',
  imports: [
    FormsModule,
    InputText,
    Password,
    ButtonDirective,
    Button,
  ],
  templateUrl: './user-login-page.component.html',
  styleUrl: './user-login-page.component.less',
})
export class UserLoginPageComponent {

  private readonly _apiService = inject(ApiService);
  private readonly _authenticationService = inject(AuthenticationService);
  private readonly _router = inject(Router);
  private readonly _cdr = inject(ChangeDetectorRef);

  email: string = '';
  password: string = '';
  errorMessage?: string;

  loading: boolean = false;
  emailSent: boolean = false;

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
    this._cdr.detectChanges();
  }

  async sendResetEmail(): Promise<void> {
    this.emailSent = true;
    this._cdr.detectChanges();
    await this._apiService.sendResetPassword(this.email);
  }
}
