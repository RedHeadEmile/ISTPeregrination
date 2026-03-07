import {ErrorHandler, inject} from '@angular/core';
import {MessageService} from 'primeng/api';

export class GlobalErrorHandler implements ErrorHandler {
  private readonly _messageService = inject(MessageService);

  handleError(error: any) {
    console.error(error);
    this._messageService.add({
      summary: 'Une erreur s\'est produite',
      detail: error.message,
      severity: 'error',
      sticky: true
    });
  }
}
