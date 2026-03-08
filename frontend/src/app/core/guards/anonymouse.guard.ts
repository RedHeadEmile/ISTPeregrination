import {CanActivateFn, RedirectCommand, Router} from '@angular/router';
import {inject} from '@angular/core';
import {AuthenticationService} from '../services/authentication.service';

export const anonymousGuard: CanActivateFn = (route, state) => {
  const authenticationService = inject(AuthenticationService);
  const router = inject(Router);

  if (authenticationService.isCurrentUserInitialized()) {
    if (!authenticationService.getCurrentUser())
      return true;

    return new RedirectCommand(router.parseUrl('/'));
  }

  return authenticationService.pullCurrentUser().then(() => {
    if (!authenticationService.getCurrentUser())
      return true;

    return new RedirectCommand(router.parseUrl('/'));
  });
}
