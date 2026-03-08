import {ChangeDetectorRef, Component, inject, OnInit} from '@angular/core';
import {ButtonDirective} from 'primeng/button';
import {FormsModule} from '@angular/forms';
import {Password} from 'primeng/password';
import {ApiError, ApiService} from '../core/services/api.service';
import {ActivatedRoute, Router} from '@angular/router';

@Component({
  selector: 'app-user-reset-password-page',
  imports: [
    ButtonDirective,
    FormsModule,
    Password
  ],
  templateUrl: './user-reset-password-page.component.html',
  styleUrl: './user-reset-password-page.component.less',
})
export class UserResetPasswordPageComponent implements OnInit {
  private readonly _apiService = inject(ApiService);
  private readonly _activatedRoute = inject(ActivatedRoute);
  private readonly _cdr = inject(ChangeDetectorRef);
  private readonly _router = inject(Router);

  loading: boolean = false;
  invalidLink: boolean = false;

  token: string = '';
  password: string = '';
  confirmPassword: string = '';
  errorMessage?: string;

  async ngOnInit(): Promise<void> {
    this.token = this._activatedRoute.snapshot.params['token'] || this._activatedRoute.snapshot.queryParams['token'] || '';
    if (!this.token || !(await this._apiService.isResetPasswordTokenValid(this.token))) {
      this.invalidLink = true;
      this._cdr.detectChanges();
      return;
    }
  }

  async resetPassword(): Promise<void> {
    if (this.password !== this.confirmPassword) {
      this.errorMessage = 'Les mots de passe ne correspondent pas';
      this._cdr.detectChanges();
      return;
    }

    this.loading = true;
    this._cdr.detectChanges();
    try {
      await this._apiService.resetPassword(this.token, this.password);
      await this._router.navigate(['/login']);
    }
    catch (error) {
      if (error instanceof ApiError && error.isApiError) {
        switch (error.error) {
          case "invalid_token":
            this.invalidLink = true;
            break;

          case "password_too_weak":
            this.errorMessage = "Mot de passe trop faible !";
            break;
        }
        this.loading = false;
        this._cdr.detectChanges();
      }
      else
        throw error;
    }
  }
}
