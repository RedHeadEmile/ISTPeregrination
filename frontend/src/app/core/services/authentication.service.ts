import {inject, Injectable, signal} from '@angular/core';
import {ApiService} from './api.service';
import {UserModel} from '../models/user.model';

@Injectable({
  providedIn: 'root',
})
export class AuthenticationService {
  private readonly _apiService: ApiService = inject(ApiService);

  private _currentUser = signal<UserModel | undefined>(undefined);
  private _currentUserInitialized = signal(false);

  isCurrentUserInitialized(): boolean {
    return this._currentUserInitialized();
  }

  getCurrentUser(): UserModel | undefined {
    return this._currentUser();
  }

  getDefinedCurrentUser(): UserModel {
    if (!this._currentUser())
      throw new Error('Current user is not defined');
    return this._currentUser()!;
  }

  async pullCurrentUser(): Promise<void> {
    this._currentUser.set(await this._apiService.getCurrentUser());
    this._currentUserInitialized.set(true);
  }

  async login(email: string, password: string): Promise<void> {
    this._currentUser.set(await this._apiService.login(email, password));
  }

  async logout(): Promise<void> {
    await this._apiService.logout();
    this._currentUser.set(undefined);
  }
}
