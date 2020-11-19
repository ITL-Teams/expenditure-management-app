import { Controller } from '../Controller'
import { TwoFactorValidatorControllerRequest } from './TwoFactorValidatorControllerRequest'
import { TwoFactorValidatorControllerResponse } from './TwoFactorValidatorControllerResponse'
import { ICredentialsRepository } from '../../../domain/ICredentialsRepository'
import { TwoFactorValidator } from '../../../application/2fa/TwoFactorValidator'

export class TwoFactorValidatorController extends Controller<
  TwoFactorValidatorControllerRequest,
  TwoFactorValidatorControllerResponse
> {
  private service: TwoFactorValidator

  constructor(repository: ICredentialsRepository) {
    super()
    this.service = new TwoFactorValidator(repository)
  }

  async handler(
    request: TwoFactorValidatorControllerRequest
  ): Promise<TwoFactorValidatorControllerResponse> {
    try {
      this.validateRequest(request)

      const user = await this.service.invoke({
        email: request.email,
        code: request.code
      })

      const status = user.status
      if (status === 'OK')
        return {
          success: {
            status: status,
            user_id: user.user_data.user_id,
            enterprise_account: user.user_data.enterprise_account
          }
        }

      return {
        success: {
          status: status
        }
      }
    } catch (error) {
      return {
        error: {
          message: 'Two factor authentication failed',
          reason: new String(error).toString()
        }
      }
    }
  }

  private validateRequest(request: TwoFactorValidatorControllerRequest): void {
    this.validateRequestParams([
      {
        value_name: 'email',
        value: request.email,
        expected: 'string'
      },
      {
        value_name: 'code',
        value: request.code,
        expected: 'string'
      }
    ])
  }
}
