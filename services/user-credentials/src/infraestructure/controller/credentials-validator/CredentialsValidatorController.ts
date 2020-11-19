import { Controller } from '../Controller'
import { CredentialsValidatorControllerRequest } from './CredentialsValidatorControllerRequest'
import { CredentialsValidatorControllerResponse } from './CredentialsValidatorControllerResponse'
import { CredentialsValidator } from '../../../application/credentials-validator/CredentialsValidator'
import { ICredentialsRepository } from '../../../domain/ICredentialsRepository'

export class CredentialsValidatorController extends Controller<
  CredentialsValidatorControllerRequest,
  CredentialsValidatorControllerResponse
> {
  private service: CredentialsValidator

  constructor(repository: ICredentialsRepository) {
    super()
    this.service = new CredentialsValidator(repository)
  }

  async handler(
    request: CredentialsValidatorControllerRequest
  ): Promise<CredentialsValidatorControllerResponse> {
    try {
      this.validateRequest(request)

      const user = await this.service.invoke({
        email: request.email,
        password: request.password
      })

      const status = user.status
      if (status === 'VALID_CREDENTIALS')
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
          message: 'Login Failed',
          reason: new String(error).toString()
        }
      }
    }
  }

  private validateRequest(
    request: CredentialsValidatorControllerRequest
  ): void {
    this.validateRequestParams([
      {
        value_name: 'email',
        value: request.email,
        expected: 'string'
      },
      {
        value_name: 'password',
        value: request.password,
        expected: 'string'
      }
    ])
  }
}
