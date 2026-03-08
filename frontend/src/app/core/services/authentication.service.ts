import {ChangeDetectorRef, inject, Injectable} from '@angular/core';
import {ApiService} from './api.service';
import {UserModel} from '../models/user.model';

@Injectable({
  providedIn: 'root',
})
export class AuthenticationService {
  private readonly _apiService: ApiService = inject(ApiService);

  private _currentUser?: UserModel;
  private _currentUserInitialized: boolean = false;

  isCurrentUserInitialized(): boolean {
    return this._currentUserInitialized;
  }

  getCurrentUser(): UserModel | undefined {
    return this._currentUser;
  }

  getDefinedCurrentUser(): UserModel {
    if (!this._currentUser)
      throw new Error('Current user is not defined');
    return this._currentUser;
  }

  async pullCurrentUser(): Promise<void> {
    this._currentUser = await this._apiService.getCurrentUser();
    this._currentUserInitialized = true;
  }

  async login(email: string, password: string): Promise<void> {
    this._currentUser = await this._apiService.login(email, password);
  }

  async logout(): Promise<void> {
    await this._apiService.logout();
    this._currentUser = undefined;
  }
}
