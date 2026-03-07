import { Injectable } from '@angular/core';
import {UserModel} from '../models/user.model';
import {MobilityReviewModel} from '../models/mobility-review.model';
import {environment} from '../../../environments/environment';

@Injectable({
  providedIn: 'root',
})
export class ApiService {
  async getCurrentUser(): Promise<UserModel | undefined> {
    const response = await fetch(environment.backendUrl + '/current-user', {
      method: 'GET',
      credentials: 'include',
    });

    if (response.status === 200)
      return await response.json() as UserModel;

    if (response.status === 401)
      return undefined;

    throw new Error('Failed to fetch current user');
  }

  async logout(): Promise<void> {
    const response = await fetch(environment.backendUrl + '/current-user', {
      method: 'DELETE',
      credentials: 'include',
    });

    if (response.status === 204)
      return;

    throw new Error('Failed to logout');
  }

  async sendResetPassword(email: string): Promise<void> {
    const response = await fetch(environment.backendUrl + '/send-reset-password', {
      method: 'POST',
      credentials: 'include',
      body: JSON.stringify({ email: email }),
    });

    if (response.status === 204)
      return;

    throw new Error('Failed to send reset password email');
  }

  async resetPassword(token: string, newPassword: string): Promise<void> {
    const response = await fetch(environment.backendUrl + '/reset-password', {
      method: 'POST',
      credentials: 'include',
      body: JSON.stringify({ token: token, password: newPassword }),
    });

    if (response.status === 204)
      return;

    throw new Error('Failed to reset password');
  }

  async isResetPasswordTokenValid(token: string): Promise<boolean> {
    const response = await fetch(environment.backendUrl + '/reset-password-token/' + token, {
      method: 'GET',
      credentials: 'include',
    });

    if (response.status === 200)
      return (await response.json())['valid'];

    throw new Error('Failed to validate reset password token');
  }

  async getUsers(): Promise<UserModel[]> {
    const response = await fetch(environment.backendUrl + '/users', {
      method: 'GET',
      credentials: 'include',
    });

    if (response.status === 200)
      return await response.json() as UserModel[];

    throw new Error('Failed to fetch users');
  }

  async createUser(email: string, password: string, firstname: string, lastname: string): Promise<UserModel> {
    const response = await fetch(environment.backendUrl + '/users', {
      method: 'POST',
      credentials: 'include',
      body: JSON.stringify({ email: email, password: password, firstname: firstname, lastname: lastname }),
    });

    if (response.status === 201)
      return await response.json() as UserModel;

    throw new Error('Failed to create user');
  }

  async login(email: string, password: string): Promise<UserModel | undefined> {
    const response = await fetch(environment.backendUrl + '/login', {
      method: 'POST',
      credentials: 'include',
      body: JSON.stringify({ email: email, password: password }),
    });

    if (response.status === 200)
      return await response.json() as UserModel;

    if (response.status === 401)
      return undefined;

    throw new Error('Failed to login');
  }

  async getMobilityReviews(): Promise<MobilityReviewModel[]> {
    const response = await fetch(environment.backendUrl + '/mobility-reviews', {
      method: 'GET',
      credentials: 'include',
    });

    if (response.status === 200)
      return await response.json() as MobilityReviewModel[];

    throw new Error('Failed to fetch mobility reviews');
  }

  async submitMobilityReview(mobilityReview: MobilityReviewModel): Promise<void> {
    const response = await fetch(environment.backendUrl + '/mobility-reviews', {
      method: 'POST',
      credentials: 'include',
      body: JSON.stringify(mobilityReview),
    });

    if (response.status === 201)
      return;

    throw new Error('Failed to submit mobility review');
  }

  async deleteMobilityReview(id: number): Promise<void> {
    const response = await fetch(environment.backendUrl + '/mobility-reviews/' + id, {
      method: 'DELETE',
      credentials: 'include'
    });

    if (response.status === 204)
      return;

    throw new Error('Failed to delete mobility review');
  }

  async approveMobilityReview(id: number): Promise<void> {
    const response = await fetch(environment.backendUrl + '/mobility-reviews/' + id + '/approve', {
      method: 'POST',
      credentials: 'include'
    });

    if (response.status === 204)
      return;

    throw new Error('Failed to delete mobility review');
  }
}
